<!-- resources/views/resources/create.blade.php -->
@extends('layouts.app')

@section('title', 'Upload Resource - Hive Workshop')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Resource Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Resource <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            <div class="form-text">Jelaskan secara detail tentang resource Anda.</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="resource_file" class="form-label">File Resource <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('resource_file') is-invalid @enderror" 
                                   id="resource_file" name="resource_file" accept=".zip,.rar,.7z,.w3x,.w3m,.map,.jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt" required>
                            <div class="form-text">
                                Format yang didukung: ZIP, RAR, 7Z, W3X, W3M, MAP, Images, PDF, DOC, TXT. Maksimal 50MB.
                            </div>
                            @error('resource_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Version -->
                        <div class="mb-3">
                            <label for="version" class="form-label">Versi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('version') is-invalid @enderror" 
                                   id="version" name="version" value="{{ old('version', '1.0') }}" required>
                            @error('version')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Update Notes -->
                        <div class="mb-3">
                            <label for="update_notes" class="form-label">Catatan Update</label>
                            <textarea class="form-control @error('update_notes') is-invalid @enderror" 
                                      id="update_notes" name="update_notes" rows="2">{{ old('update_notes') }}</textarea>
                            <div class="form-text">Jelaskan perubahan atau update pada versi ini (opsional).</div>
                            @error('update_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                   id="tags" name="tags" value="{{ old('tags') }}" placeholder="warcraft, map, custom, hd">
                            <div class="form-text">Pisahkan tags dengan koma (opsional).</div>
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Privacy -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" checked>
                                <label class="form-check-label" for="is_public">
                                    Resource Public (dapat dilihat dan didownload oleh semua user)
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('resources.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-1"></i> Upload Resource
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Upload Guidelines -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Panduan Upload</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Pastikan file yang diupload tidak melanggar hak cipta</li>
                        <li>Gunakan judul yang deskriptif dan jelas</li>
                        <li>Berikan deskripsi yang detail tentang resource Anda</li>
                        <li>Resource akan ditinjau terlebih dahulu oleh admin sebelum dipublikasikan</li>
                        <li>File yang diupload akan disimpan secara aman</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// File size validation
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('resource_file');
    const maxSize = 50 * 1024 * 1024; // 50MB in bytes
    
    if (fileInput.files.length > 0) {
        const fileSize = fileInput.files[0].size;
        if (fileSize > maxSize) {
            e.preventDefault();
            alert('Ukuran file terlalu besar! Maksimal 50MB.');
            return false;
        }
    }
});

// Show file name
document.getElementById('resource_file').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        const label = this.previousElementSibling;
        label.textContent = 'File Resource: ' + fileName;
    }
});
</script>
@endsection