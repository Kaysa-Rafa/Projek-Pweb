<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Admin\AdminController; // <-- PASTIKAN ADA
use App\Models\Resource;
use Illuminate\Support\Facades\Route;

// Homepage - TAMPILKAN HOME BLADE KITA
Route::get('/', function () {
    return view('home');
})->name('home');

// Resource Routes
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');

// Resource Routes (BUTUH AUTH)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/resources/upload', [ResourceController::class, 'create'])->name('resources.upload');
    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
    Route::get('/resources/{resource}/download', [DownloadController::class, 'download'])->name('resources.download');
    Route::get('/my-resources', [ResourceController::class, 'userResources'])->name('resources.my');
});

// Search Route
Route::get('/search', [SearchController::class, 'index'])->name('search');

// --- ADMIN ROUTES (Perbaikan untuk error RouteNotFound) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard'); 
});

// Profile Routes (Breeze default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';