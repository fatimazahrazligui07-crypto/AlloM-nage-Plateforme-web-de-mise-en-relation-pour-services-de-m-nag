<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Ville;
use App\Models\Quartier;
use App\Http\Controllers\Prestataire\PrestataireController;

Route::get('/prestataires', [PrestataireController::class, 'index']);
Route::get('/home-prestataires', [PrestataireController::class, 'homePrestataires']);
// Route API pour récupérer les services (existante)
Route::get('/services', [ServiceController::class, 'index']);

// AJOUTER : Route API pour récupérer les quartiers d'une ville
Route::get('/quartiers/{ville}', [RegisterController::class, 'getQuartiers'])->name('api.quartiers');

// Récupérer toutes les villes
Route::get('/villes', function() {
    return Ville::all();
});

// Récupérer les quartiers d'une ville spécifique
Route::get('/api/villes/{villeId}/quartiers', function($villeId) {
    return Quartier::where('ville_id', $villeId)->get();
});

// Route API pour récupérer les demandes filtrées par ville (pour prestataires)
Route::get('/api/demandes/ville/{ville}', function($ville) {
    return \App\Models\Demande::where('ville', $ville)
        ->where('statut', 'en_attente')
        ->orderBy('created_at', 'desc')
        ->get();
});