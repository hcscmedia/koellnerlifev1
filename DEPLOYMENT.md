# 🚀 Quick Deployment Guide

## Schnellstart-Anleitung für koellner.life

### 1. Voraussetzungen

- ✅ Webhosting mit PHP 7.4+ und Apache
- ✅ FTP-Zugang zu Ihrem Server
- ✅ Domain (z.B. koellner.life)

### 2. Dateien hochladen

**Via FTP-Client (FileZilla, Cyberduck, etc.):**

1. Verbinden Sie sich mit Ihrem FTP-Server
2. Navigieren Sie zum Hauptverzeichnis (meist `/public_html/` oder `/www/`)
3. Laden Sie ALLE Dateien und Ordner aus diesem Repository hoch:
   ```
   ├── assets/
   ├── includes/
   ├── pages/
   ├── .htaccess
   ├── config.php
   ├── index.php
   └── README.md
   ```

### 3. Konfiguration anpassen

**config.php bearbeiten:**

```php
// Site Information
define('SITE_NAME', 'Ihr Name');
define('SITE_URL', 'https://ihre-domain.de');
define('SITE_DESCRIPTION', 'Ihre Beschreibung');

// Contact Information
define('CONTACT_EMAIL', 'ihre-email@domain.de');
define('PHONE_NUMBER', '+49 123 456789'); // Optional

// Social Media Links
define('SOCIAL_GITHUB', 'https://github.com/username');
define('SOCIAL_LINKEDIN', 'https://linkedin.com/in/username');
define('SOCIAL_INSTAGRAM', 'https://instagram.com/username');
define('SOCIAL_TWITTER', 'https://twitter.com/username');

// Debug-Mode (auf false für Produktion)
define('DEBUG_MODE', false);
```

### 4. .htaccess anpassen (optional)

**HTTPS aktivieren (wenn SSL-Zertifikat vorhanden):**

Entfernen Sie die Kommentare vor diesen Zeilen:

```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

**WWW hinzufügen oder entfernen:**

```apache
# Mit www:
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteRule ^(.*)$ https://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Ohne www:
RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
RewriteRule ^(.*)$ https://%1%{REQUEST_URI} [L,R=301]
```

### 5. Bilder hinzufügen

**Eigene Bilder hochladen:**

1. Erstellen Sie einen Ordner in `/assets/images/`
2. Laden Sie Ihre Bilder hoch (optimiert: WebP oder JPEG)
3. Fügen Sie ein Favicon hinzu: `/assets/images/favicon.png`
4. Passen Sie die Bild-Pfade in den PHP-Dateien an

**Beispiel:**

```html
<!-- In pages/about.php -->
<img src="/assets/images/portrait.jpg" alt="Ihr Name">
```

### 6. Testen

**Öffnen Sie Ihre Website:**

1. Startseite: `https://ihre-domain.de/`
2. Leistungen: `https://ihre-domain.de/pages/services.php`
3. Projekte: `https://ihre-domain.de/pages/projects.php`
4. Über mich: `https://ihre-domain.de/pages/about.php`
5. Kontakt: `https://ihre-domain.de/pages/contact.php`

**Testen Sie:**

- ✅ Alle Links funktionieren
- ✅ Navigation auf Desktop und Mobile
- ✅ Kontaktformular sendet E-Mails
- ✅ CSS und JavaScript laden korrekt
- ✅ Responsive auf allen Geräten

### 7. E-Mail-Konfiguration

**Wenn Kontaktformular nicht funktioniert:**

**Option 1: PHP mail() Funktion**
- Kontaktieren Sie Ihren Hoster für mail()-Konfiguration
- Eventuell SPF/DKIM-Records in DNS setzen

**Option 2: SMTP verwenden (empfohlen)**
- Installieren Sie PHPMailer via Composer
- Konfigurieren Sie SMTP-Server (z.B. Gmail, SendGrid)

```bash
composer require phpmailer/phpmailer
```

### 8. Performance optimieren

**Nach dem Deployment:**

1. **Bilder komprimieren:**
   - Verwenden Sie Tools wie TinyPNG oder ImageOptim
   - Konvertieren Sie zu WebP-Format

2. **Google PageSpeed Insights:**
   - Testen Sie Ihre Website: https://pagespeed.web.dev/
   - Folgen Sie den Empfehlungen

3. **Caching überprüfen:**
   - Browser-Entwicklertools → Network-Tab
   - Prüfen Sie Cache-Headers

### 9. SEO einrichten

**Nach dem Launch:**

1. **Google Search Console:**
   - Website hinzufügen und verifizieren
   - Sitemap erstellen und einreichen

2. **Google Analytics (optional):**
   - Tracking-Code in `includes/header.php` einfügen

3. **robots.txt erstellen:**
   ```
   User-agent: *
   Allow: /
   Sitemap: https://ihre-domain.de/sitemap.xml
   ```

### 10. Wartung

**Regelmäßige Aufgaben:**

- ✅ PHP-Version aktuell halten
- ✅ Backups erstellen (wöchentlich)
- ✅ SSL-Zertifikat verlängern
- ✅ Inhalte aktualisieren
- ✅ Broken Links prüfen

---

## ⚡ Schnell-Checkliste

- [ ] Dateien hochgeladen
- [ ] config.php angepasst
- [ ] .htaccess konfiguriert
- [ ] Bilder hinzugefügt
- [ ] Favicon hochgeladen
- [ ] Alle Seiten getestet
- [ ] Mobile-Ansicht geprüft
- [ ] Kontaktformular getestet
- [ ] SSL-Zertifikat aktiv
- [ ] Google Search Console eingerichtet

---

## 🆘 Troubleshooting

### Problem: "500 Internal Server Error"

**Lösung:**
- Überprüfen Sie .htaccess (eventuell umbenennen zu .htaccess.txt zum Testen)
- PHP-Fehlerlog prüfen
- mod_rewrite aktiviert?

### Problem: CSS/JS lädt nicht

**Lösung:**
- Pfade in `includes/header.php` überprüfen
- Sollten mit `/assets/` beginnen
- Dateirechte prüfen (644 für Dateien)

### Problem: Kontaktformular funktioniert nicht

**Lösung:**
- PHP mail()-Funktion aktiviert?
- Hoster-Dokumentation prüfen
- SMTP als Alternative nutzen

### Problem: Bilder werden nicht angezeigt

**Lösung:**
- Pfade überprüfen (absolute Pfade verwenden)
- Dateirechte prüfen (644)
- Dateinamen-Schreibweise (Groß-/Kleinschreibung)

---

## 📞 Support

Bei Problemen:

1. README.md durchlesen
2. Code-Kommentare prüfen
3. Hoster-Support kontaktieren (für Server-Themen)

---

**Viel Erfolg mit Ihrer neuen Website! 🎉**
