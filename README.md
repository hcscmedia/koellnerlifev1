# Köllner Digital - Portfolio Website

Moderne, professionelle Portfolio-Website für KI-Beratung, Automation, Webentwicklung und Fotografie.

🌐 **Live:** [koellner.life](https://koellner.life)

## 📋 Übersicht

Diese Website ist eine vollständig responsive, moderne Portfolio-Website mit Dark-Theme-Design, optimiert für Performance und SEO. Sie präsentiert Dienstleistungen in den Bereichen:

- 🤖 **KI / AI Beratung** - ChatGPT, Machine Learning, Datenanalyse
- ⚡ **Automation** - Workflow-Automatisierung, Bots, API-Integration
- 💻 **Webentwicklung** - Responsive Websites, Web-Tools, Dashboards
- 📸 **Fotografie** - Business, Portrait, Content Creation

## 🚀 Features

- ✅ Modernes Dark/Tech-Design mit Glasmorphism-Effekten
- ✅ Mobile-First & vollständig responsiv
- ✅ SEO-optimiert mit semantischem HTML5
- ✅ Schnelle Ladezeiten durch Optimierungen
- ✅ Kontaktformular mit PHP-Mailer
- ✅ Interaktive Animationen
- ✅ Clean Code & gut dokumentiert
- ✅ Keine Build-Tools erforderlich
- ✅ Shared Hosting kompatibel

## 📁 Projektstruktur

```
koellnerlifev1/
├── assets/
│   ├── css/
│   │   └── style.css          # Haupt-Stylesheet (Dark Theme)
│   ├── js/
│   │   └── main.js            # JavaScript für Interaktivität
│   └── images/                # Bilder und Assets
├── includes/
│   ├── header.php             # Wiederverwendbarer Header
│   ├── footer.php             # Wiederverwendbarer Footer
│   └── navigation.php         # Navigation Component
├── pages/
│   ├── services.php           # Leistungen/Services
│   ├── projects.php           # Portfolio/Projekte
│   ├── about.php              # Über mich
│   └── contact.php            # Kontaktformular
├── index.php                  # Startseite
├── config.php                 # Konfigurationsdatei
├── .htaccess                  # Apache-Konfiguration
└── README.md                  # Diese Datei
```

## 🛠️ Technologie-Stack

### Frontend
- **HTML5** - Semantisches Markup
- **CSS3** - Custom Properties, Flexbox, Grid
- **JavaScript (ES6+)** - Vanilla JS, keine Frameworks
- **Google Fonts** - Inter Font Family

### Backend
- **PHP 7.4+** - Serverseitige Logik
- **Mail-Funktion** - Kontaktformular

### Server
- **Apache** - Webserver mit mod_rewrite
- **Shared Hosting** - Spaceship Hoster kompatibel

## 📦 Installation

### Voraussetzungen

- PHP 7.4 oder höher
- Apache Webserver mit mod_rewrite
- E-Mail-Funktion (für Kontaktformular)

### Schritt 1: Dateien hochladen

1. Alle Dateien per FTP auf Ihren Webserver hochladen
2. In das Hauptverzeichnis Ihrer Domain (z.B. `/public_html/`)

### Schritt 2: Konfiguration

1. **config.php** öffnen und anpassen:

```php
// Site Information
define('SITE_NAME', 'Ihr Name');
define('SITE_URL', 'https://ihre-domain.de');

// Contact Information
define('CONTACT_EMAIL', 'ihre-email@domain.de');

// Social Media Links
define('SOCIAL_GITHUB', 'https://github.com/username');
define('SOCIAL_LINKEDIN', 'https://linkedin.com/in/username');
define('SOCIAL_INSTAGRAM', 'https://instagram.com/username');
```

2. **Debug-Modus** für Entwicklung:

```php
define('DEBUG_MODE', true);  // Entwicklung
define('DEBUG_MODE', false); // Produktion
```

### Schritt 3: .htaccess anpassen (optional)

```apache
# HTTPS Redirect aktivieren (wenn SSL verfügbar)
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# WWW Redirect (mit oder ohne www)
# Kommentar entfernen für gewünschte Variante
```

### Schritt 4: Berechtigungen setzen

```bash
# Empfohlene Berechtigungen
chmod 644 *.php
chmod 644 .htaccess
chmod 755 assets/
chmod 755 pages/
chmod 755 includes/
```

## 🎨 Anpassungen

### Farben ändern

In `assets/css/style.css` die CSS-Variablen anpassen:

```css
:root {
    --color-accent-primary: #6366f1;    /* Hauptakzentfarbe */
    --color-accent-secondary: #8b5cf6;  /* Sekundäre Akzentfarbe */
    --color-bg-primary: #0a0a0f;        /* Haupthintergrund */
}
```

### Inhalte ändern

1. **Startseite**: `index.php` bearbeiten
2. **Leistungen**: `pages/services.php` bearbeiten
3. **Projekte**: `pages/projects.php` bearbeiten
4. **Über mich**: `pages/about.php` bearbeiten
5. **Kontakt**: `pages/contact.php` bearbeiten

### Bilder hinzufügen

1. Bilder in `/assets/images/` hochladen
2. Im entsprechenden PHP-File referenzieren:

```html
<img src="/assets/images/ihr-bild.jpg" alt="Beschreibung">
```

## 📧 Kontaktformular

Das Kontaktformular verwendet die PHP `mail()`-Funktion. 

**Wichtig:** Stellen Sie sicher, dass Ihr Hosting-Provider E-Mail-Versand unterstützt.

### Spam-Schutz

- ✅ Honeypot-Feld (unsichtbar für echte Benutzer)
- ✅ Server-seitige Validierung
- ✅ E-Mail-Format-Prüfung
- ✅ Sanitizing aller Eingaben

### Fehlerbehebung E-Mail

Falls E-Mails nicht ankommen:

1. Überprüfen Sie die Spam-Ordner
2. Prüfen Sie die PHP `mail()`-Konfiguration Ihres Hosters
3. Eventuell SMTP-Plugin verwenden (z.B. PHPMailer)

## 🚀 Performance-Optimierungen

### Bereits implementiert:

- ✅ GZIP-Komprimierung (via .htaccess)
- ✅ Browser-Caching
- ✅ Optimierte CSS (keine Frameworks)
- ✅ Minimales JavaScript
- ✅ Lazy Loading für Bilder
- ✅ Intersection Observer für Animationen

### Weitere Optimierungen:

1. **Bilder optimieren** (WebP-Format, Komprimierung)
2. **CSS & JS minifizieren** (für Produktion)
3. **CDN verwenden** (optional)
4. **HTTP/2 aktivieren** (auf Server-Ebene)

## 🔒 Sicherheit

### Implementierte Maßnahmen:

- ✅ Security Headers (X-Frame-Options, X-XSS-Protection)
- ✅ Eingabe-Sanitizing
- ✅ SQL-Injection-Schutz (prepared statements wenn DB genutzt)
- ✅ Directory Listing deaktiviert
- ✅ Sensible Dateien geschützt (.htaccess)

### Empfehlungen:

1. Regelmäßige PHP-Updates
2. Starke Passwörter für FTP/SSH
3. SSL/TLS-Zertifikat (Let's Encrypt)
4. Regelmäßige Backups

## 📱 Browser-Kompatibilität

Getestet und funktioniert in:

- ✅ Chrome (letzte 2 Versionen)
- ✅ Firefox (letzte 2 Versionen)
- ✅ Safari (letzte 2 Versionen)
- ✅ Edge (letzte 2 Versionen)
- ✅ Mobile Browser (iOS Safari, Chrome Android)

## 🐛 Troubleshooting

### Problem: Seiten laden nicht

```apache
# .htaccess überprüfen
# mod_rewrite aktiviert?
RewriteEngine On
```

### Problem: CSS/JS lädt nicht

```html
<!-- Pfade überprüfen in header.php -->
<link rel="stylesheet" href="/assets/css/style.css">
<script src="/assets/js/main.js"></script>
```

### Problem: Navigation funktioniert nicht

```bash
# JavaScript-Fehler in Browser-Console prüfen
# Pfade in config.php überprüfen
```

## 📈 SEO-Optimierung

### On-Page SEO:

- ✅ Semantische HTML5-Tags
- ✅ Meta-Tags (Title, Description)
- ✅ Open Graph Tags (Social Media)
- ✅ Strukturierte Daten (optional hinzufügbar)
- ✅ Alt-Tags für Bilder
- ✅ Saubere URL-Struktur

### Weitere Schritte:

1. Google Search Console einrichten
2. Sitemap erstellen und einreichen
3. robots.txt konfigurieren
4. Ladezeiten optimieren (PageSpeed Insights)

## 🔄 Zukünftige Erweiterungen

Mögliche Erweiterungen:

- [ ] Blog-System
- [ ] CMS-Integration
- [ ] Mehrsprachigkeit
- [ ] Datenbank-Anbindung
- [ ] Admin-Panel
- [ ] Newsletter-Integration
- [ ] Analytics-Dashboard

## 📝 Lizenz

© 2024 Köllner Digital. Alle Rechte vorbehalten.

Dieser Code ist für den persönlichen/kommerziellen Gebrauch des Auftraggebers bestimmt.

## 👨‍💻 Entwickler

**Köllner Digital**
- Website: [koellner.life](https://koellner.life)
- E-Mail: kontakt@koellner.life

---

## 🆘 Support

Bei Fragen oder Problemen:

1. README.md durchlesen
2. Code-Kommentare prüfen
3. Kontakt aufnehmen: kontakt@koellner.life

---

**Version:** 1.0.0  
**Letzte Aktualisierung:** Januar 2024  
**Status:** ✅ Produktionsreif
