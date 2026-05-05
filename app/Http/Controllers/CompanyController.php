<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmpresaWelcomeMail;

class CompanyController extends Controller
{
    /**
     * Mostrar listado de empresas
     */
    public function index()
    {
        $companies = Company::orderBy('id', 'asc')->get();
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Mostrar formulario de creación de empresa
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Guardar nueva empresa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:companies|max:255',
            'nit' => 'nullable|string|unique:companies|max:20',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255|unique:users,email',
            'contact_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean',
        ], [
            'name.required'          => 'El nombre de la empresa es obligatorio.',
            'name.unique'            => 'Ya existe una empresa con ese nombre.',
            'nit.unique'             => 'El NIT ingresado ya está registrado.',
            'contact_email.email'    => 'El correo de contacto no tiene un formato válido.',
            'contact_email.unique'   => 'El correo de contacto ya está registrado en el sistema.',
            'password.required'      => 'La contraseña es obligatoria.',
            'password.min'           => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'     => 'Las contraseñas no coinciden.',
        ]);

        // Crear la empresa
        $company = Company::create([
            'name' => $validated['name'],
            'nit' => $validated['nit'],
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'address' => $validated['address'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Crear usuario de tipo EMPRESA
        $user = User::create([
            'name' => $validated['contact_name'] ?? $validated['name'],
            'email' => $validated['contact_email'],
            'password' => Hash::make($validated['password']),
            'user_type' => 'EMPRESA',
            'company_id' => $company->id,
            'is_verified' => true,
            'verified_at' => now(),
            'must_change_password' => true,
        ]);

        // Enviar email de bienvenida
        Mail::queue(new EmpresaWelcomeMail($user, app()->getLocale(), $validated['password']));

        return redirect()->route('admin.companies.show', $company)
            ->with('success', "Empresa creada correctamente. Usuario EMPRESA ({$user->email}) creado automáticamente.");
    }

    /**
     * Mostrar detalles de una empresa
     */
    public function show(Company $company)
    {
        $users = $company->users()->get();
        $classifications = $company->classifications()->with('user', 'items')->get();

        return view('admin.companies.show', compact('company', 'users', 'classifications'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Actualizar empresa
     */
    public function update(Request $request, Company $company)
    {
        // No permitir editar empresa Tarix
        if ($company->isTarix()) {
            return back()->withErrors(['error' => 'No se puede editar la empresa Tarix']);
        }

        $validated = $request->validate([
            'name' => 'required|string|unique:companies,name,' . $company->id . '|max:255',
            'nit' => 'nullable|string|unique:companies,nit,' . $company->id . '|max:20',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $company->update($validated);

        return redirect()->route('admin.companies.show', $company)
            ->with('success', 'Empresa actualizada correctamente');
    }

    /**
     * Desactivar/Activar empresa
     */
    public function toggleActive(Company $company)
    {
        // No permitir desactivar empresa Tarix
        if ($company->isTarix()) {
            return back()->withErrors(['error' => 'No se puede desactivar la empresa Tarix']);
        }

        $company->update(['is_active' => !$company->is_active]);

        $status = $company->is_active ? 'activada' : 'desactivada';
        return back()->with('success', "Empresa {$status} correctamente");
    }

    /**
     * Eliminar empresa
     */
    public function destroy(Company $company)
    {
        // No permitir eliminar empresa Tarix
        if ($company->isTarix()) {
            return back()->withErrors(['error' => 'No se puede eliminar la empresa Tarix']);
        }

        // No permitir eliminar si tiene usuarios
        if ($company->users()->count() > 0) {
            return back()->withErrors(['error' => 'No se puede eliminar una empresa que tiene usuarios asociados']);
        }

        $name = $company->name;
        $company->delete();

        return redirect()->route('admin.companies.index')
            ->with('success', "Empresa '{$name}' eliminada correctamente");
    }
}
