<?php

namespace App\Http\Controllers\Prestataire;

use App\Http\Controllers\Controller;
use App\Models\Prestataire;
use Illuminate\Http\Request;

class PrestataireController extends Controller
{
    /**
     * Retourne quelques prestataires vérifiés pour l'accueil.
     */
    public function homePrestataires()
    {
        $prestataires = Prestataire::where('is_verify', 1)
            ->with(['utilisateur', 'quartier.ville'])
            ->take(4) // ou ->inRandomOrder()->take(4)
            ->get();

        return response()->json($prestataires);
    }

    /**
     * Retourne tous les prestataires vérifiés.
     */
    public function index()
    {
        $prestataires = Prestataire::where('is_verify', 1)
            ->with(['utilisateur', 'quartier.ville'])
            ->get();

        return response()->json($prestataires);
    }
}