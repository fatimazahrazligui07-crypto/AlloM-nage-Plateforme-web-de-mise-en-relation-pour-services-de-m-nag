<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Offre;

class OffreController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        
        // Récupérer l'ID du client
        $client = DB::table('clients')->where('user_id', $userId)->first();
        
        if (!$client) {
            return redirect()->route('login')->with('error', 'Client non trouvé');
        }

        // Récupérer les offres avec toutes les informations nécessaires
        $offres = DB::table('offres')
            ->join('demandes', 'offres.id_demande', '=', 'demandes.id')
            ->join('prestataires', 'offres.id_prestataire', '=', 'prestataires.id')
            ->join('utilisateurs', 'prestataires.user_id', '=', 'utilisateurs.id')
            ->where('demandes.id_client', $client->id)
            ->whereNull('offres.deleted_at')
            ->select(
                'offres.*',
                'demandes.ville',
                'demandes.quartier',
                'demandes.date',
                'demandes.statut as demande_statut',
                'utilisateurs.nom as prestataire_nom',
                'utilisateurs.prenom as prestataire_prenom',
                'prestataires.nom_Entreprise',
                'prestataires.is_verify'
            )
            ->orderBy('offres.created_at', 'desc')
            ->get();

        return Inertia::render('client/Offres', [
            'offres' => $offres
        ]);
    }

    public function annuler($id)
    {
        $offre = Offre::findOrFail($id);
        $offre->delete();
        return redirect()->back()->with('success', 'Offre annulée avec succès.');
    }

    public function accepter($id)
    {
        DB::beginTransaction();
        
        try {
            $offre = Offre::findOrFail($id);
            
            // Vérifier que l'offre appartient à une demande du client connecté
            $userId = Session::get('user_id');
            $client = DB::table('clients')->where('user_id', $userId)->first();
            
            $demande = DB::table('demandes')
                ->where('id', $offre->id_demande)
                ->where('id_client', $client->id)
                ->first();
                
            if (!$demande) {
                return redirect()->back()->with('error', 'Offre non trouvée ou non autorisée');
            }
            
            // Mettre à jour le statut de la demande
            DB::table('demandes')
                ->where('id', $offre->id_demande)
                ->update(['statut' => 'acceptee']);

            // Marquer l'offre comme acceptée
            $offre->update(['status' => 'acceptee']);

            // Refuser les autres offres pour cette demande
            DB::table('offres')
                ->where('id_demande', $offre->id_demande)
                ->where('id', '!=', $offre->id)
                ->update(['status' => 'refusee']);

            DB::commit();
            
            return redirect()->back()->with('success', 'Offre acceptée avec succès');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erreur lors de l\'acceptation de l\'offre');
        }
    }
}