<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Utilisateur;
use App\Models\Prestataire;
use Faker\Factory as Faker;

class UtilisateurPrestataireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Créer un utilisateur de type prestataire
        $user = Utilisateur::create([
            'nom' => 'faima',
            'prenom' => 'zahra',
            'email' => 'fatimazahra@gmail.com',
            'motdepasse' => bcrypt('mon1234'), // Assure-toi de hasher le mot de passe
            'num_telephone' => '0612235678',
            'dateInscription' => now(),
            'role' => 'prestataire',
            'status' => true,
        ]);

        // Créer le prestataire correspondant
        Prestataire::create([
            'user_id' => $user->id,  // Lier le prestataire à l'utilisateur créé
            'quartier_id' => 3,  // Exemple d'ID pour quartier (ajuste selon tes données)
            'admin_id' => 1,  // Exemple d'ID pour admin (ajuste selon tes données)
            'nom_Entreprise' => 'Entreprise fatima',
            'Bank' => 'Banque Populaire',
            'ICE' => '123456123',
            'RIB' => 'MA3512345678254234567890123456789',
            'ContratDeBank' => 'Contrat1343.pdf',
            'logo' => 'monlogo.jpg',
            
            'is_verify' => true,
        ]);

    
        }
    }
