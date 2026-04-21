<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Cambiar el idioma de la aplicación
     */
    public function setLanguage($locale)
    {
        // Validar que el idioma sea válido
        $validLocales = ['es', 'en'];
        
        if (in_array($locale, $validLocales)) {
            // Guardar en sesión
            session(['locale' => $locale]);
            // Guardar en cookie (opcional, para persistencia)
            cookie('locale', $locale, 60 * 24 * 365); // 1 año
        }

        // Redirigir de vuelta al origen
        return redirect()->back();
    }
}
