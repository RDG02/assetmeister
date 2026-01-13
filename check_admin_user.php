<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Admin Gebruikers Controleren ===\n\n";

// Zoek alle gebruikers met admin rechten
$adminUsers = User::where(function($query) {
    $query->where('permissions', 'like', '%"admin":1%')
          ->orWhere('permissions', 'like', '%"superuser":1%');
})->get();

if ($adminUsers->count() > 0) {
    echo "Gevonden admin gebruikers:\n";
    echo str_repeat("-", 60) . "\n";
    foreach ($adminUsers as $user) {
        echo "ID: {$user->id}\n";
        echo "Gebruikersnaam: {$user->username}\n";
        echo "Email: {$user->email}\n";
        echo "Voornaam: {$user->first_name}\n";
        echo "Achternaam: {$user->last_name}\n";
        echo "Geactiveerd: " . ($user->activated ? 'Ja' : 'Nee') . "\n";
        echo "Permissions: {$user->permissions}\n";
        echo "Wachtwoord hash: " . substr($user->password, 0, 20) . "...\n";
        
        // Test het wachtwoord
        if (Hash::check('admin123', $user->password)) {
            echo "✓ Wachtwoord 'admin123' is CORRECT voor deze gebruiker\n";
        } else {
            echo "✗ Wachtwoord 'admin123' is NIET correct voor deze gebruiker\n";
        }
        echo str_repeat("-", 60) . "\n\n";
    }
} else {
    echo "Geen admin gebruikers gevonden!\n\n";
}

// Zoek specifiek naar gebruiker met username 'admin'
$adminUser = User::where('username', 'admin')->first();
if ($adminUser) {
    echo "=== Specifieke 'admin' gebruiker ===\n";
    echo "ID: {$adminUser->id}\n";
    echo "Username: {$adminUser->username}\n";
    echo "Email: {$adminUser->email}\n";
    echo "Activated: " . ($adminUser->activated ? 'Ja' : 'Nee') . "\n";
    echo "Password check 'admin123': " . (Hash::check('admin123', $adminUser->password) ? 'CORRECT' : 'FOUT') . "\n";
    echo "Password check 'password': " . (Hash::check('password', $adminUser->password) ? 'CORRECT' : 'FOUT') . "\n";
    echo "\n";
}

// Toon alle gebruikers (voor debugging)
echo "=== Alle gebruikers ===\n";
$allUsers = User::take(10)->get(['id', 'username', 'email', 'activated']);
foreach ($allUsers as $user) {
    echo "ID: {$user->id} | Username: {$user->username} | Email: {$user->email} | Activated: " . ($user->activated ? 'Ja' : 'Nee') . "\n";
}

