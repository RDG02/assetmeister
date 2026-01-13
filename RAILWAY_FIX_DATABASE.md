# 🔧 Fix Database Connectie op Railway

## Het Probleem

De fout "SQLSTATE[HY000] [2002] No such file or directory" betekent dat de database connectie niet werkt. Railway gebruikt environment variables direct, niet een .env file.

## ✅ Oplossing: DATABASE_URL Instellen

### Stap 1: Kopieer DATABASE_URL van Database Service

1. Ga naar Railway Dashboard
2. Klik op je **MySQL service** (niet de web service!)
3. Ga naar het **"Variables"** tabblad
4. Zoek naar **`MYSQL_URL`** of **`DATABASE_URL`**
5. Klik op het **oog icoon** om de waarde te zien
6. **Kopieer de volledige URL** (ziet eruit als: `mysql://user:password@host:port/database`)

### Stap 2: Voeg DATABASE_URL toe aan Web Service

1. Ga terug naar je **Web Service** (assetmeister)
2. Ga naar het **"Variables"** tabblad
3. Klik op **"+ New Variable"**
4. Voeg toe:
   - **Name:** `DATABASE_URL`
   - **Value:** (plak de gekopieerde URL uit stap 1)
5. Klik **"Add"**

### Stap 3: Service Dependency Toevoegen (Belangrijk!)

Dit zorgt ervoor dat de database beschikbaar is voor je web service:

1. In je **Web Service**, ga naar **"Settings"** (tandwiel icoon)
2. Scroll naar **"Service Dependencies"**
3. Klik op **"Add Dependency"**
4. Selecteer je **MySQL service**
5. Klik **"Add"**

### Stap 4: Restart Deployment

1. Ga naar **"Deployments"** tab
2. Klik op **"Restart"** bij de crashed deployment
3. Of wacht tot Railway automatisch een nieuwe deployment start

## Alternative: Handmatige DB Variables

Als DATABASE_URL niet werkt, voeg handmatig toe:

1. In je **MySQL service** → **Variables**, noteer:
   - `MYSQLHOST`
   - `MYSQLPORT` 
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

2. In je **Web Service** → **Variables**, voeg toe:
   ```
   DB_CONNECTION=mysql
   DB_HOST=<MYSQLHOST waarde>
   DB_PORT=<MYSQLPORT waarde>
   DB_DATABASE=<MYSQLDATABASE waarde>
   DB_USERNAME=<MYSQLUSER waarde>
   DB_PASSWORD=<MYSQLPASSWORD waarde>
   ```

## ✅ Checklist

- [ ] DATABASE_URL is gekopieerd van MySQL service
- [ ] DATABASE_URL is toegevoegd aan Web Service Variables
- [ ] Service Dependency is toegevoegd (MySQL → Web Service)
- [ ] Deployment is gerestart
- [ ] Check logs om te zien of connectie werkt

## Na Fix

Na het toevoegen van DATABASE_URL en service dependency, zou de deployment moeten slagen. Check de logs om te bevestigen dat de database connectie werkt.
