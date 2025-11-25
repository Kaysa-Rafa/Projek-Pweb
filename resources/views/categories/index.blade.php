<!-- resources/views/categories/index.blade.php -->
@extends('layouts.app')

@section('title', 'Categories - Hive Workshop Community')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Resource Categories</h1>
    <p class="text-gray-600">Browse our collection of Warcraft III resources by category</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($categories as $category)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 hover-scale">
            <div class="p-6 text-center">
                <div class="text-4xl mb-4">{{ $category->icon }}</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $category->name }}</h3>
                <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                <a href="{{ route('categories.show', $category) }}" 
                   class="inline-block bg-{{ $category->color }}-500 text-white px-6 py-2 rounded-lg hover:bg-{{ $category->color }}-400 transition">
                    Explore Resources
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection