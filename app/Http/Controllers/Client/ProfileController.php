<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show()
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Non connecté');
        }

        $client = DB::table('clients')
            ->join('utilisateurs', 'clients.user_id', '=', 'utilisateurs.id')
            ->where('clients.user_id', $userId)
            ->select(
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.email',
                'utilisateurs.num_telephone'
                // Supprimé : 'clients.adresse', 'clients.ville', etc.
            )
            ->first();

        if (!$client) {
            return abort(404, 'Client introuvable.');
        }

        return Inertia::render('client/ClientProfile', [
            'client' => $client
        ]);
    }
}

