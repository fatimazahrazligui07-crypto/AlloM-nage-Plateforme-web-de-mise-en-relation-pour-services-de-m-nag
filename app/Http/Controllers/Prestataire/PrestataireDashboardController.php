<?php

namespace App\Http\Controllers\Prestataire;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class PrestataireDashboardController extends Controller
{
    public function index()
{
    $userId = Session::get('user_id');
    $prestataire = \App\Models\Prestataire::where('user_id', $userId)->first();

    if (!$prestataire) {
        $stats = [
            'totalOffres' => 0,
            'totalDemandes' => 0,
            'totalCommissions' => 0,
        ];
        return Inertia::render('prestataire/Dashboard', compact('stats'));
    }

    $stats = [
        'totalOffres' => DB::table('offres')
            ->where('id_prestataire', $prestataire->id)
            ->count(),

        'totalDemandes' => DB::table('demandes')
            ->join('offres', 'demandes.id', '=', 'offres.id_demande')
            ->where('offres.id_prestataire', $prestataire->id)
            ->distinct()
            ->count('demandes.id'),

        'totalCommissions' => DB::table('commissions')
            ->join('prestations', 'commissions.prestation_id', '=', 'prestations.id')
            ->where('prestations.id_prestataire', $prestataire->id)
            ->sum('amount'),
    ];

    return Inertia::render('prestataire/Dashboard', compact('stats'));
}
}
