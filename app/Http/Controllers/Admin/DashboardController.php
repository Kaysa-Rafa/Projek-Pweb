<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Jangan lupa impor Controller dasar
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Admin.
     */
    public function index()
    {
        // Logika untuk menghitung statistik admin (total user, total produk, dll.)
        $totalUsers = User::count();
        $totalProducts = Product::count();

        return view('admin.dashboard', compact('totalUsers', 'totalProducts'));
    }

    /**
     * Menampilkan halaman pengaturan umum.
     */
    public function settings()
    {
        return view('admin.settings');
    }
}