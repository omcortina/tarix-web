<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // ADMIN siempre puede acceder
        if ($user->user_type === 'ADMIN') {
            return $next($request);
        }

        // CLASIFICADOR siempre puede acceder
        if ($user->user_type === 'CLASIFICADOR') {
            return $next($request);
        }

        // EMPRESA siempre puede acceder (creados verificados por defecto)
        if ($user->user_type === 'EMPRESA') {
            return $next($request);
        }

        // EXTERNO debe estar verificado
        if ($user->user_type === 'EXTERNO' && !$user->is_verified) {
            auth()->logout();
            return redirect('/')->with('error', 'Tu cuenta no está verificada.');
        }

        return $next($request);
    }
}
