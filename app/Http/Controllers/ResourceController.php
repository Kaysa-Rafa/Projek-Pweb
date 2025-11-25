<?php
// app/Http/Controllers/ResourceController.php
namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Category;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::with('user', 'category')
            ->latest()
            ->paginate(12);

        return view('resources.index', compact('resources'));
    }

    public function show(Resource $resource)
    {
        $resource->load('user', 'category', 'tags');
        
        // Increment view count
        $resource->increment('view_count');
        
        return view('resources.show', compact('resource'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('resources.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Untuk sementara, redirect ke index
        return redirect()->route('resources.index')
            ->with('success', 'Resource creation will be implemented soon!');
    }
}