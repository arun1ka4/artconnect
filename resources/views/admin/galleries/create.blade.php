@extends('layouts.admin')

@section('title', 'Tambah Galeri')
@section('page-title', 'Tambah Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header py-3 px-4">
                <i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Galeri Baru
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul Galeri <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" placeholder="Masukkan judul galeri...">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="4" placeholder="Deskripsi singkat galeri...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Cover Image</label>
                        <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp" onchange="previewImage(this)">
                        <div class="form-text">Format: jpg, jpeg, png, webp. Maks 2MB.</div>
                        @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="previewWrap" class="mt-2" style="display:none">
                            <img id="imagePreview" src="" style="max-height:180px;border-radius:10px;object-fit:cover" alt="">
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Simpan
                        </button>
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('previewWrap').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
