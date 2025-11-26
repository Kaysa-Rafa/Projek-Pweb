@extends('layouts.app')

@section('content')
<div class="container my-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Daftar Resources</h2>

        @auth
            <a href="{{ route('resources.create') }}" class="btn btn-primary">
                + Tambah Resource
            </a>
        @endauth
    </div>

    {{-- Search Bar --}}
    <form action="{{ route('resources.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Cari judul / kategori..." 
                value="{{ request('search') }}">
            <button class="btn btn-outline-secondary">Cari</button>
        </div>
    </form>

    {{-- Jika tidak ada data --}}
    @if ($resources->count() == 0)
        <div class="alert alert-warning">Tidak ada resource ditemukan.</div>
    @endif

    {{-- Card List --}}
    <div class="row">
        @foreach ($resources as $resource)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">

                        {{-- Judul --}}
                        <h5 class="fw-bold">{{ $resource->title }}</h5>

                        {{-- Kategori --}}
                        <span class="badge bg-info mb-2">
                            {{ $resource->category->name ?? 'Tanpa Kategori' }}
                        </span>

                        {{-- Deskripsi --}}
                        <p class="text-muted small" style="min-height: 60px">
                            {{ Str::limit($resource->description, 80) }}
                        </p>

                        {{-- Info User --}}
                        <p class="small text-secondary mb-1">
                            Upload oleh: {{ $resource->user->name }}
                        </p>

                        {{-- Downloads --}}
                        <p class="small text-secondary">
                            {{ $resource->download_count }} downloads
                        </p>

                    </div>

                    <div class="card-footer bg-white border-top-0">
                        <a href="{{ route('resources.show', $resource->id) }}" 
                           class="btn btn-sm btn-outline-primary w-100">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $resources->links() }}
    </div>

</div>
@endsection
