<?php
/**
 * Admin Authentication Class
 * Verwaltet Login, Logout, Session und Berechtigungen
 */

class AdminAuth {
    private $db;
    private $session_name;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->session_name = ADMIN_SESSION_NAME;
        
        // Session starten
        if (session_status() === PHP_SESSION_NONE) {
            session_name($this->session_name);
            session_start();
            
            // Session-Sicherheit
            if (!isset($_SESSION['initiated'])) {
                session_regenerate_id(true);
                $_SESSION['initiated'] = true;
            }
        }
    }
    
    /**
     * Admin-Login
     */
    public function login($username, $password) {
        // Rate Limiting prüfen
        if ($this->isLockedOut($username)) {
            return [
                'success' => false,
                'message' => 'Zu viele Anmeldeversuche. Bitte warten Sie 15 Minuten.'
            ];
        }
        
        // Admin suchen
        $admin = $this->db->fetchOne(
            "SELECT * FROM admin_users WHERE username = ? AND is_active = 1",
            [$username]
        );
        
        if (!$admin) {
            $this->recordLoginAttempt($username, false);
            return [
                'success' => false,
                'message' => 'Ungültige Anmeldedaten.'
            ];
        }
        
        // Passwort prüfen
        if (!password_verify($password, $admin['password_hash'])) {
            $this->recordLoginAttempt($username, false);
            return [
                'success' => false,
                'message' => 'Ungültige Anmeldedaten.'
            ];
        }
        
        // Login erfolgreich
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_name'] = $admin['full_name'];
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['login_time'] = time();
        
        // Last Login aktualisieren
        $this->db->execute(
            "UPDATE admin_users SET last_login = NOW() WHERE id = ?",
            [$admin['id']]
        );
        
        // Activity Log
        $this->logActivity($admin['id'], 'login', 'admin_users', $admin['id'], 'Admin Login erfolgreich');
        
        // Login-Versuche zurücksetzen
        $this->resetLoginAttempts($username);
        
        return [
            'success' => true,
            'message' => 'Login erfolgreich.',
            'redirect' => ADMIN_PATH . '/dashboard.php'
        ];
    }
    
    /**
     * Admin-Logout
     */
    public function logout() {
        if ($this->isLoggedIn()) {
            $admin_id = $_SESSION['admin_id'];
            $this->logActivity($admin_id, 'logout', 'admin_users', $admin_id, 'Admin Logout');
        }
        
        $_SESSION = [];
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        session_destroy();
        
        return true;
    }
    
    /**
     * Prüfen ob Admin eingeloggt ist
     */
    public function isLoggedIn() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            return false;
        }
        
        // Session-Timeout prüfen
        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > SESSION_LIFETIME)) {
            $this->logout();
            return false;
        }
        
        // Session-Zeit aktualisieren
        $_SESSION['login_time'] = time();
        
        return true;
    }
    
    /**
     * Login erforderlich - Redirect wenn nicht eingeloggt
     */
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . ADMIN_PATH . '/login.php');
            exit;
        }
    }
    
    /**
     * Aktuellen Admin abrufen
     */
    public function getCurrentAdmin() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        return $this->db->fetchOne(
            "SELECT id, username, email, full_name, created_at FROM admin_users WHERE id = ?",
            [$_SESSION['admin_id']]
        );
    }
    
    /**
     * Login-Versuch aufzeichnen
     */
    private function recordLoginAttempt($username, $success) {
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = [];
        }
        
        if (!isset($_SESSION['login_attempts'][$username])) {
            $_SESSION['login_attempts'][$username] = [
                'count' => 0,
                'last_attempt' => time()
            ];
        }
        
        if (!$success) {
            $_SESSION['login_attempts'][$username]['count']++;
            $_SESSION['login_attempts'][$username]['last_attempt'] = time();
        }
    }
    
    /**
     * Login-Versuche zurücksetzen
     */
    private function resetLoginAttempts($username) {
        if (isset($_SESSION['login_attempts'][$username])) {
            unset($_SESSION['login_attempts'][$username]);
        }
    }
    
    /**
     * Prüfen ob Account gesperrt ist
     */
    private function isLockedOut($username) {
        if (!isset($_SESSION['login_attempts'][$username])) {
            return false;
        }
        
        $attempts = $_SESSION['login_attempts'][$username];
        
        if ($attempts['count'] >= MAX_LOGIN_ATTEMPTS) {
            $time_since_last = time() - $attempts['last_attempt'];
            
            if ($time_since_last < LOGIN_LOCKOUT_TIME) {
                return true;
            } else {
                // Lockout abgelaufen, zurücksetzen
                $this->resetLoginAttempts($username);
                return false;
            }
        }
        
        return false;
    }
    
    /**
     * Activity Log schreiben
     */
    public function logActivity($admin_id, $action, $entity_type = null, $entity_id = null, $description = null) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        
        $this->db->execute(
            "INSERT INTO admin_activity_log (admin_id, action, entity_type, entity_id, description, ip_address) 
             VALUES (?, ?, ?, ?, ?, ?)",
            [$admin_id, $action, $entity_type, $entity_id, $description, $ip]
        );
    }
    
    /**
     * Passwort ändern
     */
    public function changePassword($admin_id, $old_password, $new_password) {
        $admin = $this->db->fetchOne(
            "SELECT password_hash FROM admin_users WHERE id = ?",
            [$admin_id]
        );
        
        if (!$admin || !password_verify($old_password, $admin['password_hash'])) {
            return [
                'success' => false,
                'message' => 'Aktuelles Passwort ist falsch.'
            ];
        }
        
        // Passwort-Stärke prüfen
        if (strlen($new_password) < 8) {
            return [
                'success' => false,
                'message' => 'Passwort muss mindestens 8 Zeichen lang sein.'
            ];
        }
        
        $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
        
        $this->db->execute(
            "UPDATE admin_users SET password_hash = ? WHERE id = ?",
            [$new_hash, $admin_id]
        );
        
        $this->logActivity($admin_id, 'password_change', 'admin_users', $admin_id, 'Passwort geändert');
        
        return [
            'success' => true,
            'message' => 'Passwort erfolgreich geändert.'
        ];
    }
    
    /**
     * CSRF-Token generieren
     */
    public function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * CSRF-Token validieren
     */
    public function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
