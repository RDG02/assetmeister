<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Admin Wachtwoord Bijwerken ===\n\n";

// Update gebruiker met ID 1 (de originele admin)
$user = User::find(1);

if ($user && $user->username === 'admin') {
    $user->password = Hash::make('admin123');
    $user->save();
    
    // Verifieer
    if (Hash::check('admin123', $user->password)) {
        echo "✓ Wachtwoord succesvol bijgewerkt!\n\n";
        echo "Inloggegevens:\n";
        echo "  Gebruikersnaam: {$user->username}\n";
        echo "  Wachtwoord: admin123\n";
        echo "  Email: {$user->email}\n";
        echo "  Geactiveerd: " . ($user->activated ? 'Ja' : 'Nee') . "\n";
    } else {
        echo "✗ Fout bij het bijwerken van het wachtwoord\n";
    }
} else {
    // Als ID 1 niet bestaat, update de eerste admin gebruiker
    $user = User::where('username', 'admin')->first();
    if ($user) {
        $user->password = Hash::make('admin123');
        $user->save();
        
        if (Hash::check('admin123', $user->password)) {
            echo "✓ Wachtwoord succesvol bijgewerkt!\n\n";
            echo "Inloggegevens:\n";
            echo "  Gebruikersnaam: {$user->username}\n";
            echo "  Wachtwoord: admin123\n";
            echo "  Email: {$user->email}\n";
            echo "  ID: {$user->id}\n";
        } else {
            echo "✗ Fout bij het bijwerken van het wachtwoord\n";
        }
    } else {
        echo "✗ Geen admin gebruiker gevonden\n";
    }
}

