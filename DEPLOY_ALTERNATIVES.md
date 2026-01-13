# Alternatieve Gratis Hosting Opties voor Snipe-IT

Naast Railway zijn er andere gratis hosting opties voor je Laravel Snipe-IT applicatie. Hieronder een overzicht:

## 1. Render (Aanbevolen Alternatief)

**Voordelen:**
- ✅ Gratis tier beschikbaar
- ✅ Automatische SSL/HTTPS
- ✅ PostgreSQL database gratis
- ✅ Goede Laravel ondersteuning

**Nadelen:**
- ⚠️ Service "slaapt" na 15 minuten inactiviteit (gratis tier)
- ⚠️ Eerste request na slaap kan traag zijn

**Setup:**
1. Account aanmaken op [render.com](https://render.com)
2. Nieuwe Web Service aanmaken
3. GitHub repository koppelen
4. Build Command: `composer install --no-dev --optimize-autoloader`
5. Start Command: `php artisan migrate --force && php artisan serve --host 0.0.0.0 --port $PORT`
6. PostgreSQL database toevoegen via Render dashboard

**Documentatie:** https://render.com/docs/deploy-laravel

---

## 2. Fly.io

**Voordelen:**
- ✅ Zeer goede Laravel ondersteuning
- ✅ Geen "sleep" mode
- ✅ Goede performance
- ✅ Wereldwijde deployment mogelijk

**Nadelen:**
- ⚠️ Gratis tier is beperkt (3 shared-cpu VMs)
- ⚠️ Vereist meer technische kennis

**Setup:**
```bash
# Install Fly.io CLI
curl -L https://fly.io/install.sh | sh

# Login
fly auth login

# Init Laravel project
fly launch

# Volg de wizard en configureer database
fly postgres create
fly secrets set DB_DATABASE=... DB_USERNAME=... etc.

# Deploy
fly deploy
```

**Documentatie:** https://fly.io/docs/laravel/

---

## 3. 000webhost / InfinityFree

**Voordelen:**
- ✅ Volledig gratis
- ✅ Geen credit card nodig
- ✅ cPanel interface

**Nadelen:**
- ⚠️ Beperkte resources
- ⚠️ Geen SSH toegang (meestal)
- ⚠️ Trager dan andere opties
- ⚠️ Beperkte database grootte
- ⚠️ Ads op je site (mogelijk)

**Setup:**
1. Account aanmaken op [000webhost.com](https://000webhost.com) of [infinityfree.net](https://infinityfree.net)
2. Database aanmaken via cPanel
3. Files uploaden via FTP of File Manager
4. `.env` configureren met database gegevens
5. Migraties draaien via artisan (als SSH beschikbaar is)

**Let op:** Deze optie is vooral geschikt voor development/testing, niet voor productie.

---

## 4. PlanetScale + Vercel (Serverless)

**Voordelen:**
- ✅ Serverless (geen server management)
- ✅ Zeer schaalbaar
- ✅ Gratis tiers voor beide

**Nadelen:**
- ⚠️ Complexe setup
- ⚠️ Laravel moet aangepast worden voor serverless
- ⚠️ Veel Laravel features werken niet goed serverless

**Documentatie:**
- PlanetScale: https://planetscale.com/docs
- Laravel op Vercel: https://vercel.com/guides/deploying-laravel-with-vercel

**Niet aanbevolen** voor Snipe-IT zonder aanpassingen.

---

## 5. Heroku (Niet meer gratis)

Heroku heeft in 2022 hun gratis tier gestopt. Er is nog wel een `app.json` bestand aanwezig in dit project voor Heroku, maar je hebt nu een betaald account nodig.

---

## Vergelijkingstabel

| Service | Gratis Tier | Database | Sleep Mode | Eenvoud | Best Voor |
|---------|-------------|----------|------------|---------|-----------|
| **Railway** | ✅ $5 credits | ✅ MySQL/PostgreSQL | ❌ Nee | ⭐⭐⭐⭐⭐ | **Aanbevolen** |
| **Render** | ✅ Beperkt | ✅ PostgreSQL | ⚠️ 15min | ⭐⭐⭐⭐ | Goede alternatief |
| **Fly.io** | ✅ Beperkt | ✅ PostgreSQL | ❌ Nee | ⭐⭐⭐ | Productie-ready |
| **000webhost** | ✅ Volledig | ⚠️ Beperkt | ❌ Nee | ⭐⭐ | Testing only |
| **Heroku** | ❌ Nee meer | ✅ Add-on | ❌ Nee | ⭐⭐⭐⭐ | Betaald |

---

## Onze Aanbeveling

Voor de beste balans tussen gemak en functionaliteit:

1. **Railway** - Beste keuze voor meeste gebruikers
2. **Render** - Goede tweede keuze als Railway niet beschikbaar is
3. **Fly.io** - Als je meer controle en performance nodig hebt

---

## Migratie tussen Platforms

Als je wilt migreren van Railway naar Render (of andersom):

1. **Database backup maken:**
   ```bash
   # Op huidige platform
   mysqldump -u username -p database_name > backup.sql
   ```

2. **Database import op nieuw platform:**
   ```bash
   # Op nieuw platform
   mysql -u username -p database_name < backup.sql
   ```

3. **Files/Uploads migreren:**
   - Download `storage/app` en `storage/public/uploads`
   - Upload naar nieuwe platform

4. **Environment variables kopiëren:**
   - Kopieer alle `.env` variabelen naar nieuwe platform

5. **Deploy en test:**
   - Deploy op nieuwe platform
   - Test alle functionaliteit
   - Update DNS als je custom domain gebruikt

---

## Hulp

Voor vragen over specifieke platforms:
- Railway: https://docs.railway.app/getting-started
- Render: https://render.com/docs
- Fly.io: https://community.fly.io
