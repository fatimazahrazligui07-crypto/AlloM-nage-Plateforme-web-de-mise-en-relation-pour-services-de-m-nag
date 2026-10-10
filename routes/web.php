<?php

use App\Models\Demande;
use App\Models\Prestataire;

use App\Http\Controllers\Prestataire\PrestataireDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Prestataire\PrestataireController;

use Inertia\Inertia;
use App\Models\Service;

use App\Http\Middleware\CheckAuth;

use App\Http\Controllers\Admin\PrestataireAdminController;

use App\Http\Controllers\Prestataire\PrestataireDemandeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\DemandeController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\OffreController;
use App\Http\Controllers\Client\PrestationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\CancellationController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\CommissionRuleController;
use App\Http\Controllers\Prestataire\PrestataireOffreController;
use App\Http\Controllers\Prestataire\PrestataireProfilController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::middleware(['web'])->group(function () {
    Route::post('/api/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
// Register routes
Route::get('/register', [RegisterController::class, 'showClientForm'])->name('registerclient');
Route::get('/inscription-prestataire', [RegisterController::class, 'showPrestataireForm'])->name('inscriptionprestataire');
Route::post('/api/register', [RegisterController::class, 'apiRegisterClient']);
Route::post('/api/register-prestataire', [RegisterController::class, 'apiRegisterPrestataire']);

// Redirection générale selon le rôle
Route::get('/dashboard', function () {
    if (!session()->has('user_id')) return redirect()->route('login');
    $role = session('user_role');
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'prestataire') return redirect()->route('prestataire.dashboard');
    if ($role === 'client') return redirect()->route('client.dashboard');
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::get('/services', function () {
    return Inertia::render('Services', [
        'services' => Service::all()
    ]);
});

// Profile client routes - without changing other route structure
Route::get('/dashboard/client/profile', [ProfileController::class, 'show'])
    ->middleware(['web', CheckAuth::class])
    ->name('client.profile');
Route::post('/dashboard/client/profile', [ProfileController::class, 'update'])
    ->middleware(['web', CheckAuth::class])
    ->name('client.updateProfile');




    // CLIENT routes (keep same structure)
Route::get('/dashboard/client', function () {
    if (!\Illuminate\Support\Facades\Session::has('user_id')) {
        return redirect()->route('login');
    }
    
    $userRole = \Illuminate\Support\Facades\Session::get('user_role');
    if ($userRole !== 'client') {
        return redirect('/dashboard');
    }
    
    return Inertia::render('client/Dashboard');
})->name('client.dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/client/demandes', [DemandeController::class, 'listDemandes'])
         ->name('client.demandes');
    Route::post('/dashboard/client/demandes/{id}/annuler', [DemandeController::class, 'annulerDemande'])
         ->name('client.demandes.annuler');
});

// CLIENT routes (keep same structure)
// Route::get('/dashboard/client', [DashboardController::class, 'index'])->name('client.dashboard');
Route::post('/client/demandes', [DemandeController::class, 'creerDemande'])->name('client.demandes.create');Route::get('/client/demandes/{demande}/offres', [DashboardController::class, 'getOffres'])->name('client.demandes.offres');
Route::post('/client/offres/{offre}/accepter', [DashboardController::class, 'accepterOffre'])->name('client.offres.accepter');
Route::delete('/client/demandes/{demande}', [DashboardController::class, 'annulerDemande'])->name('client.demandes.annuler');
Route::post('/client/paiement', [DashboardController::class, 'effectuerPaiement'])->name('client.paiement');
Route::post('/client/prestations/{prestation}/noter', [DashboardController::class, 'noterPrestataire'])->name('client.prestations.noter');
Route::get('/client/demandes', [DashboardController::class, 'getDemandes'])->name('client.demandes.list');
    //route du paiement
Route::post('/dashboard/client/paiement', [\App\Http\Controllers\Client\PaiementController::class, 'payer'])->name('client.paiement');
Route::get('/dashboard/client/apropos', fn() => Inertia::render('client/Apropos', ['services' => Service::all()]))->name('client.apropos');
Route::get('/dashboard/client/services', fn() => Inertia::render('client/Services', ['services' => Service::all()]))->name('client.services');
Route::get('/dashboard/client/demandesform/create', fn() => Inertia::render('client/CreateDemande'))->name('client.demandes');
Route::get('/dashboard/client/offres', [OffreController::class, 'index'])->name('client.offres');
Route::post('/dashboard/client/offres/{id}/accepter', [OffreController::class, 'accepter'])->name('client.offres.accepter');
Route::delete('/dashboard/client/offres/{id}/annuler', [OffreController::class, 'annuler'])->name('client.offres.annuler');
Route::get('/dashboard/client/prestations', [PrestationController::class, 'index'])->name('client.prestations');
Route::post('/dashboard/client/prestations/{id}/annuler', [PrestationController::class, 'annuler'])->name('client.prestations.annuler');
Route::get('/dashboard/client/demandes', [App\Http\Controllers\Client\DemandeController::class, 'listDemandes'])->name('client.demandes');

// PRESTATAIRE routes

// Dashboard prestataire
Route::get('/dashboard/prestataire', [PrestataireDashboardController::class, 'index'])
    ->middleware(['web', 'checkauth:prestataire'])
    ->name('prestataire.dashboard');

    Route::get('/dashboard/prestataire/demandes', [App\Http\Controllers\Prestataire\PrestataireDemandeController::class, 'index'])->name('prestataire.demandes');
    // ... (autres routes prestataire)
Route::get('/dashboard/prestataire', [PrestataireDashboardController::class, 'index'])->name('prestataire.dashboard');
Route::get('/dashboard/prestataire/demandes', [App\Http\Controllers\Prestataire\PrestataireDemandeController::class, 'index'])->name('prestataire.demandes');
Route::get('/dashboard/prestataire/offres', [App\Http\Controllers\Prestataire\PrestataireOffreController::class, 'index'])->name('prestataire.offres');
Route::get('/dashboard/prestataire/commissions', [App\Http\Controllers\Prestataire\PrestataireCommissionController::class, 'index'])->name('prestataire.commissions');
Route::get('/dashboard/prestataire/temoignages', [App\Http\Controllers\Prestataire\PrestataireTemoignageController::class, 'index'])->name('prestataire.temoignages');
Route::get('/dashboard/prestataire/apropos', fn() => Inertia::render('prestataire/Apropos', ['services' => Service::all()]))->name('prestataire.apropos');
Route::get('/dashboard/prestataire/testimonials', fn() => Inertia::render('prestataire/Testimonials'));
Route::get('/dashboard/prestataire/histoire', fn() => Inertia::render('prestataire/Histoire'))->name('histoire');
Route::get('/dashboard/prestataire/services', fn() => Inertia::render('prestataire/Services', ['services' => Service::all()]))->name('prestataire.services');
Route::get('/dashboard/prestataire/profil', [PrestataireProfilController::class, 'show'])->name('prestataire.profil');
Route::get('/dashboard/prestataire/demandes', [PrestataireDemandeController::class, 'index'])
    ->name('prestataire.demandes');

    // Afficher le formulaire de création d'offre
Route::get('/dashboard/prestataire/offres/create/{demande}', [PrestataireOffreController::class, 'create'])->name('prestataire.offres.create');

// Enregistrer l'offre en base
Route::post('/dashboard/prestataire/offres', [PrestataireOffreController::class, 'store'])->name('prestataire.offres.store');



// ADMIN routes

// Routes admin avec vérification de session comme les clients
Route::get('/dashboard/admin/stats', function () {
    if (!\Illuminate\Support\Facades\Session::has('user_id')) {
        return redirect()->route('login');
    }
    
    $userRole = \Illuminate\Support\Facades\Session::get('user_role');
    if ($userRole !== 'admin') {
        return redirect('/dashboard');
    }
    
    return app(AdminController::class)->index();
})->name('admin.stats');

Route::get('/dashboard/admin/users', function () {
    if (!\Illuminate\Support\Facades\Session::has('user_id')) {
        return redirect()->route('login');
    }
    
    $userRole = \Illuminate\Support\Facades\Session::get('user_role');
    if ($userRole !== 'admin') {
        return redirect('/dashboard');
    }
    
    return Inertia::render('admin/Users');
})->name('admin.users');


// Routes in web.php
Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('admin.dashboard');
// API routes pour l'admin (sans middleware)
Route::get('/api/admin/stats', [AdminController::class, 'getApiStats'])->name('api.admin.stats');
Route::get('/api/admin/stats/{period}', [AdminController::class, 'getDetailedStats'])->name('api.admin.detailed-stats');
Route::get('/api/admin/realtime', [AdminController::class, 'getRealTimeData'])->name('api.admin.realtime');

Route::get('/admin', fn() => redirect()->route('admin.dashboard'));

// --- Routes pour la gestion des utilisateurs ---

// 1. Affiche la page avec la liste des utilisateurs
Route::get('/dashboard/admin/users', [UserController::class, 'index'])->name('admin.users');

// 2. Routes pour les actions sur les utilisateurs
Route::put('/dashboard/admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
Route::put('/dashboard/admin/users/{user}/toggle-verification', [UserController::class, 'toggleVerification'])->name('admin.users.toggleVerification');
Route::delete('/dashboard/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');


// --- Routes pour la gestion des règles de commission ---
Route::get('/dashboard/admin/commission-rules', [CommissionRuleController::class, 'index'])->name('admin.commission-rules.index');
Route::post('/dashboard/admin/commission-rules', [CommissionRuleController::class, 'store'])->name('admin.commission-rules.store');
Route::put('/dashboard/admin/commission-rules/{id}', [CommissionRuleController::class, 'update'])->name('admin.commission-rules.update');
Route::delete('/dashboard/admin/commission-rules/{id}', [CommissionRuleController::class, 'destroy'])->name('admin.commission-rules.destroy');
Route::group(['middleware' => 'web'], function () {
    Route::get('/dashboard/admin/services', function () {
        if (!session()->has('user_id') || session('user_role') !== 'admin') {
            return redirect()->route('login');
        }
        return app(\App\Http\Controllers\Admin\ServicesController::class)->index();
    })->name('admin.services.index');

    Route::post('/dashboard/admin/services', function (Illuminate\Http\Request $request) {
        if (!session()->has('user_id') || session('user_role') !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return app(\App\Http\Controllers\Admin\ServicesController::class)->store($request);
    })->name('admin.services.store');

    Route::post('/dashboard/admin/services/{service}', function (Illuminate\Http\Request $request, Service $service) {
        if (!session()->has('user_id') || session('user_role') !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return app(\App\Http\Controllers\Admin\ServicesController::class)->update($request, $service);
    })->name('admin.services.update');

    Route::delete('/dashboard/admin/services/{service}', function (Service $service) {
        if (!session()->has('user_id') || session('user_role') !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return app(\App\Http\Controllers\Admin\ServicesController::class)->destroy($service);
    })->name('admin.services.destroy');
});
Route::middleware(['web', 'checkauth:admin'])->group(function () {
    Route::get('/dashboard/admin/prestataires-a-valider', [PrestataireAdminController::class, 'index'])->name('admin.prestataires.avalider');
    Route::post('/dashboard/admin/prestataires/{id}/valider', [PrestataireAdminController::class, 'valider'])->name('admin.prestataires.valider');
});

//_________________ Public pages_________________________
Route::get('/apropos', fn() => Inertia::render('Apropos', ['services' => Service::all()]))->name('apropos');
Route::get('/Welcomeclient', fn() => Inertia::render('Welcomeclient'));
Route::get('/welcomeprestataire', fn() => Inertia::render('Welcomeprestataire'));
Route::get('/termsandconditions', fn() => Inertia::render('TermsAndConditions'));

// API
Route::get('/api/villes', [RegisterController::class, 'getVilles']);
Route::get('/api/villes/{ville}/quartiers', [RegisterController::class, 'getQuartiers']);
Route::get('/api/quartiers/{ville}', [RegisterController::class, 'getQuartiers']);


// Debug
Route::get('/test-session', fn() => dd(session()->all()));
Route::get('/prestataires', function () {
    return Inertia::render('prestataire/Prestataires');
});
Route::get('/api/prestataires', [PrestataireController::class, 'index']);
Route::get('/dashboard/client/prestataires', function () {
    return Inertia::render('client/Prestataires');
});
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';