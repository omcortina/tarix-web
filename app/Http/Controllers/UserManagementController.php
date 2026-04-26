<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserVerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    public function __construct()
    {
        // El middleware 'auth' y 'admin' ya se aplican a través de las rutas
    }

    /**
     * Mostrar lista de usuarios externos pendientes de verificación
     */
    public function index()
    {
        $unverifiedUsers = User::where('user_type', 'EXTERNO')
            ->where('is_verified', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $verifiedUsers = User::where('user_type', 'EXTERNO')
            ->where('is_verified', true)
            ->orderBy('verified_at', 'desc')
            ->get();

        return view('admin.users.index', compact('unverifiedUsers', 'verifiedUsers'));
    }

    /**
     * Verificar y clasificar usuario como GENERAL
     */
    public function verifyAsGeneral(User $user)
    {
        if ($user->user_type !== 'EXTERNO') {
            return redirect()->back()->withErrors('Este usuario no es de tipo EXTERNO.');
        }

        $user->update([
            'is_verified' => true,
            'client_type' => 'GENERAL',
            'verified_at' => now(),
        ]);

        // Enviar email de verificación al usuario en el idioma actual
        Mail::queue(new UserVerificationMail($user, 'GENERAL', app()->getLocale()));

        return redirect()->back()->with('success', 'Usuario verificado como Cliente General. Se ha enviado un email de confirmación.');
    }

    /**
     * Verificar y clasificar usuario como PREFERENCIAL
     */
    public function verifyAsPreferential(User $user)
    {
        if ($user->user_type !== 'EXTERNO') {
            return redirect()->back()->withErrors('Este usuario no es de tipo EXTERNO.');
        }

        $user->update([
            'is_verified' => true,
            'client_type' => 'PREFERENCIAL',
            'verified_at' => now(),
        ]);

        // Enviar email de verificación al usuario en el idioma actual
        Mail::queue(new UserVerificationMail($user, 'PREFERENCIAL', app()->getLocale()));

        return redirect()->back()->with('success', 'Usuario verificado como Cliente Preferencial. Se ha enviado un email de confirmación.');
    }

    /**
     * Rechazar y eliminar usuario
     */
    public function reject(User $user)
    {
        if ($user->user_type !== 'EXTERNO' || $user->is_verified) {
            return redirect()->back()->withErrors('No se puede rechazar este usuario.');
        }

        $email = $user->email;
        $user->delete();

        return redirect()->back()->with('success', "Usuario {$email} rechazado y eliminado.");
    }
}
