<!-- resources/views/categories/show.blade.php -->
@extends('layouts.app')

@section('title', $category->name . ' - HiveWorkshop Clone')

@section('content')
<div class="mb-8">
    <div class="flex items-center space-x-4 mb-4">
        <div class="text-4xl">{{ $category->icon }}</div>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $category->name }}</h1>
            <p class="text-gray-600">{{ $category->description }}</p>
        </div>
    </div>
</div>

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
                        <span class="bg-{{ $category->color }}-100 text-{{ $category->color }}-800 text-xs px-2 py-1 rounded">
                            {{ $category->name }}
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
            <h3 class="text-2xl font-bold text-gray-800 mb-2">No Resources in {{ $category->name }}</h3>
            <p class="text-gray-600 mb-6">
                There are no resources in this category yet.
            </p>
            @auth
                <a href="{{ route('resources.create') }}" 
                   class="inline-block bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition duration-200">
                    <i class="fas fa-upload mr-2"></i>Submit Resource
                </a>
            @endif
        </div>
    </div>
@endif
@endsection