<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Category;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::latest()->paginate(8);
        return view('resources.index', compact('resources'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('resources.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'installation_instructions' => 'nullable',
            'category_id' => 'required',
            'resource_file' => 'required|file',
            'version' => 'nullable',
            'tags' => 'nullable|array',
            'custom_tags' => 'nullable|string'
        ]);

        // Upload file
        $filePath = $request->file('resource_file')->store('resources', 'public');

        // Gabungkan tag bawaan + custom tags
        $tags = $request->tags ?? [];

        if ($request->custom_tags) {
            $custom = array_map('trim', explode(',', $request->custom_tags));
            $tags = array_merge($tags, $custom);
        }

        // Buat record
        Resource::create([
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'description' => $request->description,
            'installation_instructions' => $request->installation_instructions,
            'category_id' => $request->category_id,
            'file_path' => $filePath,
            'version' => $request->version,
            'tags' => json_encode($tags),
            'download_count' => 0
        ]);

        return redirect()->route('resources.index')->with('success', 'Resource uploaded successfully!');
    }

    public function show(Resource $resource)
    {
        return view('resources.show', compact('resource'));
    }

    public function edit(Resource $resource)
    {
        $categories = Category::all();
        return view('resources.edit', compact('resource', 'categories'));
    }

    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'title'       => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $resource->update($request->all());

        return redirect()->route('resources.index')->with('success', 'Resource updated!');
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();
        return redirect()->route('resources.index')->with('success', 'Resource deleted!');
    }
}