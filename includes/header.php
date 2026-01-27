<?php
/**
 * Header-Template für alle Seiten
 * Enthält: Meta-Tags, CSS-Links, Navigation
 */

// Seitentitel basierend auf der aktuellen Seite
$page_titles = [
    'home' => 'Startseite',
    'services' => 'Leistungen',
    'projects' => 'Projekte',
    'about' => 'Über mich',
    'contact' => 'Kontakt'
];

$page_title = isset($page_titles[$current_page]) ? $page_titles[$current_page] . ' | ' . SITE_NAME : SITE_NAME;
?>
<!DOCTYPE html>
<html lang="<?php echo SITE_LANGUAGE; ?>">
<head>
    <meta charset="<?php echo SITE_CHARSET; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title><?php echo escape_html($page_title); ?></title>
    <meta name="description" content="<?php echo escape_html(SITE_DESCRIPTION); ?>">
    <meta name="keywords" content="KI Beratung, AI, Automation, Webentwicklung, Fotografie, Business, Portrait">
    <meta name="author" content="Köllner Digital">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL; ?>">
    <meta property="og:title" content="<?php echo escape_html($page_title); ?>">
    <meta property="og:description" content="<?php echo escape_html(SITE_DESCRIPTION); ?>">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo SITE_URL; ?>">
    <meta property="twitter:title" content="<?php echo escape_html($page_title); ?>">
    <meta property="twitter:description" content="<?php echo escape_html(SITE_DESCRIPTION); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo BASE_PATH; ?>/assets/images/favicon.png">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>/assets/css/style.css">
    
    <!-- Font: Inter from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="page-<?php echo $current_page; ?>">
    
    <?php include 'navigation.php'; ?>
    
    <main class="main-content">
