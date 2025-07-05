<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// JSON API routes for prototyping
Route::prefix('api')->group(function () {
    Route::get('contacts', [ContactController::class, 'index']);
    Route::get('contacts/{contact}', [ContactController::class, 'show']);
    Route::post('contacts', [ContactController::class, 'store']);
    Route::put('contacts/{contact}', [ContactController::class, 'update']);
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy']);
    Route::get('zodiacs', [ContactController::class, 'zodiacs']);
    Route::get('contacts-stats', [ContactController::class, 'stats']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
