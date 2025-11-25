<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home - HiveWorkshop')

@section('content')
<!-- Hero Section -->
<div class="text-center mb-12">
    <h1 class="text-5xl font-bold text-gray-800 mb-4">Welcome to HiveWorkshop Clone</h1>
    <p class="text-xl text-gray-600 mb-8">A community platform for sharing and discovering Warcraft III resources</p>
    
    <div class="flex justify-center space-x-4">
        <a href="{{ route('resources.index') }}" 
           class="bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-400 transition duration-200">
            <i class="fas fa-search mr-2"></i>Browse Resources
        </a>
        @auth
            <a href="{{ route('resources.create') }}" 
               class="bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition duration-200">
                <i class="fas fa-upload mr-2"></i>Submit Resource
            </a>
        @else
            <a href="{{ route('register') }}" 
               class="bg-green-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-400 transition duration-200">
                <i class="fas fa-user-plus mr-2"></i>Join Community
            </a>
        @endauth
    </div>
</div>

<!-- Stats Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <div class="text-3xl text-blue-500 mb-2">
            <i class="fas fa-box"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Total Resources</h3>
        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Resource::count() }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <div class="text-3xl text-green-500 mb-2">
            <i class="fas fa-download"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Total Downloads</h3>
        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Resource::sum('download_count') }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <div class="text-3xl text-purple-500 mb-2">
            <i class="fas fa-users"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Community Members</h3>
        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
    </div>
</div>

<!-- Categories Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-12">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Browse by Category</h2>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach(\App\Models\Category::all() as $category)
            <a href="{{ route('categories.show', $category) }}" 
               class="bg-{{ $category->color }}-100 text-{{ $category->color }}-800 p-4 rounded-lg text-center hover:bg-{{ $category->color }}-200 transition duration-200 hover-scale">
                <div class="text-2xl mb-2">{{ $category->icon }}</div>
                <h3 class="font-semibold">{{ $category->name }}</h3>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $category->resources_count ?? 0 }} resources
                </p>
            </a>
        @endforeach
    </div>
</div>

<!-- Recent Resources Section -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Recent Resources</h2>
        <a href="{{ route('resources.index') }}" 
           class="text-blue-500 hover:text-blue-400 font-semibold">
            View All <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    @php
        $recentResources = \App\Models\Resource::with('user', 'category')
            ->latest()
            ->take(6)
            ->get();
    @endphp
    
    @if($recentResources->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentResources as $resource)
                <div class="border border-gray-200 rounded-lg hover:shadow-lg transition duration-200 hover-scale">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-lg">
                                <a href="{{ route('resources.show', $resource) }}" 
                                   class="text-gray-800 hover:text-blue-600 transition">
                                    {{ $resource->title }}
                                </a>
                            </h3>
                            <span class="bg-{{ $resource->category->color }}-100 text-{{ $resource->category->color }}-800 text-xs px-2 py-1 rounded">
                                {{ $resource->category->name }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            {{ Str::limit($resource->description, 100) }}
                        </p>
                        
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span class="flex items-center">
                                <i class="fas fa-user mr-1"></i>
                                {{ $resource->user->name }}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-download mr-1"></i>
                                {{ $resource->download_count }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500">No resources yet. Be the first to submit one!</p>
            @auth
                <a href="{{ route('resources.create') }}" 
                   class="inline-block mt-4 bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg font-semibold hover:bg-yellow-400 transition">
                    Submit Resource
                </a>
            @endif
        </div>
    @endif
</div>
@endsection