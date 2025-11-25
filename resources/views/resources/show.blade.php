<!-- resources/views/resources/show.blade.php -->
@extends('layouts.app')

@section('title', $resource->title . ' - HiveWorkshop')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('resources.index') }}" class="hover:text-blue-500">Resources</a></li>
            <li><i class="fas fa-chevron-right"></i></li>
            <li><a href="{{ route('categories.show', $resource->category) }}" 
                   class="hover:text-blue-500">{{ $resource->category->name }}</a></li>
            <li><i class="fas fa-chevron-right"></i></li>
            <li class="text-gray-800 font-medium">{{ Str::limit($resource->title, 50) }}</li>
        </ol>
    </nav>

    <!-- Main Resource Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $resource->title }}</h1>
                    <div class="flex items-center space-x-4 text-gray-600">
                        <span class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($resource->user->name) }}&background=random" 
                                 alt="{{ $resource->user->name }}"
                                 class="w-6 h-6 rounded-full mr-2">
                            {{ $resource->user->name }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $resource->created_at->diffForHumans() }}
                        </span>
                        <span class="bg-{{ $resource->category->color }}-100 text-{{ $resource->category->color }}-800 px-2 py-1 rounded text-sm">
                            {{ $resource->category->name }}
                        </span>
                    </div>
                </div>
                
                <!-- Download Button -->
                <form action="#" method="POST">
                    @csrf
                    <button type="submit" 
                            class="bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-400 transition duration-200 flex items-center">
                        <i class="fas fa-download mr-2"></i>
                        Download ({{ $resource->download_count }})
                    </button>
                </form>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $resource->download_count }}</div>
                    <div class="text-sm text-gray-600">Downloads</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">
                        {{ number_format($resource->average_rating, 1) }}
                    </div>
                    <div class="text-sm text-gray-600">Rating</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $resource->view_count }}</div>
                    <div class="text-sm text-gray-600">Views</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-600">v{{ $resource->version }}</div>
                    <div class="text-sm text-gray-600">Version</div>
                </div>
            </div>

            <!-- Description -->
            <div class="prose max-w-none mb-6">
                <h3 class="text-xl font-semibold mb-3">Description</h3>
                <p class="text-gray-700 leading-relaxed">{{ $resource->description }}</p>
            </div>

            <!-- Update Notes -->
            @if($resource->update_notes)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Update Notes</h3>
                    <p class="text-blue-700">{{ $resource->update_notes }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection