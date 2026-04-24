<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleMediaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Article Media Routes
Route::middleware('auth:web')->group(function () {
    Route::get('/articles/{article}/media', [ArticleMediaController::class, 'index']);
    Route::post('/articles/{article}/media', [ArticleMediaController::class, 'store']);
    Route::post('/articles/{article}/media/reorder', [ArticleMediaController::class, 'updateOrder']);
    Route::delete('/articles/{article}/media/{media}', [ArticleMediaController::class, 'destroy']);
});
