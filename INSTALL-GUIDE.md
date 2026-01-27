# 🚀 Installationsanleitung

Es gibt **zwei Methoden** zur Installation:

## Methode 1: Shell-Script (empfohlen für CLI-Zugriff)

Für Benutzer mit SSH/Shell-Zugriff:

```bash
chmod +x install.sh
./install.sh
```

Das Script führt automatisch aus:
- ✓ Systemprüfung (PHP, Extensions, Berechtigungen)
- ✓ Verzeichnisse erstellen (`uploads/`, `logs/`)
- ✓ Interaktive Datenbank-Konfiguration
- ✓ Datenbank erstellen und Schema importieren
- ✓ `config.php` aktualisieren
- ✓ Admin-Passwort setzen (optional)
- ✓ Installationstest ausführen

### Vorteile:
- Schnelle, automatisierte Installation
- Integrierte Fehlerprüfung
- Sofortiges Feedback

---

## Methode 2: Web-Setup (für Shared Hosting)

Für Benutzer ohne Shell-Zugriff:

1. Alle Dateien per FTP hochladen
2. Im Browser aufrufen: `https://ihre-domain.de/setup.php`
3. Den 4-Schritt-Assistenten durchlaufen:
   - **Schritt 1:** Systemprüfung
   - **Schritt 2:** Datenbank-Konfiguration
   - **Schritt 3:** Admin-Passwort setzen
   - **Schritt 4:** Installation abschließen

### Vorteile:
- Benutzerfreundliche Oberfläche
- Keine Shell-Kenntnisse erforderlich
- Visuelles Feedback

### ⚠️ WICHTIG:
Nach erfolgreicher Installation `setup.php` **löschen**!

```bash
rm setup.php
```

---

## Manuelle Installation

Falls beide Methoden nicht funktionieren:

### 1. Datenbank erstellen

```sql
CREATE DATABASE koellner_life CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Schema importieren

Via phpMyAdmin oder CLI:
```bash
mysql -u username -p koellner_life < database/schema.sql
```

### 3. config.php bearbeiten

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'koellner_life');
define('DB_USER', 'ihr_benutzer');
define('DB_PASS', 'ihr_passwort');
```

### 4. Verzeichnisse erstellen

```bash
mkdir -p uploads/{blog,media,temp}
chmod -R 755 uploads/
```

### 5. Admin-Login

- URL: `/admin/`
- Benutzername: `admin`
- Passwort: `Admin123!`
- ⚠️ Sofort ändern!

---

## Nach der Installation

### 1. Installationstest

```bash
php test-install.php
```

oder im Browser:
```
https://ihre-domain.de/test-install.php
```

**Dann löschen:**
```bash
rm test-install.php
```

### 2. Admin-Panel öffnen

```
https://ihre-domain.de/admin/
```

### 3. Blog zur Navigation hinzufügen

Bearbeite `includes/navigation.php`:

```php
<a href="/blog.php" class="nav-link <?php echo $current_page === 'blog' ? 'active' : ''; ?>">
    Blog
</a>
```

### 4. Ersten Blog-Post erstellen

1. Admin-Panel → Blog Posts → Neuer Post
2. Titel, Inhalt und Kategorie eingeben
3. Veröffentlichen

---

## Troubleshooting

### Problem: "Database connection failed"

**Lösung:**
- Datenbank-Zugangsdaten in `config.php` prüfen
- Datenbank existiert?
- Benutzer hat Zugriff?

### Problem: "Permission denied"

**Lösung:**
```bash
chmod 755 uploads/
chmod 644 config.php
chmod 644 .htaccess
```

### Problem: Blog-URLs funktionieren nicht

**Lösung:**
- `mod_rewrite` aktiviert?
- `.htaccess` vorhanden?
- `AllowOverride All` in Apache-Config?

### Problem: setup.php zeigt weißen Bildschirm

**Lösung:**
- PHP Errors anzeigen in `php.ini`: `display_errors = On`
- Oder in `config.php`: `define('DEBUG_MODE', true);`

---

## Support

Bei Problemen:
- 📖 [README.md](README.md) - Allgemeine Dokumentation
- 📋 [INSTALLATION.md](INSTALLATION.md) - Detaillierte Anleitung
- 📧 kontakt@koellner.life

---

**Version:** 2.0.0  
**Letzte Aktualisierung:** Januar 2026
