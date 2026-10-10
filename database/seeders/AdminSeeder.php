<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créer un utilisateur admin
        $adminUser = Utilisateur::create([
            'nom' => 'zligui',
            'prenom' => 'fatima zahra',
            'email' => 'fzzligui07@gmail.com',
            'motdepasse' => Hash::make('fati2003'), // Utilise un mot de passe sécurisé
            'num_telephone' => '0677943822',
            'dateInscription' => now(),
            'role' => 'admin',  // Assure-toi que le rôle est bien 'admin'
        ]);

        // Créer un enregistrement admin
        Admin::create([
            'user_id' => $adminUser->id, // Référence à l'utilisateur créé
        ]);
    }
}
