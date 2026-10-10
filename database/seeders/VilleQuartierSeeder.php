<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ville;
use App\Models\Quartier;

class VilleQuartierSeeder extends Seeder
{
    public function run()
    {
        // Casablanca
        $casablanca = Ville::create(['nom_ville' => 'Casablanca']);
        Quartier::create(['nom_quartier' => 'Maarif', 'ville_id' => $casablanca->id]);
        Quartier::create(['nom_quartier' => 'Ain Diab', 'ville_id' => $casablanca->id]);
        Quartier::create(['nom_quartier' => 'Bourgogne', 'ville_id' => $casablanca->id]);
        Quartier::create(['nom_quartier' => 'Hay Hassani', 'ville_id' => $casablanca->id]);

        // Rabat
        $rabat = Ville::create(['nom_ville' => 'Rabat']);
        Quartier::create(['nom_quartier' => 'Agdal', 'ville_id' => $rabat->id]);
        Quartier::create(['nom_quartier' => 'Hassan', 'ville_id' => $rabat->id]);
        Quartier::create(['nom_quartier' => 'Souissi', 'ville_id' => $rabat->id]);

        // Marrakech
        $marrakech = Ville::create(['nom_ville' => 'Marrakech']);
        Quartier::create(['nom_quartier' => 'Gueliz', 'ville_id' => $marrakech->id]);
        Quartier::create(['nom_quartier' => 'Hivernage', 'ville_id' => $marrakech->id]);
        Quartier::create(['nom_quartier' => 'Medina', 'ville_id' => $marrakech->id]);
    }
}