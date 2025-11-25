<?php
// app/Http/Controllers/CategoryController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Resource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $resources = Resource::where('category_id', $category->id)
            ->with('user')
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'resources'));
    }
}