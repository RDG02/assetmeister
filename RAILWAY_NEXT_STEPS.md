# ✅ Code staat op GitHub! Volgende Stappen voor Railway

Je code is succesvol gepusht naar: **https://github.com/RDG02/assetmeister.git**

## 🚀 Nu naar Railway - Stap voor Stap

### Stap 1: Railway Account Aanmaken (2 minuten)

1. Ga naar **[railway.app](https://railway.app)**
2. Klik op **"Start a New Project"** of **"Login"**
3. Kies **"Login with GitHub"**
4. Autoriseer Railway om toegang te krijgen tot je GitHub account

### Stap 2: Nieuw Project Aanmaken (1 minuut)

1. In Railway dashboard, klik op **"New Project"**
2. Selecteer **"Deploy from GitHub repo"**
3. Kies je repository: **`RDG02/assetmeister`**
4. Railway start automatisch met een build (wacht even, dit kan 3-5 minuten duren)

**⚠️ STOP HIER!** Wacht tot de eerste build klaar is, maar we moeten eerst de database en environment variables instellen voordat de app werkt.

### Stap 3: Database Toevoegen (1 minuut)

1. In je Railway project, klik op **"+ New"** (of het **"+"** icoon)
2. Selecteer **"Database"**
3. Kies **"Add MySQL"**
4. Railway maakt automatisch een MySQL database aan
5. **Noteer:** Je ziet nu twee services - een Web Service en een Database Service

### Stap 4: Database URL Koppelen (2 minuten)

**Optie A: Via DATABASE_URL (Aanbevolen)**

1. Klik op je **Database service** (niet de web service)
2. Ga naar het **"Variables"** tabblad
3. Zoek naar **`MYSQL_URL`** of **`DATABASE_URL`**
4. **Kopieer deze waarde** (klik op het oog icoon om te zien)
5. Ga terug naar je **Web Service**
6. Klik op **"Variables"** tab
7. Klik **"+ New Variable"**
8. Voeg toe:
   - **Name:** `DATABASE_URL`
   - **Value:** (plak de gekopieerde waarde)
9. Klik **"Add"**

**Optie B: Handmatig (Als Optie A niet werkt)**

1. In je **Database service** → **Variables**, noteer:
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

### Stap 5: Environment Variables Instellen (5 minuten)

Ga naar je **Web Service** → **Variables** tab en voeg deze toe:

#### Basis App Instellingen:

Klik **"+ New Variable"** voor elke:

```
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=Europe/Amsterdam
APP_LOCALE=nl
```

#### APP_KEY Genereren:

**BELANGRIJK!** Je moet een APP_KEY genereren. Run dit lokaal:

```powershell
php artisan key:generate --show
```

Kopieer de output (begint met `base64:`) en voeg toe als:

```
APP_KEY=<geplakte waarde>
```

**Of gebruik online tool:**
- Ga naar: https://coderstoolbox.online/toolbox/generate-symfony-secret
- Kopieer de gegenereerde key
- Voeg toe als: `APP_KEY=<geplakte waarde>`

#### Mail Configuratie:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=jouw@gmail.com
MAIL_PASSWORD=jouw_app_wachtwoord
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDR=noreply@jouwdomain.com
MAIL_FROM_NAME="Snipe-IT"
```

**⚠️ Voor Gmail:** Je moet een "App Password" gebruiken:
- Google Account → Security → 2-Step Verification → App Passwords
- Genereer een app password en gebruik die als `MAIL_PASSWORD`

#### Overige Instellingen:

```
SESSION_LIFETIME=12000
EXPIRE_ON_CLOSE=false
SECURE_COOKIES=true
LOG_CHANNEL=errorlog
FILESYSTEM_DISK=local
PUBLIC_FILESYSTEM_DISK=local_public
IMAGE_LIB=gd
QUEUE_CONNECTION=sync
```

### Stap 6: Service Dependencies Koppelen (1 minuut)

Dit zorgt ervoor dat de database beschikbaar is voor je web service:

1. Klik op je **Web Service**
2. Ga naar **"Settings"** (tandwiel icoon)
3. Scroll naar **"Service Dependencies"**
4. Klik op **"Add Dependency"**
5. Selecteer je **Database service**
6. Klik **"Add"**

### Stap 7: Build & Start Command Controleren (1 minuut)

1. In je **Web Service**, ga naar **"Settings"**
2. Controleer **"Build Command"** (zou automatisch moeten zijn):
   ```
   composer install --no-dev --optimize-autoloader
   ```

3. Controleer **"Start Command"** (zou automatisch moeten zijn):
   ```
   php railway/startup.php && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php -S 0.0.0.0:$PORT -t public
   ```

**Als deze commands niet automatisch zijn ingesteld**, voeg ze handmatig toe.

### Stap 8: Domain Instellen (1 minuut)

1. In je **Web Service**, klik op **"Settings"**
2. Scroll naar **"Networking"**
3. Klik op **"Generate Domain"** voor een gratis Railway subdomain
   - Bijv: `assetmeister-production.up.railway.app`
4. **Noteer deze URL!** Je hebt hem nodig om de app te openen

### Stap 9: Deploy! (3-5 minuten)

1. Railway deployt automatisch bij elke push naar main
2. Of klik handmatig op **"Deploy"** in je service
3. Wacht tot de deploy klaar is
4. Je kunt de voortgang zien in het **"Deployments"** tabblad
5. Bekijk logs in het **"Logs"** tabblad voor eventuele fouten

### Stap 10: Eerste Setup (5 minuten)

1. Ga naar je Railway URL (bijv. `assetmeister-production.up.railway.app`)
2. Je zou de **Snipe-IT setup wizard** moeten zien
3. Volg de installatie stappen:
   - Database connectie zou automatisch moeten werken
   - Maak je eerste admin account aan
   - Configureer basis instellingen

## ✅ Checklist

- [ ] Railway account aangemaakt
- [ ] Project aangemaakt en repository `RDG02/assetmeister` gekoppeld
- [ ] MySQL database toegevoegd
- [ ] DATABASE_URL of DB_* variables ingesteld
- [ ] APP_KEY gegenereerd en toegevoegd
- [ ] Alle environment variables ingesteld
- [ ] Service dependency toegevoegd
- [ ] Domain gegenereerd
- [ ] Deploy succesvol
- [ ] Snipe-IT setup wizard voltooid

## 🆘 Problemen?

### Database Connectie Fouten
- Check of `DATABASE_URL` correct is ingesteld
- Zorg dat service dependency is toegevoegd
- Check logs voor meer details

### APP_KEY Fouten
- Genereer nieuwe key: `php artisan key:generate --show`
- Update `APP_KEY` in Railway Variables

### 500 Internal Server Error
- Check logs in Railway Dashboard → Logs tab
- Controleer of alle environment variables zijn ingesteld
- Check of migraties zijn gedraaid (zie logs)

### Deploy Faalt
- Check build logs voor foutmeldingen
- Zorg dat `railway.json` en `railway/startup.php` aanwezig zijn
- Check of PHP versie correct is (Railway detecteert automatisch)

## 📚 Meer Hulp

- **Railway Docs:** https://docs.railway.app
- **Railway Discord:** https://discord.gg/railway
- **Snipe-IT Docs:** https://snipe-it.readme.io/docs
- **Uitgebreide handleiding:** Zie `DEPLOY_RAILWAY.md`

---

**Veel succes! 🚀 Je app zou binnen 10-15 minuten live moeten staan!**
