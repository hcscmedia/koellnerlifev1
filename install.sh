#!/bin/bash

################################################################################
# Köllner Digital - Automatisches Installationsscript
# Version: 2.0.0
################################################################################

set -e  # Bei Fehler abbrechen

# Farben für Output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Banner
echo -e "${BLUE}"
cat << "EOF"
╔═══════════════════════════════════════════════════════════╗
║                                                           ║
║           Köllner Digital - Installation                 ║
║           Admin Panel • Blog • CMS                       ║
║                                                           ║
╚═══════════════════════════════════════════════════════════╝
EOF
echo -e "${NC}"

# Funktionen
log_success() {
    echo -e "${GREEN}✓${NC} $1"
}

log_error() {
    echo -e "${RED}✗${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

log_info() {
    echo -e "${BLUE}ℹ${NC} $1"
}

# Root-Verzeichnis ermitteln
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

log_info "Installationsverzeichnis: $SCRIPT_DIR"
echo ""

################################################################################
# 1. VORAUSSETZUNGEN PRÜFEN
################################################################################

echo -e "${BLUE}[1/7] Voraussetzungen prüfen...${NC}"
echo ""

# PHP prüfen
if command -v php >/dev/null 2>&1; then
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    log_success "PHP gefunden: Version $PHP_VERSION"
    
    # PHP-Version prüfen
    PHP_MAJOR=$(php -r "echo PHP_MAJOR_VERSION;")
    PHP_MINOR=$(php -r "echo PHP_MINOR_VERSION;")
    
    if [ "$PHP_MAJOR" -lt 7 ] || ([ "$PHP_MAJOR" -eq 7 ] && [ "$PHP_MINOR" -lt 4 ]); then
        log_error "PHP 7.4 oder höher erforderlich (gefunden: $PHP_VERSION)"
        exit 1
    fi
else
    log_error "PHP nicht gefunden. Bitte installieren Sie PHP 7.4 oder höher."
    exit 1
fi

# MySQL/MariaDB prüfen
if command -v mysql >/dev/null 2>&1; then
    MYSQL_VERSION=$(mysql --version | awk '{print $5}' | sed 's/,//')
    log_success "MySQL/MariaDB gefunden: $MYSQL_VERSION"
else
    log_warning "MySQL-Client nicht gefunden. Datenbankimport muss manuell erfolgen."
    MYSQL_AVAILABLE=false
fi

# PDO MySQL Extension prüfen
if php -m | grep -q "PDO"; then
    log_success "PHP PDO Extension gefunden"
else
    log_error "PHP PDO Extension nicht gefunden"
    exit 1
fi

if php -m | grep -q "pdo_mysql"; then
    log_success "PHP PDO MySQL Extension gefunden"
else
    log_error "PHP PDO MySQL Extension nicht gefunden"
    exit 1
fi

echo ""

################################################################################
# 2. VERZEICHNISSE UND BERECHTIGUNGEN
################################################################################

echo -e "${BLUE}[2/7] Verzeichnisse erstellen...${NC}"
echo ""

# Upload-Verzeichnis
if [ ! -d "uploads" ]; then
    mkdir -p uploads
    chmod 755 uploads
    log_success "Upload-Verzeichnis erstellt: uploads/"
else
    log_info "Upload-Verzeichnis existiert bereits"
fi

# Unterverzeichnisse für Uploads
mkdir -p uploads/{blog,media,temp}
chmod -R 755 uploads/
log_success "Upload-Unterverzeichnisse erstellt"

# Logs-Verzeichnis (optional)
if [ ! -d "logs" ]; then
    mkdir -p logs
    chmod 755 logs
    log_success "Log-Verzeichnis erstellt: logs/"
fi

# Berechtigungen prüfen und setzen
chmod 644 config.php 2>/dev/null || true
chmod 644 .htaccess 2>/dev/null || true
chmod 755 admin/ 2>/dev/null || true
log_success "Berechtigungen gesetzt"

echo ""

################################################################################
# 3. DATENBANK-KONFIGURATION
################################################################################

echo -e "${BLUE}[3/7] Datenbank-Konfiguration...${NC}"
echo ""

# Interaktive Eingabe
read -p "Datenbank-Host [localhost]: " DB_HOST
DB_HOST=${DB_HOST:-localhost}

read -p "Datenbank-Name [koellner_life]: " DB_NAME
DB_NAME=${DB_NAME:-koellner_life}

read -p "Datenbank-Benutzer: " DB_USER
if [ -z "$DB_USER" ]; then
    log_error "Datenbank-Benutzer erforderlich"
    exit 1
fi

read -sp "Datenbank-Passwort: " DB_PASS
echo ""
if [ -z "$DB_PASS" ]; then
    log_warning "Kein Passwort eingegeben (nicht empfohlen)"
fi

echo ""
log_info "Konfiguration:"
echo "  Host: $DB_HOST"
echo "  Datenbank: $DB_NAME"
echo "  Benutzer: $DB_USER"
echo ""

################################################################################
# 4. CONFIG.PHP AKTUALISIEREN
################################################################################

echo -e "${BLUE}[4/7] config.php aktualisieren...${NC}"
echo ""

# Backup erstellen
if [ -f "config.php" ]; then
    cp config.php config.php.backup
    log_success "Backup erstellt: config.php.backup"
fi

# config.php aktualisieren mit sed
sed -i.bak "s/define('DB_HOST', '.*');/define('DB_HOST', '$DB_HOST');/" config.php
sed -i.bak "s/define('DB_NAME', '.*');/define('DB_NAME', '$DB_NAME');/" config.php
sed -i.bak "s/define('DB_USER', '.*');/define('DB_USER', '$DB_USER');/" config.php
sed -i.bak "s/define('DB_PASS', '.*');/define('DB_PASS', '$DB_PASS');/" config.php

# Debug-Modus deaktivieren für Produktion
sed -i.bak "s/define('DEBUG_MODE', true);/define('DEBUG_MODE', false);/" config.php

rm -f config.php.bak

log_success "config.php aktualisiert"
echo ""

################################################################################
# 5. DATENBANK ERSTELLEN UND SCHEMA IMPORTIEREN
################################################################################

echo -e "${BLUE}[5/7] Datenbank einrichten...${NC}"
echo ""

if [ "$MYSQL_AVAILABLE" != "false" ]; then
    # Datenbank erstellen
    log_info "Erstelle Datenbank '$DB_NAME'..."
    
    mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null
    
    if [ $? -eq 0 ]; then
        log_success "Datenbank erstellt/gefunden"
    else
        log_error "Fehler beim Erstellen der Datenbank"
        log_info "Bitte erstellen Sie die Datenbank manuell und importieren Sie database/schema.sql"
        exit 1
    fi
    
    # Schema importieren
    if [ -f "database/schema.sql" ]; then
        log_info "Importiere Datenbankschema..."
        
        mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < database/schema.sql 2>/dev/null
        
        if [ $? -eq 0 ]; then
            log_success "Datenbankschema erfolgreich importiert"
        else
            log_error "Fehler beim Importieren des Schemas"
            exit 1
        fi
    else
        log_error "Schema-Datei nicht gefunden: database/schema.sql"
        exit 1
    fi
else
    log_warning "Datenbankimport übersprungen (MySQL-Client nicht verfügbar)"
    log_info "Bitte importieren Sie database/schema.sql manuell"
fi

echo ""

################################################################################
# 6. ADMIN-PASSWORT
################################################################################

echo -e "${BLUE}[6/7] Admin-Konfiguration...${NC}"
echo ""

log_info "Standard Admin-Login:"
echo "  Benutzername: admin"
echo "  Passwort: Admin123!"
echo ""
log_warning "WICHTIG: Ändern Sie das Passwort nach dem ersten Login!"
echo ""

read -p "Möchten Sie jetzt ein eigenes Admin-Passwort setzen? [j/N]: " SET_PASSWORD

if [[ $SET_PASSWORD =~ ^[Jj]$ ]]; then
    read -sp "Neues Admin-Passwort (min. 8 Zeichen): " NEW_PASSWORD
    echo ""
    
    if [ ${#NEW_PASSWORD} -lt 8 ]; then
        log_error "Passwort muss mindestens 8 Zeichen lang sein"
    else
        # Passwort-Hash generieren
        PASSWORD_HASH=$(php -r "echo password_hash('$NEW_PASSWORD', PASSWORD_DEFAULT);")
        
        if [ "$MYSQL_AVAILABLE" != "false" ]; then
            mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" -e "UPDATE admin_users SET password_hash='$PASSWORD_HASH' WHERE username='admin';" 2>/dev/null
            
            if [ $? -eq 0 ]; then
                log_success "Admin-Passwort erfolgreich geändert"
            else
                log_error "Fehler beim Ändern des Passworts"
            fi
        else
            log_warning "Passwort konnte nicht automatisch gesetzt werden"
        fi
    fi
fi

echo ""

################################################################################
# 7. INSTALLATION ABSCHLIESSEN
################################################################################

echo -e "${BLUE}[7/7] Installation abschließen...${NC}"
echo ""

# .htaccess prüfen
if [ -f ".htaccess" ]; then
    log_success ".htaccess gefunden"
else
    log_warning ".htaccess nicht gefunden"
fi

# Testdatei erstellen
cat > test-install.php << 'EOF'
<?php
require_once 'config.php';
header('Content-Type: text/plain');

echo "Installationstest\n";
echo str_repeat("=", 50) . "\n\n";

// PHP-Version
echo "PHP Version: " . PHP_VERSION . "\n";

// Extensions
echo "PDO verfügbar: " . (extension_loaded('pdo') ? 'Ja' : 'Nein') . "\n";
echo "PDO MySQL verfügbar: " . (extension_loaded('pdo_mysql') ? 'Ja' : 'Nein') . "\n\n";

// Datenbankverbindung testen
try {
    $db = Database::getInstance();
    echo "Datenbankverbindung: OK\n";
    
    $result = $db->fetchOne("SELECT COUNT(*) as count FROM admin_users");
    echo "Admin-Benutzer: " . $result['count'] . "\n";
    
    $result = $db->fetchOne("SELECT COUNT(*) as count FROM blog_posts");
    echo "Blog-Posts: " . $result['count'] . "\n";
    
    $result = $db->fetchOne("SELECT COUNT(*) as count FROM blog_categories");
    echo "Blog-Kategorien: " . $result['count'] . "\n";
    
    echo "\n✓ Installation erfolgreich!\n";
} catch (Exception $e) {
    echo "Datenbankverbindung: FEHLER\n";
    echo "Fehler: " . $e->getMessage() . "\n";
}
EOF

log_success "Testdatei erstellt: test-install.php"

echo ""
echo -e "${GREEN}╔═══════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║                                                           ║${NC}"
echo -e "${GREEN}║            ✓ Installation erfolgreich!                   ║${NC}"
echo -e "${GREEN}║                                                           ║${NC}"
echo -e "${GREEN}╚═══════════════════════════════════════════════════════════╝${NC}"
echo ""

################################################################################
# ZUSAMMENFASSUNG
################################################################################

echo -e "${BLUE}Nächste Schritte:${NC}"
echo ""
echo "1. Installationstest ausführen:"
echo -e "   ${YELLOW}php test-install.php${NC}"
echo ""
echo "2. Admin-Panel öffnen:"
echo -e "   ${YELLOW}https://ihre-domain.de/admin/${NC}"
echo ""
echo "3. Mit diesen Zugangsdaten anmelden:"
if [[ $SET_PASSWORD =~ ^[Jj]$ ]]; then
    echo "   Benutzername: admin"
    echo "   Passwort: (Ihr gewähltes Passwort)"
else
    echo "   Benutzername: admin"
    echo "   Passwort: Admin123!"
    echo -e "   ${RED}⚠ WICHTIG: Passwort sofort ändern!${NC}"
fi
echo ""
echo "4. Blog zur Navigation hinzufügen:"
echo "   Bearbeiten Sie includes/navigation.php"
echo ""
echo -e "${BLUE}Dokumentation:${NC}"
echo "   • README.md - Allgemeine Übersicht"
echo "   • INSTALLATION.md - Detaillierte Anleitung"
echo ""
echo -e "${GREEN}Viel Erfolg mit Ihrer Website!${NC}"
echo ""

# Testscript ausführen?
read -p "Möchten Sie den Installationstest jetzt ausführen? [J/n]: " RUN_TEST

if [[ ! $RUN_TEST =~ ^[Nn]$ ]]; then
    echo ""
    echo -e "${BLUE}Führe Installationstest aus...${NC}"
    echo ""
    php test-install.php
fi

exit 0
