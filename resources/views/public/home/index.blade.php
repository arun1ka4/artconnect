@extends('layouts.public')

@section('title', 'Beranda')
@section('description', 'ArtConnect – Portal informasi komunitas seni Indonesia.')

@push('styles')
<style>
/* ── Carousel ── */
.ac-carousel { position: relative; overflow: hidden; background: var(--ac-dark); }
.ac-carousel .carousel-inner { aspect-ratio: 16/7; }
@media (max-width: 575px) { .ac-carousel .carousel-inner { aspect-ratio: 4/3; } }
.ac-carousel .carousel-item { height: 100%; }
.carousel-bg {
    position: absolute; inset: 0;
    background-size: cover; background-position: center;
}
.carousel-bg::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(26,26,46,.88) 0%, rgba(111,66,193,.55) 100%);
}
.carousel-caption-custom {
    position: absolute; inset: 0; z-index: 2;
    display: flex; align-items: center;
    padding: 2rem;
}
.carousel-caption-inner { max-width: 620px; }
.slide-tag {
    display: inline-flex; align-items: center; gap: .4rem;
    background: rgba(255,255,255,.15); backdrop-filter: blur(6px);
    color: #fff; border-radius: 50px;
    padding: .3rem .85rem; font-size: .78rem; font-weight: 600;
    letter-spacing: .04em; margin-bottom: 1rem;
}
.slide-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.5rem, 4vw, 2.5rem);
    font-weight: 700; color: #fff; line-height: 1.25;
    margin-bottom: .75rem;
}
.slide-desc { color: rgba(255,255,255,.8); font-size: .95rem; line-height: 1.6; margin-bottom: 0; }

/* Carousel indicators */
.ac-carousel .carousel-indicators [data-bs-target] {
    width: 28px; height: 4px; border-radius: 2px;
    background: rgba(255,255,255,.4); border: none; transition: all .3s;
}
.ac-carousel .carousel-indicators .active { background: #fff; width: 44px; }

/* Carousel controls */
.ac-carousel .carousel-control-prev,
.ac-carousel .carousel-control-next {
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,.15); backdrop-filter: blur(6px);
    top: 50%; transform: translateY(-50%);
    bottom: auto; margin: 0 1rem; opacity: .8;
    transition: background .2s, opacity .2s;
}
.ac-carousel .carousel-control-prev:hover,
.ac-carousel .carousel-control-next:hover { background: rgba(255,255,255,.3); opacity: 1; }
.ac-carousel .carousel-control-prev-icon,
.ac-carousel .carousel-control-next-icon { width: 18px; height: 18px; }

