@extends('layouts.admin')

@section('title', 'Detail Galeri')
@section('page-title', 'Detail Galeri')

@section('content')
{{-- Header --}}
<div class="card mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-4 align-items-start">
            @if($gallery->cover_image)
            <img src="{{ asset('storage/' . $gallery->cover_image) }}"
                 style="width:120px;height:90px;object-fit:cover;border-radius:12px" alt="">
            @endif
            <div class="flex-grow-1">
                <h4 class="mb-1">{{ $gallery->title }}</h4>
                <p class="text-muted mb-2">{{ $gallery->description ?? 'Tidak ada deskripsi.' }}</p>
                <span class="badge bg-light text-dark">{{ $gallery->images->count() }} foto</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.gallery-images.create', $gallery) }}" class="btn btn-primary">
                    <i class="bi bi-cloud-upload me-1"></i>Upload Foto
                </a>
                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Photo Grid --}}
<div class="card">
    <div class="card-header py-3 px-4">
        <i class="bi bi-images me-2 text-primary"></i>Koleksi Foto
    </div>
    <div class="card-body p-4">
        @if($gallery->images->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-cloud-upload fs-2 d-block mb-2"></i>
            Belum ada foto. <a href="{{ route('admin.gallery-images.create', $gallery) }}">Upload sekarang</a>
        </div>
        @else
        <div class="row g-3">
            @foreach($gallery->images as $image)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100" style="border-radius:10px;overflow:hidden">
                    <img src="{{ asset('storage/' . $image->image) }}"
                         style="height:160px;object-fit:cover" alt="{{ $image->caption }}">
                    <div class="card-body p-2">
                        <p class="small text-muted mb-2" style="min-height:2.5rem">
                            {{ $image->caption ?? '—' }}
                        </p>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.gallery-images.edit', [$gallery, $image]) }}"
                               class="btn btn-sm btn-outline-primary flex-grow-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.gallery-images.destroy', [$gallery, $image]) }}"
                                  method="POST" onsubmit="return confirm('Hapus foto ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
