@extends('layouts.public')

@section('title', $gallery->title)

@section('content')
<div class="py-4" style="background:linear-gradient(135deg,#1a1a2e,#6F42C1);color:#fff">
    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('galleries.index') }}" class="text-white-50 text-decoration-none">Galeri</a></li>
                <li class="breadcrumb-item active text-white">{{ Str::limit($gallery->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    {{-- Gallery Header --}}
    <div class="row g-4 align-items-center mb-5">
        @if($gallery->cover_image)
        <div class="col-md-4">
            <img src="{{ asset('storage/' . $gallery->cover_image) }}"
                 class="img-fluid rounded-3 w-100" style="max-height:280px;object-fit:cover" alt="{{ $gallery->title }}">
        </div>
        @endif
        <div class="{{ $gallery->cover_image ? 'col-md-8' : 'col-12' }}">
            <span class="badge mb-2 px-3 py-2" style="background:#f0ebff;color:#6F42C1">
                <i class="bi bi-images me-1"></i>{{ $gallery->images->count() }} Foto
            </span>
            <h1 class="mb-3">{{ $gallery->title }}</h1>
            @if($gallery->description)
            <p class="text-muted mb-3" style="font-size:1.05rem;line-height:1.7">{{ $gallery->description }}</p>
            @endif
            <a href="{{ route('galleries.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    {{-- Photo Grid --}}
    @if($gallery->images->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-cloud-upload fs-2 d-block mb-2"></i>
        Galeri ini belum memiliki foto.
    </div>
    @else
    <div class="row g-3" id="photoGrid">
        @foreach($gallery->images as $image)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="position-relative overflow-hidden rounded-3"
                 style="cursor:pointer" onclick="openLightbox('{{ asset('storage/' . $image->image) }}', '{{ addslashes($image->caption ?? '') }}')">
                <img src="{{ asset('storage/' . $image->image) }}"
                     class="w-100" style="height:200px;object-fit:cover;transition:transform .3s"
                     onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
                     alt="{{ $image->caption }}">
                @if($image->caption)
                <div class="position-absolute bottom-0 start-0 end-0 p-2 text-white"
                     style="background:linear-gradient(transparent,rgba(0,0,0,.7));font-size:.78rem">
                    {{ $image->caption }}
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- Lightbox --}}
<div id="lightbox" onclick="closeLightbox()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;cursor:zoom-out;display:none;align-items:center;justify-content:center;flex-direction:column">
    <button onclick="closeLightbox()" style="position:absolute;top:1rem;right:1.5rem;background:none;border:none;color:#fff;font-size:2rem;cursor:pointer">
        <i class="bi bi-x-lg"></i>
    </button>
    <img id="lightboxImg" src="" style="max-height:85vh;max-width:90vw;border-radius:8px;object-fit:contain" alt="">
    <p id="lightboxCaption" class="text-white-50 mt-3 small"></p>
</div>
@endsection

@push('scripts')
<script>
function openLightbox(src, caption) {
    const lb = document.getElementById('lightbox');
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxCaption').textContent = caption;
    lb.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>
@endpush
