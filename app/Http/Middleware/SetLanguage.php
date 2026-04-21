<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar idioma en sesión
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        } 
        // Verificar idioma en cookie
        elseif ($request->hasCookie('locale')) {
            app()->setLocale($request->cookie('locale'));
        }
        // Si no, usar el idioma por defecto (español)
        else {
            app()->setLocale('es');
        }

        return $next($request);
    }
}
