<?php
// app/Http/Controllers/ResourceController.php
namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Download;
use App\Http\Requests\ResourceStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resources.
     */
    public function index(Request $request)
    {
        $query = Resource::with(['user', 'category', 'tags'])
            ->where('is_approved', true)
            ->latest();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('tags', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $resources = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('resources.index', compact('resources', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('resources.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResourceStoreRequest $request)
    {
        try {
            // Handle file upload
            if ($request->hasFile('resource_file')) {
                $file = $request->file('resource_file');
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $mimeType = $file->getMimeType();
                
                // Generate unique filename
                $filename = 'resource_' . time() . '_' . Str::random(10) . '.' . $extension;
                $filePath = $file->storeAs('resources', $filename, 'public');
                
                // Create resource
                $resource = Resource::create([
                    'user_id' => auth()->id(),
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'slug' => Str::slug($request->title) . '-' . Str::random(6),
                    'description' => $request->description,
                    'file_path' => $filePath,
                    'original_filename' => $originalName,
                    'file_extension' => $extension,
                    'file_mime_type' => $mimeType,
                    'file_size' => $file->getSize(),
                    'version' => $request->version,
                    'update_notes' => $request->update_notes,
                    'is_public' => $request->boolean('is_public'),
                    'is_approved' => false, // Menunggu approval admin
                ]);

                // Handle tags
                if ($request->tags) {
                    $tagNames = explode(',', $request->tags);
                    $tagIds = [];
                    
                    foreach ($tagNames as $tagName) {
                        $tagName = trim($tagName);
                        if (!empty($tagName)) {
                            $tag = Tag::firstOrCreate(['name' => $tagName], [
                                'slug' => Str::slug($tagName)
                            ]);
                            $tagIds[] = $tag->id;
                        }
                    }
                    
                    $resource->tags()->sync($tagIds);
                }

                return redirect()->route('resources.show', $resource)
                    ->with('success', 'Resource berhasil diupload! Menunggu persetujuan admin.');
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi error saat upload: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        // Increment view count
        $resource->increment('view_count');
        
        $resource->load(['user', 'category', 'tags', 'ratings.user']);
        
        return view('resources.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        // Authorization - hanya pemilik yang bisa edit
        if (auth()->id() !== $resource->user_id && !auth()->user()->isAdmin()) {
            return redirect()->route('resources.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit resource ini.');
        }

        $categories = Category::where('is_active', true)->get();
        $currentTags = $resource->tags->pluck('name')->implode(', ');
        
        return view('resources.edit', compact('resource', 'categories', 'currentTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        // Authorization
        if (auth()->id() !== $resource->user_id && !auth()->user()->isAdmin()) {
            return redirect()->route('resources.index')
                ->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|min:10|max:2000',
            'version' => 'required|string|max:20',
            'update_notes' => 'nullable|string|max:1000',
            'tags' => 'nullable|string|max:255',
            'is_public' => 'boolean',
        ]);

        $resource->update($validated);

        // Update tags
        if ($request->tags) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];
            
            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);
                if (!empty($tagName)) {
                    $tag = Tag::firstOrCreate(['name' => $tagName], [
                        'slug' => Str::slug($tagName)
                    ]);
                    $tagIds[] = $tag->id;
                }
            }
            
            $resource->tags()->sync($tagIds);
        }

        return redirect()->route('resources.show', $resource)
            ->with('success', 'Resource berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        // Authorization
        if (auth()->id() !== $resource->user_id && !auth()->user()->isAdmin()) {
            return redirect()->route('resources.index')
                ->with('error', 'Akses ditolak.');
        }

        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($resource->file_path)) {
                Storage::disk('public')->delete($resource->file_path);
            }

            // Delete resource
            $resource->delete();

            return redirect()->route('resources.index')
                ->with('success', 'Resource berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi error saat menghapus: ' . $e->getMessage());
        }
    }

    /**
     * Download the specified resource.
     */
    public function download(Resource $resource)
    {
        // Check if resource is approved and public
        if (!$resource->is_approved) {
            return redirect()->back()->with('error', 'Resource belum disetujui untuk didownload.');
        }

        if (!$resource->is_public && auth()->id() !== $resource->user_id) {
            return redirect()->back()->with('error', 'Resource ini bersifat private.');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($resource->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        try {
            // Record download
            Download::create([
                'user_id' => auth()->id(),
                'resource_id' => $resource->id,
                'ip_address' => request()->ip(),
            ]);

            // Increment download count
            $resource->incrementDownloadCount();

            // Get file path and original name
            $filePath = Storage::disk('public')->path($resource->file_path);
            $originalName = $resource->original_filename ?: 'download.' . $resource->file_extension;

            // Return download response
            return response()->download($filePath, $originalName, [
                'Content-Type' => $resource->file_mime_type,
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi error saat download: ' . $e->getMessage());
        }
    }
}