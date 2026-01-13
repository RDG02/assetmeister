# Aanvullende Vragen - Mobiele App

## 1. Multi-Tenant / Klant URL Structuur

Je gaf aan: "URL wil ik of via klant of via unieke URL voor klant"

**Vragen:**
- **A)** Subdomain per klant? (bijv. `klant1.jouwapp.nl`, `klant2.jouwapp.nl`)
- **B)** Pad per klant? (bijv. `jouwapp.nl/api/klant1`, `jouwapp.nl/api/klant2`)
- **C)** Parameter in API? (bijv. `jouwapp.nl/api/v1/hardware?company_id=1`)
- **D)** Verschillende servers per klant? (bijv. `klant1-server.nl`, `klant2-server.nl`)

**Backend ondersteunt al:** Company-based scoping (ik zie `company_id` in de models)

**Aanbeveling voor app:**
- App kan meerdere "instances" hebben (verschillende klanten)
- Bij login: gebruiker kiest/krijgt automatisch de juiste company
- Of: app heeft een "server selectie" scherm bij eerste start

---

## 2. RFID/NFC Scanning - Hardware Details

Je wilt QR, Barcode, **en RFID (NFC)** scanning.

**Vragen:**
- **Welke RFID/NFC standaard?** 
  - NFC (Near Field Communication) - standaard in moderne telefoons
  - RFID tags (verschillende frequenties: LF, HF, UHF)
  - Welke specifieke tags worden gebruikt?

- **Hardware:**
  - Gebruiken klanten externe RFID readers?
  - Of alleen NFC via telefoon?
  - Welke RFID reader hardware (merk/model)?

**Technische uitdaging:**
- React Native heeft goede QR/Barcode libraries
- NFC is mogelijk met `react-native-nfc-manager`
- Externe RFID readers: vaak via Bluetooth/USB, vereist custom native module

**Aanbeveling:**
- **Fase 1:** QR + Barcode (eenvoudig, werkt direct)
- **Fase 2:** NFC (via telefoon, meeste moderne telefoons ondersteunen dit)
- **Fase 3:** Externe RFID readers (complexer, vereist hardware specs)

---

## 3. Apple Developer Account

Je hebt GitHub, Google, Cursor AI, Android Studio genoemd.

**Vraag:** Heb je ook een **Apple Developer Account** ($99/jaar)?
- Nodig voor iOS app development
- Nodig voor TestFlight (beta testing)
- Nodig voor App Store release

**Als je die nog niet hebt:**
- We kunnen beginnen met Android
- iOS later toevoegen wanneer account beschikbaar is
- Of: alleen Android voor nu?

---

## 4. Feature Prioriteiten voor v1.0

Je hebt veel features genoemd. Laten we prioriteren:

### **Must Have (v1.0):**
- [x] Login/Authenticatie
- [x] Dashboard
- [x] Asset overzicht (lijst/grid, filters)
- [x] Asset details
- [x] QR/Barcode scanner
- [x] Asset toewijzen (checkout)
- [x] Asset inchecken (checkin)
- [x] Status aanpassen

### **Should Have (v1.1):**
- [ ] NFC scanning
- [ ] Offline mode + sync
- [ ] Push notifications
- [ ] Admin: Asset aanmaken
- [ ] Admin: Asset wijzigen

### **Nice to Have (v2.0):**
- [ ] RFID (externe readers)
- [ ] Geavanceerde filters
- [ ] Export functionaliteit
- [ ] Audit features

**Vraag:** Klopt deze prioritering? Of wil je alles in v1.0?

---

## 5. Offline Sync Strategie - Details

Je wilt offline mode met sync naar cloud.

**Vragen:**
- **Welke acties moeten offline werken?**
  - [ ] Asset lijst bekijken (gecached)
  - [ ] Asset details bekijken
  - [ ] Checkout acties (queue voor sync)
  - [ ] Checkin acties (queue voor sync)
  - [ ] Status wijzigen (queue voor sync)
  - [ ] Asset aanmaken (admin, queue voor sync)
  - [ ] Asset wijzigen (admin, queue voor sync)

- **Conflict Resolution:**
  - Wat als een asset offline is gewijzigd, maar ook online is gewijzigd?
  - "Last write wins" of gebruiker moet kiezen?

