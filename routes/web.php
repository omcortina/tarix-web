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
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\ClassificationSettingController;
use App\Http\Controllers\ClassificadorController;
use App\Http\Controllers\ArticleCommentController;

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
    
    // Rutas para clasificaciones
    Route::get('classifications', [ClassificationController::class, 'index'])->name('classifications');
    Route::get('classifications/create', [ClassificationController::class, 'create'])->name('classifications.create');
    Route::get('classifications/download-template', [ClassificationController::class, 'downloadTemplate'])->name('classifications.download-template');
    Route::post('classifications', [ClassificationController::class, 'store'])->name('classifications.store');
    Route::get('classifications/{classification}', [ClassificationController::class, 'show'])->name('classifications.show');
    
    // Rutas para correcciones de ítems
    Route::get('classifications/{classification}/items/{item}/corrections', [ClassificationController::class, 'showCorrections'])->name('classifications.items.corrections');
    Route::post('classifications/{classification}/items/{item}/corrections/{correction}/respond', [ClassificationController::class, 'respondCorrection'])->name('classifications.corrections.respond');
    
    // Rutas para consulta de trámites
    Route::get('procedures', [ClassificationController::class, 'procedures'])->name('procedures');
});

// Admin routes (protegidas con middleware auth y admin)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::resource('services', ServiceController::class);
    Route::resource('articles', ArticleController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('values', ValueController::class);
    Route::resource('contacts', ContactMessagesController::class)->only(['index', 'show', 'destroy']);
    
    // Rutas para comentarios de artículos
    Route::get('articles/comments', [ArticleCommentController::class, 'index'])->name('articles.comments');
    Route::post('articles/comments/{comment}/reply', [ArticleCommentController::class, 'reply'])->name('articles.comments.reply');
    Route::patch('articles/comments/{comment}/reject', [ArticleCommentController::class, 'reject'])->name('articles.comments.reject');
    Route::delete('articles/comments/{comment}', [ArticleCommentController::class, 'destroy'])->name('articles.comments.destroy');
    Route::delete('articles/comments/{reply}/reply', [ArticleCommentController::class, 'destroyReply'])->name('articles.comments.destroyReply');
    
    // Rutas para recursos útiles
    Route::get('services/{service}/resources', [ServiceController::class, 'editResources'])->name('services.edit-resources');
    Route::post('services/{service}/resources', [ServiceController::class, 'storeResource'])->name('services.store-resource');
    Route::put('services/{service}/resources/{resource}', [ServiceController::class, 'updateResource'])->name('services.update-resource');
    Route::patch('services/{service}/resources/{resource}/toggle', [ServiceController::class, 'toggleResource'])->name('services.toggle-resource');
    Route::delete('services/{service}/resources/{resource}', [ServiceController::class, 'destroyResource'])->name('services.destroy-resource');
    
    // Rutas para valores
    Route::patch('values/{value}/toggle', [ValueController::class, 'toggle'])->name('values.toggle');
    
    // Rutas para configuración de clasificaciones
    Route::get('classifications/settings', [ClassificationSettingController::class, 'index'])->name('classifications.settings');
    Route::put('classifications/settings', [ClassificationSettingController::class, 'update'])->name('classifications.settings.update');
    
    // Rutas para gestión de usuarios (solo para ADMIN)
    Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
    Route::patch('users/{user}/verify-general', [UserManagementController::class, 'verifyAsGeneral'])->name('users.verify-general');
    Route::patch('users/{user}/verify-preferential', [UserManagementController::class, 'verifyAsPreferential'])->name('users.verify-preferential');
    Route::delete('users/{user}/reject', [UserManagementController::class, 'reject'])->name('users.reject');
    Route::get('users/create-clasificador', [UserManagementController::class, 'showCreateClasificador'])->name('users.create-clasificador');
    Route::post('users/clasificador', [UserManagementController::class, 'storeClasificador'])->name('users.store-clasificador');
    Route::get('users/{user}/edit-clasificador', [UserManagementController::class, 'editClasificador'])->name('users.edit-clasificador');
    Route::put('users/{user}/clasificador', [UserManagementController::class, 'updateClasificador'])->name('users.update-clasificador');
    Route::delete('users/{user}/clasificador', [UserManagementController::class, 'deleteClasificador'])->name('users.delete-clasificador');
});

// Clasificador routes (protegidas con middleware auth, user-verified y clasificador)
Route::prefix('clasificador')->name('clasificador.')->middleware(['auth', 'user-verified', 'clasificador'])->group(function () {
    Route::get('/', [ClassificadorController::class, 'index'])->name('index');
    Route::get('classifications/{classification}', [ClassificadorController::class, 'show'])->name('show');
    Route::post('classifications/{classification}/verify-payment', [ClassificadorController::class, 'verifyPayment'])->name('verify-payment');
    Route::post('classifications/{classification}/verify-item/{item}', [ClassificadorController::class, 'verifyItem'])->name('verify-item');
    Route::post('classifications/{classification}/reject-item/{item}', [ClassificadorController::class, 'rejectItem'])->name('reject-item');
    Route::post('classifications/{classification}/approve', [ClassificadorController::class, 'approve'])->name('approve');
});

// Rutas de contacto (pública)
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Ruta para cambiar idioma
Route::get('/lang/{locale}', [LanguageController::class, 'setLanguage'])->name('lang.set');

// Rutas públicas de artículos (blog)
Route::get('/blog', [ArticlePublicController::class, 'index'])->name('articles.index');
Route::get('/blog/{slug}', [ArticlePublicController::class, 'show'])->name('articles.show');

// Ruta para comentarios en artículos
Route::post('/articles/{article}/comments', [ArticleCommentController::class, 'store'])->name('articles.comments.store');

// Rutas públicas de servicios (dinámicas por slug)
Route::get('{service}', [ServiceController::class, 'show']);
