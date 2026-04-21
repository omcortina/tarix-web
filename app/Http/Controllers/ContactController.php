<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        // Verificar reCAPTCHA con Google
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        try {
            $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $recaptchaResponse,
            ]);

            $result = $response->json();

            // Validar que reCAPTCHA fue exitoso
            if (!$result['success'] || $result['score'] < 0.5) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validación reCAPTCHA fallida. Intenta nuevamente.',
                ], 422);
            }

            // Guardar el contacto
            $contact = Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company' => $validated['company'],
                'message' => $validated['message'],
                'recaptcha_score' => $result['score'] ?? 0,
            ]);

            // TODO: Enviar email de confirmación al usuario
            // TODO: Enviar notificación al admin

            return response()->json([
                'success' => true,
                'message' => '¡Consulta enviada exitosamente! Nos pondremos en contacto pronto.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar tu solicitud. Intenta más tarde.',
            ], 500);
        }
    }
}
