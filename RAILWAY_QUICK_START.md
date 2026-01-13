# Railway Quick Start - Stap voor Stap 🚀

Volg deze stappen om je Snipe-IT applicatie live te zetten op Railway.

## Stap 1: GitHub Repository Voorbereiden

### Option A: Als je project AL op GitHub staat
```bash
# Check of je remote al bestaat
git remote -v

# Als er geen remote is, voeg toe:
git remote add origin https://github.com/JOUW-USERNAME/JOUW-REPO.git
git branch -M main
git push -u origin main
```

### Option B: Nieuwe GitHub Repository aanmaken
1. Ga naar [github.com](https://github.com) en log in
2. Klik op **"+"** → **"New repository"**
3. Vul in:
   - **Repository name**: bijv. `snipe-it-asset-management`
   - **Description**: "Asset Management System"
   - **Public** of **Private** (jouw keuze)
   - ✅ **NIET** "Initialize with README" aanvinken
4. Klik op **"Create repository"**
5. Volg de instructies die GitHub geeft, of gebruik deze commands:

```bash
# Voeg alle bestanden toe (behalve .env en andere genegeerde bestanden)
git add .

# Maak eerste commit
git commit -m "Initial commit: Snipe-IT with Railway config"

# Voeg GitHub remote toe (VERVANG met jouw repository URL!)
git remote add origin https://github.com/JOUW-USERNAME/JOUW-REPO.git

# Push naar GitHub
git branch -M main
git push -u origin main
```

**⚠️ BELANGRIJK:** Controleer dat je `.env` bestand NIET wordt gecommit:
```bash
# Check wat er gecommit wordt
git status

# Als .env in de lijst staat, voeg toe aan .gitignore:
echo ".env" >> .gitignore
git add .gitignore
git commit -m "Add .env to gitignore"
```

---

## Stap 2: Railway Account Aanmaken

1. Ga naar [railway.app](https://railway.app)
2. Klik op **"Start a New Project"** of **"Login"**
3. Kies **"Login with GitHub"**
4. Autoriseer Railway om toegang te krijgen tot je GitHub account

---

## Stap 3: Nieuw Railway Project

1. In Railway dashboard, klik op **"New Project"**
2. Selecteer **"Deploy from GitHub repo"**
3. Kies je Snipe-IT repository uit de lijst
4. Railway start automatisch met een build

**Wacht even!** We moeten eerst de database en environment variables instellen voordat we deployen.

---

## Stap 4: Database Toevoegen

1. In je Railway project, klik op **"+ New"** (of het **"+"** icoon)
2. Selecteer **"Database"**
3. Kies **"Add MySQL"** (of PostgreSQL als je dat prefereert)
4. Railway maakt automatisch een MySQL database aan
5. **Noteer de volgende info** (je hebt dit nodig):
   - Database naam
   - Username
   - Password
   - Host
   - Port (meestal 3306)

**TIP:** Je kunt deze info ook later vinden in de database service → "Variables" tab.

---

## Stap 5: Environment Variables Instellen

1. Ga terug naar je **Web Service** (niet de database)
2. Klik op de service naam
3. Ga naar het **"Variables"** tabblad
4. Voeg de volgende variabelen toe (klik op **"+ New Variable"** voor elke):

### Basis App Instellingen:

```
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=Europe/Amsterdam
APP_LOCALE=nl
```

### Database Instellingen:

```
DB_CONNECTION=mysql
DB_HOST=JOUW_DB_HOST_UIT_STAP_4
DB_PORT=3306
DB_DATABASE=JOUW_DATABASE_NAAM
DB_USERNAME=JOUW_DB_USERNAME
DB_PASSWORD=JOUW_DB_PASSWORD
```

**💡 TIP:** In plaats van handmatig, kun je ook de `DATABASE_URL` gebruiken:
- Ga naar je **Database service** → **Variables** tab
- Kopieer de `MYSQL_URL` of `DATABASE_URL` waarde
- Ga naar je **Web Service** → **Variables**
- Voeg toe: `DATABASE_URL` = (geplakte waarde)
- Het `railway/startup.php` script zal dit automatisch parsen!

### APP_KEY Genereren:

Je moet een APP_KEY genereren. Doe dit lokaal:

```bash
# In je project directory
php artisan key:generate --show
```

Kopieer de gegenereerde key en voeg toe als:

```
APP_KEY=base64:JOUW_GEGENEREERDE_KEY_HIER
```

**Of gebruik online tool:**
- Ga naar: https://coderstoolbox.online/toolbox/generate-symfony-secret
- Kopieer de gegenereerde key

### Mail Configuratie:

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

**⚠️ Voor Gmail:** Je moet een "App Password" gebruiken, niet je gewone wachtwoord:
- Google Account → Security → 2-Step Verification → App Passwords

### Overige Instellingen:

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

---

## Stap 6: Service Dependencies Koppelen

Dit zorgt ervoor dat de database beschikbaar is voor je web service:

1. In je **Web Service**, ga naar **"Settings"** (tandwiel icoon)
2. Scroll naar **"Service Dependencies"**
3. Klik op **"Add Dependency"**
4. Selecteer je **Database service**
5. Klik op **"Add"**

---

## Stap 7: Build & Deploy Settings

1. In je **Web Service**, ga naar **"Settings"**
2. Controleer de volgende settings:

### Build Command:
```
composer install --no-dev --optimize-autoloader
```

### Start Command:
```
php railway/startup.php && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php -S 0.0.0.0:$PORT -t public
```

**💡 TIP:** Railway detecteert automatisch Laravel en gebruikt Nixpacks. De bovenstaande commands zijn meestal al ingesteld.

---

## Stap 8: Custom Domain (Optioneel)

1. In je **Web Service**, ga naar **"Settings"**
2. Scroll naar **"Networking"**
3. Klik op **"Generate Domain"** voor een gratis Railway subdomain
   - Bijv: `jouw-app.up.railway.app`
4. Of voeg je eigen custom domain toe (bijv. `asset-management.jouwdomain.com`)

---

## Stap 9: Deploy!

1. Railway deployt automatisch bij elke push naar je main branch
2. Of klik handmatig op **"Deploy"** in je service
3. Wacht tot de deploy klaar is (meestal 3-5 minuten de eerste keer)
4. Je kunt de voortgang zien in het **"Deployments"** tabblad
5. Bekijk logs in het **"Logs"** tabblad voor eventuele fouten

---

## Stap 10: Eerste Setup

1. Ga naar je Railway URL (bijv. `jouw-app.up.railway.app`)
2. Je zou de Snipe-IT setup wizard moeten zien
3. Volg de installatie stappen:
   - Database connectie zou automatisch moeten werken
   - Maak je eerste admin account aan
   - Configureer basis instellingen

---

## Troubleshooting

### Database Connectie Fouten

**Probleem:** "SQLSTATE[HY000] [2002] Connection refused"

**Oplossing:**
1. Check of database service draait (groen bolletje)
2. Controleer DATABASE_URL of DB_* variables
3. Zorg dat service dependency is toegevoegd
4. Check logs voor meer details

### APP_KEY Fouten

**Probleem:** "No application encryption key has been specified"

**Oplossing:**
1. Genereer nieuwe key: `php artisan key:generate --show`
2. Update `APP_KEY` in Railway Variables
3. Redeploy service

### 500 Internal Server Error

**Oplossing:**
1. Check logs in Railway Dashboard → Logs tab
2. Controleer of alle environment variables zijn ingesteld
3. Check storage permissions (Railway draait als root, zou geen probleem moeten zijn)
4. Probeer cache te clearen via logs:
   - Klik op "Shell" in je service
   - Run: `php artisan config:clear && php artisan cache:clear`

### Migraties Draaien Niet

**Oplossing:**
1. Ga naar Railway Dashboard → Je Service → "Shell"
2. Run handmatig: `php artisan migrate --force`
3. Of check of start command correct is ingesteld

---

## Post-Deployment Checklist

- [ ] Database connectie werkt
- [ ] Migraties zijn gedraaid (check via Shell: `php artisan migrate:status`)
- [ ] Admin account aangemaakt
- [ ] Uploads kunnen worden geüpload (test met avatar upload)
- [ ] Email functionaliteit werkt (test met password reset)
- [ ] HTTPS werkt (Railway doet dit automatisch)
- [ ] Logs zijn zichtbaar en werken

---

## Kosten Overzicht

Railway geeft je **$5 gratis credits per maand**.

Typische maandelijkse kosten:
- Web Service (512MB RAM): ~$2-3
- MySQL Database (256MB): ~$1-2
- **Totaal: ~$3-5/maand**

De gratis credits dekken dit meestal! Check je usage in het Railway Dashboard.

---

## Handige Commands

### Via Railway Dashboard Shell:
```bash
# Migraties draaien
php artisan migrate --force

# Cache clearen
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Status checken
php artisan migrate:status
php artisan about

# Tinker (interactieve shell)
php artisan tinker
```

### Via Railway CLI (Optioneel):
```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Link project
railway link

# Run commands
railway run php artisan migrate
railway run php artisan tinker
```

---

## Volgende Stappen

Na succesvolle deployment:

1. **Backups instellen** - Railway heeft geen automatische backups in gratis tier
2. **Monitoring** - Check Railway Dashboard regelmatig voor resource usage
3. **Custom Domain** - Voeg je eigen domain toe (optioneel)
4. **Storage** - Overweeg S3-compatible storage voor persistente uploads

---

## Hulp Nodig?

- 📚 Railway Docs: https://docs.railway.app
- 💬 Railway Discord: https://discord.gg/railway
- 📖 Snipe-IT Docs: https://snipe-it.readme.io/docs
- 🐛 Dit project: Check `DEPLOY_RAILWAY.md` voor uitgebreide handleiding

**Veel succes! 🎉**
