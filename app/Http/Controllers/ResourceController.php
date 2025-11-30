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
        $query = Resource::with(['user', 'category', 'tags'])
            ->where('is_approved', true) 
            ->latest();

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
        $request->validate([
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'required|string|min:10',
            'version'       => 'required|string|max:20',
            'resource_file' => 'required|file|max:51200|extensions:zip,rar,7z,w3x,w3m,map,jpg,jpeg,png,pdf,doc,docx,txt',
            'is_public'     => 'nullable',
        ]);

        try {
            if ($request->hasFile('resource_file')) {
                $file = $request->file('resource_file');
                
                $originalName = $file->getClientOriginalName();
                $extension    = $file->getClientOriginalExtension();
                $mimeType     = $file->getMimeType();
                $fileSize     = $file->getSize();

                $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
                $filePath = $file->storeAs('resources', $filename, 'public');

                $resource = Resource::create([
                    'user_id'           => Auth::id(),
                    'category_id'       => $request->category_id,
                    'title'             => $request->title,
                    'slug'              => Str::slug($request->title) . '-' . Str::random(5),
                    'description'       => $request->description,
                    'file_path'         => $filePath,
                    'original_filename' => $originalName,
                    'file_extension'    => $extension,
                    'file_mime_type'    => $mimeType,
                    'file_size'         => $fileSize,
                    'version'           => $request->version,
                    'update_notes'      => $request->update_notes,
                    'is_public'         => $request->has('is_public') ? true : false,
                    'is_approved'       => true, // Auto Approve
                    'download_count'    => 0,
                    'view_count'        => 0,
                ]);

                return redirect()->route('resources.show', $resource)
                    ->with('success', 'Resource berhasil diupload dan dipublikasikan!');
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
     * Menampilkan form edit resource.
     */
    public function edit(Resource $resource)
    {
        // Otorisasi: Hanya Pemilik atau Admin
        if (Auth::id() !== $resource->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('resources.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit resource ini.');
        }

        $categories = Category::all();
        return view('resources.edit', compact('resource', 'categories'));
    }

    /**
     * Update resource di database.
     */
    public function update(Request $request, Resource $resource)
    {
        // Otorisasi
        if (Auth::id() !== $resource->user_id && Auth::user()->role !== 'admin') {
            return abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'required|string|min:10',
            'version'       => 'required|string|max:20',
            'resource_file' => 'nullable|file|max:51200|extensions:zip,rar,7z,w3x,w3m,map,jpg,jpeg,png,pdf,doc,docx,txt',
            'is_public'     => 'nullable',
        ]);

        try {
            // Update Data Teks
            $resource->title = $request->title;
            $resource->category_id = $request->category_id;
            $resource->description = $request->description;
            $resource->version = $request->version;
            $resource->update_notes = $request->update_notes;
            
            // Handle checkbox is_public
            // Jika dicentang di form, request punya key 'is_public', jika tidak maka null/false
            $resource->is_public = $request->has('is_public');

            // Cek Jika Ada File Baru Diupload
            if ($request->hasFile('resource_file')) {
                // Hapus file lama
                if ($resource->file_path && Storage::disk('public')->exists($resource->file_path)) {
                    Storage::disk('public')->delete($resource->file_path);
                }

                // Upload file baru
                $file = $request->file('resource_file');
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
                $filePath = $file->storeAs('resources', $filename, 'public');

                // Update info file
                $resource->file_path = $filePath;
                $resource->original_filename = $originalName;
                $resource->file_extension = $extension;
                $resource->file_mime_type = $file->getMimeType();
                $resource->file_size = $file->getSize();
            }

            $resource->save();

            return redirect()->route('resources.show', $resource)
                ->with('success', 'Resource berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Update gagal: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus resource dari database dan storage.
     */
    public function destroy(Resource $resource)
    {
        // Otorisasi
        if (Auth::id() !== $resource->user_id && Auth::user()->role !== 'admin') {
            return abort(403, 'Unauthorized action.');
        }

        // Hapus Fisik File
        if ($resource->file_path && Storage::disk('public')->exists($resource->file_path)) {
            Storage::disk('public')->delete($resource->file_path);
        }

        // Hapus Data Database
        $resource->delete();

        return redirect()->route('resources.index')
            ->with('success', 'Resource berhasil dihapus.');
    }

    /**
     * Proses Download File.
     */
    public function download(Resource $resource)
    {
        if (!$resource->is_public && Auth::id() !== $resource->user_id) {
            return back()->with('error', 'Resource ini bersifat private.');
        }

        if (!$resource->is_approved && Auth::id() !== $resource->user_id) {
            return back()->with('error', 'Resource belum disetujui.');
        }

        if (!Storage::disk('public')->exists($resource->file_path)) {
            return back()->with('error', 'File tidak ditemukan di server (404).');
        }

        if (Auth::check()) {
            Download::create([
                'user_id'     => Auth::id(),
                'resource_id' => $resource->id,
                'ip_address'  => request()->ip(),
            ]);
        }

        $resource->increment('download_count');

        return Storage::disk('public')->download(
            $resource->file_path, 
            $resource->original_filename
        );
    }
}