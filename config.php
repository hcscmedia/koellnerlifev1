<?php
/**
 * Konfigurationsdatei für koellner.life
 * 
 * Hier werden alle wichtigen Einstellungen für die Website zentral verwaltet.
 */

// Site Information
define('SITE_NAME', 'Köllner Digital');
define('SITE_TAGLINE', 'KI-Beratung | Automation | Webentwicklung | Fotografie');
define('SITE_URL', 'https://koellner.life');
define('SITE_DESCRIPTION', 'Professionelle Dienstleistungen in den Bereichen KI/AI-Beratung, Automation, Webentwicklung und Fotografie.');

// Contact Information
define('CONTACT_EMAIL', 'kontakt@koellner.life');
define('PHONE_NUMBER', ''); // Optional: Telefonnummer eintragen

// Social Media Links
define('SOCIAL_GITHUB', 'https://github.com');
define('SOCIAL_LINKEDIN', 'https://linkedin.com');
define('SOCIAL_INSTAGRAM', 'https://instagram.com');
define('SOCIAL_TWITTER', 'https://twitter.com');

// Site Settings
define('SITE_CHARSET', 'UTF-8');
define('SITE_LANGUAGE', 'de');

// Base Path (für Unterverzeichnis-Installation wie /koellnerlife/)
// Automatisch ermitteln oder manuell setzen: define('BASE_PATH', '/koellnerlife');
$script_name = dirname($_SERVER['SCRIPT_NAME']);
define('BASE_PATH', $script_name === '/' ? '' : rtrim($script_name, '/'));

// Error Reporting (für Entwicklung auf true, für Produktion auf false)
define('DEBUG_MODE', false);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'koellner_life');
define('DB_USER', 'root');
define('DB_PASS', '');

// Admin Panel Settings
define('ADMIN_PATH', '/admin');
define('SESSION_LIFETIME', 3600); // 1 Stunde
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 Minuten

// Upload Settings
define('UPLOAD_DIR', __DIR__ . '/uploads');
define('MAX_UPLOAD_SIZE', 5242880); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Security
define('ADMIN_SESSION_NAME', 'koellner_admin_session');

// Autoload Database Class
require_once __DIR__ . '/database/Database.php';

// Aktuelle Seite ermitteln
$current_page = basename($_SERVER['PHP_SELF'], '.php');
if ($current_page === 'index') {
    $current_page = 'home';
}

/**
 * Funktion zum Escapen von HTML
 * 
 * @param string $string Der zu escapende String
 * @return string Der escapte String
 */
function escape_html($string) {
    return htmlspecialchars($string, ENT_QUOTES, SITE_CHARSET);
}

/**
 * Funktion zum Prüfen ob aktuelle Seite
 * 
 * @param string $page Die zu prüfende Seite
 * @return string 'active' wenn aktuelle Seite, sonst ''
 */
function is_active($page) {
    global $current_page;
    return ($current_page === $page) ? 'active' : '';
}
?>
