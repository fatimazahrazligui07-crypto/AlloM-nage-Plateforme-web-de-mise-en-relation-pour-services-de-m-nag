<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        
        // Récupérer les informations du client
        $client = DB::table('clients')
            ->join('utilisateurs', 'clients.user_id', '=', 'utilisateurs.id')
            ->where('clients.user_id', $userId)
            ->select('utilisateurs.*', 'clients.id as client_id')
            ->first();

        // Récupérer les demandes du client
        $demandes = DB::table('demandes')
            ->where('id_client', $client->client_id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Récupérer les offres du client avec les informations des prestataires
        $offres = DB::table('offres')
            ->join('demandes', 'offres.id_demande', '=', 'demandes.id')
            ->join('prestataires', 'offres.id_prestataire', '=', 'prestataires.id')
            ->join('utilisateurs', 'prestataires.user_id', '=', 'utilisateurs.id')
            ->where('demandes.id_client', $client->client_id)
            ->select(
                'offres.*',
                'demandes.ville',
                'demandes.quartier',
                'demandes.date',
                'utilisateurs.nom as prestataire_nom',
                'utilisateurs.prenom as prestataire_prenom',
                'prestataires.nom_Entreprise',
                'prestataires.is_verify'
            )
            ->orderBy('offres.created_at', 'desc')
            ->limit(5) // Limiter à 5 offres récentes pour le dashboard
            ->get();

        // Calculer les statistiques
        $stats = [
            'total_demandes' => $demandes->count(),
            'demandes_en_attente' => $demandes->where('statut', 'en_attente')->count(),
            'total_offres' => DB::table('offres')
                ->join('demandes', 'offres.id_demande', '=', 'demandes.id')
                ->where('demandes.id_client', $client->client_id)
                ->count(),
            'offres_recentes' => $offres->count()
        ];

        // Types de services
        $typesServices = DB::table('types_services')->get();

        return Inertia::render('client/Dashboard', [
            'user' => $client,
            'demandes' => $demandes,
            'offres' => $offres,
            'stats' => $stats,
            'typesServices' => $typesServices
        ]);
    }

    public function creerDemande(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type_service_id' => 'required|exists:types_services,id',
            'date_souhaitee' => 'required|date|after:today',
            'budget_max' => 'nullable|numeric|min:0',
            'adresse' => 'required|string',
        ]);

        $userId = Session::get('user_id');
        $client = DB::table('clients')->where('user_id', $userId)->first();

        $demandeId = DB::table('demandes')->insertGetId([
            'client_id' => $client->id,
            'type_service_id' => $request->type_service_id,
            'titre' => $request->titre,
            'description' => $request->description,
            'date_souhaitee' => $request->date_souhaitee,
            'heure_souhaitee' => $request->heure_souhaitee,
            'budget_max' => $request->budget_max,
            'adresse' => $request->adresse,
            'instructions_speciales' => $request->instructions_speciales,
            'statut' => 'en_attente',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Demande créée avec succès');
    }

    public function getOffres($demandeId)
    {
        $offres = DB::table('offres')
            ->join('prestataires', 'offres.prestataire_id', '=', 'prestataires.id')
            ->join('utilisateurs', 'prestataires.user_id', '=', 'utilisateurs.id')
            ->where('offres.demande_id', $demandeId)
            ->select(
                'offres.*',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                DB::raw('CONCAT(utilisateurs.prenom, " ", utilisateurs.nom) as prestataire_nom')
            )
            ->get();

        return response()->json($offres);
    }

    public function accepterOffre(Request $request, $offreId)
    {
        DB::beginTransaction();
        
        try {
            $offre = DB::table('offres')->where('id', $offreId)->first();
            
            // Mettre à jour le statut de la demande
            DB::table('demandes')
                ->where('id', $offre->demande_id)
                ->update(['statut' => 'acceptee']);

            // Marquer l'offre comme acceptée
            DB::table('offres')
                ->where('id', $offreId)
                ->update(['statut' => 'acceptee']);

            // Refuser les autres offres
            DB::table('offres')
                ->where('demande_id', $offre->demande_id)
                ->where('id', '!=', $offreId)
                ->update(['statut' => 'refusee']);

            DB::commit();
            
            return redirect()->back()->with('success', 'Offre acceptée avec succès');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erreur lors de l\'acceptation de l\'offre');
        }
    }

    public function annulerDemande($demandeId)
    {
        $userId = Session::get('user_id');
        $client = DB::table('clients')->where('user_id', $userId)->first();

        // Vérifier que la demande appartient au client
        $demande = DB::table('demandes')
            ->where('id', $demandeId)
            ->where('client_id', $client->id)
            ->first();

        if (!$demande) {
            return redirect()->back()->with('error', 'Demande non trouvée');
        }

        // Vérifier si la demande peut être annulée
        if ($demande->statut !== 'en_attente') {
            return redirect()->back()->with('error', 'Cette demande ne peut plus être annulée');
        }

        DB::table('demandes')
            ->where('id', $demandeId)
            ->update(['statut' => 'annulee']);

        return redirect()->back()->with('success', 'Demande annulée avec succès');
    }

    public function effectuerPaiement(Request $request)
    {
        // Simulation de paiement
        $request->validate([
            'offre_id' => 'required|exists:offres,id',
            'montant' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            $offre = DB::table('offres')->where('id', $request->offre_id)->first();
            
            // Créer l'enregistrement de paiement
            $paiementId = DB::table('paiements')->insertGetId([
                'demande_id' => $offre->demande_id,
                'client_id' => Session::get('client_id'),
                'prestataire_id' => $offre->prestataire_id,
                'montant' => $request->montant,
                'statut' => 'effectue',
                'methode_paiement' => 'carte_bancaire',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Créer la prestation
            DB::table('prestations')->insert([
                'demande_id' => $offre->demande_id,
                'prestataire_id' => $offre->prestataire_id,
                'client_id' => Session::get('client_id'),
                'paiement_id' => $paiementId,
                'statut' => 'en_cours',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            
            return redirect()->back()->with('success', 'Paiement effectué avec succès');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erreur lors du paiement');
        }
    }

    public function noterPrestataire(Request $request, $prestationId)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $userId = Session::get('user_id');
        $client = DB::table('clients')->where('user_id', $userId)->first();

        // Vérifier que la prestation appartient au client
        $prestation = DB::table('prestations')
            ->where('id', $prestationId)
            ->where('client_id', $client->id)
            ->first();

        if (!$prestation) {
            return redirect()->back()->with('error', 'Prestation non trouvée');
        }

        // Créer l'avis
        DB::table('avis')->insert([
            'prestation_id' => $prestationId,
            'client_id' => $client->id,
            'prestataire_id' => $prestation->prestataire_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Évaluation enregistrée avec succès');
    }
    //------------------------demandes------------------------
    public function getDemandes($clientId)
{
    // Récupérer les demandes du client avec les informations supplémentaires
    $demandes = DB::table('demandes')
        ->join('services', 'demandes.id_service', '=', 'services.id')
        ->join('clients', 'demandes.id_client', '=', 'clients.id')
        ->where('demandes.id_client', $clientId)  // Filtrer par le client spécifique
        ->select(
            'demandes.*',  // Récupérer toutes les colonnes de la table demandes
            'services.nom as service_nom',  // Nom du service associé à la demande
            'clients.nom as client_nom',  // Nom du client associé à la demande
            'clients.prenom as client_prenom',  // Prénom du client
            DB::raw('CONCAT(clients.prenom, " ", clients.nom) as client_nom_complet')  // Nom complet du client
        )
        ->get();

    // Retourner les résultats sous forme de JSON
    return response()->json($demandes);
}
}
