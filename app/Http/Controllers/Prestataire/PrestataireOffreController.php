<?php

namespace App\Http\Controllers\Prestataire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Offre;
use Inertia\Inertia;
use App\Models\Demande;

class PrestataireOffreController extends Controller
{
    /**
     * Affiche la liste des offres pour le prestataire connecté.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Vérifier si le prestataire est authentifié
       
        // Récupérer l'ID du prestataire depuis la session
         $userId = Session::get('user_id');
    $prestataire = \App\Models\Prestataire::where('user_id', $userId)->first();
if (!$prestataire) {
        // Gérer le cas où le prestataire n'existe pas
        return Inertia::render('prestataire/Offres', [
            'offres' => []
        ]);
    }

        // Récupérer toutes les offres liées à ce prestataire
        // On utilise 'with' pour charger les informations de la demande associée
        // et ainsi optimiser le nombre de requêtes à la base de données.
$offres = Offre::where('id_prestataire', $prestataire->id)            ->with('demande') 
            ->orderBy('created_at', 'desc') // Trier les offres des plus récentes aux plus anciennes
            ->get();
            
        // Retourner la vue Inertia (un composant Vue.js) avec les données
        return Inertia::render('prestataire/Offres', [
            'offres' => $offres
        ]);
    }
    public function create($demandeId)
    {
        $demande = Demande::findOrFail($demandeId);
        return Inertia::render('prestataire/OffreForm', [
            'demande' => $demande
        ]);
    }
    public function store(Request $request)
{
    $request->validate([
        'demande_id' => 'required|exists:demandes,id',
        'prixpropose' => 'required|numeric|min:1',
        'message' => 'required|string',
    ]);

    $userId = Session::get('user_id');
    $prestataire = \App\Models\Prestataire::where('user_id', $userId)->first();

    if (!$prestataire) {
        return back()->with('error', 'Aucun profil prestataire trouvé pour cet utilisateur.');
    }

    \App\Models\Offre::create([
        'id_demande' => $request->demande_id,
        'id_prestataire' => $prestataire->id, // <-- c'est bien l'id du prestataire !
        'prixpropose' => $request->prixpropose,
        'message' => $request->message,
    ]);

    return redirect()->route('prestataire.offres')->with('success', 'Offre soumise avec succès !');
}
    
}