<?php

namespace App\Http\Controllers\Prestataire;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Demande;
use App\Models\Prestataire;
use Inertia\Inertia;

class PrestataireDemandeController extends Controller
{
    public function index()
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = Session::get('user_id');
        
        // Récupérer le prestataire avec ses relations ville/quartier
        $prestataire = Prestataire::where('user_id', $userId)
            ->with(['quartier.ville'])
            ->first();
        
        if (!$prestataire) {
            return redirect()->route('login')->with('error', 'Prestataire non trouvé');
        }
        
        // Récupérer la ville du prestataire en utilisant la méthode du modèle
        $villePrestataire = $prestataire->ville;
        
        if (!$villePrestataire) {
            return redirect()->back()->with('error', 'Ville non définie pour ce prestataire');
        }
        
        // Filtrer les demandes par la ville du prestataire
        $demandes = Demande::where('ville', $villePrestataire)
            ->where('statut', 'en_attente') // Optionnel : ne montrer que les demandes en attente
            ->orderBy('created_at', 'desc')
            ->get();
        
        return Inertia::render('prestataire/Demandes', [
            'demandes' => $demandes,
            'ville_prestataire' => $villePrestataire
        ]);
    }
}