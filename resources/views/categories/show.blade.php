<!-- resources/views/categories/show.blade.php -->
@extends('layouts.app')

@section('title', $category->name . ' - Hive Workshop')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="d-flex align-items-center mb-4">
        <div class="text-primary me-3" style="font-size: 2.5rem;">
            {{ $category->icon }}
        </div>
        <div>
            <h1 class="h2 fw-bold text-dark mb-1">{{ $category->name }}</h1>
            <p class="text-muted mb-0">{{ $category->description }}</p>
        </div>
    </div>

    <!-- Resources Grid -->
    @if($resources->count() > 0)
        <div class="row">
            @foreach($resources as $resource)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">
                                    <a href="{{ route('resources.show', $resource) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $resource->title }}
                                    </a>
                                </h5>
                                <span class="badge bg-info">{{ $category->name }}</span>
                            </div>
                            
                            <p class="card-text text-muted small">
                                {{ Str::limit($resource->description, 100) }}
                            </p>
                            
                            <div class="d-flex justify-content-between text-muted small">
                                <span>
                                    <i class="fas fa-user me-1"></i>
                                    {{ $resource->user->name }}
                                </span>
                                <span>
                                    <i class="fas fa-download me-1"></i>
                                    {{ $resource->download_count }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('resources.show', $resource) }}" 
                               class="btn btn-outline-primary btn-sm w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $resources->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No Resources in {{ $category->name }}</h4>
            <p class="text-muted">There are no resources in this category yet.</p>
            @auth
                <a href="{{ route('resources.create') }}" class="btn btn-warning">
                    Submit Resource
                </a>
            @endif
        </div>
    @endif
</div>
@endsection