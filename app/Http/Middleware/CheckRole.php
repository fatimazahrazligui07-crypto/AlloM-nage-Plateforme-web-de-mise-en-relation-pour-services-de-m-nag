<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page');
        }

        $userRole = Session::get('user_role');

        // Vérifier si le rôle de l'utilisateur est autorisé
        if (!in_array($userRole, $roles)) {
            // Rediriger vers le dashboard approprié selon le rôle
            switch ($userRole) {
                case 'admin':
                    return redirect('/dashboard/admin');
                case 'prestataire':
                    return redirect('/dashboard/prestataire');
                case 'client':
                    return redirect('/dashboard/client');
                default:
                    return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
