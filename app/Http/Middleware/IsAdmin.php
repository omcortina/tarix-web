<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder al admin.');
        }

        if (auth()->user()->user_type !== 'ADMIN') {
            // Si es EXTERNO verificado, mandarlo al dashboard de usuario
            if (auth()->user()->user_type === 'EXTERNO' && auth()->user()->is_verified) {
                return redirect()->route('user.dashboard')->with('info', 'No tienes acceso al panel de administración. Accediendo a tu dashboard.');
            }
            // Si es EXTERNO pero no verificado, mostrar error de aprobación
            return redirect('/')->with('error', 'No tienes permiso para acceder al panel de administración. Tu cuenta está en proceso de aprobación.');
        }

        return $next($request);
    }
}
