# Installation und Setup Guide

## 🚀 Schnellstart

### Automatische Installation (empfohlen)

**Shell-Script:**
```bash
chmod +x install.sh
./install.sh
```

**Web-Setup:**
```
https://ihre-domain.de/setup.php
```

Siehe [INSTALL-GUIDE.md](INSTALL-GUIDE.md) für detaillierte Anweisungen.

---

## 🔧 Manuelle Installation

### 1. Datenbank erstellen

Erstelle eine MySQL-Datenbank und importiere das Schema:

```bash
mysql -u username -p database_name < database/schema.sql
```

Oder über phpMyAdmin:
1. Neue Datenbank erstellen: `koellner_life`
2. SQL-Import: `database/schema.sql` hochladen und ausführen

### 2. Datenbank-Zugangsdaten konfigurieren

Bearbeite [config.php](config.php):

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'koellner_life');
define('DB_USER', 'dein_db_benutzer');
define('DB_PASS', 'dein_db_passwort');
```

### 3. Upload-Verzeichnis erstellen

```bash
mkdir uploads
chmod 755 uploads
```

### 4. Standard Admin-Login

Nach dem Import der Datenbank kannst du dich anmelden:

- **URL**: `https://deine-domain.de/admin/`
- **Benutzername**: `admin`
- **Passwort**: `Admin123!`

⚠️ **WICHTIG**: Ändere das Passwort sofort nach dem ersten Login!

## 📋 Admin-Panel Features

### Dashboard
- Übersicht über alle Inhalte
- Statistiken (Posts, Views, Kontakte)
- Schnellzugriff auf wichtige Funktionen

### Blog-System
- **Posts erstellen/bearbeiten**: Vollständiger WYSIWYG-Editor
- **Kategorien verwalten**: Organisiere Artikel in Kategorien
- **SEO-Optimierung**: Meta-Tags für jeden Post
- **Status-Verwaltung**: Draft, Published, Archived
- **Auto-Slug-Generierung**: SEO-freundliche URLs

### CMS-System
- **Seiten erstellen**: Erstelle beliebige Seiten
- **Templates**: Verschiedene Seitenlayouts
- **URL-Management**: Custom URLs für jede Seite

### Medien-Bibliothek (geplant)
- Bilder hochladen und verwalten
- Bildoptimierung
- Medien-Galerie

### Kontakt-Verwaltung
- Alle Kontaktanfragen anzeigen
- Status-Management
- Archivierung

## 🎨 Frontend-Integration

### Blog anzeigen

Die Blog-Übersicht ist verfügbar unter:
```
https://deine-domain.de/blog.php
```

Einzelne Posts:
```
https://deine-domain.de/blog/post-slug
```

### Navigation erweitern

Füge in [includes/navigation.php](includes/navigation.php) den Blog-Link hinzu:

```php
<a href="/blog.php" class="nav-link">Blog</a>
```

### CMS-Seiten

CMS-Seiten sind verfügbar unter:
```
https://deine-domain.de/page/seiten-slug
```

## 🔒 Sicherheit

### Admin-Bereich schützen

Die `.htaccess` enthält bereits grundlegende Sicherheitseinstellungen.

Optional: Zusätzlichen HTTP-Auth-Schutz aktivieren:

1. `.htpasswd` erstellen:
```bash
htpasswd -c /pfad/zu/.htpasswd admin
```

2. In `.htaccess` aktivieren (auskommentiert vorhanden)

### Session-Sicherheit

- Session-Timeout: 1 Stunde (konfigurierbar)
- CSRF-Token-Protection
- Login-Rate-Limiting
- Activity-Logging

### Passwort-Richtlinien

- Minimum 8 Zeichen
- Passwörter werden mit `password_hash()` verschlüsselt
- Nach 5 fehlgeschlagenen Versuchen: 15 Minuten Sperre

## 📝 Verwendung

### Neuen Blog-Post erstellen

1. Navigiere zu **Blog Posts** → **Neuer Post**
2. Titel eingeben (Slug wird automatisch generiert)
3. Kategorie auswählen
4. Inhalt schreiben
5. SEO-Einstellungen anpassen
6. Als **Entwurf** speichern oder direkt **Veröffentlichen**

### Blog-Kategorien verwalten

1. **Blog Posts** → **Kategorien**
2. Neue Kategorie erstellen
3. Name und Beschreibung eingeben
4. Slug wird automatisch generiert

### CMS-Seiten erstellen

1. **CMS Seiten** → **Neue Seite**
2. Titel und Inhalt eingeben
3. Template auswählen (Standard, Volle Breite, Landing Page)
4. SEO-Meta-Daten hinzufügen
5. Veröffentlichen

### Kontaktanfragen verwalten

Alle Formulareinsendungen werden in der Datenbank gespeichert:
- Status: New, Read, Replied, Archived
- Alle Details inkl. IP und User-Agent

## 🎯 SEO-Optimierung

### URL-Struktur

Blog-Posts:
```
/blog/ai-beratung-guide
```

CMS-Seiten:
```
/page/ueber-uns
```

### Meta-Tags

Für jeden Post/Seite konfigurierbar:
- Meta Title
- Meta Description
- Meta Keywords (optional)

### Sitemap (manuell)

Erstelle eine `sitemap.xml` im Root-Verzeichnis:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://koellner.life/</loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://koellner.life/blog.php</loc>
        <priority>0.8</priority>
    </url>
    <!-- Blog Posts dynamisch generieren -->
</urlset>
```

## 🔧 Troubleshooting

### Problem: "Database connection failed"

**Lösung**: Prüfe Datenbankzugangsdaten in `config.php`

### Problem: Admin-Login funktioniert nicht

**Lösung**:
1. Prüfe ob Datenbank korrekt importiert wurde
2. Standard-Credentials verwenden: `admin` / `Admin123!`
3. Browser-Cache leeren

### Problem: Blog-URLs funktionieren nicht

**Lösung**:
1. Prüfe ob `mod_rewrite` aktiviert ist
2. `.htaccess` Berechtigungen: `chmod 644 .htaccess`
3. Apache: `AllowOverride All` in der VHost-Config

### Problem: Uploads funktionieren nicht

**Lösung**:
1. `uploads/` Verzeichnis erstellen
2. Berechtigungen setzen: `chmod 755 uploads`
3. PHP `upload_max_filesize` prüfen

## 📊 Datenbank-Backup

### Manuelles Backup

```bash
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
```

### Automatisches Backup (Cron)

```bash
# Täglich um 2 Uhr nachts
0 2 * * * mysqldump -u user -ppassword db_name > /backups/db_$(date +\%Y\%m\%d).sql
```

## 🆕 Updates & Wartung

### Debug-Modus

Für Entwicklung in `config.php`:

```php
define('DEBUG_MODE', true);
```

Für Produktion:

```php
define('DEBUG_MODE', false);
```

### Logs anzeigen

Aktivitätslogs im Admin-Panel:
- Alle Admin-Aktionen werden protokolliert
- Zugriff über Datenbank-Tabelle `admin_activity_log`

## 📞 Support

Bei Fragen oder Problemen:
- E-Mail: kontakt@koellner.life
- Dokumentation: [README.md](README.md)

---

**Version**: 2.0.0 (mit Admin-Panel, Blog & CMS)  
**Stand**: Januar 2024
