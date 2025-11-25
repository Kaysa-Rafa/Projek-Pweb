<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Tampilkan form upload.
     */
    public function showForm()
    {
        return view('upload');
    }

    /**
     * Proses upload file.
     */
    public function store(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Simpan file ke storage/app/public/uploads
        $path = $request->file('file')->store('uploads', 'public');

        // Kembalikan ke form dengan pesan sukses
        return back()->with('success', 'File berhasil diupload ke: ' . $path);
    }
}