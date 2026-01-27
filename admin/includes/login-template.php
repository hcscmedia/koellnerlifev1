<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/assets/css/admin-style.css">
</head>
<body class="admin-login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1><?php echo SITE_NAME; ?></h1>
                <p>Admin-Panel</p>
            </div>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="login-form" id="loginForm">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                
                <div class="form-group">
                    <label for="username">Benutzername</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           required 
                           autofocus
                           autocomplete="username">
                </div>
                
                <div class="form-group">
                    <label for="password">Passwort</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           autocomplete="current-password">
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember_me">
                        <span>Angemeldet bleiben</span>
                    </label>
                </div>
                
                <button type="submit" name="login" class="btn btn-primary btn-block">
                    Anmelden
                </button>
            </form>
            
            <div class="login-footer">
                <a href="<?php echo SITE_URL; ?>" class="back-link">← Zurück zur Website</a>
            </div>
        </div>
    </div>
    
    <script>
        // Form-Validierung
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                e.preventDefault();
                alert('Bitte füllen Sie alle Felder aus.');
            }
        });
    </script>
</body>
</html>
