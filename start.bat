@echo off
chcp 65001 >nul
title Snipe-IT Starter
color 0A

echo ========================================
echo    Snipe-IT Asset Management System
echo ========================================
echo.

REM Controleer of PHP geïnstalleerd is
where php >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo [FOUT] PHP is niet gevonden in het PATH!
    echo.
    echo Zorg ervoor dat PHP geïnstalleerd is en beschikbaar is in het systeempad.
    echo Download PHP van: https://windows.php.net/download/
    echo.
    pause
    exit /b 1
)

echo [OK] PHP gevonden
php -v
echo.

REM Controleer of we in de juiste directory zijn
if not exist "artisan" (
    echo [FOUT] artisan bestand niet gevonden!
    echo Zorg ervoor dat je start.bat in de hoofdmap van de applicatie uitvoert.
    echo.
    pause
    exit /b 1
)

echo [OK] Laravel applicatie gedetecteerd
echo.

REM Controleer of .env bestand bestaat
if not exist ".env" (
    echo [WAARSCHUWING] .env bestand niet gevonden!
    echo.
    if exist ".env.example" (
        echo Kopieer .env.example naar .env en configureer de instellingen.
        echo.
    )
)

REM Controleer of vendor directory bestaat (composer dependencies)
if not exist "vendor" (
    echo [WAARSCHUWING] Vendor directory niet gevonden!
    echo.
    echo Dependencies zijn mogelijk niet geïnstalleerd.
    echo Voer 'composer install' uit om dependencies te installeren.
    echo.
    set /p install="Wil je nu composer install uitvoeren? (J/N): "
    if /i "%install%"=="J" (
        echo.
        echo Composer dependencies installeren...
        composer install
        if %ERRORLEVEL% NEQ 0 (
            echo.
            echo [FOUT] Composer install is mislukt!
            pause
            exit /b 1
        )
        echo.
    ) else (
        echo.
        echo Je kunt de applicatie starten, maar sommige functies werken mogelijk niet.
        echo.
    )
)

echo.
echo ========================================
echo    Applicatie opstarten...
echo ========================================
echo.
echo De applicatie wordt gestart op: http://localhost:3000
echo.
echo Druk op Ctrl+C om de server te stoppen.
echo.

REM Start de Laravel development server op poort 3000
php artisan serve --port=3000

pause

