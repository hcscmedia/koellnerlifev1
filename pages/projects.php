<?php
/**
 * Projekte - koellner.life
 */

require_once '../config.php';
include '../includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-title">Meine Projekte</h1>
        <p class="page-description">
            Eine Auswahl meiner erfolgreich umgesetzten Projekte
        </p>
    </div>
</section>

<section class="projects-section section">
    <div class="container">
        <!-- Filter -->
        <div class="projects-filter">
            <button class="filter-btn active" data-filter="all">Alle</button>
            <button class="filter-btn" data-filter="ai">KI / AI</button>
            <button class="filter-btn" data-filter="automation">Automation</button>
            <button class="filter-btn" data-filter="web">Webentwicklung</button>
            <button class="filter-btn" data-filter="photography">Fotografie</button>
        </div>
        
        <!-- Projects Grid -->
        <div class="projects-grid">
            <!-- Projekt 1 -->
            <div class="project-card" data-category="ai web">
                <div class="project-image">
                    <div class="project-image-placeholder">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <path d="M40 10L50 30L70 34L55 50L58 70L40 60L22 70L25 50L10 34L30 30L40 10Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-tags">
                        <span class="project-tag">KI</span>
                        <span class="project-tag">Web</span>
                    </div>
                    <h3 class="project-title">AI Content Generator</h3>
                    <p class="project-description">
                        Web-basiertes Tool zur automatischen Generierung von Marketing-Content 
                        mittels GPT-4 API Integration.
                    </p>
                    <div class="project-tech">
                        <span class="tech-badge">OpenAI</span>
                        <span class="tech-badge">React</span>
                        <span class="tech-badge">Node.js</span>
                    </div>
                </div>
            </div>
            
            <!-- Projekt 2 -->
            <div class="project-card" data-category="automation">
                <div class="project-image">
                    <div class="project-image-placeholder">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <path d="M20 30L40 10L60 30M20 50L40 30L60 50M20 70L40 50L60 70" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-tags">
                        <span class="project-tag">Automation</span>
                    </div>
                    <h3 class="project-title">E-Mail Marketing Automation</h3>
                    <p class="project-description">
                        Vollautomatisiertes E-Mail-Marketing-System mit Segmentierung, 
                        A/B-Testing und Analytics.
                    </p>
                    <div class="project-tech">
                        <span class="tech-badge">Zapier</span>
                        <span class="tech-badge">Python</span>
                        <span class="tech-badge">APIs</span>
                    </div>
                </div>
            </div>
            
            <!-- Projekt 3 -->
            <div class="project-card" data-category="web">
                <div class="project-image">
                    <div class="project-image-placeholder">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <rect x="10" y="10" width="60" height="60" rx="5" stroke="currentColor" stroke-width="2"/>
                            <path d="M10 30h60M30 10v60" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-tags">
                        <span class="project-tag">Web</span>
                    </div>
                    <h3 class="project-title">Dashboard für Datenvisualisierung</h3>
                    <p class="project-description">
                        Interaktives Dashboard zur Visualisierung komplexer Unternehmensdaten 
                        in Echtzeit.
                    </p>
                    <div class="project-tech">
                        <span class="tech-badge">Vue.js</span>
                        <span class="tech-badge">D3.js</span>
                        <span class="tech-badge">PHP</span>
                    </div>
                </div>
            </div>
            
            <!-- Projekt 4 -->
            <div class="project-card" data-category="photography">
                <div class="project-image">
                    <div class="project-image-placeholder">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="24" stroke="currentColor" stroke-width="2"/>
                            <path d="M40 16v48M16 40h48" stroke="currentColor" stroke-width="2"/>
                            <circle cx="40" cy="40" r="8" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-tags">
                        <span class="project-tag">Fotografie</span>
                    </div>
                    <h3 class="project-title">Corporate Photography Series</h3>
                    <p class="project-description">
                        Professionelle Fotoserie für Unternehmenswebsite und Marketing-Materialien 
                        eines Tech-Startups.
                    </p>
                    <div class="project-tech">
                        <span class="tech-badge">Business</span>
                        <span class="tech-badge">Portrait</span>
                        <span class="tech-badge">Bearbeitung</span>
                    </div>
                </div>
            </div>
            
            <!-- Projekt 5 -->
            <div class="project-card" data-category="automation web">
                <div class="project-image">
                    <div class="project-image-placeholder">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <path d="M20 40h40M40 20v40M30 30l10-10 10 10M30 50l10 10 10-10" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-tags">
                        <span class="project-tag">Automation</span>
                        <span class="project-tag">Web</span>
                    </div>
                    <h3 class="project-title">Social Media Scheduler</h3>
                    <p class="project-description">
                        Web-App zur automatisierten Planung und Veröffentlichung von 
                        Social Media Posts über mehrere Plattformen.
                    </p>
                    <div class="project-tech">
                        <span class="tech-badge">React</span>
                        <span class="tech-badge">APIs</span>
                        <span class="tech-badge">Cron</span>
                    </div>
                </div>
            </div>
            
            <!-- Projekt 6 -->
            <div class="project-card" data-category="ai automation">
                <div class="project-image">
                    <div class="project-image-placeholder">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <circle cx="40" cy="40" r="25" stroke="currentColor" stroke-width="2"/>
                            <circle cx="40" cy="40" r="15" stroke="currentColor" stroke-width="2"/>
                            <circle cx="40" cy="40" r="5" fill="currentColor"/>
                        </svg>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-tags">
                        <span class="project-tag">KI</span>
                        <span class="project-tag">Automation</span>
                    </div>
                    <h3 class="project-title">Chatbot für Kundenservice</h3>
                    <p class="project-description">
                        KI-gestützter Chatbot mit Natural Language Processing für 
                        automatisierten 24/7 Kundenservice.
                    </p>
                    <div class="project-tech">
                        <span class="tech-badge">GPT-4</span>
                        <span class="tech-badge">Python</span>
                        <span class="tech-badge">WebSocket</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section section">
    <div class="container">
        <div class="cta-card">
            <div class="cta-content">
                <h2 class="cta-title">Haben Sie ein Projekt im Kopf?</h2>
                <p class="cta-description">
                    Lassen Sie uns gemeinsam etwas Großartiges schaffen.
                </p>
            </div>
            <div class="cta-actions">
                <a href="/pages/contact.php" class="btn btn-primary btn-large">
                    Projekt besprechen
                </a>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
