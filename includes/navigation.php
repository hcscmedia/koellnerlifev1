<nav class="navbar" id="navbar">
    <div class="container">
        <div class="nav-wrapper">
            <a href="/" class="logo">
                <span class="logo-text"><?php echo SITE_NAME; ?></span>
            </a>
            
            <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle Navigation">
                <span class="hamburger"></span>
                <span class="hamburger"></span>
                <span class="hamburger"></span>
            </button>
            
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item">
                    <a href="/" class="nav-link <?php echo is_active('home'); ?>">Startseite</a>
                </li>
                <li class="nav-item">
                    <a href="/pages/services.php" class="nav-link <?php echo is_active('services'); ?>">Leistungen</a>
                </li>
                <li class="nav-item">
                    <a href="/pages/projects.php" class="nav-link <?php echo is_active('projects'); ?>">Projekte</a>
                </li>
                <li class="nav-item">
                    <a href="/pages/about.php" class="nav-link <?php echo is_active('about'); ?>">Über mich</a>
                </li>
                <li class="nav-item">
                    <a href="/pages/contact.php" class="nav-link <?php echo is_active('contact'); ?>">Kontakt</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
