<?php
/**
 * Web-basiertes Setup-Script - Optimierte Version
 * Ermöglicht die Installation über den Browser
 * 
 * WICHTIG: Diese Datei nach der Installation löschen oder umbenennen!
 */

// Output Buffering starten
ob_start();

// Sicherheitscheck: Installation nur einmal erlauben
$lock_file = __DIR__ . '/.installed.lock';
if (file_exists($lock_file)) {
    die('Installation wurde bereits durchgeführt. Bitte löschen Sie .installed.lock um erneut zu installieren.');
}

session_start();

$step = $_GET['step'] ?? 1;
$errors = [];
$success = [];

// ========================================
// POST REQUEST VERARBEITUNG (VOR HTML OUTPUT)
// ========================================

// SCHRITT 2: Datenbank-Konfiguration verarbeiten
if ($step == 2 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = $_POST['db_host'] ?? '';
    $db_name = $_POST['db_name'] ?? '';
    $db_user = $_POST['db_user'] ?? '';
    $db_pass = $_POST['db_pass'] ?? '';
    
    if (empty($db_host) || empty($db_name) || empty($db_user)) {
        $errors[] = 'Bitte füllen Sie alle Pflichtfelder aus.';
    } else {
        try {
            $pdo = new PDO(
                "mysql:host=$db_host;charset=utf8mb4",
                $db_user,
                $db_pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            
            // Datenbank erstellen
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `$db_name`");
            
            // Schema importieren
            $schema = file_get_contents(__DIR__ . '/database/schema.sql');
            
            // SQL Statements aufteilen und säubern
            $statements = explode(';', $schema);
            foreach ($statements as $statement) {
                $statement = trim($statement);
                // Überspringe leere Statements und Kommentare
                if (empty($statement) || preg_match('/^--/', $statement)) {
                    continue;
                }
                // Entferne Block-Kommentare
                $statement = preg_replace('/\/\*.*?\*\//s', '', $statement);
                $statement = trim($statement);
                
                if (!empty($statement)) {
                    $pdo->exec($statement);
                }
            }
            
            // config.php aktualisieren
            $config = file_get_contents(__DIR__ . '/config.php');
            $config = preg_replace("/define\('DB_HOST',\s*'[^']*'\);/", "define('DB_HOST', '$db_host');", $config);
            $config = preg_replace("/define\('DB_NAME',\s*'[^']*'\);/", "define('DB_NAME', '$db_name');", $config);
            $config = preg_replace("/define\('DB_USER',\s*'[^']*'\);/", "define('DB_USER', '$db_user');", $config);
            $config = preg_replace("/define\('DB_PASS',\s*'[^']*'\);/", "define('DB_PASS', '$db_pass');", $config);
            $config = preg_replace("/define\('DEBUG_MODE',\s*true\);/", "define('DEBUG_MODE', false);", $config);
            
            file_put_contents(__DIR__ . '/config.php', $config);
            
            $_SESSION['db_configured'] = true;
            
            // Redirect zu Schritt 3
            ob_end_clean();
            header('Location: ?step=3');
            exit;
            
        } catch (PDOException $e) {
            $errors[] = 'Datenbankfehler: ' . $e->getMessage();
        } catch (Exception $e) {
            $errors[] = 'Fehler: ' . $e->getMessage();
        }
    }
}

// SCHRITT 3: Admin-Account erstellen
if ($step == 3 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['db_configured'])) {
        ob_end_clean();
        header('Location: ?step=2');
        exit;
    }
    
    $admin_user = $_POST['admin_user'] ?? '';
    $admin_email = $_POST['admin_email'] ?? '';
    $admin_pass = $_POST['admin_pass'] ?? '';
    $admin_pass_confirm = $_POST['admin_pass_confirm'] ?? '';
    
    if (empty($admin_user) || empty($admin_email) || empty($admin_pass)) {
        $errors[] = 'Bitte füllen Sie alle Felder aus.';
    } elseif ($admin_pass !== $admin_pass_confirm) {
        $errors[] = 'Die Passwörter stimmen nicht überein.';
    } elseif (strlen($admin_pass) < 8) {
        $errors[] = 'Das Passwort muss mindestens 8 Zeichen lang sein.';
    } else {
        try {
            require_once __DIR__ . '/config.php';
            require_once __DIR__ . '/database/Database.php';
            
            $db = Database::getInstance();
            $pdo = $db->getConnection();
            
            // Prüfen ob bereits ein Admin existiert
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_users");
            $stmt->execute();
            $count = $stmt->fetchColumn();
            
            if ($count > 0) {
                // Admin bereits vorhanden, überspringen
                $success[] = 'Admin-Account existiert bereits.';
            } else {
                // Admin-Account erstellen
                $password_hash = password_hash($admin_pass, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("
                    INSERT INTO admin_users (username, email, password_hash, full_name) 
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([$admin_user, $admin_email, $password_hash, 'Administrator']);
                
                $success[] = 'Admin-Account erfolgreich erstellt!';
            }
            
            // Lock-File erstellen
            file_put_contents($lock_file, date('Y-m-d H:i:s'));
            
            $_SESSION['installation_complete'] = true;
            
            // Redirect zu Schritt 4
            ob_end_clean();
            header('Location: ?step=4');
            exit;
            
        } catch (Exception $e) {
            $errors[] = 'Fehler beim Erstellen des Admin-Accounts: ' . $e->getMessage();
        }
    }
}

// Session-Checks für Steps
if ($step == 3 && !isset($_SESSION['db_configured'])) {
    ob_end_clean();
    header('Location: ?step=2');
    exit;
}

if ($step == 4 && !isset($_SESSION['installation_complete'])) {
    ob_end_clean();
    header('Location: ?step=1');
    exit;
}

// CSS Styles
$styles = <<<CSS
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #f1f5f9;
        min-height: 100vh;
        padding: 40px 20px;
    }
    .container {
        max-width: 700px;
        margin: 0 auto;
        background: #1e293b;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        overflow: hidden;
    }
    .header {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        padding: 40px;
        text-align: center;
    }
    .header h1 {
        font-size: 32px;
        margin-bottom: 8px;
    }
    .header p {
        opacity: 0.9;
    }
    .content {
        padding: 40px;
    }
    .steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 2px solid #334155;
    }
    .step-item {
        flex: 1;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        opacity: 0.5;
    }
    .step-item.active {
        background: rgba(79, 70, 229, 0.1);
        opacity: 1;
        border: 2px solid #4f46e5;
    }
    .step-item.completed {
        opacity: 1;
        color: #10b981;
    }
    .form-group {
        margin-bottom: 24px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 12px 16px;
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 8px;
        color: #f1f5f9;
        font-size: 14px;
    }
    .form-group input:focus {
        outline: none;
        border-color: #4f46e5;
    }
    .form-group small {
        display: block;
        margin-top: 6px;
        color: #94a3b8;
        font-size: 13px;
    }
    .btn {
        padding: 12px 28px;
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: transform 0.2s;
    }
    .btn:hover {
        transform: translateY(-2px);
    }
    .btn-secondary {
        background: #334155;
    }
    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 24px;
    }
    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid #ef4444;
        color: #fca5a5;
    }
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid #10b981;
        color: #6ee7b7;
    }
    .alert-info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid #3b82f6;
        color: #93c5fd;
    }
    .check-list {
        list-style: none;
    }
    .check-list li {
        padding: 12px;
        margin-bottom: 8px;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 8px;
    }
    .check-list .success { color: #10b981; }
    .check-list .error { color: #ef4444; }
    .check-list .warning { color: #f59e0b; }
    .code-block {
        background: #0f172a;
        padding: 16px;
        border-radius: 8px;
        margin: 16px 0;
        font-family: 'Courier New', monospace;
        font-size: 13px;
        overflow-x: auto;
    }
    .button-group {
        display: flex;
        gap: 12px;
        justify-content: space-between;
        margin-top: 32px;
    }
</style>
CSS;

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Köllner Digital - Installation</title>
    <?php echo $styles; ?>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Köllner Digital</h1>
            <p>Web-Installation - Admin Panel, Blog & CMS</p>
        </div>
        
        <div class="content">
            <div class="steps">
                <div class="step-item <?php echo $step == 1 ? 'active' : ($step > 1 ? 'completed' : ''); ?>">
                    1. Check
                </div>
                <div class="step-item <?php echo $step == 2 ? 'active' : ($step > 2 ? 'completed' : ''); ?>">
                    2. Datenbank
                </div>
                <div class="step-item <?php echo $step == 3 ? 'active' : ($step > 3 ? 'completed' : ''); ?>">
                    3. Admin
                </div>
                <div class="step-item <?php echo $step == 4 ? 'active' : ''; ?>">
                    4. Fertig
                </div>
            </div>
            
            <?php
            // ========================================
            // SCHRITT 1: SYSTEMPRÜFUNG
            // ========================================
            if ($step == 1):
            ?>
                <h2>Systemprüfung</h2>
                <p style="margin-bottom: 24px; color: #94a3b8;">
                    Überprüfung der Systemvoraussetzungen...
                </p>
                
                <ul class="check-list">
                    <?php
                    $all_ok = true;
                    
                    // PHP Version
                    $php_ok = version_compare(PHP_VERSION, '7.4.0', '>=');
                    if (!$php_ok) $all_ok = false;
                    echo '<li class="' . ($php_ok ? 'success' : 'error') . '">';
                    echo ($php_ok ? '✓' : '✗') . ' PHP Version: ' . PHP_VERSION . ($php_ok ? ' (OK)' : ' (mindestens 7.4 erforderlich)');
                    echo '</li>';
                    
                    // PDO
                    $pdo_ok = extension_loaded('pdo');
                    if (!$pdo_ok) $all_ok = false;
                    echo '<li class="' . ($pdo_ok ? 'success' : 'error') . '">';
                    echo ($pdo_ok ? '✓' : '✗') . ' PDO Extension';
                    echo '</li>';
                    
                    // PDO MySQL
                    $pdo_mysql_ok = extension_loaded('pdo_mysql');
                    if (!$pdo_mysql_ok) $all_ok = false;
                    echo '<li class="' . ($pdo_mysql_ok ? 'success' : 'error') . '">';
                    echo ($pdo_mysql_ok ? '✓' : '✗') . ' PDO MySQL Extension';
                    echo '</li>';
                    
                    // config.php schreibbar
                    $config_writable = is_writable(__DIR__ . '/config.php');
                    if (!$config_writable) $all_ok = false;
                    echo '<li class="' . ($config_writable ? 'success' : 'error') . '">';
                    echo ($config_writable ? '✓' : '✗') . ' config.php schreibbar';
                    echo '</li>';
                    
                    // uploads/ Verzeichnis
                    $uploads_exists = is_dir(__DIR__ . '/uploads');
                    $uploads_writable = $uploads_exists && is_writable(__DIR__ . '/uploads');
                    echo '<li class="' . ($uploads_writable ? 'success' : 'warning') . '">';
                    echo ($uploads_writable ? '✓' : '⚠') . ' uploads/ Verzeichnis ' . ($uploads_writable ? 'OK' : 'nicht gefunden/schreibbar');
                    echo '</li>';
                    
                    // database/schema.sql
                    $schema_exists = file_exists(__DIR__ . '/database/schema.sql');
                    if (!$schema_exists) $all_ok = false;
                    echo '<li class="' . ($schema_exists ? 'success' : 'error') . '">';
                    echo ($schema_exists ? '✓' : '✗') . ' database/schema.sql vorhanden';
                    echo '</li>';
                    ?>
                </ul>
                
                <?php if ($all_ok): ?>
                    <div class="alert alert-success">
                        ✓ Alle Systemvoraussetzungen erfüllt!
                    </div>
                    <div class="button-group">
                        <div></div>
                        <a href="?step=2" class="btn">Weiter zur Datenbank →</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-error">
                        ✗ Bitte beheben Sie die rot markierten Fehler vor der Installation.
                    </div>
                    <div class="button-group">
                        <div></div>
                        <a href="?step=1" class="btn btn-secondary">Neu laden</a>
                    </div>
                <?php endif; ?>
            
            <?php
            // ========================================
            // SCHRITT 2: DATENBANK-KONFIGURATION
            // ========================================
            elseif ($step == 2):
            ?>
                <h2>Datenbank-Konfiguration</h2>
                <p style="margin-bottom: 24px; color: #94a3b8;">
                    Geben Sie Ihre Datenbank-Zugangsdaten ein.
                </p>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <?php foreach ($errors as $error): ?>
                            <div>✗ <?php echo htmlspecialchars($error); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label>Datenbank-Host *</label>
                        <input type="text" name="db_host" value="<?php echo htmlspecialchars($_POST['db_host'] ?? 'localhost'); ?>" required>
                        <small>Meist "localhost"</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Datenbank-Name *</label>
                        <input type="text" name="db_name" value="<?php echo htmlspecialchars($_POST['db_name'] ?? 'koellner_life'); ?>" required>
                        <small>Name der zu erstellenden/verwendenden Datenbank</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Datenbank-Benutzer *</label>
                        <input type="text" name="db_user" value="<?php echo htmlspecialchars($_POST['db_user'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Datenbank-Passwort</label>
                        <input type="password" name="db_pass" value="<?php echo htmlspecialchars($_POST['db_pass'] ?? ''); ?>">
                    </div>
                    
                    <div class="alert alert-info">
                        ℹ Die Datenbank wird automatisch erstellt, falls sie nicht existiert. Das Schema wird automatisch importiert.
                    </div>
                    
                    <div class="button-group">
                        <a href="?step=1" class="btn btn-secondary">← Zurück</a>
                        <button type="submit" class="btn">Datenbank einrichten →</button>
                    </div>
                </form>
            
            <?php
            // ========================================
            // SCHRITT 3: ADMIN-ACCOUNT
            // ========================================
            elseif ($step == 3):
            ?>
                <h2>Admin-Account erstellen</h2>
                <p style="margin-bottom: 24px; color: #94a3b8;">
                    Erstellen Sie Ihren Administrator-Account.
                </p>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <?php foreach ($errors as $error): ?>
                            <div>✗ <?php echo htmlspecialchars($error); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <?php foreach ($success as $msg): ?>
                            <div>✓ <?php echo htmlspecialchars($msg); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label>Benutzername *</label>
                        <input type="text" name="admin_user" value="<?php echo htmlspecialchars($_POST['admin_user'] ?? 'admin'); ?>" required>
                        <small>Ihr Login-Name</small>
                    </div>
                    
                    <div class="form-group">
                        <label>E-Mail-Adresse *</label>
                        <input type="email" name="admin_email" value="<?php echo htmlspecialchars($_POST['admin_email'] ?? 'kontakt@koellner.life'); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Passwort *</label>
                        <input type="password" name="admin_pass" required>
                        <small>Mindestens 8 Zeichen</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Passwort bestätigen *</label>
                        <input type="password" name="admin_pass_confirm" required>
                    </div>
                    
                    <div class="alert alert-info">
                        ℹ Merken Sie sich diese Zugangsdaten gut! Sie benötigen sie für den Login unter /admin/
                    </div>
                    
                    <div class="button-group">
                        <a href="?step=2" class="btn btn-secondary">← Zurück</a>
                        <button type="submit" class="btn">Admin-Account erstellen →</button>
                    </div>
                </form>
            
            <?php
            // ========================================
            // SCHRITT 4: INSTALLATION ABGESCHLOSSEN
            // ========================================
            elseif ($step == 4):
            ?>
                <h2>🎉 Installation abgeschlossen!</h2>
                <p style="margin-bottom: 24px; color: #94a3b8;">
                    Ihre Website wurde erfolgreich eingerichtet.
                </p>
                
                <div class="alert alert-success">
                    <div>✓ Datenbank erstellt und konfiguriert</div>
                    <div>✓ Admin-Account erstellt</div>
                    <div>✓ System einsatzbereit</div>
                </div>
                
                <div class="alert alert-info">
                    <strong>Wichtige nächste Schritte:</strong>
                    <ol style="margin-left: 20px; margin-top: 12px;">
                        <li>Löschen Sie setup.php aus Sicherheitsgründen</li>
                        <li>Loggen Sie sich im Admin-Panel ein</li>
                        <li>Ändern Sie bei Bedarf Ihr Passwort</li>
                    </ol>
                </div>
                
                <div class="code-block">
                    <strong>Admin-Panel:</strong><br>
                    URL: <a href="/admin/" style="color: #6ee7b7;"><?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']; ?>/admin/</a><br><br>
                    <strong>Ihre Website:</strong><br>
                    URL: <a href="/" style="color: #6ee7b7;"><?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']; ?>/</a>
                </div>
                
                <div class="button-group">
                    <a href="/" class="btn btn-secondary">← Zur Website</a>
                    <a href="/admin/" class="btn">Zum Admin-Panel →</a>
                </div>
            
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>
