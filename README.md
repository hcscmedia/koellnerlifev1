# Koellner.life - Moderne Website

Modernisierung des Online-Auftritts https://koellner.life mit modernem Design und neuesten Web-Technologien.

## Features

- ✨ Modernes, professionelles Design mit Glassmorphismus
- 📱 Vollständig responsive für Desktop, Tablet und Smartphone
- ⚡ Optimierte Performance mit schnellen Ladezeiten
- ♿ Barrierefreie Implementierung mit ARIA-Labels
- 🎨 Ansprechende Animationen und Interaktionen
- 🔒 Sicher - keine Abhängigkeiten von Drittanbietern

## Technologie-Stack

- **HTML5** - Semantische Struktur
- **CSS3** - Moderne Styling-Features (Custom Properties, Flexbox, Grid)
- **Vanilla JavaScript** - Keine Framework-Abhängigkeiten
- **Responsive Design** - Mobile-First-Ansatz

## Lokale Entwicklung

### Voraussetzungen
- Ein moderner Webbrowser (Chrome, Firefox, Safari, Edge)
- Optional: Ein lokaler Webserver (z.B. Python HTTP Server)

### Installation

1. Repository klonen:
```bash
git clone https://github.com/hcscmedia/koellnerlifev1.git
cd koellnerlifev1
```

2. Lokalen Server starten:
```bash
# Mit Python 3
python3 -m http.server 8080

# Oder mit Node.js
npx http-server -p 8080
```

3. Im Browser öffnen:
```
http://localhost:8080
```

## Deployment

Die Website besteht aus statischen Dateien und kann auf jedem Webhosting-Service deployed werden:

- **GitHub Pages**: Push zu GitHub und aktiviere GitHub Pages
- **Netlify**: Drag & Drop der Dateien ins Netlify Dashboard
- **Vercel**: Verbinde das Repository mit Vercel
- **Traditionelles Hosting**: Upload der Dateien via FTP

### Dateien für Deployment
- `index.html` - Hauptseite
- `styles.css` - Alle Styles
- `script.js` - Interaktivität

## Browser-Unterstützung

- Chrome/Edge (letzte 2 Versionen)
- Firefox (letzte 2 Versionen)
- Safari (letzte 2 Versionen)
- Mobile Browser (iOS Safari, Chrome Mobile)

## Anpassungen

### Farben ändern
Farben können in `styles.css` über CSS Custom Properties angepasst werden:
```css
:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    /* weitere Farben... */
}
```

### Inhalte ändern
Texte und Inhalte direkt in `index.html` bearbeiten.

### Formular konfigurieren
Das Kontaktformular ist derzeit eine Demo. Für echte Funktionalität:
1. Backend-API erstellen oder Service wie Formspree nutzen
2. `script.js` Zeile 109-133 anpassen

## Lizenz

© 2026 Koellner.life. Alle Rechte vorbehalten.
