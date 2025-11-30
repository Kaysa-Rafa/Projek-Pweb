<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Wajib ada

class DownloadController extends Controller
{
    public function download(Resource $resource)
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mendownload.');
        }

        // 2. Cek apakah file fisik ada di storage
        // Pastikan sudah menjalankan: php artisan storage:link
        if (!Storage::disk('public')->exists($resource->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server (Fisik file hilang).');
        }

        try {
            // 3. Catat History Download
            Download::create([
                'user_id' => Auth::id(),
                'resource_id' => $resource->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // 4. Tambah counter download di tabel resources
            $resource->increment('download_count');

            // 5. PROSES DOWNLOAD
            // Mengambil path file dari database dan mendownloadnya
            // Argumen kedua adalah nama file yang akan dilihat user saat didownload
            $downloadName = $resource->original_filename ?? basename($resource->file_path);
            
            return Storage::disk('public')->download($resource->file_path, $downloadName);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses download: ' . $e->getMessage());
        }
    }
}