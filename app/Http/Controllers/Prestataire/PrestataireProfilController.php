<?php

namespace App\Http\Controllers\Prestataire;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Prestataire;
use Inertia\Inertia;

class PrestataireProfilController extends Controller
{
    /**
     * Affiche la page de profil du prestataire connecté.
     *
     * @return \Inertia\Response
     */
    public function show()
    {
        // =================================================================
        // == ATTENTION : MODIFICATION POUR LE DÉVELOPPEMENT UNIQUEMENT ==
        // =================================================================
        // Pour que cette page fonctionne, assurez-vous d'avoir un enregistrement
        // dans votre table `prestataires` avec un `user_id` qui existe.
        // Par exemple, l'utilisateur avec l'ID 1.
        $userId = 10; 

        /*
        // --- CODE ORIGINAL À RÉACTIVER AVANT LA MISE EN PRODUCTION ---
        if (!Session::has('user_id') || Session::get('user_role') !== 'prestataire') {
            return redirect()->route('login');
        }
        $userId = Session::get('user_id');
        // --- FIN DU CODE ORIGINAL ---
        */


        // Récupérer le profil du prestataire en utilisant l'ID de l'utilisateur.
        // La fonction `with()` charge les informations liées (utilisateur, quartier et ville)
        // pour éviter de faire des requêtes multiples à la base de données.
        $prestataire = Prestataire::where('user_id', $userId)
                                  ->with(['user', 'quartier.ville'])
                                  ->first();

        // Si aucun profil n'est trouvé pour l'utilisateur connecté, on affiche une erreur.
        if (!$prestataire) {
            abort(404, 'Profil prestataire non trouvé pour cet utilisateur.');
        }
            
        // Retourner la vue Inertia (un composant Vue.js) en lui passant les données du prestataire
        return Inertia::render('prestataire/Profil', [
    'prestataire' => $prestataire
]);
    }
}