<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $allServices = [
            [
                'id' => 1,
                'type_id' => 1,
                'title' => 'Ménage résidentiel',
                'description' => 'Entretien régulier ou ponctuel de votre domicile pour un cadre de vie propre et agréable.',
                'logo' => '/service1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'type_id' => 2,
                'title' => 'Ménage des bureaux',
                'description' => 'Un nettoyage régulier pour maintenir un environnement de travail propre et agréable, incluant les bureaux, les salles de réunion et les espaces communs.',
                'logo' => '/service11.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'type_id' => 1,
                'title' => 'Nettoyage après travaux',
                'description' => 'Nettoyage complet après des travaux de rénovation ou de construction pour un intérieur impeccable.',
                'logo' => '/service5.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'type_id' => 1,
                'title' => 'Nettoyage après fête',
                'description' => 'Remise en ordre rapide et efficace après un événement privé, en éliminant déchets et taches.',
                'logo' => '/service2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'type_id' => 1,
                'title' => 'Nettoyage de tapis/moquette/canapé',
                'description' => 'Service de nettoyage en profondeur pour vos tissus d\'ameublement, éliminant taches et allergènes.',
                'logo' => '/service6.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'type_id' => 1,
                'title' => 'Entretien des extérieurs',
                'description' => 'Nettoyage des jardins, terrasses et allées pour un extérieur soigné et agréable.',
                'logo' => '/service7.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'type_id' => 2,
                'title' => 'Ménage industriel',
                'description' => 'Nettoyage spécialisé pour les environnements industriels, respectant les normes de sécurité et d\'hygiène.',
                'logo' => '/service4.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'type_id' => 2,
                'title' => 'Ménage en milieu scolaire',
                'description' => 'Nettoyage régulier des écoles pour un environnement sain et sécurisé pour les élèves et le personnel.',
                'logo' => '/service8.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'type_id' => 2,
                'title' => 'Ménage hôtelier',
                'description' => 'Entretien des chambres et espaces communs pour offrir une expérience agréable à vos clients.',
                'logo' => '/service9.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'type_id' => 2,
                'title' => 'Ménage médico-social / hospitalier (cliniques...)',
                'description' => 'Nettoyage conforme aux normes strictes de sécurité et d\'hygiène pour les établissements de santé.',
                'logo' => '/service10.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('services')->insert($allServices);
    }
}