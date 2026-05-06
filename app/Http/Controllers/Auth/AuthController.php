<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Mail\CompanyRegistrationLinkMail;
use App\Mail\PendingRegistrationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Encryption\DecryptException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (auth()->attempt($credentials, $request->filled('remember'))) {
            $user = auth()->user();
            $request->session()->regenerate();

            // Validar que usuarios EXTERNO estén verificados
            if ($user->user_type === 'EXTERNO' && !$user->is_verified) {
                auth()->logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta aún está en proceso de aprobación. Recibirás un correo cuando sea verificada.',
                ])->onlyInput('email');
            }

            // Si debe cambiar contraseña (clasificadores creados por admin)
            if ($user->must_change_password) {
                return redirect()->route('password.change');
            }

            // Redirigir según tipo de usuario
            if ($user->user_type === 'ADMIN') {
                return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido al admin!');
            } else {
                return redirect()->route('user.dashboard')->with('success', '¡Bienvenido!');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        $companies = Company::active()->get();
        return view('auth.register', compact('companies'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
            'company_id' => 'required|exists:companies,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'user_type' => 'EXTERNO',
            'company_id' => $validated['company_id'],
        ]);

        return redirect()->route('auth.pending')->with('success', '¡Registro completado! Por favor revisa tu correo.');
    }

    // -------------------------------------------------------------------------
    // Company registration link flow
    // -------------------------------------------------------------------------

    public function showSendRegistrationLink()
    {
        return view('user.send-registration-link');
    }

    public function sendRegistrationLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $company = Company::find($user->company_id);

        if (!$company) {
            return back()->with('error', 'No se encontró la empresa asociada a tu cuenta.');
        }

        $token = Crypt::encryptString((string) $company->id);
        $registrationUrl = route('register.by-link', $token);

        Mail::to($request->email)->send(
            new CompanyRegistrationLinkMail($company, $registrationUrl, $request->email)
        );

        return back()->with('success', "El link de registro fue enviado a {$request->email}.");
    }

    public function showRegisterByLink(string $token)
    {
        try {
            $companyId = (int) Crypt::decryptString($token);
        } catch (DecryptException) {
            abort(404);
        }

        $company = Company::where('id', $companyId)->where('is_active', true)->firstOrFail();

        return view('auth.register-by-link', compact('company', 'token'));
    }

    public function registerByLink(Request $request, string $token)
    {
        try {
            $companyId = (int) Crypt::decryptString($token);
        } catch (DecryptException) {
            abort(404);
        }

        $company = Company::where('id', $companyId)->where('is_active', true)->firstOrFail();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ]);

        if (User::where('email', $validated['email'])->exists()) {
            return back()
                ->withInput($request->only('name', 'email', 'phone'))
                ->withErrors([
                    'email' => 'Ya existe una cuenta registrada con este correo electrónico. Puedes iniciar sesión directamente.',
                ]);
        }

        $newUser = User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'password'   => Hash::make($validated['password']),
            'user_type'  => 'EXTERNO',
            'company_id' => $company->id,
        ]);

        Mail::to($newUser->email)->send(new PendingRegistrationMail($newUser));

        return redirect()->route('auth.pending')->with('success', '¡Registro completado! Por favor revisa tu correo.');
    }

    // Google OAuth Methods
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('register')->withErrors('Error al conectar con Google.');
        }

        // Buscar usuario existente
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Usuario ya existe
            // Loguea según su tipo de usuario
            if ($user->user_type === 'ADMIN') {
                auth()->login($user);
                return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido de vuelta! Has iniciado sesión con Google.');
            } elseif ($user->user_type === 'CLASIFICADOR') {
                auth()->login($user);
                return redirect()->route('user.dashboard')->with('success', '¡Bienvenido de vuelta! Has iniciado sesión con Google.');
            } elseif ($user->user_type === 'EXTERNO' && $user->is_verified) {
                auth()->login($user);
                return redirect()->route('user.dashboard')->with('success', '¡Bienvenido de vuelta! Has iniciado sesión con Google.');
            } else {
                // Usuario registrado pero no verificado
                return redirect()->route('auth.pending')->with('error', 'Tu cuenta está en proceso de aprobación. Recibirás un correo cuando sea verificada.');
            }
        }

        // Crear nuevo usuario - Guardar en sesión para luego completar datos
        session([
            'google_name' => $googleUser->getName(),
            'google_email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
        ]);

        return redirect()->route('register.google.complete');
    }

    public function showGoogleCompleteForm()
    {
        if (!session()->has('google_email')) {
            return redirect()->route('register');
        }

        $companies = Company::active()->get();

        return view('auth.register-google-complete', [
            'name' => session('google_name'),
            'email' => session('google_email'),
            'companies' => $companies,
        ]);
    }

    public function completeGoogleRegistration(Request $request)
    {
        if (!session()->has('google_email')) {
            return redirect()->route('register');
        }

        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'company_id' => 'required|exists:companies,id',
        ]);

        $user = User::create([
            'name' => session('google_name'),
            'email' => session('google_email'),
            'phone' => $validated['phone'],
            'password' => Hash::make(uniqid()),
            'user_type' => 'EXTERNO',
            'company_id' => $validated['company_id'] ?? null,
        ]);

        session()->forget(['google_name', 'google_email', 'google_id']);

        return redirect()->route('auth.pending')->with('success', '¡Registro completado! Por favor revisa tu correo.');
    }

    public function pendingApproval()
    {
        return view('auth.pending-approval');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        $servicesCount = \App\Models\Service::count();
        $publishedCount = \App\Models\Service::where('published', true)->count();
        $services = \App\Models\Service::latest()->limit(3)->get();
        
        $articlesCount = \App\Models\Article::count();
        $publishedArticlesCount = \App\Models\Article::where('published', true)->count();
        $articles = \App\Models\Article::latest()->limit(3)->get();
        
        return view('admin.dashboard', compact('servicesCount', 'publishedCount', 'services', 'articlesCount', 'publishedArticlesCount', 'articles'));
    }

    public function userDashboard()
    {
        $user = auth()->user();
        $stats = null;
        
        // Si es clasificador, calcular estadísticas de clasificaciones asignadas
        if ($user->user_type === 'CLASIFICADOR') {
            $stats = [
                'pending_payment' => $user->assignedClassifications()
                    ->where('status', 'Pendiente de Pago')
                    ->count(),
                'in_process' => $user->assignedClassifications()
                    ->whereIn('status', ['En Proceso', 'En proceso', 'Asignado'])
                    ->count(),
                'completed' => $user->assignedClassifications()
                    ->where('status', 'Aprobado')
                    ->count(),
                'total' => $user->assignedClassifications()->count(),
            ];
        }

        // Si es externo, calcular estadísticas de sus propias clasificaciones
        if ($user->user_type === 'EXTERNO') {
            $canSeePrices = $user->canSeePrices();
            $stats = [
                'pending'    => $user->classifications()
                    ->whereIn('status', ['Pendiente de Pago', 'En Revisión'])
                    ->count(),
                'in_process' => $user->classifications()
                    ->whereIn('status', ['En Proceso', 'En proceso', 'Asignado'])
                    ->count(),
                'completed'  => $user->classifications()
                    ->where('status', 'Aprobado')
                    ->count(),
                'pending_label' => $canSeePrices ? 'Pendiente de Pago' : 'En Revisión',
            ];
        }
        
        return view('user.dashboard', compact('stats'));
    }

    public function showChangePassword()
    {
        // Si ya no necesita cambiar contraseña, redirigir al dashboard
        if (!auth()->user()->must_change_password) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%&*?])/',
            ],
        ], [
            'password.regex' => 'La contraseña debe tener al menos una mayúscula, un número y un carácter especial (!@#$%&*?).',
        ]);

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route('user.dashboard')->with('success', '¡Contraseña actualizada correctamente! Bienvenido.');
    }
}
