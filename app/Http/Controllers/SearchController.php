<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Resource::with(['user', 'category', 'tags']);
        
        // Search term
        if ($request->has('q') && $request->q) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
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
                $query->orderBy('rating', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $resources = $query->paginate(20);
        $categories = Category::all();

        return view('search.results', compact('resources', 'categories'));
    }
}