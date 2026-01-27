<?php
/**
 * Admin Login Page
 */

require_once '../config.php';

// Admin Auth laden
require_once __DIR__ . '/classes/AdminAuth.php';
$auth = new AdminAuth();

// Wenn bereits eingeloggt, zu Dashboard weiterleiten
if ($auth->isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

// CSRF-Token generieren
$csrf_token = $auth->generateCSRFToken();

$error_message = null;
$success_message = null;

// Login-Formular verarbeiten
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // CSRF-Token validieren
    if (!isset($_POST['csrf_token']) || !$auth->validateCSRFToken($_POST['csrf_token'])) {
        $error_message = 'Ungültige Anfrage. Bitte versuchen Sie es erneut.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $error_message = 'Bitte füllen Sie alle Felder aus.';
        } else {
            $result = $auth->login($username, $password);
            
            if ($result['success']) {
                // Redirect nach erfolreichem Login
                $redirect = $_SESSION['redirect_after_login'] ?? 'dashboard.php';
                unset($_SESSION['redirect_after_login']);
                header('Location: ' . $redirect);
                exit;
            } else {
                $error_message = $result['message'];
            }
        }
    }
}

// Logout-Message
if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
    $success_message = 'Sie wurden erfolgreich abgemeldet.';
}

// Login-Template laden
include __DIR__ . '/includes/login-template.php';
