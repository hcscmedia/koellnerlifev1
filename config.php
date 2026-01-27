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

// Error Reporting (für Entwicklung auf true, für Produktion auf false)
define('DEBUG_MODE', false);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Database Configuration (optional für zukünftige Erweiterungen)
define('DB_HOST', 'localhost');
define('DB_NAME', 'koellner_life');
define('DB_USER', '');
define('DB_PASSWORD', '');

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
