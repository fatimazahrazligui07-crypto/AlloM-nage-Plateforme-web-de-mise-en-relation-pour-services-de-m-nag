<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use App\Models\Prestation;
use Carbon\Carbon;

class PrestationController extends Controller
{
    public function index()
    {
        if (!Session::has('user_id') || Session::get('user_role') !== 'client') {
            return redirect()->route('login');
        }

        $clientId = Session::get('user_id');

        // Charger les prestations de ce client via la relation demandes => prestations
        $prestations = Prestation::with('prestataire')
            ->where('id_client', $clientId)
            ->get()
            ->map(function ($prestation) {
                return [
                    'id' => $prestation->id,
                    'date_prestation' => $prestation->date_prestation,
                    'heure_prestation' => $prestation->heure_prestation,
                    'statut' => $prestation->etat,
                    'montant_paye' => $prestation->montant_paye,
                    'prestataire' => $prestation->prestataire
                ];
            });

        return Inertia::render('client/PrestationSuivi', [
            'prestations' => $prestations
        ]);
    }

    public function annuler($id)
    {
        $prestation = Prestation::findOrFail($id);

        $now = Carbon::now();
        $prestationDate = Carbon::parse($prestation->date_prestation);

        if ($prestationDate->diffInHours($now, false) < -48) {
            $prestation->etat = 'Annulée';
            $prestation->save();
            return redirect()->back()->with('success', 'Prestation annulée');
        } else {
            return redirect()->back()->with('error', 'Impossible d’annuler à moins de 48h');
        }
    }
}