/* ── Welcome ── */
.welcome-section { padding: 5rem 0; background: #fff; }
.welcome-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    background: var(--ac-primary-light); color: var(--ac-primary);
    border-radius: 50px; padding: .35rem .9rem;
    font-size: .78rem; font-weight: 700; letter-spacing: .05em;
    margin-bottom: 1.25rem;
}
.welcome-title {
    font-size: clamp(1.6rem, 3.5vw, 2.6rem);
    font-weight: 700; line-height: 1.25;
    color: var(--ac-dark); margin-bottom: 1.1rem;
}
.welcome-desc { color: #666; font-size: 1.05rem; line-height: 1.8; max-width: 580px; }
.welcome-art {
    display: flex; align-items: center; justify-content: center;
    border-radius: 20px; overflow: hidden;
    background: linear-gradient(135deg, var(--ac-dark) 0%, var(--ac-primary) 60%, var(--ac-accent) 100%);
    min-height: 320px;
}

/* ── Section headers ── */
.section-header { margin-bottom: 2.5rem; }
.section-label {
    display: inline-block;
    font-size: .72rem; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: var(--ac-primary);
    margin-bottom: .5rem;
}
.section-title { font-size: clamp(1.4rem, 3vw, 2rem); color: var(--ac-dark); margin-bottom: .4rem; }
.section-sub { color: #888; font-size: .93rem; }

/* ── Gallery cards ── */
.art-card {
    border: none; border-radius: 14px; overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,.07);
    transition: transform .28s, box-shadow .28s;
    background: #fff;
}
.art-card:hover { transform: translateY(-5px); box-shadow: 0 10px 36px rgba(111,66,193,.18); }
.art-card-img { width: 100%; height: 210px; object-fit: cover; display: block; }
.art-card-body { padding: .9rem 1rem; }
.art-card-title { font-size: .95rem; font-weight: 600; color: var(--ac-dark); margin-bottom: .2rem; line-height: 1.4; }
.art-card-sub { font-size: .78rem; color: #999; }

/* Mobile slider for gallery section */
.art-slider-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
.art-slider-wrap::-webkit-scrollbar { display: none; }
.art-slider { display: flex; gap: 1rem; padding-bottom: .5rem; }
.art-slider .art-card { flex: 0 0 240px; }
@media (min-width: 768px) {
    .art-slider-wrap { overflow: visible; }
    .art-slider { flex-wrap: wrap; }
    .art-slider .art-card { flex: 1 1 calc(20% - 1rem); min-width: 0; }
}

/* ── Category cards ── */
.cat-card {
    border-radius: 16px; overflow: hidden; position: relative;
    cursor: pointer; text-decoration: none; display: block;
    box-shadow: 0 2px 14px rgba(0,0,0,.1);
    transition: transform .28s, box-shadow .28s;
}
.cat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 32px rgba(0,0,0,.18); }
.cat-card-img { width: 100%; height: 160px; object-fit: cover; display: block; }
.cat-card-overlay {
    position: absolute; inset: 0;
    display: flex; flex-direction: column;
    align-items: center; justify-content: flex-end;
    padding: 1.25rem 1rem;
    background: linear-gradient(transparent 30%, rgba(0,0,0,.72) 100%);
}
.cat-card-icon {
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(255,255,255,.2); backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.2rem; margin-bottom: .6rem;
}
.cat-card-name { color: #fff; font-size: .9rem; font-weight: 700; text-align: center; line-height: 1.2; }

/* Placeholder gradient covers when no image */
.cat-placeholder-0 { background: linear-gradient(135deg,#6F42C1,#9b6dff); }
.cat-placeholder-1 { background: linear-gradient(135deg,#e83e8c,#ff7eb9); }
.cat-placeholder-2 { background: linear-gradient(135deg,#0dcaf0,#36d9f5); }
.cat-placeholder-3 { background: linear-gradient(135deg,#fd7e14,#ffc107); }
.cat-placeholder-4 { background: linear-gradient(135deg,#198754,#34d399); }
.cat-placeholder-5 { background: linear-gradient(135deg,#dc3545,#ff6b6b); }
.cat-placeholder-6 { background: linear-gradient(135deg,#6610f2,#a855f7); }
.cat-placeholder-7 { background: linear-gradient(135deg,#20c997,#0ea5e9); }

/* ── About snippet ── */
.about-section { padding: 5rem 0; background: #fafafa; }
.about-card {
    background: #fff; border-radius: 20px;
    padding: 2.5rem; height: 100%;
    box-shadow: 0 2px 20px rgba(0,0,0,.06);
}
.about-icon {
    width: 56px; height: 56px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; margin-bottom: 1rem;
}

/* ── News section ── */
.news-section { padding: 5rem 0; background: #fff; }
.news-card-ac {
    border: none; border-radius: 14px;
    box-shadow: 0 2px 16px rgba(0,0,0,.07);
    overflow: hidden; transition: transform .25s, box-shadow .25s;
}
.news-card-ac:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(111,66,193,.18); }
.news-card-ac .card-img-top { height: 195px; object-fit: cover; }
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     1. CAROUSEL
══════════════════════════════════════════ --}}
<div id="heroCarousel" class="carousel slide ac-carousel" data-bs-ride="carousel" data-bs-interval="4500">

    {{-- Indicators --}}
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
    </div>

    <div class="carousel-inner">
        @php
        $slides = [
            [
                'tag'   => 'Pameran Seni',
                'title' => 'Festival Seni Lukis Nasional 2024',
                'desc'  => 'Ratusan karya seniman terbaik Indonesia hadir dalam satu panggung megah di Taman Ismail Marzuki.',
                'grad'  => 'linear-gradient(135deg,#1a1a2e 0%,#6F42C1 100%)',
                'icon'  => '🎨',
            ],
            [
                'tag'   => 'Galeri Unggulan',
                'title' => 'Fotografi Arsitektur Kota — Eksplorasi Visual',
                'desc'  => 'Memotret jiwa kota lewat lensa — sebuah perjalanan visual menemukan keindahan tersembunyi di sudut-sudut urban.',
                'grad'  => 'linear-gradient(135deg,#0f0c29,#302b63,#24243e)',
                'icon'  => '📸',
            ],
            [
                'tag'   => 'Workshop',
                'title' => 'Kelas Batik Tulis — Warisan Nusantara',
                'desc'  => 'Pelajari seni batik tulis dari pengrajin berpengalaman. Lestarikan warisan budaya UNESCO bersama komunitas.',
                'grad'  => 'linear-gradient(135deg,#1a1a2e,#8b1a1a)',
                'icon'  => '🖌️',
            ],
            [
                'tag'   => 'Event Komunitas',
                'title' => 'Konser Musik Etnik Nusantara — Satu Nada Satu Bangsa',
                'desc'  => 'Kolaborasi indah musisi dari 34 provinsi memainkan instrumen tradisional dalam harmoni yang memukau.',
                'grad'  => 'linear-gradient(135deg,#0d1117,#1a3a5c)',
                'icon'  => '🎵',
            ],
            [
                'tag'   => 'Karya Terpilih',
                'title' => 'Pameran Patung Kontemporer — Dimensi Baru',
                'desc'  => 'Karya tiga dimensi yang menggabungkan material tradisional dengan teknik modern — eksplorasi identitas dan ruang.',
                'grad'  => 'linear-gradient(135deg,#1a1a2e,#2d4a1e)',
                'icon'  => '🗿',
            ],
        ];
        @endphp

        @foreach($slides as $i => $slide)
        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
            <div class="carousel-bg" style="background: {{ $slide['grad'] }}">
                {{-- decorative shapes --}}
                <svg style="position:absolute;inset:0;width:100%;height:100%;opacity:.07" viewBox="0 0 800 400" preserveAspectRatio="xMidYMid slice">
                    <circle cx="650" cy="80"  r="200" fill="#fff"/>
                    <circle cx="100" cy="350" r="150" fill="#fff"/>
                    <circle cx="400" cy="200" r="80"  fill="none" stroke="#fff" stroke-width="2"/>
                </svg>
            </div>
            <div class="carousel-caption-custom">
                <div class="carousel-caption-inner">
                    <div class="slide-tag">
                        <span>{{ $slide['icon'] }}</span>
                        <span>{{ $slide['tag'] }}</span>
                    </div>
                    <h2 class="slide-title">{{ $slide['title'] }}</h2>
                    <p class="slide-desc d-none d-sm-block">{{ $slide['desc'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Controls --}}
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" aria-label="Sebelumnya">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" aria-label="Berikutnya">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>


{{-- ══════════════════════════════════════════
     2. WELCOME SECTION
══════════════════════════════════════════ --}}
<section class="welcome-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="welcome-badge">
                    <i class="bi bi-palette2"></i>Portal Komunitas Seni
                </div>
                <h1 class="welcome-title">
                    Menghubungkan Komunitas Seni Melalui Informasi dan Karya
                </h1>
                <p class="welcome-desc mb-4">
                    ArtConnect merupakan portal informasi komunitas seni yang menghadirkan berita,
                    galeri karya, dan berbagai aktivitas seni dalam satu platform.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('galleries.index') }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-images me-2"></i>Jelajahi Galeri
                    </a>
                    <a href="{{ route('news.index') }}" class="btn btn-outline-primary btn-lg px-4">
                        <i class="bi bi-newspaper me-2"></i>Baca Berita
                    </a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="welcome-art p-5">
                    <div class="text-center">
                        <div style="font-size:5rem;opacity:.5;line-height:1">🎨</div>
                        <div class="mt-3 d-flex justify-content-center gap-4 flex-wrap">
                            @php $stats = [['500+','Anggota'],['1000+','Berita'],['200+','Galeri'],['34','Provinsi']]; @endphp
                            @foreach($stats as $s)
                            <div class="text-center">
                                <div style="font-size:1.5rem;font-weight:700;color:#fff">{{ $s[0] }}</div>
                                <div style="font-size:.75rem;color:rgba(255,255,255,.6)">{{ $s[1] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════
     3. GALERI KARYA UNGGULAN (5 karya)
     Desktop: grid 5 kolom
     Mobile:  horizontal slider
══════════════════════════════════════════ --}}
<section style="padding:4rem 0;background:#f8f8fc">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-end flex-wrap gap-2">
            <div>
                <div class="section-label"><i class="bi bi-images me-1"></i>Karya Pilihan</div>
                <h2 class="section-title mb-1">Galeri Karya Unggulan</h2>
                <p class="section-sub">Lima karya terpilih dari anggota komunitas ArtConnect</p>
            </div>
            <a href="{{ route('galleries.index') }}" class="btn btn-outline-primary btn-sm">
                Semua Galeri <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @if($latestGalleries->isEmpty())
        <div class="text-center py-4 text-muted">Belum ada galeri tersedia.</div>
        @else
        <div class="art-slider-wrap">
            <div class="art-slider">
                @foreach($latestGalleries->take(5) as $gallery)
                <a href="{{ route('galleries.show', $gallery) }}" class="art-card text-decoration-none">
                    @if($gallery->cover_image)
                    <img src="{{ asset('storage/' . $gallery->cover_image) }}"
                         class="art-card-img" alt="{{ $gallery->title }}">
                    @else
                    <div class="art-card-img d-flex align-items-center justify-content-center"
                         style="background:linear-gradient(135deg,#f0ebff,#e8e0ff);color:#9b6dff;font-size:2.5rem">
                        <i class="bi bi-images"></i>
                    </div>
                    @endif
                    <div class="art-card-body">
                        <div class="art-card-title">{{ Str::limit($gallery->title, 36) }}</div>
                        <div class="art-card-sub">
                            <i class="bi bi-image me-1"></i>{{ $gallery->images_count }} foto
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>


{{-- ══════════════════════════════════════════
     4. KATEGORI SENI
══════════════════════════════════════════ --}}
<section style="padding:4rem 0;background:#fff">
    <div class="container">
        <div class="section-header text-center">
            <div class="section-label"><i class="bi bi-tags me-1"></i>Jelajahi</div>
            <h2 class="section-title">Kategori Seni</h2>
            <p class="section-sub">Temukan karya dan berita berdasarkan bidang seni yang Anda minati</p>
        </div>

        @php
        $catMeta = [
            ['icon' => 'bi-brush',          'color' => '#6F42C1'],
            ['icon' => 'bi-camera2',         'color' => '#e83e8c'],
            ['icon' => 'bi-hammer',          'color' => '#0dcaf0'],
            ['icon' => 'bi-music-note-beamed','color' => '#fd7e14'],
            ['icon' => 'bi-person-arms-up',  'color' => '#198754'],
            ['icon' => 'bi-masks-theater',   'color' => '#dc3545'],
            ['icon' => 'bi-scissors',        'color' => '#6610f2'],
            ['icon' => 'bi-vector-pen',      'color' => '#20c997'],
        ];
        @endphp

        <div class="row g-3">
            @foreach($categories as $idx => $cat)
            @php $meta = $catMeta[$idx % 8]; @endphp
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ route('news.index') }}?category={{ $cat->id }}" class="cat-card">
                    <div class="cat-card-img cat-placeholder-{{ $idx % 8 }}" style="height:150px">
                        {{-- placeholder gradient --}}
                        <div style="height:100%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;opacity:.35;color:#fff">
                            <i class="bi {{ $meta['icon'] }}"></i>
                        </div>
                    </div>
                    <div class="cat-card-overlay">
                        <div class="cat-card-icon" style="background:rgba(255,255,255,.25)">
                            <i class="bi {{ $meta['icon'] }}"></i>
                        </div>
                        <div class="cat-card-name">{{ $cat->name }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════
     5. BERITA TERBARU
══════════════════════════════════════════ --}}
<section class="news-section">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-end flex-wrap gap-2">
            <div>
                <div class="section-label"><i class="bi bi-newspaper me-1"></i>Terkini</div>
                <h2 class="section-title mb-1">Berita Terbaru</h2>
                <p class="section-sub">Informasi dan kabar terkini dari dunia seni</p>
            </div>
            <a href="{{ route('news.index') }}" class="btn btn-outline-primary btn-sm">
                Semua Berita <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @if($latestNews->isEmpty())
        <div class="text-center py-4 text-muted">Belum ada berita.</div>
        @else
        <div class="row g-4">
            @foreach($latestNews as $item)
            <div class="col-md-6 col-lg-4">
                <div class="news-card-ac card h-100">
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                    @else
                    <div class="card-img-top d-flex align-items-center justify-content-center"
                         style="height:195px;background:linear-gradient(135deg,#f0ebff,#e8e0ff);font-size:3rem;color:#c4b5fd">
                        <i class="bi bi-image"></i>
                    </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <span class="badge badge-category mb-2" style="width:fit-content">{{ $item->category->name }}</span>
                        <h5 class="card-title mb-2" style="font-size:.97rem;line-height:1.5">
                            <a href="{{ route('news.show', $item->slug) }}" class="text-dark text-decoration-none">
                                {{ $item->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted small flex-grow-1" style="line-height:1.6">
                            {{ Str::limit(strip_tags($item->content), 95) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                            <span class="text-muted" style="font-size:.76rem">
                                <i class="bi bi-person me-1"></i>{{ $item->user->name }}
                            </span>
                            <span class="text-muted" style="font-size:.76rem">
                                <i class="bi bi-calendar3 me-1"></i>{{ $item->publish_date->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>


{{-- ══════════════════════════════════════════
     6. TENTANG ARTCONNECT
══════════════════════════════════════════ --}}
<section class="about-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="rounded-4 overflow-hidden"
                     style="background:linear-gradient(135deg,var(--ac-dark),var(--ac-primary));min-height:280px;display:flex;align-items:center;justify-content:center;padding:2.5rem">
                    <div class="text-center">
                        <div style="font-size:4rem;opacity:.5">🎭</div>
                        <div class="mt-3 d-flex gap-4 justify-content-center">
                            @foreach([['Seniman','500+'],['Karya','1200+'],['Event','80+']] as $s)
                            <div class="text-center">
                                <div style="font-size:1.4rem;font-weight:700;color:#fff">{{ $s[1] }}</div>
                                <div style="font-size:.72rem;color:rgba(255,255,255,.55)">{{ $s[0] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="welcome-badge" style="margin-bottom:1.1rem">
                    <i class="bi bi-info-circle"></i>Tentang ArtConnect
                </div>
                <h2 style="font-size:clamp(1.5rem,3vw,2.1rem);color:var(--ac-dark);margin-bottom:1rem">
                    Wadah Kreativitas Seniman Indonesia
                </h2>
                <p style="color:#666;line-height:1.85;font-size:1rem;margin-bottom:1.5rem">
                    ArtConnect adalah platform digital yang menghubungkan seniman, pecinta seni, dan masyarakat
                    umum untuk bersama-sama mengapresiasi dan mengembangkan seni Indonesia.
                    Kami hadir sebagai ruang ekspresi yang inklusif, mewadahi berbagai aliran seni dari
                    seluruh penjuru nusantara.
                </p>
                <a href="{{ route('about') }}" class="btn btn-primary px-4">
                    <i class="bi bi-info-circle me-2"></i>Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
