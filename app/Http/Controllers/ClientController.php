<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // Affiche le tableau de bord du client
    public function dashboard()
    {
        // Récupérer le client actuellement connecté
        $client = Auth::user()->client;
        
        // Récupérer les demandes du client
        $reservations = $client->reservations; // Assurez-vous que la relation 'reservations' existe dans le modèle Client

        return view('client.dashboard', compact('client', 'reservations'));
    }

    // Fonction pour afficher les détails d'une réservation
    public function createReservation()
    {
        return view('client.create-reservation');
    }
}
