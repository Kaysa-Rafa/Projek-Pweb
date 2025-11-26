<!-- resources/views/resources/show.blade.php -->
@extends('layouts.app')

@section('title', $resource->title . ' - Hive Workshop')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('resources.index') }}">Resources</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.show', $resource->category) }}">{{ $resource->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($resource->title, 30) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="h2 fw-bold mb-2">{{ $resource->title }}</h1>
                            <div class="d-flex align-items-center text-muted mb-3">
                                <span class="badge bg-info me-2">{{ $resource->category->name }}</span>
                                <small class="me-3">
                                    <i class="fas fa-user me-1"></i>{{ $resource->user->name }}
                                </small>
                                <small class="me-3">
                                    <i class="fas fa-clock me-1"></i>{{ $resource->created_at->diffForHumans() }}
                                </small>
                                @if(!$resource->is_approved)
                                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Download Button -->
                        @if($resource->is_approved && ($resource->is_public || auth()->id() === $resource->user_id))
                            <a href="{{ route('resources.download', $resource) }}" 
                               class="btn btn-success btn-lg"
                               onclick="return confirm('Download resource ini?')">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                        @elseif(!$resource->is_approved && auth()->id() === $resource->user_id)
                            <span class="badge bg-warning fs-6">Menunggu Approval</span>
                        @endif
                    </div>

                    <!-- File Info -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-file me-2"></i>File Info:</strong>
                                    <ul class="list-unstyled mt-2">
                                        <li><small>Nama: {{ $resource->original_filename }}</small></li>
                                        <li><small>Ukuran: {{ $resource->file_size_formatted }}</small></li>
                                        <li><small>Format: {{ strtoupper($resource->file_extension) }}</small></li>
                                        <li><small>Versi: {{ $resource->version }}</small></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="fas fa-chart-bar me-2"></i>Statistik:</strong>
                                    <ul class="list-unstyled mt-2">
                                        <li><small>Downloads: {{ $resource->download_count }}</small></li>
                                        <li><small>Views: {{ $resource->view_count }}</small></li>
                                        <li><small>Status: {{ $resource->is_public ? 'Public' : 'Private' }}</small></li>
                                        <li><small>Rating: {{ number_format($resource->average_rating, 1) }}/5</small></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h5 class="fw-bold">Deskripsi</h5>
                        <p class="text-muted" style="white-space: pre-line;">{{ $resource->description }}</p>
                    </div>

                    <!-- Update Notes -->
                    @if($resource->update_notes)
                        <div class="mb-4">
                            <h5 class="fw-bold">Catatan Update</h5>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ $resource->update_notes }}
                            </div>
                        </div>
                    @endif

                    <!-- Tags -->
                    @if($resource->tags->count() > 0)
                        <div class="mb-4">
                            <h5 class="fw-bold">Tags</h5>
                            <div>
                                @foreach($resource->tags as $tag)
                                    <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Author Actions -->
            @if(auth()->id() === $resource->user_id)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Kelola Resource</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('resources.edit', $resource) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i>Edit Resource
                            </a>
                            @if(!$resource->is_approved)
                                <small class="text-muted text-center mt-2">
                                    <i class="fas fa-clock me-1"></i>Menunggu persetujuan admin
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- File Info Card -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi File</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas {{ $resource->file_icon }} fa-3x text-primary"></i>
                    </div>
                    <table class="table table-sm">
                        <tr>
                            <td><small>Format:</small></td>
                            <td><small>{{ strtoupper($resource->file_extension) }}</small></td>
                        </tr>
                        <tr>
                            <td><small>Ukuran:</small></td>
                            <td><small>{{ $resource->file_size_formatted }}</small></td>
                        </tr>
                        <tr>
                            <td><small>Versi:</small></td>
                            <td><small>{{ $resource->version }}</small></td>
                        </tr>
                        <tr>
                            <td><small>Status:</small></td>
                            <td>
                                <small>
                                    @if($resource->is_approved)
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection