<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Store a newly created contact in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
            'g-recaptcha-response' => 'required',
        ]);

        try {
            // TODO: Habilitar validación reCAPTCHA cuando esté correctamente configurado
            // Por ahora solo almacenamos el token
            $recaptchaResponse = $request->input('g-recaptcha-response');

            // Guardar el contacto
            $contact = Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company' => $validated['company'],
                'message' => $validated['message'],
                'recaptcha_score' => 0,
            ]);

            // TODO: Enviar email de confirmación al usuario
            // TODO: Enviar notificación al admin

            return response()->json([
                'success' => true,
                'message' => '¡Consulta enviada exitosamente! Nos pondremos en contacto pronto.',
            ]);

        } catch (\Exception $e) {
            Log::error('Error al guardar contacto', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar tu solicitud. Intenta más tarde.',
            ], 500);
        }
    }
}
