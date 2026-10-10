<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Inertia\Inertia;  // Utiliser Inertia pour envoyer les données à Vue.js

class ServiceController extends Controller
{
    /**
     * Récupérer tous les services avec leur type
     */
    public function index()
    {
        try {
            // Récupérer tous les services avec leur type
            $services = Service::with('typeService')->get();

            // Retourner la vue avec Inertia
            return Inertia::render('Services', [
                'services' => $services // Passez les services à la vue
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des services',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}