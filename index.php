<?php
/**
 * Startseite - koellner.life
 */

require_once 'config.php';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-background">
        <div class="grid-overlay"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="badge-dot"></span>
                Verfügbar für neue Projekte
            </div>
            <h1 class="hero-title">
                <span class="gradient-text">Digitale Lösungen</span><br>
                für die Zukunft
            </h1>
            <p class="hero-description">
                KI-Beratung, Automation, Webentwicklung und professionelle Fotografie<br>
                — alles aus einer Hand für Ihr erfolgreiches Business.
            </p>
            <div class="hero-cta">
                <a href="/pages/contact.php" class="btn btn-primary">
                    Projekt starten
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="btn-icon">
                        <path d="M4 10h12m0 0l-4-4m4 4l-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="/pages/projects.php" class="btn btn-secondary">
                    Projekte ansehen
                </a>
            </div>
        </div>
        
        <div class="hero-stats">
            <div class="stat-card">
                <div class="stat-number">5+</div>
                <div class="stat-label">Jahre Erfahrung</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">50+</div>
                <div class="stat-label">Projekte</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">100%</div>
                <div class="stat-label">Kundenzufriedenheit</div>
            </div>
        </div>
    </div>
</section>

<!-- Services Preview -->
<section class="services-preview section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Meine Leistungen</h2>
            <p class="section-description">
                Professionelle Services für Ihr digitales Business
            </p>
        </div>
        
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M20 5L25 15L35 17L27.5 25L29 35L20 30L11 35L12.5 25L5 17L15 15L20 5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="service-title">KI / AI Beratung</h3>
                <p class="service-description">
                    Nutzen Sie die Kraft künstlicher Intelligenz für Ihr Unternehmen. 
                    Von Strategieentwicklung bis zur Implementierung.
                </p>
                <a href="/pages/services.php#ai" class="service-link">
                    Mehr erfahren
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M3 8h10m0 0l-3-3m3 3l-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M10 15L20 5L30 15M10 25L20 15L30 25M10 35L20 25L30 35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="service-title">Automation</h3>
                <p class="service-description">
                    Optimieren Sie Ihre Workflows durch intelligente Automatisierung. 
                    Mehr Zeit für das Wesentliche.
                </p>
                <a href="/pages/services.php#automation" class="service-link">
                    Mehr erfahren
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M3 8h10m0 0l-3-3m3 3l-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <rect x="5" y="5" width="30" height="30" rx="3" stroke="currentColor" stroke-width="2"/>
                        <path d="M5 15h30M15 5v30" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="service-title">Webentwicklung</h3>
                <p class="service-description">
                    Moderne Websites, Tools und Dashboards. Schnell, sicher und 
                    benutzerfreundlich.
                </p>
                <a href="/pages/services.php#web" class="service-link">
                    Mehr erfahren
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M3 8h10m0 0l-3-3m3 3l-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <circle cx="20" cy="20" r="12" stroke="currentColor" stroke-width="2"/>
                        <path d="M20 8v24M8 20h24" stroke="currentColor" stroke-width="2"/>
                        <circle cx="20" cy="20" r="4" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="service-title">Fotografie</h3>
                <p class="service-description">
                    Professionelle Business-, Portrait- und Content-Fotografie 
                    für Ihre Markenpräsenz.
                </p>
                <a href="/pages/services.php#photography" class="service-link">
                    Mehr erfahren
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M3 8h10m0 0l-3-3m3 3l-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
        
        <div class="section-cta">
            <a href="/pages/services.php" class="btn btn-primary">
                Alle Leistungen ansehen
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section">
    <div class="container">
        <div class="cta-card">
            <div class="cta-content">
                <h2 class="cta-title">Bereit für Ihr nächstes Projekt?</h2>
                <p class="cta-description">
                    Lassen Sie uns gemeinsam Ihre Vision in die Realität umsetzen.
                </p>
            </div>
            <div class="cta-actions">
                <a href="/pages/contact.php" class="btn btn-primary btn-large">
                    Jetzt Kontakt aufnehmen
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
