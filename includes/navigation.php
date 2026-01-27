<nav class="navbar" id="navbar">
    <div class="container">
        <div class="nav-wrapper">
            <a href="<?php echo BASE_PATH; ?>/" class="logo">
                <span class="logo-text"><?php echo SITE_NAME; ?></span>
            </a>
            
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle Navigation">
                <span class="hamburger"></span>
                <span class="hamburger"></span>
                <span class="hamburger"></span>
            </button>
            
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>/" class="nav-link <?php echo is_active('home'); ?>">Startseite</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>/pages/services.php" class="nav-link <?php echo is_active('services'); ?>">Leistungen</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>/pages/projects.php" class="nav-link <?php echo is_active('projects'); ?>">Projekte</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>/pages/about.php" class="nav-link <?php echo is_active('about'); ?>">Über mich</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>/pages/contact.php" class="nav-link <?php echo is_active('contact'); ?>">Kontakt</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
