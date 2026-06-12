@extends('layouts.public')

@section('title', 'Galeri')

@section('content')
<div class="py-4" style="background:linear-gradient(135deg,#1a1a2e,#6F42C1);color:#fff">
    <div class="container py-3">
        <h1 class="mb-1" style="font-size:2rem">Galeri Karya</h1>
        <p class="mb-0 opacity-75">Koleksi karya seni terbaik anggota komunitas ArtConnect</p>
    </div>
</div>

<div class="container py-5">
    @if($galleries->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-images fs-2 d-block mb-2"></i>
        <p>Belum ada galeri yang tersedia.</p>
    </div>
    @else
    <div class="row g-4">
        @foreach($galleries as $gallery)
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('galleries.show', $gallery) }}" class="text-decoration-none">
                <div class="gallery-card card position-relative">
                    @if($gallery->cover_image)
                    <img src="{{ asset('storage/' . $gallery->cover_image) }}"
                         class="card-img-top" alt="{{ $gallery->title }}">
                    @else
                    <div class="d-flex align-items-center justify-content-center"
                         style="height:220px;background:linear-gradient(135deg,#f0ebff,#e8e0ff);font-size:3.5rem;color:#9b6dff">
                        <i class="bi bi-images"></i>
                    </div>
                    @endif
                    <div class="gallery-overlay">
                        <h6 class="text-white mb-1 fw-600">{{ $gallery->title }}</h6>
                        <small class="text-white-50">
                            <i class="bi bi-image me-1"></i>{{ $gallery->images_count }} foto
                        </small>
                    </div>
                </div>
                @if($gallery->description)
                <p class="mt-2 text-muted small px-1">{{ Str::limit($gallery->description, 80) }}</p>
                @endif
            </a>
        </div>
        @endforeach
    </div>

    @if($galleries->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $galleries->links() }}
    </div>
    @endif
    @endif
</div>
@endsection
