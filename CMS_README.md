# Koellner.life CMS - Setup & Installation Guide

## Überblick

Das Koellner.life CMS ist ein leichtgewichtiges Content Management System mit:
- **Backend**: Node.js + Express
- **Datenbank**: SQLite
- **Admin Panel**: AI-themed responsive Interface
- **API**: RESTful endpoints

## Installation

### 1. Voraussetzungen

- Node.js (v14 oder höher)
- npm oder yarn

### 2. Abhängigkeiten installieren

```bash
npm install
```

### 3. Umgebungsvariablen konfigurieren

Kopieren Sie `.env.example` zu `.env`:

```bash
cp .env.example .env
```

**Wichtig**: Ändern Sie die Standardwerte in der Produktion!

```env
PORT=3000
JWT_SECRET=your-secret-key-change-this-in-production
ADMIN_USERNAME=admin
ADMIN_PASSWORD=admin123
```

### 4. Datenbank initialisieren

```bash
npm run init-db
```

Dies erstellt:
- SQLite-Datenbank in `./database/cms.db`
- Standard-Admin-Benutzer
- Beispiel-Content und Services

## Server starten

### Entwicklung (mit Auto-Reload)
```bash
npm run dev
```

### Produktion
```bash
npm start
```

Der Server läuft auf: `http://localhost:3000`

## Zugriff

### Frontend (Public Website)
- URL: `http://localhost:3000/`
- Die statische Website wird wie gewohnt ausgeliefert

### Admin Panel
- URL: `http://localhost:3000/admin`
- Standard-Login:
  - Benutzername: `admin`
  - Passwort: `admin123`

### API Endpoints
- Health Check: `http://localhost:3000/api/health`
- Dokumentation siehe unten

## API Dokumentation

### Authentifizierung

#### POST /api/auth/login
Login und Token erhalten

```json
{
  "username": "admin",
  "password": "admin123"
}
```

Response:
```json
{
  "token": "eyJhbGc...",
  "user": {
    "id": 1,
    "username": "admin"
  }
}
```

#### GET /api/auth/verify
Token validieren (Header: `Authorization: Bearer <token>`)

### Content Management

#### GET /api/content
Alle Content-Bereiche abrufen (öffentlich)

#### GET /api/content/:section
Spezifischen Content-Bereich abrufen (öffentlich)

#### PUT /api/content/:section
Content aktualisieren (authentifiziert)

```json
{
  "title": "Neuer Titel",
  "subtitle": "Neuer Untertitel",
  "description": "Neue Beschreibung"
}
```

### Services Management

#### GET /api/services
Alle aktiven Services abrufen (öffentlich)

#### POST /api/services
Neuen Service erstellen (authentifiziert)

```json
{
  "number": "05",
  "title": "Neuer Service",
  "description": "Beschreibung",
  "icon": "icon-name",
  "order_index": 5
}
```

#### PUT /api/services/:id
Service aktualisieren (authentifiziert)

#### DELETE /api/services/:id
Service löschen (authentifiziert)

### Messages Management

#### POST /api/messages
Kontaktformular-Nachricht senden (öffentlich)

```json
{
  "name": "Max Mustermann",
  "email": "max@example.com",
  "message": "Hallo, ich habe eine Frage..."
}
```

#### GET /api/messages
Alle Nachrichten abrufen (authentifiziert)

#### PUT /api/messages/:id/read
Nachricht als gelesen markieren (authentifiziert)

#### DELETE /api/messages/:id
Nachricht löschen (authentifiziert)

## Admin Panel Features

### Dashboard
- Übersicht über Content, Services und Nachrichten
- Anzahl ungelesener Nachrichten

### Content-Verwaltung
- Bearbeiten von Hero, About, Services und Contact Sections
- Titel, Untertitel und Beschreibung anpassen

### Services-Verwaltung
- Services hinzufügen, bearbeiten und löschen
- Reihenfolge und Status verwalten

### Nachrichten-Inbox
- Kontaktformular-Nachrichten anzeigen
- Als gelesen markieren
- Löschen

## Datenbankstruktur

### Tabelle: content
- `id`: Integer (Primary Key)
- `section`: VARCHAR(50) (Unique)
- `title`: TEXT
- `subtitle`: TEXT
- `description`: TEXT
- `updated_at`: DATETIME

### Tabelle: services
- `id`: Integer (Primary Key)
- `number`: VARCHAR(10)
- `title`: VARCHAR(100)
- `description`: TEXT
- `icon`: VARCHAR(50)
- `active`: BOOLEAN
- `order_index`: INTEGER
- `created_at`: DATETIME

### Tabelle: messages
- `id`: Integer (Primary Key)
- `name`: VARCHAR(100)
- `email`: VARCHAR(255)
- `message`: TEXT
- `read`: BOOLEAN
- `created_at`: DATETIME

### Tabelle: users
- `id`: Integer (Primary Key)
- `username`: VARCHAR(50) (Unique)
- `password_hash`: VARCHAR(255)
- `created_at`: DATETIME

## Sicherheit

⚠️ **Wichtige Sicherheitshinweise:**

1. **Passwort ändern**: Ändern Sie das Standard-Admin-Passwort sofort!
2. **JWT Secret**: Verwenden Sie einen starken, zufälligen JWT_SECRET
3. **HTTPS**: In Produktion immer HTTPS verwenden
4. **Firewall**: Nur notwendige Ports öffnen
5. **Updates**: Abhängigkeiten regelmäßig aktualisieren

## Deployment

### Vorbereitung
1. `.env` mit Produktionswerten konfigurieren
2. Datenbank initialisieren: `npm run init-db`
3. Admin-Passwort ändern

### Mit PM2 (empfohlen)
```bash
npm install -g pm2
pm2 start server.js --name koellner-cms
pm2 save
pm2 startup
```

### Mit systemd
Service-Datei erstellen unter `/etc/systemd/system/koellner-cms.service`

## Troubleshooting

### Port bereits in Verwendung
```bash
# Port in .env ändern oder
lsof -i :3000
kill -9 <PID>
```

### Datenbank-Fehler
```bash
# Datenbank neu initialisieren
rm database/cms.db
npm run init-db
```

### Admin-Passwort vergessen
```bash
# Datenbank löschen und neu initialisieren
rm database/cms.db
npm run init-db
```

## Support

Bei Fragen oder Problemen:
- GitHub Issues: [Repository URL]
- E-Mail: kontakt@koellner.life

## Lizenz

MIT License - Copyright (c) 2026 Koellner.life
