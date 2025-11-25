<!-- resources/views/resources/index.blade.php -->
@extends('layouts.app')

@section('title', 'Resources - Hive Workshop Community')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Community Resources</h1>
            <p class="text-gray-600">Discover and download resources shared by our community</p>
        </div>
        @auth
            <a href="{{ route('resources.create') }}" 
               class="bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition duration-200">
                <i class="fas fa-upload mr-2"></i>Submit Resource
            </a>
        @endauth
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form action="{{ route('resources.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:space-x-4">
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       name="search" 
                       placeholder="Search resources..." 
                       value="{{ request('search') }}"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="md:w-64">
            <select name="category" 
                    class="block w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Categories</option>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" 
                class="w-full md:w-auto bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-400 transition duration-200">
            Search
        </button>
    </form>
</div>

<!-- Resources Grid -->
@php
    $resources = \App\Models\Resource::with('user', 'category')
        ->latest()
        ->paginate(12);
@endphp

@if($resources->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($resources as $resource)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 hover-scale">
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-lg">
                            <a href="{{ route('resources.show', $resource) }}" 
                               class="text-gray-800 hover:text-blue-600 transition duration-200">
                                {{ $resource->title }}
                            </a>
                        </h3>
                        <span class="bg-{{ $resource->category->color }}-100 text-{{ $resource->category->color }}-800 text-xs px-2 py-1 rounded">
                            {{ $resource->category->name }}
                        </span>
                    </div>
                    
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                        {{ Str::limit($resource->description, 120) }}
                    </p>

                    <div class="flex justify-between items-center text-sm text-gray-600">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($resource->user->name) }}&background=random" 
                                 alt="{{ $resource->user->name }}"
                                 class="w-6 h-6 rounded-full mr-2">
                            {{ $resource->user->name }}
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <span class="flex items-center" title="Downloads">
                                <i class="fas fa-download mr-1"></i>
                                {{ $resource->download_count }}
                            </span>
                            <span class="flex items-center" title="Rating">
                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                {{ number_format($resource->average_rating, 1) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="bg-white rounded-lg shadow-md p-4">
        {{ $resources->links() }}
    </div>
@else
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <div class="max-w-md mx-auto">
            <i class="fas fa-inbox text-6xl text-gray-400 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">No Resources Found</h3>
            <p class="text-gray-600 mb-6">
                @if(request()->hasAny(['search', 'category']))
                    Try adjusting your search filters or 
                @endif
                Be the first to share your creation with the community!
            </p>
            @auth
                <a href="{{ route('resources.create') }}" 
                   class="inline-block bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition duration-200">
                    <i class="fas fa-upload mr-2"></i>Share Your Resource
                </a>
            @else
                <div class="space-y-3">
                    <p class="text-gray-600">Ready to contribute?</p>
                    <a href="{{ route('register') }}" 
                       class="inline-block bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-400 transition duration-200">
                        Join Our Community
                    </a>
                </div>
            @endauth
        </div>
    </div>
@endif
@endsection