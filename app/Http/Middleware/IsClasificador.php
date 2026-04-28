<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsClasificador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a clasificador.');
        }

        if (auth()->user()->user_type !== 'CLASIFICADOR') {
            return redirect()->route('user.dashboard')->with('error', 'No tienes acceso a este módulo.');
        }

        return $next($request);
    }
}
