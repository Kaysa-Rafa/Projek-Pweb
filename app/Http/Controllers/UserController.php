<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan dashboard khusus pengguna (user).
     */
    public function dashboard()
    {
        $user = Auth::user();
        // Logika untuk menampilkan data spesifik pengguna (misal: pesanan terbaru)

        return view('user.dashboard', compact('user'));
    }

    /**
     * Menampilkan dan menangani pembaruan profil pengguna.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // Method untuk mengupdate profil (updateProfile) juga bisa ditambahkan di sini.
}