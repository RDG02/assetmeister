# Snipe-IT Deployen op Railway (Gratis)

Railway is een moderne platform-as-a-service (PaaS) met een gratis tier die perfect is voor Laravel applicaties. Deze handleiding helpt je om Snipe-IT live te zetten op Railway.

## Voordelen van Railway

- ✅ **Gratis tier** - $5 gratis credits per maand (meestal genoeg voor een kleine app)
- ✅ **Automatische deployments** - direct van GitHub
- ✅ **Database hosting** - MySQL of PostgreSQL
- ✅ **HTTPS/SSL** - automatisch geconfigureerd
- ✅ **Eenvoudige setup** - geen complexe configuratie nodig

## Vereisten

1. Een GitHub account
2. Een Railway account (gratis aan te maken op [railway.app](https://railway.app))
3. Deze repository op GitHub (push naar je eigen repo of fork)

## Stap-voor-stap Handleiding

### Stap 1: Repository voorbereiden

Zorg ervoor dat je code op GitHub staat:

```bash
# Als je nog geen git repository hebt:
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/JOUW-USERNAME/JOUW-REPO.git
git push -u origin main
```

### Stap 2: Railway Project aanmaken

1. Ga naar [railway.app](https://railway.app) en log in met GitHub
2. Klik op **"New Project"**
3. Selecteer **"Deploy from GitHub repo"**
4. Kies je Snipe-IT repository

### Stap 3: Database toevoegen

1. In je Railway project, klik op **"+ New"**
2. Selecteer **"Database"**
3. Kies **"MySQL"** (of PostgreSQL als je dat prefereert)
4. Railway maakt automatisch een database aan

### Stap 4: Environment Variables instellen

Ga naar je service (web app) en klik op **"Variables"**. Voeg de volgende variabelen toe:

#### Verplichte variabelen:

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:JOUW_GEGENEREERDE_KEY_HIER
APP_TIMEZONE=Europe/Amsterdam
APP_LOCALE=nl

# Database (Railway vult deze automatisch in via DATABASE_URL)
# Als je ze handmatig wilt instellen:
DB_CONNECTION=mysql
DB_HOST=JOUW_DB_HOST
DB_PORT=3306
DB_DATABASE=JOUW_DATABASE
DB_USERNAME=JOUW_DB_USER
DB_PASSWORD=JOUW_DB_PASSWORD

# Mail configuratie (vervang met jouw SMTP gegevens)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=jouw@email.com
MAIL_PASSWORD=jouw_wachtwoord
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDR=no-reply@jouwdomain.com
MAIL_FROM_NAME="Snipe-IT"

# Session configuratie
SESSION_LIFETIME=12000
EXPIRE_ON_CLOSE=false
SECURE_COOKIES=true

# Logging
LOG_CHANNEL=errorlog

# Filesystem
FILESYSTEM_DISK=local
PUBLIC_FILESYSTEM_DISK=local_public

# Image library
IMAGE_LIB=gd

# Queue
QUEUE_CONNECTION=sync
```

#### APP_KEY genereren:

Run lokaal:
```bash
php artisan key:generate --show
```

Of gebruik een online tool zoals: https://coderstoolbox.online/toolbox/generate-symfony-secret

### Stap 5: Database URL koppelen

1. Ga naar je **Database** service in Railway
2. Klik op **"Variables"**
3. Kopieer de `DATABASE_URL` waarde
4. Ga terug naar je **Web Service**
5. Voeg toe: `DATABASE_URL` = (geplakte waarde)

**OF** voeg de database als service dependency toe:
- In je web service, ga naar **"Settings"**
- Scroll naar **"Service Dependencies"**
- Voeg je database service toe

### Stap 6: Build en Deploy Configuratie

Railway detecteert automatisch dat dit een PHP/Laravel project is. Zorg dat de volgende bestanden aanwezig zijn:

- ✅ `composer.json` (al aanwezig)
- ✅ `railway.json` (toegevoegd)
- ✅ `railway/startup.php` (toegevoegd)

Railway zal automatisch:
- Composer dependencies installeren
- PHP extensies installeren (via Nixpacks)
- De applicatie builden

### Stap 7: Deploy Settings

In je web service, ga naar **"Settings"** en controleer:

1. **Root Directory**: Laat leeg (of `/` als dat vereist is)
2. **Build Command**: Railway doet dit automatisch, maar je kunt overschrijven met:
   ```
   composer install --no-dev --optimize-autoloader
   ```
3. **Start Command**: 
   ```
   php railway/startup.php && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php -S 0.0.0.0:$PORT -t public
   ```

### Stap 8: Domain instellen

1. In je web service, klik op **"Settings"**
2. Scroll naar **"Networking"**
3. Klik op **"Generate Domain"** voor een gratis Railway subdomain
4. Of voeg je eigen custom domain toe (gratis)

### Stap 9: Deploy!

1. Railway deployt automatisch bij elke push naar je main branch
2. Of klik handmatig op **"Deploy"**
3. Wacht tot de deploy klaar is (meestal 3-5 minuten)
4. Ga naar je gegenereerde URL
5. Je zou de Snipe-IT setup pagina moeten zien!

### Stap 10: Eerste Setup

1. Ga naar je Railway URL (bijv. `jouw-app.up.railway.app`)
2. Volg de Snipe-IT setup wizard
3. Maak je eerste admin account aan

## Database Migraties

Railway voert automatisch migraties uit via het start command. Als je later handmatig migraties wilt draaien:

1. Ga naar Railway Dashboard
2. Klik op je service
3. Klik op **"Deployments"** → **"Latest"** → **"View Logs"**
4. Of gebruik de Railway CLI:
   ```bash
   railway run php artisan migrate
   ```

## Storage Persistente

Railway's gratis tier heeft **ephemeral storage** - dit betekent dat uploads verloren kunnen gaan bij redeployments. Voor productie gebruik overweeg:

1. **Railway Volumes** (betaald) voor persistente storage
2. **S3-compatible storage** (bijv. DigitalOcean Spaces, AWS S3) - gratis tiers beschikbaar
3. Voor development/testing is ephemeral storage meestal prima

Voor S3 setup, voeg toe aan je `.env`:
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=...
AWS_SECRET_ACCESS_KEY=...
AWS_DEFAULT_REGION=...
AWS_BUCKET=...
AWS_ENDPOINT=... (voor S3-compatible services)
```

## Monitoring en Logs

- **Logs**: Bekijk real-time logs in Railway Dashboard → Service → Logs
- **Metrics**: Railway toont CPU, Memory en Network gebruik
- **Alerts**: Stel alerts in voor crashes of hoge resource usage

## Kosten

Railway geeft je **$5 gratis credits per maand**. Voor een kleine Snipe-IT installatie is dit meestal genoeg, maar controleer je usage in het Dashboard.

Typische kosten:
- Web Service (512MB RAM): ~$2-3/maand
- MySQL Database (256MB): ~$1-2/maand
- **Totaal: ~$3-5/maand** (gratis credits dekken dit!)

## Troubleshooting

### Database connectie fouten
- Controleer of `DATABASE_URL` correct is ingesteld
- Zorg dat de database service draait
- Check of de database dependency is toegevoegd

### APP_KEY fouten
- Genereer een nieuwe key: `php artisan key:generate --show`
- Update de `APP_KEY` environment variable

### Permission fouten
- Railway draait als root, dit zou geen probleem moeten zijn
- Als storage fouten, check of `storage/` en `bootstrap/cache/` schrijfbaar zijn

### 500 errors
- Check de logs in Railway Dashboard
- Zorg dat alle environment variables zijn ingesteld
- Run `php artisan config:clear` via Railway CLI

## Railway CLI (Optioneel)

Voor geavanceerde deployment controle:

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

## Alternatieven (Ook Gratis)

Als Railway niet werkt, hier zijn andere gratis opties:

1. **Render** - Vergelijkbaar met Railway, ook gratis tier
2. **Fly.io** - Goede Laravel ondersteuning, gratis tier
3. **000webhost/InfinityFree** - Gratis PHP hosting (beperkingen)
4. **PlanetScale + Vercel** - Serverless setup (complexer)

Zie `DEPLOY_ALTERNATIVES.md` voor meer details.

## Hulp Nodig?

- Railway Docs: https://docs.railway.app
- Railway Discord: https://discord.gg/railway
- Snipe-IT Docs: https://snipe-it.readme.io/docs

---

**Veel succes met je deployment! 🚀**
