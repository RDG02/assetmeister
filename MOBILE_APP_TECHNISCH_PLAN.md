# Mobiele App - Technisch Plan (Definitief)

## Beslissingen

✅ **Technologie:** React Native (Android eerst, iOS later)  
✅ **Project Locatie:** Apart project naast Laravel backend  
✅ **Multi-tenant:** Één app met server/company selectie bij login  
✅ **Scanning:** QR/Barcode in v1.0, NFC in v1.1  
✅ **Platform:** Android eerst (Windows development), iOS later  
✅ **Features:** Gefaseerd (v1.0 = core, v1.1 = uitbreidingen)  
✅ **Offline:** Queue voor acties + automatische sync  
✅ **Push Notifications:** Checkout requests, reminders, status wijzigingen  
✅ **Distributie:** Direct APK voor nu, later publiek  

---

## Wat betekent "Company-Based Scoping"?

**Uitleg:**
De Laravel backend heeft al een multi-company systeem. Dit betekent:

1. **Elke gebruiker heeft een `company_id`**
   - Wanneer een gebruiker inlogt, weet de backend bij welke company hij hoort
   - De API retourneert alleen data van die company

2. **Automatische filtering:**
   - `GET /api/v1/hardware` retourneert alleen assets van jouw company
   - Je ziet niet de assets van andere companies
   - Dit gebeurt automatisch in de backend

3. **Voor de mobiele app:**
   - Gebruiker logt in → backend weet company
   - Alle API calls worden automatisch gefilterd op company
   - Geen extra code nodig in de app voor filtering

**Implementatie in app:**
- Bij login: gebruiker logt in met username/password
- Backend retourneert user info inclusief `company_id`
- App slaat `company_id` op (voor referentie, maar backend filtert al)
- Alle volgende API calls gebruiken de token → backend filtert automatisch

**Server selectie (multi-tenant):**
- App kan meerdere "servers" hebben (verschillende klanten)
- Bij eerste start: gebruiker voert server URL in
- Of: app heeft een lijst met beschikbare servers
- Elke server = aparte backend instance

---

## Project Structuur

```
Desktop/
├── Asset management/              (Laravel backend - huidige project)
│   ├── app/
│   ├── routes/
│   └── ...
│
└── asset-management-mobile/        (React Native app - NIEUW)
    ├── src/
    │   ├── api/                    (API client)
    │   ├── components/             (Herbruikbare componenten)
    │   ├── screens/                (App schermen)
    │   ├── navigation/              (Navigatie setup)
    │   ├── services/                (Business logic)
    │   ├── storage/                 (Local storage, offline queue)
    │   ├── utils/                   (Helper functies)
    │   └── constants/               (Configuratie)
    ├── android/                     (Android native code)
    ├── ios/                         (iOS native code - later)
    ├── package.json
    └── app.json
```

---

## Feature Roadmap

### v1.0 - Core Features (MVP)
- [x] **Authenticatie**
  - Login scherm
  - Server URL configuratie
  - Token management
  - Auto-login

- [x] **Dashboard**
  - Overzicht toegewezen assets
  - Snelle statistieken
  - Snelle acties

- [x] **Asset Overzicht**
  - Lijst weergave
  - Grid weergave
  - Filters (status, locatie, etc.)
  - Zoeken
  - Pull-to-refresh

- [x] **Asset Details**
  - Volledige asset informatie
  - Foto's
  - Geschiedenis
  - Status

- [x] **Checkout/Checkin**
  - Asset uitchecken naar gebruiker
  - Asset inchecken
  - Bevestigingen

- [x] **QR/Barcode Scanner**
  - Scan asset tags
  - Direct naar asset details
  - Snelle checkout/checkin

- [x] **Status Wijzigen**
  - Status aanpassen van asset
  - Status labels

### v1.1 - Uitbreidingen
- [ ] **NFC Scanning**
  - NFC tag lezen
  - Asset identificatie via NFC

- [ ] **Offline Mode**
  - Local database (SQLite)
  - Queue voor offline acties
  - Automatische sync wanneer online
  - Conflict resolution

- [ ] **Push Notifications**
  - Checkout requests
  - Reminders
  - Status wijzigingen
  - Firebase Cloud Messaging setup

- [ ] **Admin Features**
  - Asset aanmaken
  - Asset wijzigen
  - Permissions check

### v2.0 - Geavanceerd
- [ ] **RFID (Externe Readers)**
  - Bluetooth/USB RFID readers
  - Custom native modules

- [ ] **Geavanceerde Features**
  - Audit functionaliteit
  - Reports
  - Export

---

## Technische Stack

### Core
- **React Native** 0.73+ (latest stable)
- **TypeScript** (type safety)
- **React Navigation** (navigatie)
- **React Native Paper** (Material Design UI components)

### API & State
- **Axios** (HTTP client)
- **React Query** (API state management, caching)
- **AsyncStorage** (local storage)
- **React Native Keychain** (secure token storage)

