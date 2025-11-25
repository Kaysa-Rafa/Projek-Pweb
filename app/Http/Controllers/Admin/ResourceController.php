<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Category;
use App\Http\Requests\ResourceStoreRequest;
// use App\Http\Requests\ResourceUpdateRequest; // Dihapus karena belum digunakan
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Ditambahkan untuk Str::slug()

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
            // Pastikan Anda telah membuat model Resource
            $resource = Resource::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title), // Menggunakan Str yang sudah di-import
                'description' => $request->description,
                'installation_instructions' => $request->installation_instructions,
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'file_path' => 'temp/path', // Temporary
                'file_size' => 1024, // Temporary
                'file_type' => 'application/zip', // Temporary
                'version' => $request->version,
                'is_approved' => true, // Auto-approve for now
            ]);

            return redirect()->route('resources.show', $resource)
                ->with('success', 'Resource uploaded successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Upload failed: ' . $e->getMessage())
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