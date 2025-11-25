<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan model ini ada
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function list()
    {
        // Mengambil semua produk dengan pagination
        $products = Product::paginate(12); 

        return view('products.list', compact('products'));
    }

    /**
     * Menampilkan detail satu produk berdasarkan ID.
     */
    public function show($id)
    {
        // Mencari produk atau hentikan jika tidak ditemukan (404)
        $product = Product::findOrFail($id); 

        return view('products.show', compact('product'));
    }
}