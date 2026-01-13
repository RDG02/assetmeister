# Mobiele App Ontwikkelplan - Asset Management

## Overzicht
Dit document beschrijft het plan voor het ontwikkelen van een mobiele app (Android & iOS) voor de Asset Management applicatie.

## Technologie Keuze

### Aanbeveling: **React Native** of **Flutter**

**React Native (Aanbevolen):**
- ✅ Eén codebase voor iOS en Android
- ✅ Grote community en veel libraries
- ✅ JavaScript/TypeScript (bekende technologie)
- ✅ Hot reload voor snelle ontwikkeling
- ✅ Goede API integratie mogelijkheden

**Flutter:**
- ✅ Eén codebase voor iOS en Android
- ✅ Uitstekende performance
- ✅ Mooie UI out-of-the-box
- ⚠️ Dart taal (minder bekend)

**Native (iOS Swift + Android Kotlin):**
- ✅ Beste performance
- ✅ Volledige native features
- ❌ Twee aparte codebases nodig
- ❌ Meer ontwikkeltijd

## Project Structuur

### Optie 1: Apart Project (AANBEVOLEN)
```
Asset management/          (huidige Laravel project)
├── app/
├── routes/
└── ...

mobile-app/                (nieuw project)
├── src/
├── android/
├── ios/
└── package.json
```

**Voordelen:**
- Schone scheiding van concerns
- Onafhankelijke deployment
- Makkelijker te onderhouden
- Team kan parallel werken

### Optie 2: In Huidige Project
```
Asset management/
├── app/                   (Laravel backend)
├── mobile/                (mobiele app code)
│   ├── src/
│   ├── android/
│   └── ios/
└── ...
```

**Nadelen:**
- Verwarrende structuur
- Moeilijker deployment
- Niet standaard

## API Endpoints Beschikbaar

De backend heeft al een volledige REST API:

### Authenticatie
- `POST /api/v1/account/personal-access-tokens` - Token aanmaken
- `GET /api/v1/account/personal-access-tokens` - Tokens ophalen
- `DELETE /api/v1/account/personal-access-tokens/{id}` - Token verwijderen

### Assets (Hardware)
- `GET /api/v1/hardware` - Lijst assets
- `GET /api/v1/hardware/{id}` - Asset details
- `POST /api/v1/hardware/{id}/checkout` - Asset uitchecken
- `POST /api/v1/hardware/{id}/checkin` - Asset inchecken
- `GET /api/v1/hardware/bytag/{tag}` - Asset zoeken op tag

### Gebruikers
- `GET /api/v1/users/me` - Huidige gebruiker info
- `GET /api/v1/users/{id}/assets` - Assets van gebruiker

### En veel meer...

## Ontwikkel Stappen

### Fase 1: Setup (Week 1)
1. ✅ Technologie kiezen (React Native aanbevolen)
2. ✅ Project opzetten
3. ✅ Development environment configureren
4. ✅ API client library opzetten

### Fase 2: Authenticatie (Week 1-2)
1. Login scherm
2. Token management (opslaan, refresh)
3. Auto-login functionaliteit
4. Logout

### Fase 3: Basis UI (Week 2-3)
1. Dashboard/Home scherm
2. Navigatie (tab bar of drawer)
3. Asset lijst scherm
4. Asset detail scherm

### Fase 4: Core Features (Week 3-4)
1. Asset checkout
2. Asset checkin
3. QR/Barcode scanner
4. Asset zoeken

### Fase 5: Uitbreidingen (Week 4+)
1. Offline mode
2. Push notifications
3. Foto's uploaden
4. Notificaties

## Volgende Stap

**Stap 1: Project Setup**
- Kies React Native of Flutter
- Maak nieuw project aan
- Configureer API base URL

Zal ik beginnen met het opzetten van een React Native project?
