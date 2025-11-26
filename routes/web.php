<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// PUBLIC
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/categories/{slug}', [CategoryController::class, 'show'])
    ->name('categories.show');

// RESOURCES
Route::get('/resources', [ResourceController::class, 'index'])
    ->name('resources.index');

// 👇👇👇 IMPORTANT: CREATE HARUS DI ATAS /{resource}
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/resources/create', [ResourceController::class, 'create'])
        ->name('resources.create');

    Route::post('/resources', [ResourceController::class, 'store'])
        ->name('resources.store');
});

// 👇 INI PENTING: letakkan show PALING BAWAH
Route::get('/resources/{resource}', [ResourceController::class, 'show'])
    ->name('resources.show');

// Auth Routes
require __DIR__.'/auth.php';
