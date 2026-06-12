@extends('layouts.admin')

@section('title', 'Edit Foto')
@section('page-title', 'Edit Foto Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header py-3 px-4">
                <i class="bi bi-pencil me-2 text-primary"></i>Edit Foto
            </div>
            <div class="card-body p-4">
                <div class="mb-4 text-center">
                    <img src="{{ asset('storage/' . $galleryImage->image) }}"
                         style="max-height:240px;border-radius:12px;object-fit:cover;max-width:100%" alt="">
                </div>
                <form action="{{ route('admin.gallery-images.update', [$gallery, $galleryImage]) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Ganti Gambar</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp">
                        <div class="form-text">Kosongkan jika tidak ingin mengganti gambar.</div>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="caption" class="form-control @error('caption') is-invalid @enderror"
                               value="{{ old('caption', $galleryImage->caption) }}"
                               placeholder="Tambahkan keterangan foto...">
                        @error('caption')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Simpan
                        </button>
                        <a href="{{ route('admin.galleries.show', $gallery) }}"
                           class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
