<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');

// Test Routes
Route::get('/test-data', function () {
    return [
        'users' => \App\Models\User::count(),
        'categories' => \App\Models\Category::count(),
        'resources' => \App\Models\Resource::count(),
    ];
});

// Auth routes (from Breeze)
require __DIR__.'/auth.php';