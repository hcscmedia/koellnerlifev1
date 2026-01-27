# Köllner Digital - Portfolio Website & CMS

Moderne, professionelle Portfolio-Website mit vollständigem Admin-Panel, Blog-System und CMS für KI-Beratung, Automation, Webentwicklung und Fotografie.

🌐 **Live:** [koellner.life](https://koellner.life)

## 📋 Übersicht

Diese Website ist eine vollständig responsive, moderne Portfolio-Website mit Dark-Theme-Design, optimiert für Performance und SEO. Version 2.0 beinhaltet ein vollständiges Content Management System mit Admin-Panel und Blog-Funktionalität.

### Dienstleistungen:
- 🤖 **KI / AI Beratung** - ChatGPT, Machine Learning, Datenanalyse
- ⚡ **Automation** - Workflow-Automatisierung, Bots, API-Integration
- 💻 **Webentwicklung** - Responsive Websites, Web-Tools, Dashboards
- 📸 **Fotografie** - Business, Portrait, Content Creation

## 🚀 Features (Version 2.0)

### Frontend
- ✅ Modernes Dark/Tech-Design mit Glasmorphism-Effekten
- ✅ Mobile-First & vollständig responsiv
- ✅ SEO-optimiert mit semantischem HTML5
- ✅ Schnelle Ladezeiten durch Optimierungen
- ✅ Interaktive Animationen
- ✅ Blog mit Kategorien und Pagination
- ✅ Dynamische CMS-Seiten
- ✅ Clean URLs mit mod_rewrite

### Backend & Admin
- ✅ **Vollständiges Admin-Panel** mit Dashboard
- ✅ **Blog-System** (CRUD, Kategorien, SEO, Status-Management)
- ✅ **CMS-System** (Dynamische Seiten, Templates)
- ✅ **Authentifizierung** (Session-Management, Rate Limiting)
- ✅ **Sicherheit** (CSRF-Protection, Activity Logging)
- ✅ **Medien-Verwaltung** (Upload-System vorbereitet)
- ✅ **Kontakt-Management** (Alle Anfragen in Datenbank)
- ✅ **MySQL-Datenbank** (8 Tabellen, optimiert)

### Installation
- ✅ Automatisches Shell-Script (`install.sh`)
- ✅ Web-basiertes Setup (`setup.php`)
- ✅ Keine Build-Tools erforderlich
- ✅ Shared Hosting kompatibel

## 📁 Projektstruktur

```
koellnerlifev1/
├── admin/                     # 🔐 Admin-Panel
│   ├── blog/
│   │   ├── posts.php          # Blog-Posts-Übersicht
│   │   ├── edit.php           # Post erstellen/bearbeiten
│   │   └── new.php            # Neuer Post
│   ├── cms/
│   │   ├── pages.php          # CMS-Seiten-Übersicht
│   │   └── edit.php           # Seite erstellen/bearbeiten
│   ├── classes/
│   │   ├── AdminAuth.php      # Authentifizierung
│   │   ├── BlogPost.php       # Blog-Post Model
│   │   ├── BlogCategory.php   # Kategorie Model
│   │   └── CMSPage.php        # CMS-Seiten Model
│   ├── includes/
│   │   ├── header.php         # Admin-Header
│   │   ├── footer.php         # Admin-Footer
│   │   └── login-template.php # Login-Template
│   ├── dashboard.php          # Admin-Dashboard
│   ├── login.php              # Admin-Login
│   └── logout.php             # Logout
├── assets/
│   ├── css/
│   │   ├── style.css          # Frontend-Styles
│   │   └── admin-style.css    # Admin-Panel-Styles
│   ├── js/
│   │   └── main.js            # Frontend JavaScript
│   └── images/                # Bilder und Assets
├── database/
│   ├── schema.sql             # Vollständiges DB-Schema
│   └── Database.php           # Datenbank-Klasse (PDO)
├── includes/
│   ├── header.php             # Frontend-Header
│   ├── footer.php             # Frontend-Footer
│   └── navigation.php         # Navigation
├── pages/
│   ├── services.php           # Leistungen
│   ├── projects.php           # Portfolio
│   ├── about.php              # Über mich
│   └── contact.php            # Kontaktformular
├── uploads/                   # Upload-Verzeichnis
│   ├── blog/                  # Blog-Bilder
│   ├── media/                 # Medien-Bibliothek
│   └── temp/                  # Temporäre Dateien
├── index.php                  # Startseite
├── blog.php                   # 📝 Blog-Übersicht
├── blog-post.php              # Einzelner Blog-Post
├── cms-page.php               # Dynamische CMS-Seite
├── config.php                 # Konfiguration
├── .htaccess                  # Apache-Config mit URL-Rewriting
├── install.sh                 # 🚀 Shell-Installationsscript
├── setup.php                  # 🌐 Web-basiertes Setup
├── INSTALL-GUIDE.md           # Installations-Guide
├── INSTALLATION.md            # Detaillierte Anleitung
└── README.md                  # Diese Datei
```

## 🛠️ Technologie-Stack

### Frontend
- **HTML5** - Semantisches Markup
- **CSS3** - Custom Properties, Flexbox, Grid, Responsive Design
- **JavaScript (ES6+)** - Vanilla JS, keine Frameworks
- **Google Fonts** - Inter Font Family
- **Font Awesome** - Icons (Admin-Panel)

### Backend
- **PHP 7.4+** - Serverseitige Logik, OOP-Architektur
- **PDO** - Sichere Datenbankabfragen (Prepared Statements)
- **Session-Management** - Sichere Admin-Authentifizierung
- **Password Hashing** - password_hash() / password_verify()

### Datenbank
- **MySQL 5.7+ / MariaDB** - Relationale Datenbank
- **8 Tabellen** - Blog, CMS, Medien, Admin, Logs
- **UTF8MB4** - Vollständige Unicode-Unterstützung
- **InnoDB Engine** - Transaktionen & Foreign Keys

### Server
- **Apache 2.4+** - Webserver mit mod_rewrite
- **.htaccess** - URL-Rewriting, Security Headers, Caching
- **Shared Hosting** - Kompatibel (keine Root-Rechte erforderlich)

## 📦 Installation

### Voraussetzungen

- **PHP 7.4+** mit PDO und pdo_mysql Extension
- **MySQL 5.7+ / MariaDB 10.2+**
- **Apache** mit mod_rewrite
- **Schreibrechte** für uploads/ Verzeichnis

### 🚀 Schnellinstallation

**Methode 1: Shell-Script (empfohlen)**
```bash
chmod +x install.sh
./install.sh
```

**Methode 2: Web-Setup**
```
https://ihre-domain.de/setup.php
```

Das Script führt automatisch aus:
- ✓ Systemprüfung (PHP, Extensions, Berechtigungen)
- ✓ Datenbank erstellen und Schema importieren
- ✓ config.php konfigurieren
- ✓ Upload-Verzeichnisse erstellen
- ✓ Admin-Passwort setzen

**⚠️ Nach Installation:** `setup.php` löschen!

### 📖 Detaillierte Anleitung

Siehe [INSTALL-GUIDE.md](INSTALL-GUIDE.md) für:
- Manuelle Installation
- Datenbank-Setup
- Troubleshooting
- Konfigurationsoptionen

### 🔐 Admin-Zugang

Nach der Installation:
- **URL**: `/admin/`
- **Benutzername**: `admin`
- **Passwort**: Während Installation gesetzt (oder `Admin123!`)
- ⚠️ **WICHTIG**: Passwort sofort ändern!

## 💼 Admin-Panel Funktionen

### Dashboard
- 📊 **Statistiken** - Posts, Views, Kontakte auf einen Blick
- 🔔 **Letzte Aktivitäten** - Neue Posts und Kontaktanfragen
- ⚡ **Schnellaktionen** - Direktzugriff auf häufige Aufgaben

### Blog-Verwaltung
- ✍️ **Post-Editor** - Vollständiger WYSIWYG-Editor
- 📁 **Kategorien** - Organisieren Sie Ihre Artikel
- 🏷️ **Tags & Meta** - SEO-Optimierung für jeden Post
- 👁️ **Vorschau** - Live-Vorschau vor Veröffentlichung
- 📈 **View-Counter** - Tracking der Seitenaufrufe
- 🔄 **Status-Management** - Draft, Published, Archived

### CMS-Seiten
- 📄 **Seiten-Editor** - Erstellen Sie beliebige Seiten
- 🎨 **Template-Auswahl** - Standard, Full-Width, Landing Page
- 🔗 **URL-Management** - Custom Slugs für saubere URLs
- 📝 **Content-Verwaltung** - HTML/Markdown Support

### Medien (vorbereitet)
- 📸 **Upload-System** - Bilderverwaltung
- 🖼️ **Galerie** - Medien-Bibliothek
- ✂️ **Bildbearbeitung** - Zuschneiden, Skalieren

### Kontakte
- 📧 **Anfragen-Verwaltung** - Alle Kontaktformular-Einträge
- 🏷️ **Status-Tracking** - New, Read, Replied, Archived
- 📊 **Details** - IP, User-Agent, Zeitstempel

## 🎨 Anpassungen

### Site-Konfiguration

In `config.php`:
```php
// Site Information
define('SITE_NAME', 'Ihr Name');
define('SITE_URL', 'https://ihre-domain.de');
define('CONTACT_EMAIL', 'ihre-email@domain.de');

// Social Media
define('SOCIAL_GITHUB', 'https://github.com/username');
define('SOCIAL_LINKEDIN', 'https://linkedin.com/in/username');
```

### Farben ändern

In `assets/css/style.css`:
```css
:root {
    --color-accent-primary: #6366f1;    /* Hauptakzentfarbe */
    --color-accent-secondary: #8b5cf6;  /* Sekundäre Akzentfarbe */
    --color-bg-primary: #0a0a0f;        /* Haupthintergrund */
}
```

### Admin-Panel anpassen

In `assets/css/admin-style.css`:
```css
:root {
    --admin-primary: #4f46e5;           /* Admin-Akzentfarbe */
    --admin-bg: #0f172a;                /* Admin-Hintergrund */
}
```

### Navigation erweitern

Blog zur Navigation hinzufügen in `includes/navigation.php`:
```php
<a href="/blog.php" class="nav-link <?php echo $current_page === 'blog' ? 'active' : ''; ?>">
    Blog
</a>
```

## 📝 Blog verwenden

### Ersten Post erstellen

1. Zum Admin-Panel: `/admin/`
2. **Blog Posts** → **Neuer Post**
3. Titel, Inhalt und Kategorie eingeben
4. SEO-Meta-Daten anpassen
5. Als Draft speichern oder veröffentlichen

### Blog-URLs

- **Übersicht**: `/blog.php`
- **Einzelner Post**: `/blog/post-slug`
- **Kategorie**: `/blog.php?category=1`

### Frontend-Integration

Der Blog ist automatisch verfügbar unter `/blog.php` mit:
- Responsive Design
- Pagination
- Kategoriefilter
- Suchfunktion (vorbereitet)
- Social Sharing (erweiterbar)

## 📧 Kontaktformular

Das Kontaktformular speichert alle Anfragen in der Datenbank.

**Features:**
- ✅ Honeypot-Spam-Schutz
- ✅ Server-seitige Validierung
- ✅ E-Mail-Format-Prüfung
- ✅ Sanitizing aller Eingaben
- ✅ Speicherung in Datenbank
- ✅ Optionaler E-Mail-Versand

**Verwaltung:**
Alle Anfragen im Admin-Panel unter **Kontakte** einsehen.

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

- ✅ **Security Headers** (X-Frame-Options, X-XSS-Protection, Referrer-Policy)
- ✅ **SQL-Injection-Schutz** (PDO Prepared Statements)
- ✅ **CSRF-Protection** (Token-Validierung im Admin-Panel)
- ✅ **XSS-Schutz** (htmlspecialchars() für alle Ausgaben)
- ✅ **Session-Sicherheit** (Session Regeneration, Timeout)
- ✅ **Password Hashing** (bcrypt via password_hash())
- ✅ **Rate Limiting** (Login-Versuche begrenzt)
- ✅ **Activity Logging** (Admin-Aktionen protokolliert)
- ✅ **Directory Listing** deaktiviert
- ✅ **Sensible Dateien** geschützt (.htaccess, .sql)

### Admin-Panel Sicherheit:

- 🔐 **Session-Timeout** - Automatischer Logout nach 1 Stunde
- 🔒 **Login-Sperre** - 15 Min. Sperre nach 5 fehlgeschlagenen Versuchen
- 📝 **Activity Log** - Alle Admin-Aktionen werden gespeichert
- 🛡️ **CSRF-Token** - Schutz vor Cross-Site Request Forgery

### Empfehlungen:

1. **Regelmäßige Updates** - PHP, MySQL, Dependencies
2. **Starke Passwörter** - Min. 8 Zeichen, Groß-/Kleinbuchstaben, Zahlen
3. **SSL/TLS** - Let's Encrypt oder kommerzielles Zertifikat
4. **Backups** - Täglich automatisierte Backups
5. **Firewall** - ModSecurity oder ähnlich
6. **2FA** - Zwei-Faktor-Authentifizierung (erweiterbar)

## 📱 Browser-Kompatibilität

Getestet und funktioniert in:

- ✅ Chrome (letzte 2 Versionen)
- ✅ Firefox (letzte 2 Versionen)
- ✅ Safari (letzte 2 Versionen)
- ✅ Edge (letzte 2 Versionen)
- ✅ Mobile Browser (iOS Safari, Chrome Android)

## 🐛 Troubleshooting

### Problem: Installation schlägt fehl

**Lösung:**
- PHP-Version prüfen: `php -v` (min. 7.4)
- PDO-Extension: `php -m | grep pdo`
- Datenbank-Zugangsdaten in `config.php` prüfen
- Schreibrechte: `chmod 755 uploads/`

### Problem: Admin-Login funktioniert nicht

**Lösung:**
- Standard-Login: `admin` / `Admin123!`
- Browser-Cache leeren
- Cookies löschen
- Session-Verzeichnis prüfen

### Problem: Blog-URLs (404 Not Found)

**Lösung:**
```apache
# mod_rewrite aktivieren
a2enmod rewrite

# .htaccess prüfen
RewriteEngine On

# Apache: AllowOverride All
<Directory /var/www/html>
    AllowOverride All
</Directory>
```

### Problem: Datenbank-Verbindung fehlschlägt

**Lösung:**
- Zugangsdaten in `config.php` prüfen
- MySQL-Service läuft: `systemctl status mysql`
- Datenbank existiert: `SHOW DATABASES;`
- Benutzerrechte: `GRANT ALL ON db.* TO 'user'@'localhost';`

### Problem: CSS/JS lädt nicht

**Lösung:**
```html
<!-- Pfade in header.php prüfen -->
<link rel="stylesheet" href="/assets/css/style.css">
<script src="/assets/js/main.js"></script>

<!-- Bei Subdirectory-Installation -->
<link rel="stylesheet" href="/subdirectory/assets/css/style.css">
```

### Problem: Upload funktioniert nicht

**Lösung:**
```bash
# Verzeichnis erstellen und Rechte setzen
mkdir -p uploads/{blog,media,temp}
chmod -R 755 uploads/

# PHP upload_max_filesize prüfen
php -i | grep upload_max_filesize
```

## 📈 SEO-Optimierung

### On-Page SEO (implementiert):

- ✅ **Semantische HTML5-Tags** - header, nav, main, article, section
- ✅ **Meta-Tags** - Title, Description pro Seite/Post
- ✅ **Open Graph Tags** - Social Media Sharing
- ✅ **Alt-Tags** - Alle Bilder beschriftet
- ✅ **Saubere URLs** - `/blog/mein-artikel` statt `?id=123`
- ✅ **Mobile-First** - Responsive Design
- ✅ **Performance** - Schnelle Ladezeiten
- ✅ **Strukturierte Daten** - Schema.org (erweiterbar)

### Blog-SEO:

Jeder Post hat eigene:
- 📝 **Meta Title** - Individueller Seitentitel
- 📄 **Meta Description** - Beschreibung für Suchergebnisse
- 🏷️ **Meta Keywords** - Relevante Schlagwörter
- 🔗 **Canonical URL** - Vermeidung von Duplicate Content
- 📊 **View Counter** - Tracking der Popularität

### Weitere Optimierungen:

1. **Google Search Console** einrichten
2. **Sitemap** erstellen und einreichen:
   ```xml
   <?xml version="1.0" encoding="UTF-8"?>
   <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
       <url><loc>https://koellner.life/</loc></url>
       <url><loc>https://koellner.life/blog.php</loc></url>
   </urlset>
   ```
3. **robots.txt** optimieren
4. **PageSpeed Insights** - Ladezeiten optimieren
5. **Structured Data** - Rich Snippets implementieren

## 📊 Datenbank-Schema

### Tabellen-Übersicht:

| Tabelle | Zweck | Einträge |
|---------|-------|----------|
| `admin_users` | Admin-Benutzer | 1 (Standard) |
| `blog_posts` | Blog-Artikel | Unbegrenzt |
| `blog_categories` | Blog-Kategorien | 4 (Standard) |
| `cms_pages` | CMS-Seiten | Unbegrenzt |
| `media_library` | Medien/Uploads | Unbegrenzt |
| `contact_submissions` | Kontaktanfragen | Unbegrenzt |
| `site_settings` | Website-Einstellungen | 6 (Standard) |
| `admin_activity_log` | Admin-Aktivitäten | Auto-Log |

### Standard-Daten:

Nach Installation vorhanden:
- 1 Admin-User (`admin`)
- 4 Blog-Kategorien (KI, Webentwicklung, Automation, Fotografie)
- 6 Site-Settings (Name, Email, Posts per Page, etc.)

## 🔄 Backup & Wartung

### Datenbank-Backup:

```bash
# Manuelles Backup
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql

# Automatisches Backup (Cron)
0 2 * * * mysqldump -u user -ppass db > /backups/db_$(date +\%Y\%m\%d).sql
```

### Datei-Backup:

```bash
# Uploads sichern
tar -czf uploads_backup_$(date +%Y%m%d).tar.gz uploads/

# Komplette Installation
tar -czf website_backup_$(date +%Y%m%d).tar.gz \
  --exclude='node_modules' \
  --exclude='.git' \
  .
```

### Wartungs-Aufgaben:

- 📅 **Täglich** - Datenbank-Backup
- 📅 **Wöchentlich** - Datei-Backup, Log-Review
- 📅 **Monatlich** - Updates prüfen, Performance-Check
- 📅 **Quartalsweise** - Security-Audit, Cleanup alter Daten

## 🔄 Zukünftige Erweiterungen

### Bereits implementiert:
- ✅ Blog-System
- ✅ CMS-Integration
- ✅ Datenbank-Anbindung
- ✅ Admin-Panel

### Geplante Features:

- [ ] **WYSIWYG-Editor** - TinyMCE oder CKEditor für Posts
- [ ] **Mehrsprachigkeit** - i18n Support (DE/EN)
- [ ] **Kommentar-System** - Diskussionen unter Blog-Posts
- [ ] **Newsletter** - E-Mail-Marketing Integration
- [ ] **Analytics-Dashboard** - Erweiterte Statistiken
- [ ] **Media-Upload-UI** - Drag & Drop Image Upload
- [ ] **Theme-Switcher** - Light/Dark Mode Toggle
- [ ] **API** - RESTful API für Headless CMS
- [ ] **Cache-System** - Redis/Memcached für Performance
- [ ] **Search** - Volltext-Suche über alle Inhalte
- [ ] **Tags** - Erweiterte Tag-Verwaltung
- [ ] **RSS-Feed** - Automatischer Feed für Blog
- [ ] **Social Sharing** - Share-Buttons für Posts
- [ ] **User Roles** - Erweiterte Rechteverwaltung

## 📚 Dokumentation

### Verfügbare Guides:

- 📄 **README.md** (diese Datei) - Projekt-Übersicht
- 🚀 **[INSTALL-GUIDE.md](INSTALL-GUIDE.md)** - Installations-Anleitung
- 📖 **[INSTALLATION.md](INSTALLATION.md)** - Detaillierte Setup-Anleitung
- 🔄 **[DEPLOYMENT.md](DEPLOYMENT.md)** - Deployment-Guide

### Code-Dokumentation:

Alle Klassen und Funktionen sind inline dokumentiert:
- `admin/classes/AdminAuth.php` - Authentifizierung
- `admin/classes/BlogPost.php` - Blog-Post Model
- `admin/classes/CMSPage.php` - CMS-Seiten Model
- `database/Database.php` - Datenbank-Wrapper

### API-Referenz (vorbereitet):

```php
// Blog-Post abrufen
$blogPost = new BlogPost();
$posts = $blogPost->getAll($page, $per_page, 'published');

// CMS-Seite laden
$cmsPage = new CMSPage();
$page = $cmsPage->getBySlug('about-us');

// Admin-Authentifizierung
$auth = new AdminAuth();
$auth->requireLogin();
```

## 📞 Support & Kontakt

### Bei Fragen oder Problemen:

- 📧 **E-Mail**: kontakt@koellner.life
- 💬 **GitHub Issues**: [github.com/hcscmedia/koellnerlifev1/issues](https://github.com/hcscmedia/koellnerlifev1/issues)
- 📖 **Dokumentation**: Siehe INSTALL-GUIDE.md
- 🔍 **Troubleshooting**: Siehe Abschnitt "Troubleshooting" oben

### Entwickler:

**Köllner Digital**
- 🌐 Website: [koellner.life](https://koellner.life)
- 📧 E-Mail: kontakt@koellner.life
- 💼 GitHub: [@hcscmedia](https://github.com/hcscmedia)

---

## 📄 Lizenz

© 2024-2026 Köllner Digital. Alle Rechte vorbehalten.

Dieser Code ist für den persönlichen/kommerziellen Gebrauch des Auftraggebers bestimmt.

---

## 🆕 Changelog

### Version 2.0.0 (2026-01-27)
- ➕ Vollständiges Admin-Panel mit Dashboard
- ➕ Blog-System mit CRUD, Kategorien, SEO
- ➕ CMS-System für dynamische Seiten
- ➕ MySQL-Datenbank mit 8 Tabellen
- ➕ Authentifizierungs-System mit Session-Management
- ➕ CSRF-Protection und Activity Logging
- ➕ Automatische Installation (Shell + Web)
- ➕ URL-Rewriting für saubere Blog/Page-URLs
- ➕ Admin-Styles mit Dark-Theme
- ➕ Frontend-Blog-Integration mit Pagination
- 📝 Umfangreiche Dokumentation

### Version 1.0.0 (2024-01-01)
- 🎉 Initial Release
- ✅ Portfolio-Website mit Dark-Theme
- ✅ Responsive Design
- ✅ Kontaktformular
- ✅ Service-Seiten

---

**Version:** 2.0.0  
**Letzte Aktualisierung:** 27. Januar 2026  
**Status:** ✅ Produktionsreif  
**PHP:** 7.4+  
**MySQL:** 5.7+  
**License:** Proprietär
