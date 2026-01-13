# Railway Deployment Script voor Snipe-IT
# Dit script helpt je met het deployen naar Railway

Write-Host "🚀 Railway Deployment Script voor Snipe-IT" -ForegroundColor Cyan
Write-Host ""

# Check of git repository bestaat
if (-not (Test-Path .git)) {
    Write-Host "❌ Geen git repository gevonden. Run eerst: git init" -ForegroundColor Red
    exit 1
}

# Check of Railway CLI geïnstalleerd is
$railwayCliInstalled = Get-Command railway -ErrorAction SilentlyContinue

if (-not $railwayCliInstalled) {
    Write-Host "⚠️  Railway CLI niet gevonden." -ForegroundColor Yellow
    Write-Host "   Installeren met: npm i -g @railway/cli" -ForegroundColor Yellow
    Write-Host ""
    
    $install = Read-Host "Wil je Railway CLI nu installeren? (j/n)"
    if ($install -eq "j" -or $install -eq "J") {
        Write-Host "📦 Railway CLI installeren..." -ForegroundColor Cyan
        npm i -g @railway/cli
        if ($LASTEXITCODE -ne 0) {
            Write-Host "❌ Installatie mislukt. Installeer handmatig: npm i -g @railway/cli" -ForegroundColor Red
            exit 1
        }
        Write-Host "✅ Railway CLI geïnstalleerd!" -ForegroundColor Green
    }
}

# Check GitHub remote
$gitRemote = git remote get-url origin 2>$null
if (-not $gitRemote) {
    Write-Host "⚠️  Geen GitHub remote gevonden." -ForegroundColor Yellow
    Write-Host ""
    Write-Host "Je moet eerst:" -ForegroundColor Yellow
    Write-Host "1. Een GitHub repository aanmaken op https://github.com/new" -ForegroundColor Yellow
    Write-Host "2. De repository URL kopiëren" -ForegroundColor Yellow
    Write-Host ""
    
    $repoUrl = Read-Host "Voer je GitHub repository URL in (bijv. https://github.com/username/repo.git)"
    if ($repoUrl) {
        Write-Host "📝 GitHub remote toevoegen..." -ForegroundColor Cyan
        git remote add origin $repoUrl
        git branch -M main
        
        Write-Host "📤 Code naar GitHub pushen..." -ForegroundColor Cyan
        git push -u origin main
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ Code succesvol naar GitHub gepusht!" -ForegroundColor Green
        } else {
            Write-Host "❌ Push mislukt. Controleer je GitHub credentials." -ForegroundColor Red
            exit 1
        }
    } else {
        Write-Host "❌ Geen URL ingevoerd. Exiting." -ForegroundColor Red
        exit 1
    }
} else {
    Write-Host "✅ GitHub remote gevonden: $gitRemote" -ForegroundColor Green
    
    # Check of er uncommitted changes zijn
    $status = git status --porcelain
    if ($status) {
        Write-Host "⚠️  Er zijn uncommitted changes. Committen en pushen..." -ForegroundColor Yellow
        git add .
        git commit -m "Update voor Railway deployment"
        git push
    }
}

Write-Host ""
Write-Host "=" * 60 -ForegroundColor Cyan
Write-Host "VOLGENDE STAPPEN VOOR RAILWAY:" -ForegroundColor Cyan
Write-Host "=" * 60 -ForegroundColor Cyan
Write-Host ""
Write-Host "1. Ga naar https://railway.app en log in met GitHub" -ForegroundColor Yellow
Write-Host "2. Klik op 'New Project' → 'Deploy from GitHub repo'" -ForegroundColor Yellow
Write-Host "3. Selecteer je repository: $(Split-Path -Leaf (git remote get-url origin | ForEach-Object { $_ -replace '.*[:/]([^/]+/[^/]+)(?:\.git)?$', '$1' }))" -ForegroundColor Yellow
Write-Host "4. Voeg een MySQL database toe via '+ New' → 'Database' → 'MySQL'" -ForegroundColor Yellow
Write-Host "5. Ga naar je web service → 'Variables' en voeg environment variables toe" -ForegroundColor Yellow
Write-Host ""
Write-Host "📖 Zie RAILWAY_QUICK_START.md voor gedetailleerde instructies" -ForegroundColor Cyan
Write-Host ""

# Als Railway CLI beschikbaar is, bied optie aan om te linken
if (Get-Command railway -ErrorAction SilentlyContinue) {
    Write-Host "💡 Railway CLI is beschikbaar!" -ForegroundColor Green
    $link = Read-Host "Wil je het project nu linken aan Railway? (j/n)"
    if ($link -eq "j" -or $link -eq "J") {
        Write-Host "🔗 Project linken aan Railway..." -ForegroundColor Cyan
        railway login
        railway link
        
        Write-Host ""
        Write-Host "✅ Project gelinkt! Je kunt nu:" -ForegroundColor Green
        Write-Host "   - railway up          (deploy)" -ForegroundColor Yellow
        Write-Host "   - railway run php artisan migrate  (migraties draaien)" -ForegroundColor Yellow
        Write-Host "   - railway logs       (logs bekijken)" -ForegroundColor Yellow
    }
}

Write-Host ""
Write-Host "✨ Klaar! Volg de stappen hierboven om je app live te zetten." -ForegroundColor Green
