<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Category;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    /**
     * Menampilkan daftar resource.
     */
    public function index(Request $request)
    {
        // Hanya tampilkan yang is_approved = true
        // Karena sekarang auto-approve, semua file baru akan langsung muncul
        $query = Resource::with(['user', 'category', 'tags'])
            ->where('is_approved', true) 
            ->latest();

        // Fitur Pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $resources = $query->paginate(12);
        $categories = Category::all();

        return view('resources.index', compact('resources', 'categories'));
    }

    /**
     * Menampilkan form upload.
     */
    public function create()
    {
        $categories = Category::all();
        return view('resources.create', compact('categories'));
    }

    /**
     * Proses Simpan (Upload) Resource.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'required|string|min:10',
            'version'       => 'required|string|max:20',
            'resource_file' => 'required|file|max:51200|extensions:zip,rar,7z,w3x,w3m,map,jpg,jpeg,png,pdf,doc,docx,txt',
            'is_public'     => 'nullable',
        ]);

        try {
            // 2. Proses Upload File
            if ($request->hasFile('resource_file')) {
                $file = $request->file('resource_file');
                
                // Ambil data teknis file
                $originalName = $file->getClientOriginalName();
                $extension    = $file->getClientOriginalExtension();
                $mimeType     = $file->getMimeType();
                $fileSize     = $file->getSize();

                // Buat nama file unik untuk disimpan di server
                $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
                
                // Simpan ke folder 'resources' di storage public
                $filePath = $file->storeAs('resources', $filename, 'public');

                // 3. Simpan ke Database
                $resource = Resource::create([
                    'user_id'           => Auth::id(),
                    'category_id'       => $request->category_id,
                    'title'             => $request->title,
                    'slug'              => Str::slug($request->title) . '-' . Str::random(5),
                    'description'       => $request->description,
                    
                    // Data File
                    'file_path'         => $filePath,
                    'original_filename' => $originalName,
                    'file_extension'    => $extension,
                    'file_mime_type'    => $mimeType,
                    'file_size'         => $fileSize,
                    
                    'version'           => $request->version,
                    'update_notes'      => $request->update_notes,
                    'is_public'         => $request->has('is_public') ? true : false,
                    
                    // --- PERUBAHAN DI SINI ---
                    'is_approved'       => true, // LANGSUNG TRUE (AUTO APPROVE)
                    // -------------------------
                    
                    'download_count'    => 0,
                    'view_count'        => 0,
                ]);

                // Handle Tags jika ada (logika sederhana)
                if ($request->tags) {
                    // $resource->tags()->sync(...);
                }

                return redirect()->route('resources.show', $resource)
                    ->with('success', 'Resource berhasil diupload dan langsung dipublikasikan!');
            }

            return back()->with('error', 'Gagal mengupload file.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail resource.
     */
    public function show(Resource $resource)
    {
        $resource->increment('view_count');
        return view('resources.show', compact('resource'));
    }

    /**
     * Proses Download File.
     */
    public function download(Resource $resource)
    {
        // 1. Cek Permission (Public / Private / Owner)
        if (!$resource->is_public && Auth::id() !== $resource->user_id) {
            return back()->with('error', 'Resource ini bersifat private.');
        }

        // 2. Cek Approval (Sekarang auto-approve, tapi pengecekan ini tetap bagus untuk keamanan)
        if (!$resource->is_approved && Auth::id() !== $resource->user_id) {
            return back()->with('error', 'Resource belum disetujui.');
        }

        // 3. Cek Fisik File
        if (!Storage::disk('public')->exists($resource->file_path)) {
            return back()->with('error', 'File tidak ditemukan di server (404).');
        }

        // 4. Catat History Download
        if (Auth::check()) {
            Download::create([
                'user_id'     => Auth::id(),
                'resource_id' => $resource->id,
                'ip_address'  => request()->ip(),
            ]);
        }

        // 5. Tambah Counter
        $resource->increment('download_count');

        // 6. Download
        return Storage::disk('public')->download(
            $resource->file_path, 
            $resource->original_filename
        );
    }

    // Method dummy
    public function edit(Resource $resource) { return abort(404); }
    public function update(Request $request, Resource $resource) { return abort(404); }
    public function destroy(Resource $resource) { return abort(404); }
}