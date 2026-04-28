<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'user_type' => 'EXTERNO',
        ]);

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

        return view('auth.register-google-complete', [
            'name' => session('google_name'),
            'email' => session('google_email'),
        ]);
    }

    public function completeGoogleRegistration(Request $request)
    {
        if (!session()->has('google_email')) {
            return redirect()->route('register');
        }

        $validated = $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $user = User::create([
            'name' => session('google_name'),
            'email' => session('google_email'),
            'phone' => $validated['phone'],
            'password' => Hash::make(uniqid()),
            'user_type' => 'EXTERNO',
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
        
        return view('user.dashboard', compact('stats'));
    }
}
