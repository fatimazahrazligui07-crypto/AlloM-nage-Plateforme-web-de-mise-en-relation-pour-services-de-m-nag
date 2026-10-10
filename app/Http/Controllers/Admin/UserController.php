<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs avec filtres.
     */
  public function index(Request $request)
{
    $users = Utilisateur::query()
        ->select('utilisateurs.*', 'prestataires.is_verify')
        ->leftJoin('prestataires', 'utilisateurs.id', '=', 'prestataires.user_id')
        ->when($request->input('search'), function ($query, $search) {
            $query->where(function($q) use ($search) {
                $q->where('utilisateurs.nom', 'like', "%{$search}%")
                  ->orWhere('utilisateurs.prenom', 'like', "%{$search}%")
                  ->orWhere('utilisateurs.email', 'like', "%{$search}%");
            });
        })
        ->when($request->input('role'), function ($query, $role) {
            if ($role === 'client' || $role === 'prestataire' || $role === 'admin') {
                $query->where('utilisateurs.role', $role);
            }
        })
        ->orderBy('utilisateurs.nom')
        ->paginate(15);

    // Ajoute cette ligne pour forcer la conversion en tableau
    $users = $users->toArray();

    return Inertia::render('admin/Users', [
        'users' => $users,
        'filters' => $request->only(['search', 'role'])
    ]);
}

    /**
     * Active ou désactive le statut d'un utilisateur.
     */
    public function toggleStatus(Utilisateur $user)
    {
        $user->status = !$user->status;
        $user->save();

        return back()->with('success', 'Statut de l\'utilisateur mis à jour.');
    }
    
    /**
     * Vérifie ou dé-vérifie un compte prestataire.
     */
    public function toggleVerification(Utilisateur $user)
    {
        if ($user->role !== 'prestataire') {
            return back()->with('error', 'Cet utilisateur n\'est pas un prestataire.');
        }

        // On cherche la table prestataire liée à cet utilisateur
        $prestataire = DB::table('prestataires')->where('user_id', $user->id)->first();

        if ($prestataire) {
            DB::table('prestataires')
                ->where('user_id', $user->id)
                ->update(['is_verify' => !$prestataire->is_verify]);
            return back()->with('success', 'Statut de vérification mis à jour.');
        }

        return back()->with('error', 'Profil prestataire non trouvé.');
    }


    /**
     * Supprime un utilisateur.
     */
    public function destroy(Utilisateur $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }
}