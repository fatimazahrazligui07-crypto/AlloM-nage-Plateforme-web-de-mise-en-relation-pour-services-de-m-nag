<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Offre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaiementController extends Controller
{
    public function payer(Request $request)
    {
        $request->validate([
            'offre_id' => 'required|exists:offres,id',
            'montant' => 'required|numeric|min:0',
        ]);

        $offre = Offre::findOrFail($request->offre_id);

        // Vérifier que l'offre appartient bien à une demande du client connecté
        $userId = Session::get('user_id');
        $client = DB::table('clients')->where('user_id', $userId)->first();
        if (!$client || $offre->demande->id_client != $client->id) {
            return back()->with('error', 'Non autorisé');
        }

        // Créer le paiement
        $paiement = Paiement::create([
            'montant' => $request->montant,
            'datepaiement' => now(),
            'etat' => 'payé',
            'id_offre' => $offre->id,
        ]);

        // Ici tu peux aussi créer la prestation si besoin

        // Mettre à jour le statut de l'offre et de la demande
        $offre->update(['status' => 'acceptee']);
        $offre->demande->update(['statut' => 'acceptee']);

        return redirect()->route('client.offres')->with('success', 'Paiement effectué avec succès !');
    }
}