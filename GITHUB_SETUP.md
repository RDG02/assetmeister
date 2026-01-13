# GitHub Repository Setup voor Railway

Volg deze stappen om je code naar GitHub te pushen:

## Stap 1: GitHub Repository Aanmaken

1. Ga naar [github.com](https://github.com) en log in
2. Klik op het **"+"** icoon rechtsboven → **"New repository"**
3. Vul de volgende informatie in:
   - **Repository name**: `snipe-it-asset-management` (of een andere naam)
   - **Description**: "Asset Management System met Railway deployment"
   - **Public** of **Private** (jouw keuze)
   - **⚠️ BELANGRIJK:** Laat **"Initialize this repository with a README"** UITGEVINKT
   - Laat ook de andere opties uitgevinkt (no .gitignore, no license)
4. Klik op **"Create repository"**

## Stap 2: Repository URL Kopiëren

Na het aanmaken zie je een pagina met instructies. Je hebt de **HTTPS URL** nodig, bijvoorbeeld:
```
https://github.com/JOUW-USERNAME/snipe-it-asset-management.git
```

**Kopieer deze URL!**

## Stap 3: Code Pushen naar GitHub

Open PowerShell in je project directory en run deze commands:

```powershell
# Controleer of je in de juiste directory bent
cd "C:\Users\Rick de Grood\Desktop\Asset management"

# Voeg GitHub remote toe (VERVANG met jouw URL!)
git remote add origin https://github.com/JOUW-USERNAME/JOUW-REPO-NAAM.git

# Verander branch naar 'main' (als je nog op 'master' zit)
git branch -M main

# Push naar GitHub
git push -u origin main
```

**Als je een foutmelding krijgt** over authenticatie, gebruik dan GitHub CLI of Personal Access Token:
- Zie hieronder voor GitHub CLI setup
- Of gebruik Personal Access Token: https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/creating-a-personal-access-token

## Alternatief: GitHub CLI

Als je GitHub CLI hebt geïnstalleerd:

```powershell
# Login
gh auth login

# Maak repository en push in één keer
gh repo create snipe-it-asset-management --public --source=. --remote=origin --push
```

---

**Na het pushen naar GitHub kun je doorgaan met Railway setup!** 🚀

Zie `RAILWAY_QUICK_START.md` voor de volgende stappen.