### Offline & Sync
- **SQLite** (local database via `react-native-sqlite-storage`)
- **Redux Persist** (state persistence)
- **NetInfo** (network status)

### Scanning
- **react-native-vision-camera** (camera)
- **react-native-qrcode-scanner** (QR/Barcode scanning)
- **react-native-nfc-manager** (NFC - v1.1)

### Push Notifications
- **@react-native-firebase/app** (Firebase)
- **@react-native-firebase/messaging** (FCM)

### Development
- **ESLint** (code quality)
- **Prettier** (code formatting)
- **Jest** (testing)

---

## API Integratie

### Base URL Configuratie
```typescript
// src/constants/config.ts
export const API_CONFIG = {
  // Development
  BASE_URL: 'http://localhost:3000/api/v1',
  
  // Of dynamisch via server selectie
  getBaseUrl: () => {
    // Haal opgeslagen server URL op
    return AsyncStorage.getItem('server_url') || 'http://localhost:3000/api/v1';
  }
};
```

### Authenticatie Flow
1. Gebruiker voert server URL in (eerste keer)
2. Gebruiker logt in met username/password
3. App maakt API call: `POST /api/v1/account/personal-access-tokens`
4. Backend retourneert access token
5. App slaat token op in Keychain
6. Alle volgende requests: `Authorization: Bearer {token}`
7. Backend filtert automatisch op company_id van gebruiker

### API Client Structuur
```typescript
// src/api/client.ts
- Base API client met axios
- Token injectie
- Error handling
- Request/Response interceptors

// src/api/services/
- authService.ts (login, token management)
- assetService.ts (assets CRUD)
- userService.ts (user info)
- checkoutService.ts (checkout/checkin)
```

---

## Offline Sync Strategie

### Local Database Schema (SQLite)
```sql
-- Assets cache
CREATE TABLE assets (
  id INTEGER PRIMARY KEY,
  asset_tag TEXT,
  name TEXT,
  status_id INTEGER,
  -- ... andere velden
  synced_at INTEGER,
  updated_at INTEGER
);

-- Offline Queue
CREATE TABLE offline_queue (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  action TEXT, -- 'checkout', 'checkin', 'update_status'
  endpoint TEXT,
  payload TEXT, -- JSON
  created_at INTEGER,
  synced INTEGER DEFAULT 0
);
```

### Sync Flow
1. **Offline Actie:**
   - Gebruiker voert actie uit (checkout/checkin)
   - Actie wordt in queue gezet
   - Data wordt lokaal bijgewerkt (optimistic update)

2. **Wanneer Online:**
   - App detecteert internet verbinding (NetInfo)
   - Sync service verwerkt queue
   - API calls worden gemaakt
   - Bij succes: queue item verwijderd
   - Bij fout: queue item blijft, retry later

3. **Conflict Resolution:**
   - Timestamp check: laatste wijziging wint
   - Of: gebruiker krijgt melding bij conflict

---

## Push Notifications Setup

### Backend Vereisten
- Firebase project aanmaken
- FCM server key configureren in Laravel
- Notification endpoints in API

### App Setup
- Firebase configuratie (google-services.json voor Android)
- FCM token registreren bij login
- Token naar backend sturen
- Notification handlers

### Notification Types
1. **Checkout Request:** "Nieuwe checkout request voor asset X"
2. **Reminder:** "Asset X moet binnenkort ingeleverd worden"
3. **Status Wijziging:** "Status van asset X is gewijzigd"

---

## Development Workflow

### Setup
1. Node.js installeren (v18+)
2. React Native CLI installeren
3. Android Studio installeren
4. Android SDK configureren
5. Project initialiseren

### Development
```bash
# Start Metro bundler
npm start

# Run Android
npm run android

# Run iOS (later, op Mac)
npm run ios
```

### Testing
- Unit tests: Jest
- Component tests: React Native Testing Library
- E2E tests: Detox (later)

---

## Volgende Stappen

1. ✅ **Project opzetten** - React Native project initialiseren
2. ✅ **Basis structuur** - Folders en bestanden aanmaken
3. ✅ **API client** - Base API setup
4. ✅ **Navigatie** - React Navigation configureren
5. ✅ **Login scherm** - Eerste scherm met server URL + login
6. ✅ **Token management** - Secure storage setup
7. ✅ **Dashboard** - Basis dashboard scherm
8. ✅ **Asset lijst** - Asset overzicht met filters
9. ✅ **Asset details** - Detail scherm
10. ✅ **Scanner** - QR/Barcode scanner
11. ✅ **Checkout/Checkin** - Actie functionaliteit
12. ✅ **Offline mode** - SQLite + sync
13. ✅ **Push notifications** - FCM setup

---

## Start Nu!

Zal ik beginnen met:
1. React Native project opzetten
2. Basis project structuur maken
3. Eerste schermen (login) implementeren

Ready to start? 🚀
