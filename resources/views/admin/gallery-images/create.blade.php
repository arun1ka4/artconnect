@extends('layouts.admin')

@section('title', 'Upload Foto')
@section('page-title', 'Upload Foto Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center gap-3">
                    @if($gallery->cover_image)
                    <img src="{{ asset('storage/' . $gallery->cover_image) }}"
                         style="width:50px;height:50px;object-fit:cover;border-radius:8px" alt="">
                    @endif
                    <div>
                        <div class="fw-600">{{ $gallery->title }}</div>
                        <div class="text-muted small">{{ $gallery->images()->count() }} foto tersimpan</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-3 px-4">
                <i class="bi bi-cloud-upload me-2 text-primary"></i>Upload Foto Baru
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.gallery-images.store', $gallery) }}" method="POST"
                      enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Pilih Foto <span class="text-danger">*</span></label>
                        <div id="dropZone" class="border border-2 border-dashed rounded-3 p-5 text-center"
                             style="cursor:pointer;border-color:#6F42C1!important;background:#faf8ff">
                            <i class="bi bi-cloud-upload text-primary" style="font-size:2.5rem"></i>
                            <div class="mt-2 fw-500">Klik atau seret file ke sini</div>
                            <div class="text-muted small mt-1">JPG, JPEG, PNG, WEBP • Maks 2MB per file • Bisa banyak file</div>
                            <input type="file" name="images[]" id="imageFiles" multiple
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   class="@error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                   style="display:none" onchange="handleFiles(this)">
                        </div>
                        @error('images')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        @error('images.*')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- Preview grid --}}
                    <div id="previewGrid" class="row g-2 mb-4" style="display:none!important"></div>

                    {{-- Captions --}}
                    <div id="captionsSection" style="display:none">
                        <label class="form-label">Keterangan Foto (opsional)</label>
                        <div id="captionInputs"></div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary px-4" id="submitBtn" disabled>
                            <i class="bi bi-cloud-upload me-2"></i>Upload Foto
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

@push('scripts')
<script>
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('imageFiles');
const previewGrid = document.getElementById('previewGrid');
const captionsSection = document.getElementById('captionsSection');
const captionInputs = document.getElementById('captionInputs');
const submitBtn = document.getElementById('submitBtn');

dropZone.addEventListener('click', () => fileInput.click());
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.background = '#f0ebff'; });
dropZone.addEventListener('dragleave', () => dropZone.style.background = '#faf8ff');
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.style.background = '#faf8ff';
    fileInput.files = e.dataTransfer.files;
    handleFiles(fileInput);
});

function handleFiles(input) {
    if (!input.files.length) return;
    previewGrid.innerHTML = '';
    captionInputs.innerHTML = '';
    previewGrid.style.cssText = '';
    captionsSection.style.display = 'block';
    submitBtn.disabled = false;

    Array.from(input.files).forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = e => {
            previewGrid.innerHTML += `
                <div class="col-6 col-md-3">
                    <img src="${e.target.result}" class="w-100 rounded-3" style="height:110px;object-fit:cover" alt="">
                    <div class="small text-muted mt-1 text-truncate">${file.name}</div>
                </div>`;
        };
        reader.readAsDataURL(file);

        captionInputs.innerHTML += `
            <div class="mb-2">
                <input type="text" name="captions[]" class="form-control form-control-sm"
                       placeholder="Keterangan foto ${idx + 1} (opsional)">
            </div>`;
    });
}
</script>
@endpush
