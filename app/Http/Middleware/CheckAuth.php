<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckAuth
{
   public function handle($request, Closure $next, $role = null)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }

        // Si un rôle est requis, on vérifie
        if ($role && Session::get('user_role') !== $role) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}

