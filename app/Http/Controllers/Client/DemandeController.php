<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class DemandeController extends Controller

{
     public function creerDemande(Request $request)
    {
        $request->validate([
            'nbr_perstataires' => 'required|integer|min:1',
            'sexe' => 'required|string',
            'age' => 'nullable|integer|min:0',
            'ville_id' => 'required|exists:villes,id',
            'quartier_id' => 'required|exists:quartiers,id',
            'produit' => 'boolean',
            'duree' => 'required|integer|min:1',
            'date' => 'required|date|after:today',
            'change_deco' => 'boolean',
            'id_service' => 'required|exists:services,id',
        ]);

        $userId = Session::get('user_id');
        $client = DB::table('clients')->where('user_id', $userId)->first();

        // Récupérer le nom de la ville et du quartier à partir de leur ID
        $ville = DB::table('villes')->where('id', $request->ville_id)->value('nom_ville');
        $quartier = DB::table('quartiers')->where('id', $request->quartier_id)->value('nom_quartier');

        DB::table('demandes')->insert([
            'nbr_perstataires' => $request->nbr_perstataires,
            'sexe' => $request->sexe,
            'age' => $request->age,
            'ville' => $ville,
            'quartier' => $quartier,
            'produit' => $request->produit ? 1 : 0,
            'duree' => $request->duree,
            'date' => $request->date,
            'statut' => 'en_attente',
            'change_deco' => $request->change_deco ? 1 : 0,
            'id_client' => $client->id,
            'id_service' => $request->id_service,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Demande créée avec succès');
    }
    public function listDemandes()
    {
        $userId = Session::get('user_id');

        $client = DB::table('clients')->where('user_id', $userId)->first();

        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        // Récupérer les demandes avec les informations du service
        $demandes = DB::table('demandes')
            ->join('services', 'demandes.id_service', '=', 'services.id')
            ->select(
                'demandes.*',
                'services.title as service_nom' // CORRECTION: 'services.nom' remplacé par 'services.nom_service'
            )
            ->where('demandes.id_client', $client->id)
            ->orderBy('demandes.created_at', 'desc')
            ->get()
            ->map(function ($demande) {
                return [
                    'id' => $demande->id,
                    'service' => [
                        'nom' => $demande->service_nom
                    ],
                    'ville' => $demande->ville,
                    'date' => $demande->date,
                    'statut' => $demande->statut ?? 'en attente',
                    'created_at' => $demande->created_at
                ];
            });

        return Inertia::render('client/Demandes', [
            'demandes' => $demandes
        ]);
    }
}