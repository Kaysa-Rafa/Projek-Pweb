<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResourceController; // Untuk user publik
use App\Http\Controllers\Admin\ResourceController as AdminResourceController; // Untuk admin
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;

// PUBLIC PAGES
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/categories/{slug}', [CategoryController::class, 'show'])
    ->name('categories.show');

// RESOURCES (PUBLIC LIST)
Route::get('/resources', [ResourceController::class, 'index'])
    ->name('resources.index');

// DOWNLOAD ROUTE (PENTING: Tambahkan ini agar tombol download berfungsi)
Route::get('/resources/{resource}/download', [ResourceController::class, 'download'])
    ->name('resources.download');

// AUTHENTICATED ROUTES
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CREATE & STORE (Harus di atas 'show')
    Route::get('/resources/create', [ResourceController::class, 'create'])
        ->name('resources.create');

    Route::post('/resources', [ResourceController::class, 'store'])
        ->name('resources.store');
        
    // EDIT & UPDATE & DESTROY
    Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])
        ->name('resources.edit');
        
    Route::put('/resources/{resource}', [ResourceController::class, 'update'])
        ->name('resources.update');
        
    Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])
        ->name('resources.destroy');
});

// SHOW DETAIL (Letakkan paling bawah agar tidak bentrok dengan /create)
Route::get('/resources/{resource}', [ResourceController::class, 'show'])
    ->name('resources.show');

// ADMIN ROUTES
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/resources', [AdminResourceController::class, 'index']);
    // Tambahkan rute admin lainnya di sini
});

// AUTH ROUTES
require __DIR__.'/auth.php';