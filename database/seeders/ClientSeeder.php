<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Utilisateur;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;  // Ajoute cette ligne

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créer un utilisateur client
        $clientUser = Utilisateur::create([
            'nom' => 'zligui',
            'prenom' => 'mouad',
            'email' => 'mouad2006@gmail.com',
            'motdepasse' => Hash::make('mouad2006'), // Utilise un mot de passe sécurisé
            'num_telephone' => '0687654321',
            'dateInscription' => now(),
            'role' => 'client',  // Assure-toi que le rôle est bien 'client'
        ]);

        // Trouver un admin existant
        $admin = Admin::first(); // Si tu as déjà un admin dans la base, tu peux récupérer le premier admin

        // Créer un client
        Client::create([
            'user_id' => $clientUser->id,
            'quartier_id' => 1,  // Assure-toi qu'un quartier avec l'ID 1 existe dans la table 'quartiers'
            'admin_id' => $admin->id,  // Référence à l'admin existant
        ]);
    }
}
