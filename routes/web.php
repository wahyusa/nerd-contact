<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ContactControllerAPI;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// JSON API routes for prototyping
Route::prefix('api')->group(function () {
    Route::get('contacts', [ContactControllerAPI::class, 'index']);
    Route::get('contacts/{contact}', [ContactControllerAPI::class, 'show']);
    Route::post('contacts', [ContactControllerAPI::class, 'store']);
    Route::put('contacts/{contact}', [ContactControllerAPI::class, 'update']);
    Route::delete('contacts/{contact}', [ContactControllerAPI::class, 'destroy']);
    Route::get('zodiacs', [ContactControllerAPI::class, 'zodiacs']);
    Route::get('contacts-stats', [ContactControllerAPI::class, 'stats']);
});

// Fullstack Vue with inertia JS
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
