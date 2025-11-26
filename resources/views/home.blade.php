<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home - Hive Workshop')

@section('content')
<div class="container py-4">
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary mb-3">Welcome to Hive Workshop</h1>
        <p class="lead text-muted">Your community hub for sharing and discovering Warcraft III resources</p>
        
        <div class="mt-4">
            <a href="{{ route('resources.index') }}" class="btn btn-primary btn-lg me-3">
                <i class="fas fa-search me-2"></i>Browse Resources
            </a>
            @auth
                <a href="{{ route('resources.create') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-upload me-2"></i>Submit Resource
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Join Community
                </a>
            @endauth
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-primary mb-3">
                        <i class="fas fa-box fa-3x"></i>
                    </div>
                    <h3 class="card-title">{{ \App\Models\Resource::count() }}</h3>
                    <p class="card-text text-muted">Total Resources</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-success mb-3">
                        <i class="fas fa-download fa-3x"></i>
                    </div>
                    <h3 class="card-title">{{ \App\Models\Resource::sum('download_count') }}</h3>
                    <p class="card-text text-muted">Total Downloads</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-purple mb-3">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <h3 class="card-title">{{ \App\Models\User::count() }}</h3>
                    <p class="card-text text-muted">Community Members</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">Browse by Category</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-4 col-lg-2 mb-3">
                        <a href="{{ route('categories.show', $category) }}" 
                           class="card category-card text-decoration-none text-center h-100">
                            <div class="card-body">
                                <div class="text-primary mb-2" style="font-size: 2rem;">
                                    {{ $category->icon }}
                                </div>
                                <h6 class="card-title text-dark">{{ $category->name }}</h6>
                                <small class="text-muted">
                                    {{ $category->resources->count() }} resources
                                </small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Resources Section -->
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Recently Added</h3>
            <a href="{{ route('resources.index') }}" class="btn btn-light btn-sm">
                View All <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body">
            @if($recentResources->count() > 0)
                <div class="row">
                    @foreach($recentResources as $resource)
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
                                        <span class="badge bg-info">{{ $resource->category->name }}</span>
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
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No resources yet. Be the first to submit one!</p>
                    @auth
                        <a href="{{ route('resources.create') }}" class="btn btn-warning">
                            Submit Resource
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.category-card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection