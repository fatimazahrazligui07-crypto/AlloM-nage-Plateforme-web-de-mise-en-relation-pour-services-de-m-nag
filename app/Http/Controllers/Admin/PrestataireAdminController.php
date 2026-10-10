<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestataire;
use Illuminate\Http\Request;

class PrestataireAdminController extends Controller
{
    // Affiche la liste des prestataires à valider
    public function index()
    {
        $prestataires = Prestataire::with('utilisateur')
            ->where('is_verify', false)
            ->get();

        return inertia('admin/PrestatairesAValider', [
            'prestataires' => $prestataires
        ]);
    }

    // Valide un prestataire
    public function valider($id)
    {
        $prestataire = Prestataire::findOrFail($id);
        $prestataire->is_verify = true;
        $prestataire->save();

        return back()->with('success', 'Le compte prestataire a été validé.');
    }
}