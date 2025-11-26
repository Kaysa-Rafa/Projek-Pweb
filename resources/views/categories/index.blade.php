<!-- resources/views/categories/index.blade.php -->
@extends('layouts.app')

@section('title', 'Categories - Hive Workshop')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold text-dark">Resource Categories</h1>
        <p class="text-muted mb-0">Browse resources by category</p>
    </div>

    <div class="row">
        @foreach($categories as $category)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="text-primary mb-3" style="font-size: 3rem;">
                            {{ $category->icon }}
                        </div>
                        <h4 class="card-title text-dark">{{ $category->name }}</h4>
                        <p class="card-text text-muted">{{ $category->description }}</p>
                        <div class="mt-3">
                            <span class="badge bg-secondary">
                                {{ $category->resources->count() }} resources
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-center">
                        <a href="{{ route('categories.show', $category) }}" 
                           class="btn btn-primary w-100">
                            Browse Resources
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection