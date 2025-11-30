@extends('layouts.app')

@section('title', 'Edit Resource - Hive Workshop')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Resource</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('resources.update', $resource->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label for="title" class="form-label">Judul Resource <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $resource->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ (old('category_id', $resource->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $resource->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="resource_file" class="form-label">Ganti File Resource (Opsional)</label>
                            <input type="file" class="form-control @error('resource_file') is-invalid @enderror" 
                                   id="resource_file" name="resource_file" accept=".zip,.rar,.7z,.w3x,.w3m,.map,.jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt">
                            <div class="form-text text-muted">
                                File saat ini: <strong>{{ $resource->original_filename }}</strong><br>
                                Biarkan kosong jika tidak ingin mengganti file.
                            </div>
                            @error('resource_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="version" class="form-label">Versi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('version') is-invalid @enderror" 
                                   id="version" name="version" value="{{ old('version', $resource->version) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="update_notes" class="form-label">Catatan Update</label>
                            <textarea class="form-control @error('update_notes') is-invalid @enderror" 
                                      id="update_notes" name="update_notes" rows="2" placeholder="Apa yang baru di versi ini?">{{ old('update_notes', $resource->update_notes) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="is_public" value="0">
                                <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" 
                                    {{ old('is_public', $resource->is_public) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_public">
                                    Resource Public (Dapat dilihat dan didownload oleh semua user)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{ route('resources.show', $resource) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection