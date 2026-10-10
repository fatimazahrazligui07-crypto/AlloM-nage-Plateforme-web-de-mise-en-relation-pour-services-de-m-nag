<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeServiceSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'id' => 1,
                'nom_type' => 'particuliers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nom_type' => 'professionnels',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('types_services')->insert($types);
    }
}