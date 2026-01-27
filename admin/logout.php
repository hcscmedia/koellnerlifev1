<?php
/**
 * Admin Logout
 */

require_once '../config.php';
require_once __DIR__ . '/classes/AdminAuth.php';

$auth = new AdminAuth();
$auth->logout();

header('Location: login.php?logout=success');
exit;
