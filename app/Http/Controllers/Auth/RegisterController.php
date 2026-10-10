<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ville;
use App\Models\Quartier;
use App\Models\Utilisateur;
use App\Models\Client;
use App\Models\Prestataire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Inertia\Inertia;

class RegisterController extends Controller
{
     /**
     * Afficher le formulaire d'inscription prestataire
     */
    public function showPrestataireForm()
    {
        try {
            $villes = Ville::all();
            
            // CORRECTION: Enlever le slash initial
            return Inertia::render('auth/InscriptionPrestataire', [
                'villes' => $villes,
                'debug_info' => [
                    'villes_count' => $villes->count(),
                    'component' => 'InscriptionPrestataire',
                    'timestamp' => now()->toDateTimeString()
                ]
            ]);
        } catch (\Exception $e) {
            // Ajouter logging pour débugger
            \Log::error('Erreur showPrestataireForm:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Retourner une page d'erreur ou rediriger
            return redirect()->route('home')->with('error', 'Erreur lors du chargement de la page');
        }
    }

    /**
     * Afficher le formulaire d'inscription client
     */
    public function showClientForm()
    {
        try {
            $villes = Ville::all();
            
            return Inertia::render('Auth/Register', [
                'villes' => $villes,
                'debug_info' => [
                    'villes_count' => $villes->count(),
                    'component' => 'Register',
                    'timestamp' => now()->toDateTimeString()
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur showClientForm:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('home')->with('error', 'Erreur lors du chargement de la page');
        }
    }
    

    /**
     * API: Enregistrer un nouveau client
     */
    public function apiRegisterClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilisateurs',
            'password' => 'required|string|min:8|confirmed',
            'num_telephone' => 'required|string|max:20',
            'quartier_id' => 'required|exists:quartiers,id',
            'role' => 'required|string|in:admin,client,prestataire',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $utilisateur = Utilisateur::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'motdepasse' => Hash::make($request->password),
                'num_telephone' => $request->num_telephone,
                'dateInscription' => Carbon::now()->toDateString(),
                'role' => $request->role,
            ]);

            if ($request->role === 'client') {
                Client::create([
                    'user_id' => $utilisateur->id,
                    'quartier_id' => $request->quartier_id,
                    'admin_id' => 1,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Inscription réussie ! Vous pouvez maintenant vous connecter.',
                'redirect' => '/login'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur inscription API:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'inscription: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Enregistrer un nouveau prestataire
     */
    public function apiRegisterPrestataire(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilisateurs',
            'password' => 'required|string|min:8|confirmed',
            'num_telephone' => 'required|string|max:20',
            'quartier_id' => 'required|exists:quartiers,id',
            'nom_Entreprise' => 'required|string|max:255',
            'ICE' => 'nullable|string|max:255',
            'Bank' => 'nullable|string|max:255',
            'RIB' => 'nullable|string|max:255',
            'role' => 'required|string|in:admin,client,prestataire',
            'fichier_assurance' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Créer l'utilisateur
            $utilisateur = Utilisateur::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'motdepasse' => Hash::make($request->password),
                'num_telephone' => $request->num_telephone,
                'dateInscription' => Carbon::now()->toDateString(),
                'role' => $request->role,
                'status' => true, // actif par défaut
            ]);

            // Gérer les fichiers uploadés
            $logoPath = null;
            $assurancePath = null;

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            if ($request->hasFile('fichier_assurance')) {
                $assurancePath = $request->file('fichier_assurance')->store('assurances', 'public');
            }

            // Créer le prestataire
            if ($request->role === 'prestataire') {
                Prestataire::create([
                    'user_id' => $utilisateur->id,
                    'quartier_id' => $request->quartier_id,
                    'admin_id' => 1,
                    'nom_Entreprise' => $request->nom_Entreprise,
                    'Bank' => $request->Bank,
                    'ICE' => $request->ICE,
                    'RIB' => $request->RIB,
                    'ContratDeBank' => $assurancePath,
                    'logo' => $logoPath,
                   // 'is_active' => false, // En attente de validation
                    'is_verify' => false,// à valider par l'admin
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Inscription réussie ! Votre compte est en attente de validation.',
                'redirect' => '/login'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur inscription prestataire API:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'inscription: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enregistrer un nouveau client (version web)
     */
    public function registerClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilisateurs',
            'password' => 'required|string|min:8|confirmed',
            'num_telephone' => 'required|string|max:20',
            'quartier_id' => 'required|exists:quartiers,id',
            'role' => 'required|string|in:admin,client,prestataire',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $utilisateur = Utilisateur::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'motdepasse' => Hash::make($request->password),
                'num_telephone' => $request->num_telephone,
                'dateInscription' => Carbon::now()->toDateString(),
                'role' => $request->role,
            ]);

            if ($request->role === 'client') {
                Client::create([
                    'user_id' => $utilisateur->id,
                    'quartier_id' => $request->quartier_id,
                    'admin_id' => 1,
                ]);
            }

            return redirect()->route('login')->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'inscription: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * API: Récupérer toutes les villes
     */
    public function getVilles()
    {
        try {
            $villes = Ville::all(['id', 'nom_ville']);
            return response()->json([
                'success' => true,
                'data' => $villes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des villes'
            ], 500);
        }
    }

    /**
     * API: Récupérer les quartiers d'une ville
     */
    public function getQuartiers($villeId)
    {
        try {
            $quartiers = Quartier::where('ville_id', $villeId)
                                ->get(['id', 'nom_quartier']);
            
            return response()->json([
                'success' => true,
                'data' => $quartiers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des quartiers'
            ], 500);
        }
    }
}