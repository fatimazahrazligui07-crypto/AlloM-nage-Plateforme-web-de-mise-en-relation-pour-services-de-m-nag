<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ville;
use App\Models\Quartier;

class LocationSeeder extends Seeder
{
    public function run()
    {
        // Créer les villes
        $casablanca = Ville::create([
            'nom_ville' => 'Casablanca'
        ]);

        $rabat = Ville::create([
            'nom_ville' => 'Rabat'
        ]);

        $marrakech = Ville::create([
            'nom_ville' => 'Marrakech'
        ]);

        // Quartiers de Casablanca
        $casablancaQuarters = [
            'Ain Diab', 'Anfa', 'Belvédère', 'Bourgogne', 'California',
            'Centre-ville', 'Gauthier', 'Hay Hassani', 'Hay Mohammadi',
            'Maarif', 'Palmier', 'Racine', 'Sidi Belyout', 'Sidi Maarouf'
        ];

        foreach ($casablancaQuarters as $quarter) {
            Quartier::create([
                'nom_quartier' => $quarter,
                'ville_id' => $casablanca->id
            ]);
        }

        // Quartiers de Rabat
        $rabatQuarters = [
            'Agdal', 'Hassan', 'Hay Riad', 'Hay Ryad', 'Kamra',
            'Les Orangers', 'Madinat Al Irfane', 'Medina', 'Souissi',
            'Takaddoum', 'Temara', 'Touarga', 'Villa Mandarine', 'Yacoub Al Mansour'
        ];

        foreach ($rabatQuarters as $quarter) {
            Quartier::create([
                'nom_quartier' => $quarter,
                'ville_id' => $rabat->id
            ]);
        }

        // Quartiers de Marrakech
        $marrakechQuarters = [
            'Gueliz', 'Hivernage', 'Majorelle', 'Medina', 'Palmeraie',
            'Semlalia', 'Targa', 'Daoudiate', 'Hay Essalam', 'Massira',
            'Menara', 'Sidi Ghanem', 'Sidi Youssef Ben Ali', 'Victor Hugo'
        ];

        foreach ($marrakechQuarters as $quarter) {
            Quartier::create([
                'nom_quartier' => $quarter,
                'ville_id' => $marrakech->id
            ]);
        }
    }
}
