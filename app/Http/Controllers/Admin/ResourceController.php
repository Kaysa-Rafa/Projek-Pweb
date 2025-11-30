<?php

namespace App\Http\Controllers\Admin;

use App\Models\Resource;
use App\Models\Category;
use App\Http\Requests\ResourceStoreRequest;
use App\Http\Controllers\Controller;
// use App\Http\Requests\ResourceUpdateRequest; // Dihapus karena belum digunakan
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    protected $fileService;

    // Pastikan FileService ada di app/Services/FileService.php
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        $query = Resource::with(['user', 'category', 'tags']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('download_count', 'desc');
                break;
            case 'rating':
                // Perlu field rating di tabel resources
                $query->orderBy('rating', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $resources = $query->paginate(20);
        $categories = Category::all();

        return view('resources.index', compact('resources', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        // Mengatasi error 404 karena rute ini sekarang aktif
        return view('resources.create', compact('categories'));
    }

    public function show(Resource $resource)
    {
        // Increment view count
        $resource->increment('view_count');
        
        $resource->load(['user', 'category', 'tags', 'comments.user']);
        
        return view('resources.show', compact('resource'));
    }

    public function store(ResourceStoreRequest $request)
    {
        try {
            // 1. Definisikan variabel default
            $filePath = null;
            $fileSize = 0;
            $fileType = 'unknown';
            $originalName = null;

            // 2. Cek apakah ada file yang diupload
            // PENTING: Pastikan name di form HTML adalah name="resource_file" atau sesuaikan di sini
            if ($request->hasFile('resource_file')) { 
                $file = $request->file('resource_file');
                
                $originalName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                $fileType = $file->getMimeType();
                
                // Buat nama unik agar tidak bentrok
                $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                
                // Simpan ke folder storage/app/public/resources
                $filePath = $file->storeAs('resources', $filename, 'public');
            } else {
                // Opsional: Jika file wajib, return error
                // return redirect()->back()->with('error', 'File wajib diupload!');
            }

            // 3. Simpan ke Database
            $resource = Resource::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'installation_instructions' => $request->installation_instructions,
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                
                // Simpan path yang didapat dari proses upload di atas
                'file_path' => $filePath, 
                'file_size' => $fileSize,
                'file_type' => $fileType,
                'original_filename' => $originalName,
                
                'version' => $request->version,
                'is_approved' => true, // Admin upload langsung approved
            ]);

            return redirect()->route('resources.show', $resource)
                ->with('success', 'Resource berhasil diupload!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Upload gagal: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function userResources(Request $request)
    {
        $resources = Resource::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(20);

        return view('resources.user-index', compact('resources'));
    }
}