<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCotizador
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        if (!in_array(auth()->user()->user_type, ['COTIZADOR', 'ADMIN'])) {
            return redirect()->route('user.dashboard')->with('error', 'No tienes acceso al módulo de cotizaciones.');
        }

        return $next($request);
    }
}
