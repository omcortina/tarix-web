<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticlePublicController;
use App\Http\Controllers\ContactMessagesController;
use App\Http\Controllers\LanguageController;

Route::get('/', function () {
    $services = \App\Models\Service::where('published', true)->get();
    return view('app', compact('services'));
});

// Auth routes (sin protección)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (protegidas con middleware auth)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::resource('services', ServiceController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('contacts', ContactMessagesController::class)->only(['index', 'show', 'destroy']);
    
    // Rutas para recursos útiles
    Route::get('services/{service}/resources', [ServiceController::class, 'editResources'])->name('services.edit-resources');
    Route::post('services/{service}/resources', [ServiceController::class, 'storeResource'])->name('services.store-resource');
    Route::put('services/{service}/resources/{resource}', [ServiceController::class, 'updateResource'])->name('services.update-resource');
    Route::patch('services/{service}/resources/{resource}/toggle', [ServiceController::class, 'toggleResource'])->name('services.toggle-resource');
    Route::delete('services/{service}/resources/{resource}', [ServiceController::class, 'destroyResource'])->name('services.destroy-resource');
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
