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
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CotizadorController;

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
Route::get('/register/{token}', [AuthController::class, 'showRegisterByLink'])->name('register.by-link');
Route::post('/register/{token}', [AuthController::class, 'registerByLink']);
Route::get('/pending', [AuthController::class, 'pendingApproval'])->name('auth.pending');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Cambio obligatorio de contraseña (solo auth, sin user-verified ni admin)
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.update');
});

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
    Route::get('classifications/{classification}/pdf', [ClassificationController::class, 'printPdf'])->name('classifications.pdf');
    
    // Rutas exclusivas para usuario tipo EMPRESA
    Route::get('empresa/classifications', [ClassificationController::class, 'empresaIndex'])->name('empresa.classifications');
    Route::get('empresa/billing', [ClassificationController::class, 'empresaBilling'])->name('empresa.billing');
    Route::get('empresa/send-link', [AuthController::class, 'showSendRegistrationLink'])->name('empresa.send-link');
    Route::post('empresa/send-link', [AuthController::class, 'sendRegistrationLink'])->name('empresa.send-link.send');
    
    // Rutas para consulta de trámites
    Route::get('procedures', [ClassificationController::class, 'procedures'])->name('procedures');
});

// Admin routes (protegidas con middleware auth y admin)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::resource('services', ServiceController::class);
    Route::resource('articles', ArticleController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('values', ValueController::class);
    Route::resource('companies', CompanyController::class);
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

    // Cancelar clasificación (admin)
    Route::patch('classifications/{classification}/cancel', [ClassificationController::class, 'adminCancel'])->name('classifications.cancel');
    Route::get('classifications/{classification}', [ClassificationController::class, 'adminShow'])->name('classifications.show');

    // Facturación y Totales (admin)
    Route::get('billing', [ClassificationController::class, 'adminBilling'])->name('billing');

    // Bandeja de entrada (admin accede a todas las cuentas)
    Route::get('inbox', [CotizadorController::class, 'inbox'])->name('inbox');
    Route::post('inbox/sync', [CotizadorController::class, 'syncInbox'])->name('inbox.sync');
    Route::get('inbox/{inboxEmail}', [CotizadorController::class, 'showEmail'])->name('inbox.show');
    Route::post('inbox/{inboxEmail}/reply', [CotizadorController::class, 'replyEmail'])->name('inbox.reply');
    Route::get('inbox/{inboxEmail}/attachment/{attachment}/download', [CotizadorController::class, 'downloadInboxAttachment'])->name('inbox.attachment.download');
    
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
    Route::get('users/{user}/edit-externo', [UserManagementController::class, 'editExterno'])->name('users.edit-externo');
    Route::put('users/{user}/externo', [UserManagementController::class, 'updateExterno'])->name('users.update-externo');
    Route::get('users/{user}/edit-empresa', [UserManagementController::class, 'editEmpresa'])->name('users.edit-empresa');
    Route::put('users/{user}/empresa', [UserManagementController::class, 'updateEmpresa'])->name('users.update-empresa');
    Route::patch('users/{user}/desactivate', [UserManagementController::class, 'desactivate'])->name('users.desactivate');
    // Cotizador user management
    Route::get('users/create-cotizador', [UserManagementController::class, 'showCreateCotizador'])->name('users.create-cotizador');
    Route::post('users/cotizador', [UserManagementController::class, 'storeCotizador'])->name('users.store-cotizador');
    Route::get('users/{user}/edit-cotizador', [UserManagementController::class, 'editCotizador'])->name('users.edit-cotizador');
    Route::put('users/{user}/cotizador', [UserManagementController::class, 'updateCotizador'])->name('users.update-cotizador');
    Route::delete('users/{user}/cotizador', [UserManagementController::class, 'deleteCotizador'])->name('users.delete-cotizador');
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

// ─────────────────────────────────────────────
// Cotizador routes
// ─────────────────────────────────────────────
Route::prefix('cotizador')->name('cotizador.')->middleware(['auth', 'cotizador'])->group(function () {
    Route::get('/', [CotizadorController::class, 'dashboard'])->name('dashboard');

    // Plantillas de mensajes
    Route::get('templates', [CotizadorController::class, 'templates'])->name('templates');
    Route::get('templates/create', [CotizadorController::class, 'createTemplate'])->name('templates.create');
    Route::post('templates', [CotizadorController::class, 'storeTemplate'])->name('templates.store');
    Route::get('templates/{template}/edit', [CotizadorController::class, 'editTemplate'])->name('templates.edit');
    Route::put('templates/{template}', [CotizadorController::class, 'updateTemplate'])->name('templates.update');
    Route::delete('templates/{template}', [CotizadorController::class, 'destroyTemplate'])->name('templates.destroy');
    Route::get('templates/{template}/body', [CotizadorController::class, 'templateBody'])->name('templates.body');

    // Envío de cotizaciones
    Route::get('quotes/send', [CotizadorController::class, 'sendQuoteForm'])->name('quotes.send');
    Route::post('quotes/send', [CotizadorController::class, 'sendQuote'])->name('quotes.send.post');
    Route::get('quotes/history', [CotizadorController::class, 'quotesHistory'])->name('quotes.history');

    // Cuentas de correo
    Route::get('email-accounts', [CotizadorController::class, 'emailAccounts'])->name('email-accounts');
    Route::get('email-accounts/create', [CotizadorController::class, 'createEmailAccount'])->name('email-accounts.create');
    Route::post('email-accounts', [CotizadorController::class, 'storeEmailAccount'])->name('email-accounts.store');
    Route::get('email-accounts/{emailAccount}/edit', [CotizadorController::class, 'editEmailAccount'])->name('email-accounts.edit');
    Route::put('email-accounts/{emailAccount}', [CotizadorController::class, 'updateEmailAccount'])->name('email-accounts.update');
    Route::delete('email-accounts/{emailAccount}', [CotizadorController::class, 'destroyEmailAccount'])->name('email-accounts.destroy');

    // Bandeja de entrada
    Route::get('inbox', [CotizadorController::class, 'inbox'])->name('inbox');
    Route::post('inbox/sync', [CotizadorController::class, 'syncInbox'])->name('inbox.sync');
    Route::get('inbox/{inboxEmail}', [CotizadorController::class, 'showEmail'])->name('inbox.show');
    Route::post('inbox/{inboxEmail}/reply', [CotizadorController::class, 'replyEmail'])->name('inbox.reply');
    Route::get('inbox/{inboxEmail}/attachment/{attachment}/download', [CotizadorController::class, 'downloadInboxAttachment'])->name('inbox.attachment.download');

    // Clientes
    Route::get('clients', [CotizadorController::class, 'clients'])->name('clients');
    Route::get('clients/create', [CotizadorController::class, 'createClient'])->name('clients.create');
    Route::post('clients', [CotizadorController::class, 'storeClient'])->name('clients.store');
    Route::get('clients/{client}/edit', [CotizadorController::class, 'editClient'])->name('clients.edit');
    Route::put('clients/{client}', [CotizadorController::class, 'updateClient'])->name('clients.update');
    Route::delete('clients/{client}', [CotizadorController::class, 'destroyClient'])->name('clients.destroy');
});

// Rutas para descargar attachments (accesibles para usuario autenticado, usuario verificado)
// IMPORTANTE: Deben ir ANTES de la ruta dinámica /{service}
Route::middleware(['auth', 'user-verified'])->group(function () {
    Route::prefix('download')->group(function () {
        Route::get('attachment/{attachment}', [ClassificationController::class, 'downloadAttachment'])->name('attachments.download');
        Route::get('correction-attachment/{attachment}', [ClassificationController::class, 'downloadCorrectionAttachment'])->name('corrections.attachments.download');
    });
});

// Ruta para cambiar idioma
Route::get('/lang/{locale}', [LanguageController::class, 'setLanguage'])->name('lang.set');

// Página legal
Route::get('/privacidad', function () {
    return view('privacidad');
})->name('privacidad');

// Rutas públicas de artículos (blog)
Route::get('/blog', [ArticlePublicController::class, 'index'])->name('articles.index');
Route::get('/blog/{slug}', [ArticlePublicController::class, 'show'])->name('articles.show');

// Ruta para comentarios en artículos
Route::post('/articles/{article}/comments', [ArticleCommentController::class, 'store'])->name('articles.comments.store');

// Sitemap dinámico
Route::get('/sitemap.xml', function () {
    $services = \App\Models\Service::where('published', true)->get();
    $articles = \App\Models\Article::where('published', true)->get();
    return response()
        ->view('sitemap', compact('services', 'articles'))
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// Rutas públicas de servicios (dinámicas por slug)
Route::get('{service}', [ServiceController::class, 'show']);
