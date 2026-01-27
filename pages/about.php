<?php
/**
 * Über mich - koellner.life
 */

require_once '../config.php';
include '../includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-title">Über mich</h1>
        <p class="page-description">
            Digitaler Problemlöser mit Leidenschaft für Innovation
        </p>
    </div>
</section>

<!-- About Content -->
<section class="about-section section">
    <div class="container">
        <div class="about-grid">
            <div class="about-image">
                <div class="about-image-placeholder">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none">
                        <circle cx="50" cy="35" r="20" stroke="currentColor" stroke-width="2"/>
                        <path d="M20 90c0-16.569 13.431-30 30-30s30 13.431 30 30" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
            </div>
            
            <div class="about-content">
                <h2 class="about-title">Hallo, ich bin Köllner</h2>
                <p class="about-text">
                    Als Full-Stack-Entwickler und digitaler Stratege helfe ich Unternehmen dabei, 
                    ihre digitale Transformation erfolgreich zu gestalten. Mit über 5 Jahren Erfahrung 
                    in den Bereichen KI, Automation, Webentwicklung und Fotografie bringe ich eine 
                    einzigartige Kombination von Fähigkeiten mit.
                </p>
                <p class="about-text">
                    Mein Fokus liegt auf der Entwicklung maßgeschneiderter Lösungen, die nicht nur 
                    technisch einwandfrei funktionieren, sondern auch echten Mehrwert für Ihr Business 
                    schaffen. Dabei setze ich auf moderne Technologien, agile Methoden und eine enge 
                    Zusammenarbeit mit meinen Kunden.
                </p>
                <p class="about-text">
                    Neben der Entwicklung begeistere ich mich für professionelle Fotografie. Die 
                    Kombination aus technischem Know-how und kreativem Auge ermöglicht es mir, 
                    ganzheitliche digitale Lösungen anzubieten.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Skills -->
<section class="skills-section section section-alt">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Skills & Technologien</h2>
            <p class="section-description">
                Mein Werkzeugkasten für erfolgreiche Projekte
            </p>
        </div>
        
        <div class="skills-grid">
            <div class="skill-category">
                <h3 class="skill-category-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3L17 8L22 10L17 15L19 20L12 18L5 20L7 15L2 10L7 8L12 3Z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    KI & Machine Learning
                </h3>
                <div class="skill-tags">
                    <span class="skill-tag">ChatGPT / GPT-4</span>
                    <span class="skill-tag">OpenAI API</span>
                    <span class="skill-tag">TensorFlow</span>
                    <span class="skill-tag">PyTorch</span>
                    <span class="skill-tag">Hugging Face</span>
                    <span class="skill-tag">LangChain</span>
                    <span class="skill-tag">Natural Language Processing</span>
                    <span class="skill-tag">Computer Vision</span>
                </div>
            </div>
            
            <div class="skill-category">
                <h3 class="skill-category-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M5 15L12 8L19 15M5 20L12 13L19 20" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Automation & Tools
                </h3>
                <div class="skill-tags">
                    <span class="skill-tag">Zapier</span>
                    <span class="skill-tag">Make.com</span>
                    <span class="skill-tag">n8n</span>
                    <span class="skill-tag">Python Scripts</span>
                    <span class="skill-tag">Selenium</span>
                    <span class="skill-tag">REST APIs</span>
                    <span class="skill-tag">Webhooks</span>
                    <span class="skill-tag">Cron Jobs</span>
                </div>
            </div>
            
            <div class="skill-category">
                <h3 class="skill-category-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 9h18M9 3v18" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Frontend Development
                </h3>
                <div class="skill-tags">
                    <span class="skill-tag">HTML5</span>
                    <span class="skill-tag">CSS3 / SASS</span>
                    <span class="skill-tag">JavaScript (ES6+)</span>
                    <span class="skill-tag">React</span>
                    <span class="skill-tag">Vue.js</span>
                    <span class="skill-tag">TypeScript</span>
                    <span class="skill-tag">Tailwind CSS</span>
                    <span class="skill-tag">Responsive Design</span>
                </div>
            </div>
            
            <div class="skill-category">
                <h3 class="skill-category-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Backend Development
                </h3>
                <div class="skill-tags">
                    <span class="skill-tag">PHP</span>
                    <span class="skill-tag">Python</span>
                    <span class="skill-tag">Node.js</span>
                    <span class="skill-tag">MySQL</span>
                    <span class="skill-tag">PostgreSQL</span>
                    <span class="skill-tag">MongoDB</span>
                    <span class="skill-tag">RESTful APIs</span>
                    <span class="skill-tag">GraphQL</span>
                </div>
            </div>
            
            <div class="skill-category">
                <h3 class="skill-category-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 4v16M4 12h16" stroke="currentColor" stroke-width="2"/>
                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Fotografie & Medien
                </h3>
                <div class="skill-tags">
                    <span class="skill-tag">Business Fotografie</span>
                    <span class="skill-tag">Portrait Fotografie</span>
                    <span class="skill-tag">Adobe Photoshop</span>
                    <span class="skill-tag">Lightroom</span>
                    <span class="skill-tag">Content Creation</span>
                    <span class="skill-tag">Video Editing</span>
                    <span class="skill-tag">Social Media Content</span>
                </div>
            </div>
            
            <div class="skill-category">
                <h3 class="skill-category-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Tools & Workflow
                </h3>
                <div class="skill-tags">
                    <span class="skill-tag">Git / GitHub</span>
                    <span class="skill-tag">VS Code</span>
                    <span class="skill-tag">Docker</span>
                    <span class="skill-tag">Figma</span>
                    <span class="skill-tag">Adobe XD</span>
                    <span class="skill-tag">Postman</span>
                    <span class="skill-tag">Linux</span>
                    <span class="skill-tag">Agile / Scrum</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="values-section section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Meine Arbeitsweise</h2>
            <p class="section-description">
                Was Sie von mir erwarten können
            </p>
        </div>
        
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <path d="M24 8L32 18L44 21L34 31L36 43L24 37L12 43L14 31L4 21L16 18L24 8Z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="value-title">Qualität vor Quantität</h3>
                <p class="value-description">
                    Jedes Projekt verdient höchste Aufmerksamkeit und Sorgfalt. Ich lege Wert 
                    auf sauberen Code und durchdachte Lösungen.
                </p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="16" stroke="currentColor" stroke-width="2"/>
                        <path d="M24 12v12l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="value-title">Zuverlässigkeit</h3>
                <p class="value-description">
                    Transparente Kommunikation, realistische Zeitpläne und verlässliche 
                    Umsetzung — darauf können Sie sich verlassen.
                </p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <path d="M8 24l8 8 24-24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="value-title">Ergebnisorientiert</h3>
                <p class="value-description">
                    Mein Fokus liegt auf messbaren Ergebnissen und echtem Mehrwert 
                    für Ihr Business.
                </p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <path d="M24 4v40M4 24h40M12 12l24 24M12 36l24-24" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="value-title">Innovation</h3>
                <p class="value-description">
                    Ich bleibe am Puls der Zeit und setze moderne Technologien 
                    gezielt und sinnvoll ein.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section section">
    <div class="container">
        <div class="cta-card">
            <div class="cta-content">
                <h2 class="cta-title">Lassen Sie uns zusammenarbeiten</h2>
                <p class="cta-description">
                    Ich freue mich darauf, von Ihrem Projekt zu hören.
                </p>
            </div>
            <div class="cta-actions">
                <a href="/pages/contact.php" class="btn btn-primary btn-large">
                    Kontakt aufnehmen
                </a>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
