<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ArtConnect') – Portal Informasi Komunitas Seni</title>
    <meta name="description" content="@yield('description', 'ArtConnect adalah portal informasi komunitas seni yang menyediakan berita, event, dan galeri karya anggota komunitas seni Indonesia.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --ac-primary:       #6F42C1;
            --ac-primary-dark:  #5a34a3;
            --ac-primary-light: #f0ebff;
            --ac-accent:        #e83e8c;
            --ac-dark:          #1a1a2e;
        }

        /* ── Base ── */
        *, *::before, *::after { box-sizing: border-box; }
        body   { font-family: 'Inter', sans-serif; color: #333; margin: 0; }
        h1,h2,h3,h4,h5 { font-family: 'Playfair Display', serif; }

        /* ── Navbar ── */
        .ac-navbar {
            position: sticky; top: 0; z-index: 1030;
            background: #fff;
            border-bottom: 2px solid var(--ac-primary-light);
            padding: .75rem 0;
        }
        .ac-navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--ac-primary);
            text-decoration: none;
            display: flex; align-items: center; gap: .35rem;
        }
        /* hamburger */
        .nav-toggle {
            display: none;
            background: none; border: none; cursor: pointer;
            padding: .4rem .5rem;
            color: var(--ac-dark);
            font-size: 1.5rem;
            line-height: 1;
        }
        /* Desktop nav links */
        .nav-desktop {
            display: flex; align-items: center; gap: .25rem;
        }
        .nav-desktop .nav-link {
            font-weight: 500; font-size: .93rem; color: #555;
            padding: .45rem .75rem; border-radius: 8px;
            text-decoration: none; transition: color .2s, background .2s;
        }
        .nav-desktop .nav-link:hover,
        .nav-desktop .nav-link.active { color: var(--ac-primary); background: var(--ac-primary-light); }
        .nav-desktop .btn-nav-login {
            background: var(--ac-primary); color: #fff;
            border: none; border-radius: 8px;
            padding: .42rem 1rem; font-size: .88rem; font-weight: 600;
            text-decoration: none; transition: background .2s;
        }
        .nav-desktop .btn-nav-login:hover { background: var(--ac-primary-dark); color: #fff; }
        .nav-desktop .btn-nav-dashboard {
            background: var(--ac-primary); color: #fff;
            border: none; border-radius: 8px;
            padding: .42rem 1rem; font-size: .88rem; font-weight: 600;
            text-decoration: none; transition: background .2s;
        }
        .nav-desktop .btn-nav-dashboard:hover { background: var(--ac-primary-dark); color: #fff; }

        /* ── Mobile drawer ── */
        .nav-mobile-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 1040;
        }
        .nav-mobile-overlay.open { display: block; }
        .nav-mobile-drawer {
            position: fixed;
            top: 0; right: -320px;
            width: 300px; max-width: 90vw;
            height: 100%;
            background: #fff;
            z-index: 1050;
            display: flex; flex-direction: column;
            transition: right .3s cubic-bezier(.4,0,.2,1);
            box-shadow: -4px 0 24px rgba(0,0,0,.15);
        }
        .nav-mobile-drawer.open { right: 0; }
        .nav-drawer-head {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .nav-drawer-head .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem; font-weight: 700; color: var(--ac-primary);
        }
        .btn-close-drawer {
            background: none; border: none; cursor: pointer;
            font-size: 1.4rem; color: #888; padding: .2rem .4rem;
        }
        .nav-drawer-body {
            flex: 1; overflow-y: auto;
            padding: 1rem 1.25rem;
            display: flex; flex-direction: column; gap: .25rem;
        }
        /* Login button top of drawer */
        .drawer-login-btn {
            display: flex; align-items: center; gap: .6rem;
            background: var(--ac-primary); color: #fff !important;
            border-radius: 10px; padding: .75rem 1rem;
            font-weight: 600; font-size: .95rem;
            text-decoration: none; margin-bottom: .5rem;
            transition: background .2s;
        }
        .drawer-login-btn:hover { background: var(--ac-primary-dark); color: #fff; }
        .drawer-link {
            display: flex; align-items: center; gap: .7rem;
            color: #444; text-decoration: none;
            padding: .7rem .9rem; border-radius: 10px;
            font-size: .95rem; font-weight: 500;
            transition: background .2s, color .2s;
        }
        .drawer-link i { font-size: 1.1rem; width: 1.4rem; text-align: center; color: var(--ac-primary); }
        .drawer-link:hover, .drawer-link.active {
            background: var(--ac-primary-light); color: var(--ac-primary);
        }
        .drawer-divider {
            height: 1px; background: #f0f0f0; margin: .5rem 0;
        }
        /* Drawer search */
        .drawer-search {
            margin-top: .25rem;
            padding: .5rem .5rem 0;
        }
        .drawer-search label {
            font-size: .78rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .06em;
            color: #999; margin-bottom: .4rem; display: block;
        }
        .drawer-search form { display: flex; gap: .4rem; }
        .drawer-search input {
            flex: 1; border: 1.5px solid #e0e0e0; border-radius: 8px;
            padding: .5rem .75rem; font-size: .88rem;
            outline: none;
        }
        .drawer-search input:focus { border-color: var(--ac-primary); }
        .drawer-search button {
            background: var(--ac-primary); color: #fff; border: none;
            border-radius: 8px; padding: .5rem .85rem; font-size: .9rem;
            cursor: pointer; transition: background .2s;
        }
        .drawer-search button:hover { background: var(--ac-primary-dark); }

        /* Show/hide based on breakpoint */
        @media (max-width: 991px) {
            .nav-toggle  { display: block; }
            .nav-desktop { display: none; }
        }

        /* ── Buttons ── */
        .btn-primary { background: var(--ac-primary); border-color: var(--ac-primary); }
        .btn-primary:hover { background: var(--ac-primary-dark); border-color: var(--ac-primary-dark); }
        .btn-outline-primary { color: var(--ac-primary); border-color: var(--ac-primary); }
        .btn-outline-primary:hover { background: var(--ac-primary); border-color: var(--ac-primary); color: #fff; }
        .text-primary { color: var(--ac-primary) !important; }
        .badge-category { background: var(--ac-primary); font-size: .72rem; padding: .35em .75em; border-radius: 50px; }

        /* ── News card ── */
        .news-card { border: none; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,.07); transition: transform .25s, box-shadow .25s; overflow: hidden; }
        .news-card:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(111,66,193,.18); }
        .news-card .card-img-top { height: 200px; object-fit: cover; }

        /* ── Gallery card ── */
        .gallery-card { border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,.07); transition: transform .25s; }
        .gallery-card:hover { transform: translateY(-4px); }
        .gallery-card img { height: 220px; object-fit: cover; }
        .gallery-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,.75)); padding: 2rem 1.2rem 1.2rem; }

        /* ── Pagination ── */
        .page-link { color: var(--ac-primary); }
        .page-item.active .page-link { background: var(--ac-primary); border-color: var(--ac-primary); }

        /* ── Alert ── */
        .alert { border-radius: 10px; }

        /* ── Footer ── */
        .ac-footer { background: var(--ac-dark); color: #9a9ab0; padding: 3.5rem 0 0; }
        .ac-footer .foot-brand { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: #fff; }
        .ac-footer h6 { color: #fff; font-size: .82rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 1rem; }
        .ac-footer a { color: #9a9ab0; text-decoration: none; font-size: .88rem; transition: color .2s; display: block; margin-bottom: .35rem; }
        .ac-footer a:hover { color: var(--ac-primary-light); }
        .ac-footer .contact-item { display: flex; align-items: flex-start; gap: .6rem; font-size: .88rem; margin-bottom: .6rem; }
        .ac-footer .contact-item i { color: var(--ac-primary); margin-top: .1rem; flex-shrink: 0; }
        .ac-footer .social-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(255,255,255,.08); color: #ccc;
            font-size: 1.05rem; transition: background .2s, color .2s;
            text-decoration: none;
        }
        .ac-footer .social-icon:hover { background: var(--ac-primary); color: #fff; }
        .ac-footer .foot-bottom {
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 1.1rem 0; margin-top: 2.5rem;
            text-align: center; font-size: .82rem; color: #666;
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ===================== NAVBAR ===================== --}}
<nav class="ac-navbar" role="navigation" aria-label="Navigasi utama">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-palette2"></i>ArtConnect
        </a>

        {{-- Desktop nav --}}
        <div class="nav-desktop">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
            <a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">Berita</a>
            <a class="nav-link {{ request()->routeIs('galleries.*') ? 'active' : '' }}" href="{{ route('galleries.index') }}">Galeri</a>
            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang</a>
            @auth
                <a class="btn-nav-dashboard ms-2" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                </a>
            @else
                <a class="btn-nav-login ms-2" href="{{ route('admin.login') }}">
                    <i class="bi bi-person-circle me-1"></i>Login
                </a>
            @endauth
        </div>

        {{-- Hamburger (mobile only) --}}
        <button class="nav-toggle" id="navToggle" aria-label="Buka menu" aria-expanded="false">
            <i class="bi bi-list"></i>
        </button>
    </div>
</nav>

{{-- ===================== MOBILE DRAWER ===================== --}}
<div class="nav-mobile-overlay" id="navOverlay"></div>
<div class="nav-mobile-drawer" id="navDrawer" role="dialog" aria-label="Menu navigasi">
    <div class="nav-drawer-head">
        <span class="brand"><i class="bi bi-palette2 me-1"></i>ArtConnect</span>
        <button class="btn-close-drawer" id="navClose" aria-label="Tutup menu">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <div class="nav-drawer-body">
        {{-- 1. Login (paling atas) --}}
        @auth
        <a class="drawer-login-btn" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i>Dashboard Admin
        </a>
        @else
        <a class="drawer-login-btn" href="{{ route('admin.login') }}">
            <i class="bi bi-person-circle"></i>Login Admin
        </a>
        @endauth

        <div class="drawer-divider"></div>

        {{-- 2–5. Menu navigasi --}}
        <a class="drawer-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
            <i class="bi bi-house-door"></i>Beranda
        </a>
        <a class="drawer-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">
            <i class="bi bi-newspaper"></i>Berita
        </a>
        <a class="drawer-link {{ request()->routeIs('galleries.*') ? 'active' : '' }}" href="{{ route('galleries.index') }}">
            <i class="bi bi-images"></i>Galeri
        </a>
        <a class="drawer-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
            <i class="bi bi-info-circle"></i>Tentang
        </a>

        <div class="drawer-divider"></div>

        {{-- 6. Search --}}
        <div class="drawer-search">
            <label><i class="bi bi-search me-1"></i>Pencarian</label>
            <form action="{{ route('news.index') }}" method="GET">
                <input type="text" name="search" placeholder="Cari berita...">
                <button type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</div>

{{-- Flash Messages --}}
@if(session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

@yield('content')

{{-- ===================== FOOTER ===================== --}}
<footer class="ac-footer">
    <div class="container">
        <div class="row g-5">
            {{-- Brand --}}
            <div class="col-md-4 col-lg-4">
                <div class="foot-brand mb-2"><i class="bi bi-palette2 me-2"></i>ArtConnect</div>
                <p style="font-size:.88rem;line-height:1.7;max-width:280px">
                    Portal informasi komunitas seni Indonesia — menghubungkan seniman, karya,
                    dan pecinta seni dari seluruh nusantara.
                </p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="social-icon" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon" aria-label="Twitter/X"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-icon" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="social-icon" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>

            {{-- Menu cepat --}}
            <div class="col-6 col-md-2 col-lg-2">
                <h6>Menu</h6>
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('news.index') }}">Berita</a>
                <a href="{{ route('galleries.index') }}">Galeri</a>
                <a href="{{ route('about') }}">Tentang Kami</a>
                <a href="{{ route('admin.login') }}">Login Admin</a>
            </div>

            {{-- Kategori --}}
            <div class="col-6 col-md-2 col-lg-2">
                <h6>Kategori</h6>
                <a href="{{ route('news.index') }}?category=1">Seni Lukis</a>
                <a href="{{ route('news.index') }}?category=3">Fotografi</a>
                <a href="{{ route('news.index') }}?category=4">Seni Musik</a>
                <a href="{{ route('news.index') }}?category=5">Seni Tari</a>
                <a href="{{ route('news.index') }}?category=6">Teater</a>
            </div>

            {{-- Kontak --}}
            <div class="col-md-4 col-lg-4">
                <h6>Kontak</h6>
                <div class="contact-item"><i class="bi bi-envelope-fill"></i><span>info@artconnect.id</span></div>
                <div class="contact-item"><i class="bi bi-telephone-fill"></i><span>+62 21 1234 5678</span></div>
                <div class="contact-item"><i class="bi bi-geo-alt-fill"></i><span>Jl. Seni Budaya No. 1,<br>Jakarta Pusat, Indonesia</span></div>
            </div>
        </div>

        <div class="foot-bottom">
            &copy; {{ date('Y') }} <strong style="color:#ccc">ArtConnect</strong>.
            Semua hak dilindungi &nbsp;·&nbsp; Dibuat dengan <i class="bi bi-heart-fill" style="color:#e83e8c;font-size:.75rem"></i> untuk komunitas seni Indonesia
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    const toggle  = document.getElementById('navToggle');
    const drawer  = document.getElementById('navDrawer');
    const overlay = document.getElementById('navOverlay');
    const close   = document.getElementById('navClose');

    function openDrawer() {
        drawer.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
        toggle.setAttribute('aria-expanded', 'true');
    }
    function closeDrawer() {
        drawer.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
        toggle.setAttribute('aria-expanded', 'false');
    }

    toggle.addEventListener('click', openDrawer);
    close.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });
})();
</script>
@stack('scripts')
</body>
</html>
