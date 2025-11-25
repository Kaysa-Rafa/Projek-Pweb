<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes (Tanpa Login)
|--------------------------------------------------------------------------
| Semua user, termasuk Guest (belum login), dapat mengakses rute ini.
*/

// Homepage
Route::get('/', function () {
    return view('home');
})->name('home');

// Melihat Resource (Index & Detail)
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes (User & Admin)
|--------------------------------------------------------------------------
| Rute yang membutuhkan user sudah login (middleware: auth) dan terverifikasi email (verified).
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // DOWNLOAD: Membutuhkan Login
    Route::get('/resources/{resource}/download', [DownloadController::class, 'download'])->name('resources.download');

    // RESOURCE MANAGEMENT (UPLOAD): Membutuhkan Gate 'manage-resources' (User atau Admin)
    Route::get('/resources/upload', [ResourceController::class, 'create'])->name('resources.upload')->can('manage-resources');
    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store')->can('manage-resources');
    
    // My Resources
    Route::get('/my-resources', [ResourceController::class, 'userResources'])->name('resources.my');
    
    // PROFIL (Breeze Default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Admin ONLY)
|--------------------------------------------------------------------------
| Rute yang hanya bisa diakses oleh Admin (middleware: auth & can:access-admin-panel).
*/

Route::middleware(['auth', 'can:access-admin-panel'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard'); 

});

require __DIR__.'/auth.php';