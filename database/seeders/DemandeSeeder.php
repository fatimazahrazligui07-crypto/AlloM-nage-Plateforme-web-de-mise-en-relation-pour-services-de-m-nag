<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DemandeSeeder extends Seeder
{
    public function run()
    {
        // Inserting sample data for 'demande'
        DB::table('demandes')->insert([
            [
                'nbr_perstataires' => 2,
                'sexe' => 'Homme',
                'age' => 25,
                'ville' => 'Rabat',
                'quartier' => 'Souissi',
                'produit' => false,
                'duree' => 6,
                'date' => now(),
                'statut' => 'En attente',
                'change_deco' => false,
                'id_client' => 3, // Replace with an existing client ID if available
                'id_service' => 3, // Replace with an existing service ID if available
            ],
            // Add more sample data as needed
        ]);
    }
}
