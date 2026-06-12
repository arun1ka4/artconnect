@extends('layouts.public')

@section('title', 'Berita')

@section('content')
<div class="py-4" style="background:linear-gradient(135deg,#1a1a2e,#6F42C1);color:#fff">
    <div class="container py-3">
        <h1 class="mb-1" style="font-size:2rem">Berita & Informasi</h1>
        <p class="mb-0 opacity-75">Kabar terkini dari dunia seni komunitas ArtConnect</p>
    </div>
</div>

<div class="container py-5">
    {{-- Search & Filter --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('news.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label small fw-500 text-muted">Cari Berita</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                   placeholder="Ketik judul berita..." value="{{ $search }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-500 text-muted">Filter Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter me-1"></i>Filter
                        </button>
                    </div>
                </div>
                @if($search || $categoryId)
                <div class="mt-2">
                    <a href="{{ route('news.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x me-1"></i>Reset Filter
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    @if($news->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-newspaper fs-2 d-block mb-2"></i>
        <p>{{ ($search || $categoryId) ? 'Tidak ada berita yang sesuai dengan filter.' : 'Belum ada berita.' }}</p>
    </div>
    @else
    <div class="row g-4">
        @foreach($news as $item)
        <div class="col-md-6 col-lg-4">
            <div class="news-card card h-100">
                @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                @else
                <div class="d-flex align-items-center justify-content-center bg-light"
                     style="height:200px;font-size:3rem;color:#ccc">
                    <i class="bi bi-image"></i>
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <span class="badge badge-category">{{ $item->category->name }}</span>
                    </div>
                    <h5 class="card-title mb-2" style="font-size:1rem;line-height:1.5">
                        <a href="{{ route('news.show', $item->slug) }}"
                           class="text-dark text-decoration-none">{{ $item->title }}</a>
                    </h5>
                    <p class="card-text text-muted small flex-grow-1">
                        {{ Str::limit(strip_tags($item->content), 100) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="text-muted small">
                            <i class="bi bi-person me-1"></i>{{ $item->user->name }}
                        </span>
                        <span class="text-muted small">
                            <i class="bi bi-calendar3 me-1"></i>{{ $item->publish_date->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($news->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $news->links() }}
    </div>
    @endif
    @endif
</div>
@endsection
