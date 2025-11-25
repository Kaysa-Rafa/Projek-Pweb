<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Role: user & admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // DOWNLOAD: Membutuhkan Login
    Route::get('/resources/{resource}/download', [DownloadController::class, 'download'])->name('resources.download');

    // UPLOAD: Membutuhkan Gate 'manage-resources'
    Route::get('/resources/upload', [ResourceController::class, 'create'])->name('resources.upload')->can('manage-resources');
    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store')->can('manage-resources');
    
    Route::get('/my-resources', [ResourceController::class, 'userResources'])->name('resources.my');
    
    // PROFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Role: admin ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'can:access-admin-panel'])->group(function () {
    // DASHBOARD ADMIN
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard'); 
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';