<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticlePublicController;
use App\Http\Controllers\ContactMessagesController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ValueController;
use App\Http\Controllers\UserManagementController;

Route::get('/', function () {
    $services = \App\Models\Service::where('published', true)->get();
    $values = \App\Models\Value::where('is_active', true)->orderBy('order')->get();
    return view('app', compact('services', 'values'));
});

// Auth routes (sin protección)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/pending', [AuthController::class, 'pendingApproval'])->name('auth.pending');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth routes
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/register/google/complete', [AuthController::class, 'showGoogleCompleteForm'])->name('register.google.complete');
Route::post('/register/google/complete', [AuthController::class, 'completeGoogleRegistration'])->name('register.google.store');

// User dashboard routes (protegidas con middleware auth y user-verified)
Route::prefix('dashboard')->name('user.')->middleware(['auth', 'user-verified'])->group(function () {
    Route::get('/', [AuthController::class, 'userDashboard'])->name('dashboard');
});

// Admin routes (protegidas con middleware auth y admin)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::resource('services', ServiceController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('values', ValueController::class);
    Route::resource('contacts', ContactMessagesController::class)->only(['index', 'show', 'destroy']);
    
    // Rutas para recursos útiles
    Route::get('services/{service}/resources', [ServiceController::class, 'editResources'])->name('services.edit-resources');
    Route::post('services/{service}/resources', [ServiceController::class, 'storeResource'])->name('services.store-resource');
    Route::put('services/{service}/resources/{resource}', [ServiceController::class, 'updateResource'])->name('services.update-resource');
    Route::patch('services/{service}/resources/{resource}/toggle', [ServiceController::class, 'toggleResource'])->name('services.toggle-resource');
    Route::delete('services/{service}/resources/{resource}', [ServiceController::class, 'destroyResource'])->name('services.destroy-resource');
    
    // Rutas para valores
    Route::patch('values/{value}/toggle', [ValueController::class, 'toggle'])->name('values.toggle');
    
    // Rutas para gestión de usuarios (solo para ADMIN)
    Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
    Route::patch('users/{user}/verify-general', [UserManagementController::class, 'verifyAsGeneral'])->name('users.verify-general');
    Route::patch('users/{user}/verify-preferential', [UserManagementController::class, 'verifyAsPreferential'])->name('users.verify-preferential');
    Route::delete('users/{user}/reject', [UserManagementController::class, 'reject'])->name('users.reject');
});

// Rutas de contacto (pública)
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Ruta para cambiar idioma
Route::get('/lang/{locale}', [LanguageController::class, 'setLanguage'])->name('lang.set');

// Rutas públicas de artículos (blog)
Route::get('/blog', [ArticlePublicController::class, 'index'])->name('articles.index');
Route::get('/blog/{slug}', [ArticlePublicController::class, 'show'])->name('articles.show');

// Rutas públicas de servicios (dinámicas por slug)
Route::get('{service}', [ServiceController::class, 'show']);
