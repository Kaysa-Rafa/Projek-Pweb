<?php
namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'resources_count' => Resource::count(),
            'downloads_count' => Resource::sum('download_count'),
            'users_count' => User::count(),
        ];

        $recentResources = Resource::with('user', 'category')
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::all();

        return view('home', compact('stats', 'recentResources', 'categories'));
    }
}