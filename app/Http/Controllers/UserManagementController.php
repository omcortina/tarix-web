<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Mail\UserVerificationMail;
use App\Mail\ClasificadorWelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    public function __construct()
    {
        // El middleware 'auth' y 'admin' ya se aplican a través de las rutas
    }

    /**
     * Mostrar lista de usuarios pendientes de verificación
     */
    public function index(Request $request)
    {
        $selectedCompanyId = $request->get('company_id');

        $verifiedQuery   = User::whereIn('user_type', ['EXTERNO', 'EMPRESA'])->where('is_verified', true);
        $unverifiedQuery = User::where('user_type', 'EXTERNO')->where('is_verified', false);

        if ($selectedCompanyId) {
            $verifiedQuery->where('company_id', $selectedCompanyId);
            $unverifiedQuery->where('company_id', $selectedCompanyId);
        }

        $verifiedUsers   = $verifiedQuery->orderBy('verified_at', 'desc')->get();
        $unverifiedUsers = $unverifiedQuery->orderBy('created_at', 'desc')->get();

        $clasificadores = User::where('user_type', 'CLASIFICADOR')
            ->orderBy('created_at', 'desc')
            ->get();

        $companies = Company::orderBy('name')->get();

        return view('admin.users.index', compact('unverifiedUsers', 'verifiedUsers', 'clasificadores', 'companies', 'selectedCompanyId'));
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

    /**
     * Mostrar formulario para crear usuario CLASIFICADOR
     */
    public function showCreateClasificador()
    {
        return view('admin.users.create-clasificador');
    }

    /**
     * Guardar nuevo usuario CLASIFICADOR
     */
    public function storeClasificador(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'user_type' => 'CLASIFICADOR',
            'is_verified' => true,
            'verified_at' => now(),
            'must_change_password' => true,
        ]);

        // Enviar email de bienvenida
        Mail::queue(new ClasificadorWelcomeMail($user, app()->getLocale(), $validated['password']));

        return redirect()->route('admin.users.index')->with('success', "Usuario CLASIFICADOR {$user->email} creado exitosamente.");
    }

    /**
     * Mostrar formulario para editar usuario EXTERNO
     */
    public function editExterno(User $user)
    {
        if ($user->user_type !== 'EXTERNO') {
            return redirect()->route('admin.users.index')->withErrors('Este usuario no es de tipo EXTERNO.');
        }

        $companies = Company::orderBy('name')->get();
        return view('admin.users.edit-externo', compact('user', 'companies'));
    }

    /**
     * Actualizar usuario EXTERNO
     */
    public function updateExterno(Request $request, User $user)
    {
        if ($user->user_type !== 'EXTERNO') {
            return redirect()->route('admin.users.index')->withErrors('Este usuario no es de tipo EXTERNO.');
        }

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:20',
            'company_id' => 'nullable|exists:companies,id',
            'password'   => 'nullable|min:8|confirmed',
        ], [
            'email.unique'    => 'El correo ya está registrado por otro usuario.',
            'password.min'    => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user->update([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'] ?? $user->phone,
            'company_id' => $validated['company_id'] ?? null,
        ]);

        if (!empty($validated['password'])) {
            $user->update([
                'password'             => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'must_change_password' => true,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', "Usuario {$user->email} actualizado exitosamente.");
    }

    /**
     * Mostrar formulario para editar usuario EMPRESA
     */
    public function editEmpresa(User $user)
    {
        if ($user->user_type !== 'EMPRESA') {
            return redirect()->route('admin.users.index')->withErrors('Este usuario no es de tipo EMPRESA.');
        }

        $companies = Company::orderBy('name')->get();
        return view('admin.users.edit-empresa', compact('user', 'companies'));
    }

    /**
     * Actualizar usuario EMPRESA
     */
    public function updateEmpresa(Request $request, User $user)
    {
        if ($user->user_type !== 'EMPRESA') {
            return redirect()->route('admin.users.index')->withErrors('Este usuario no es de tipo EMPRESA.');
        }

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:20',
            'company_id' => 'nullable|exists:companies,id',
            'password'   => 'nullable|min:8|confirmed',
        ], [
            'email.unique'       => 'El correo ya está registrado por otro usuario.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user->update([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'] ?? $user->phone,
            'company_id' => $validated['company_id'] ?? null,
        ]);

        if (!empty($validated['password'])) {
            $user->update([
                'password'             => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'must_change_password' => true,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', "Usuario empresa {$user->email} actualizado exitosamente.");
    }

    /**
     * Mostrar formulario para editar usuario CLASIFICADOR
     */
    public function editClasificador(User $user)
    {
        if ($user->user_type !== 'CLASIFICADOR') {
            return redirect()->route('admin.users.index')->withErrors('Este usuario no es de tipo CLASIFICADOR.');
        }

        return view('admin.users.edit-clasificador', compact('user'));
    }

    /**
     * Actualizar usuario CLASIFICADOR
     */
    public function updateClasificador(Request $request, User $user)
    {
        if ($user->user_type !== 'CLASIFICADOR') {
            return redirect()->route('admin.users.index')->withErrors('Este usuario no es de tipo CLASIFICADOR.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($validated['password']) {
            $user->update([
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                'must_change_password' => true,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', "Usuario CLASIFICADOR {$user->email} actualizado exitosamente.");
    }

    /**
     * Eliminar usuario CLASIFICADOR
     */
    public function deleteClasificador(User $user)
    {
        if ($user->user_type !== 'CLASIFICADOR') {
            return redirect()->route('admin.users.index')->withErrors('Este usuario no es de tipo CLASIFICADOR.');
        }

        $email = $user->email;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "Usuario CLASIFICADOR {$email} eliminado exitosamente.");
    }
}
