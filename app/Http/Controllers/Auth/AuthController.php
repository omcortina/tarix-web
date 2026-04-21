<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido al admin!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }

    public function dashboard()
    {
        $servicesCount = \App\Models\Service::count();
        $publishedCount = \App\Models\Service::where('published', true)->count();
        $services = \App\Models\Service::latest()->limit(5)->get();
        
        $articlesCount = \App\Models\Article::count();
        $publishedArticlesCount = \App\Models\Article::where('published', true)->count();
        $articles = \App\Models\Article::latest()->limit(5)->get();
        
        return view('admin.dashboard', compact('servicesCount', 'publishedCount', 'services', 'articlesCount', 'publishedArticlesCount', 'articles'));
    }
}
