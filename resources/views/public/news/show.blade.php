@extends('layouts.public')

@section('title', $news->title)
@section('description', Str::limit(strip_tags($news->content), 160))

@section('content')
<div class="py-4" style="background:linear-gradient(135deg,#1a1a2e,#6F42C1);color:#fff">
    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider-color:rgba(255,255,255,.5)">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('news.index') }}" class="text-white-50 text-decoration-none">Berita</a></li>
                <li class="breadcrumb-item active text-white">{{ Str::limit($news->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        {{-- Article --}}
        <div class="col-lg-8">
            <article>
                <div class="mb-3">
                    <span class="badge badge-category">{{ $news->category->name }}</span>
                </div>
                <h1 class="mb-3" style="font-size:2rem;line-height:1.3">{{ $news->title }}</h1>
                <div class="d-flex flex-wrap gap-3 text-muted small mb-4 pb-3 border-bottom">
                    <span><i class="bi bi-person-circle me-1"></i>{{ $news->user->name }}</span>
                    <span><i class="bi bi-calendar3 me-1"></i>{{ $news->publish_date->format('d F Y') }}</span>
                    <span><i class="bi bi-tags me-1"></i>{{ $news->category->name }}</span>
                </div>

                @if($news->image)
                <img src="{{ asset('storage/' . $news->image) }}"
                     class="img-fluid rounded-3 mb-4 w-100"
                     style="max-height:420px;object-fit:cover" alt="{{ $news->title }}">
                @endif

                <div class="article-content" style="font-size:1.05rem;line-height:1.9;color:#444">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </article>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="sticky-top" style="top:80px">
                {{-- Related --}}
                @if($relatedNews->isNotEmpty())
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 fw-600"><i class="bi bi-newspaper me-2 text-primary"></i>Berita Terkait</h6>
                    </div>
                    <div class="card-body p-0">
                        @foreach($relatedNews as $related)
                        <a href="{{ route('news.show', $related->slug) }}"
                           class="d-flex gap-3 p-3 text-decoration-none text-dark border-bottom"
                           style="transition:background .2s" onmouseover="this.style.background='#faf8ff'" onmouseout="this.style.background=''">
                            @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}"
                                 style="width:60px;height:50px;object-fit:cover;border-radius:8px;flex-shrink:0" alt="">
                            @else
                            <div style="width:60px;height:50px;background:#f0ebff;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;color:#6F42C1">
                                <i class="bi bi-image"></i>
                            </div>
                            @endif
                            <div>
                                <div class="small fw-500 lh-sm mb-1">{{ Str::limit($related->title, 55) }}</div>
                                <div class="text-muted" style="font-size:.75rem">{{ $related->publish_date->format('d M Y') }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <a href="{{ route('news.index') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Berita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
