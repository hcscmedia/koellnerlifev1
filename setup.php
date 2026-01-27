<?php
/**
 * Web-basiertes Setup-Script
 * Ermöglicht die Installation über den Browser
 * 
 * WICHTIG: Diese Datei nach der Installation löschen oder umbenennen!
 */

// Sicherheitscheck: Installation nur einmal erlauben
$lock_file = __DIR__ . '/.installed.lock';
if (file_exists($lock_file)) {
    die('Installation wurde bereits durchgeführt. Bitte löschen Sie .installed.lock um erneut zu installieren.');
}

session_start();

$step = $_GET['step'] ?? 1;
$errors = [];
$success = [];

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
        margin-top: 4px;
        color: #94a3b8;
        font-size: 13px;
    }
    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 24px;
    }
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid #10b981;
        color: #6ee7b7;
    }
    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid #ef4444;
        color: #fca5a5;
    }
    .alert-info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid #3b82f6;
        color: #93c5fd;
    }
    .btn {
        display: inline-block;
        padding: 14px 28px;
        background: #4f46e5;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        border: none;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn:hover {
        background: #4338ca;
        transform: translateY(-2px);
    }
    .btn-secondary {
        background: #334155;
    }
    .btn-secondary:hover {
        background: #475569;
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
                        ✓ Alle Voraussetzungen erfüllt! Sie können mit der Installation fortfahren.
                    </div>
                <?php else: ?>
                    <div class="alert alert-error">
                        ✗ Einige Voraussetzungen sind nicht erfüllt. Bitte beheben Sie die Fehler und laden Sie die Seite neu.
                    </div>
                <?php endif; ?>
                
                <div class="button-group">
                    <div></div>
                    <?php if ($all_ok): ?>
                        <a href="?step=2" class="btn">Weiter →</a>
                    <?php else: ?>
                        <a href="?step=1" class="btn btn-secondary">Neu laden</a>
                    <?php endif; ?>
                </div>
            
            <?php
            // ========================================
            // SCHRITT 2: DATENBANK-KONFIGURATION
            // ========================================
            elseif ($step == 2):
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $db_host = $_POST['db_host'] ?? '';
                    $db_name = $_POST['db_name'] ?? '';
                    $db_user = $_POST['db_user'] ?? '';
                    $db_pass = $_POST['db_pass'] ?? '';
                    
                    if (empty($db_host) || empty($db_name) || empty($db_user)) {
                        $errors[] = 'Bitte füllen Sie alle Pflichtfelder aus.';
                    } else {
                        // Verbindung testen
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
                            
                            // Schema importieren - Statement für Statement
                            $schema = file_get_contents(__DIR__ . '/database/schema.sql');
                            
                            // SQL Statements aufteilen
                            $statements = array_filter(
                                array_map('trim', explode(';', $schema)),
                                function($stmt) {
                                    // Leere Statements und Kommentare überspringen
                                    return !empty($stmt) && 
                                           !preg_match('/^--/', $stmt) && 
                                           !preg_match('/^\/\*/', $stmt);
                                }
                            );
                            
                            // Jedes Statement einzeln ausführen
                            foreach ($statements as $statement) {
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
                            header('Location: ?step=3');
                            exit;
                            
                        } catch (PDOException $e) {
                            $errors[] = 'Datenbankfehler: ' . $e->getMessage();
                        }
                    }
                }
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
                if (!isset($_SESSION['db_configured'])) {
                    header('Location: ?step=2');
                    exit;
                }
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $admin_password = $_POST['admin_password'] ?? '';
                    $admin_password_confirm = $_POST['admin_password_confirm'] ?? '';
                    
                    if (strlen($admin_password) < 8) {
                        $errors[] = 'Passwort muss mindestens 8 Zeichen lang sein.';
                    } elseif ($admin_password !== $admin_password_confirm) {
                        $errors[] = 'Passwörter stimmen nicht überein.';
                    } else {
                        require_once 'config.php';
                        require_once 'database/Database.php';
                        
                        try {
                            $db = Database::getInstance();
                            $password_hash = password_hash($admin_password, PASSWORD_DEFAULT);
                            
                            $db->execute(
                                "UPDATE admin_users SET password_hash = ? WHERE username = 'admin'",
                                [$password_hash]
                            );
                            
                            // Lock-Datei erstellen
                            file_put_contents($lock_file, date('Y-m-d H:i:s'));
                            
                            $_SESSION['installation_complete'] = true;
                            header('Location: ?step=4');
                            exit;
                            
                        } catch (Exception $e) {
                            $errors[] = 'Fehler: ' . $e->getMessage();
                        }
                    }
                }
            ?>
                <h2>Admin-Account einrichten</h2>
                <p style="margin-bottom: 24px; color: #94a3b8;">
                    Setzen Sie ein sicheres Passwort für den Admin-Account.
                </p>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <?php foreach ($errors as $error): ?>
                            <div>✗ <?php echo htmlspecialchars($error); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="alert alert-info">
                    <strong>Benutzername:</strong> admin<br>
                    Dieser kann später nicht geändert werden.
                </div>
                
                <form method="POST">
                    <div class="form-group">
                        <label>Neues Passwort *</label>
                        <input type="password" name="admin_password" required minlength="8">
                        <small>Mindestens 8 Zeichen</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Passwort wiederholen *</label>
                        <input type="password" name="admin_password_confirm" required minlength="8">
                    </div>
                    
                    <div class="button-group">
                        <a href="?step=2" class="btn btn-secondary">← Zurück</a>
                        <button type="submit" class="btn">Installation abschließen →</button>
                    </div>
                </form>
            
            <?php
            // ========================================
            // SCHRITT 4: FERTIG
            // ========================================
            elseif ($step == 4):
                if (!isset($_SESSION['installation_complete'])) {
                    header('Location: ?step=1');
                    exit;
                }
            ?>
                <div style="text-align: center; padding: 40px 0;">
                    <div style="font-size: 64px; margin-bottom: 24px;">🎉</div>
                    <h2 style="margin-bottom: 16px;">Installation erfolgreich!</h2>
                    <p style="color: #94a3b8; margin-bottom: 32px;">
                        Ihre Website ist jetzt einsatzbereit.
                    </p>
                </div>
                
                <div class="alert alert-success">
                    <strong>✓ Alle Komponenten wurden erfolgreich eingerichtet:</strong><br><br>
                    • Datenbank erstellt und konfiguriert<br>
                    • Blog-System aktiviert<br>
                    • CMS-System aktiviert<br>
                    • Admin-Panel bereit
                </div>
                
                <div class="alert alert-error">
                    <strong>⚠ WICHTIG - Sicherheitshinweis:</strong><br><br>
                    Löschen Sie die Datei <code>setup.php</code> aus Sicherheitsgründen!
                </div>
                
                <h3 style="margin: 32px 0 16px;">Nächste Schritte:</h3>
                
                <div class="code-block">
                    1. setup.php löschen<br>
                    2. Zum Admin-Panel: /admin/<br>
                    3. Einloggen mit: admin / (Ihr Passwort)<br>
                    4. Ersten Blog-Post erstellen<br>
                    5. Blog zur Navigation hinzufügen
                </div>
                
                <div style="margin-top: 32px; text-align: center;">
                    <a href="/admin/" class="btn" style="margin-right: 12px;">Zum Admin-Panel →</a>
                    <a href="/" class="btn btn-secondary">Zur Website →</a>
                </div>
            
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