- **Sync Trigger:**
  - Automatisch wanneer online?
  - Alleen handmatig (pull-to-refresh)?
  - Beide?

**Aanbeveling:**
- Local database (SQLite) voor offline data
- Queue voor offline acties
- Background sync wanneer online
- Conflict: "Last write wins" met timestamp check

---

## 6. Push Notifications - Details

Je wilt push notifications.

**Vragen:**
- **Welke notificaties?**
  - [ ] Asset checkout requests
  - [ ] Asset checkin reminders
  - [ ] Asset status wijzigingen
  - [ ] Nieuwe assets toegewezen
  - [ ] Audit reminders
  - [ ] Algemene updates

- **Backend ondersteuning:**
  - Heeft de backend al push notification setup?
  - Firebase Cloud Messaging (FCM) voor Android?
  - Apple Push Notification Service (APNS) voor iOS?

**Technische vereisten:**
- Firebase project setup
- APNS certificaten (iOS)
- Backend moet notifications kunnen sturen

---

## 7. Admin Features - Permissions

Je wilt admin features (asset aanmaken/wijzigen).

**Vragen:**
- **Hoe werkt permissions in de backend?**
  - Ik zie `permissions` JSON in User model
  - Welke permissions zijn er voor assets?
    - `assets.create`
    - `assets.edit`
    - `assets.delete`
    - `assets.checkout`
    - `assets.checkin`

- **Admin vs Regular User:**
  - Moet de app UI anders zijn voor admins?
  - Of gewoon extra knoppen/features zichtbaar?

**Aanbeveling:**
- App checkt user permissions via API
- Toon alleen relevante features per gebruiker
- Admin: extra "Create" en "Edit" knoppen

---

## 8. UI Design - Kleuren & Branding

Je wilt consistente UI met kleuren die overgenomen mogen worden.

**Vragen:**
- **Heeft de web applicatie al een kleurenschema?**
  - Primaire kleur?
  - Secundaire kleur?
  - Accent kleuren?

- **Logo/Branding:**
  - Heeft de app een logo?
  - Moet dit in de mobiele app komen?

- **Design Referenties:**
  - Zijn er andere apps die je mooi vindt?
  - Material Design of Cupertino als basis?

**Aanbeveling:**
- Ik kan de web app kleuren analyseren
- Consistente kleuren gebruiken in mobiele app
- Modern, clean design met goede UX

---

## 9. Development Omgeving

**Vragen:**
- **Welke OS gebruik je voor development?**
  - Windows (Android Studio werkt)
  - Mac (nodig voor iOS development)
  - Linux

- **Voor iOS development:**
  - Heb je toegang tot een Mac?
  - Of alleen Android voor nu?

**Belangrijk:** iOS development vereist Mac + Xcode (kan niet op Windows)

---

## 10. Deployment & Distributie

**Vragen:**
- **Hoe wil je de app distribueren?**
  - [ ] App Store (publiek)
  - [ ] TestFlight (beta, iOS)
  - [ ] Google Play Internal Testing
  - [ ] Enterprise distribution (intern)
  - [ ] APK/IPA direct installeren

- **Per klant:**
  - Zelfde app voor alle klanten? (met server selectie)
  - Of aparte app per klant? (white-label)

**Aanbeveling:**
- Eén app met server/company selectie
- Makkelijker onderhoud
- Klanten kunnen zelf server URL instellen

---

## Samenvatting - Belangrijkste Vragen

1. **Multi-tenant URL structuur?** (subdomain/pad/parameter)
2. **RFID hardware details?** (welke readers/tags?)
3. **Apple Developer Account?** (voor iOS)
4. **Feature prioriteiten?** (alles in v1.0 of gefaseerd?)
5. **Offline sync details?** (welke acties, conflict resolution)
6. **Push notification types?** (welke notificaties?)
7. **Development OS?** (Windows/Mac voor iOS?)
8. **App distributie?** (App Store/Enterprise/direct?)

---

## Volgende Stap

Nadat we deze vragen hebben beantwoord, kunnen we:
1. ✅ Definitief technisch plan opstellen
2. ✅ Project structuur bepalen
3. ✅ Feature lijst finaliseren
4. ✅ Development roadmap maken
5. ✅ **Project opzetten en beginnen!** 🚀
