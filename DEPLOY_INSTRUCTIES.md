# 🚀 Snelle Deployment Instructies

## Optie 1: Automatisch Script (Aanbevolen)

Run het PowerShell script:

```powershell
.\deploy-to-railway.ps1
```

Dit script helpt je met:
- ✅ GitHub remote setup
- ✅ Code naar GitHub pushen
- ✅ Railway CLI installatie (optioneel)
- ✅ Stapsgewijze instructies

## Optie 2: Handmatig - Stap voor Stap

### Stap 1: GitHub Repository Aanmaken

1. Ga naar https://github.com/new
2. Repository naam: `snipe-it-asset-management`
3. **NIET** "Initialize with README" aanvinken
4. Klik "Create repository"
5. Kopieer de HTTPS URL (bijv. `https://github.com/jouw-username/snipe-it-asset-management.git`)

### Stap 2: Code naar GitHub Pushen

```powershell
# Voeg GitHub remote toe (VERVANG met jouw URL!)
git remote add origin https://github.com/JOUW-USERNAME/JOUW-REPO.git

# Push naar GitHub
git branch -M main
git push -u origin main
```

### Stap 3: Railway Account & Project

1. **Account aanmaken:**
   - Ga naar https://railway.app
   - Klik "Start a New Project"
   - Login met GitHub

2. **Project aanmaken:**
   - Klik "New Project"
   - Selecteer "Deploy from GitHub repo"
   - Kies je repository

3. **Database toevoegen:**
   - Klik "+ New" in je project
   - Selecteer "Database"
   - Kies "MySQL"
   - Railway maakt automatisch een database aan

### Stap 4: Environment Variables

Ga naar je **Web Service** → **Variables** tab en voeg toe:

#### Verplicht:
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENEREER_VIA_php_artisan_key_generate
APP_TIMEZONE=Europe/Amsterdam
APP_LOCALE=nl
```

#### Database (automatisch via DATABASE_URL):
- Ga naar je **Database service** → **Variables**
- Kopieer `MYSQL_URL` of `DATABASE_URL`
- Ga terug naar **Web Service** → **Variables**
- Voeg toe: `DATABASE_URL` = (geplakte waarde)

**OF** voeg handmatig toe:
```
DB_CONNECTION=mysql
DB_HOST=JOUW_DB_HOST
DB_PORT=3306
DB_DATABASE=JOUW_DATABASE
DB_USERNAME=JOUW_USERNAME
DB_PASSWORD=JOUW_PASSWORD
```

#### Mail (vervang met jouw gegevens):
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

#### Overige:
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

### Stap 5: APP_KEY Genereren

Run lokaal:
```powershell
php artisan key:generate --show
```

Kopieer de output en voeg toe als `APP_KEY` in Railway Variables.

### Stap 6: Service Dependencies

1. Ga naar je **Web Service** → **Settings**
2. Scroll naar **"Service Dependencies"**
3. Klik **"Add Dependency"**
4. Selecteer je **Database service**

### Stap 7: Domain & Deploy

1. **Domain:**
   - Ga naar **Web Service** → **Settings** → **Networking**
   - Klik **"Generate Domain"** voor gratis subdomain

2. **Deploy:**
   - Railway deployt automatisch bij push naar main
   - Of klik handmatig op **"Deploy"**

3. **Wachten:**
   - Eerste deploy duurt 3-5 minuten
   - Bekijk voortgang in **Deployments** tab

### Stap 8: Eerste Setup

1. Ga naar je Railway URL (bijv. `jouw-app.up.railway.app`)
2. Volg de Snipe-IT setup wizard
3. Maak je eerste admin account aan

## ✅ Checklist

- [ ] Code op GitHub
- [ ] Railway account aangemaakt
- [ ] Project aangemaakt en repository gekoppeld
- [ ] MySQL database toegevoegd
- [ ] Environment variables ingesteld
- [ ] APP_KEY gegenereerd en toegevoegd
- [ ] Service dependency toegevoegd
- [ ] Domain gegenereerd
- [ ] Deploy succesvol
- [ ] Snipe-IT setup wizard voltooid

## 🆘 Problemen?

- **Database connectie fout?** → Check DATABASE_URL en service dependency
- **APP_KEY fout?** → Genereer nieuwe key en update variable
- **500 error?** → Check logs in Railway Dashboard → Logs tab
- **Deploy faalt?** → Check build logs voor foutmeldingen

Zie `DEPLOY_RAILWAY.md` voor uitgebreide troubleshooting.

## 📚 Meer Hulp

- Railway Docs: https://docs.railway.app
- Railway Discord: https://discord.gg/railway
- Snipe-IT Docs: https://snipe-it.readme.io/docs
