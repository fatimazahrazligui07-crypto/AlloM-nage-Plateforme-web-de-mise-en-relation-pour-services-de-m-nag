<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestataire; // Important: Importer le modèle Prestataire
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
 public function login(Request $request)
{
    // Validation des données
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ], [
        'email.required' => 'L\'email est requis',
        'email.email' => 'Format d\'email invalide',
        'password.required' => 'Le mot de passe est requis',
        'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
    ]);

    // Rechercher l'utilisateur dans la table utilisateurs
    $utilisateur = \App\Models\Utilisateur::where('email', $request->email)->first();

    if (!$utilisateur || !\Hash::check($request->password, $utilisateur->motdepasse)) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'Email ou mot de passe incorrect',
        ]);
    }

    // Vérifier que l'utilisateur est actif
    if (!$utilisateur->status) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'Votre compte est désactivé.',
        ]);
    }

    // Vérification spécifique pour le prestataire
    if ($utilisateur->role === 'prestataire') {
        $prestataire = \App\Models\Prestataire::where('user_id', $utilisateur->id)->first();
        if (!$prestataire) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'Aucun profil prestataire associé à ce compte.',
            ]);
        }
        if (!$prestataire->is_verify) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'Votre compte prestataire doit être validé par un administrateur.',
            ]);
        }
    }

    // Créer la session utilisateur
    session([
        'user_id' => $utilisateur->id,
        'user_email' => $utilisateur->email,
        'user_role' => $utilisateur->role,
        'user_nom' => $utilisateur->nom,
        'user_prenom' => $utilisateur->prenom,
    ]);

    // Redirection selon le rôle
    if ($utilisateur->role === 'client') {
        return redirect()->route('client.dashboard');
    } elseif ($utilisateur->role === 'prestataire') {
        return redirect()->route('prestataire.dashboard');
    } elseif ($utilisateur->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect('/dashboard');
}

  private function getRedirectUrlByRole($role)
  {
      $redirectUrl = '/dashboard'; // default
      if ($role === 'admin') {
          $redirectUrl = '/dashboard/admin';
      } elseif ($role === 'prestataire') {
          $redirectUrl = '/dashboard/prestataire';
      } elseif ($role === 'client') {
          $redirectUrl = '/dashboard/client';
      }
      return $redirectUrl;
  }
}
