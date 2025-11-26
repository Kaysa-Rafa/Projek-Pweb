<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Resource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $resources = \App\Models\Resource::where('category_id', $category->id)
            ->with('user')
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'resources'));
    }

}
