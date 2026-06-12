<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') – ArtConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --ac-primary: #6F42C1;
            --ac-primary-dark: #5a34a3;
            --ac-sidebar-bg: #1a1a2e;
            --ac-sidebar-width: 260px;
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: #f4f5f7; }

        /* Sidebar */
        .sidebar {
            width: var(--ac-sidebar-width);
            min-height: 100vh;
            background: var(--ac-sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: transform .3s;
            display: flex; flex-direction: column;
        }
        .sidebar-brand {
            padding: 1.5rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            color: #fff;
            font-size: 1.3rem;
            font-weight: 700;
            text-decoration: none;
        }
        .sidebar-brand span { color: var(--ac-primary); }
        .sidebar-nav { padding: 1rem 0; flex: 1; overflow-y: auto; }
        .nav-section-title {
            color: rgba(255,255,255,.4);
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .75rem 1.2rem .35rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.65);
            padding: .65rem 1.2rem;
            border-radius: 8px;
            margin: 2px .6rem;
            display: flex; align-items: center; gap: .65rem;
            font-size: .88rem;
            transition: all .2s;
        }
        .sidebar .nav-link i { font-size: 1.05rem; width: 1.2rem; text-align: center; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,.08); color: #fff; }
        .sidebar .nav-link.active { background: var(--ac-primary); color: #fff; }
        .sidebar-footer { padding: 1rem 1.2rem; border-top: 1px solid rgba(255,255,255,.08); }
        .sidebar-user { color: rgba(255,255,255,.7); font-size: .82rem; }

        /* Main content */
        .main-wrapper { margin-left: var(--ac-sidebar-width); display: flex; flex-direction: column; min-height: 100vh; }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e8e8e8;
            padding: .75rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 999;
        }
        .topbar-title { font-size: 1.1rem; font-weight: 600; color: #2d2d2d; margin: 0; }
        .content-area { padding: 1.5rem; flex: 1; }

        /* Cards */
        .stat-card { border: none; border-radius: 14px; padding: 1.4rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.06); }
        .card-header { background: #fff; border-bottom: 1px solid #f0f0f0; font-weight: 600; border-radius: 12px 12px 0 0 !important; }

        /* Buttons */
        .btn-primary { background: var(--ac-primary); border-color: var(--ac-primary); }
        .btn-primary:hover { background: var(--ac-primary-dark); border-color: var(--ac-primary-dark); }
        .text-primary { color: var(--ac-primary) !important; }
        .badge-primary { background: var(--ac-primary) !important; }

        /* Table */
        .table th { font-size: .8rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #888; background: #fafafa; }
        .table td { vertical-align: middle; font-size: .88rem; }

        /* Form */
        .form-label { font-weight: 500; font-size: .88rem; color: #555; }
        .form-control, .form-select { border-radius: 8px; border-color: #ddd; font-size: .88rem; }
        .form-control:focus, .form-select:focus { border-color: var(--ac-primary); box-shadow: 0 0 0 .2rem rgba(111,66,193,.15); }
        .form-text { font-size: .78rem; }

        /* Alert */
        .alert { border-radius: 10px; font-size: .88rem; }

        /* Overlay */
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 999; }

        /* Image thumbnail */
        .img-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .sidebar-overlay { display: block; opacity: 0; pointer-events: none; transition: opacity .3s; }
            .sidebar-overlay.show { opacity: 1; pointer-events: all; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">
    <a class="sidebar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-palette2"></i>
        Art<span>Connect</span>
    </a>
    <nav class="sidebar-nav">
        <div class="nav-section-title">Utama</div>
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section-title mt-2">Konten</div>
        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
            <i class="bi bi-tags"></i> Kategori
        </a>
        <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
            <i class="bi bi-newspaper"></i> Berita
        </a>
        <a class="nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}" href="{{ route('admin.galleries.index') }}">
            <i class="bi bi-images"></i> Galeri
        </a>

        <div class="nav-section-title mt-2">Publik</div>
        <a class="nav-link" href="{{ route('home') }}" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i> Lihat Website
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user d-flex align-items-center gap-2 mb-2">
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width:32px;height:32px;font-size:.8rem;background:var(--ac-primary)!important">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="text-white fw-500" style="font-size:.82rem">{{ auth()->user()->name }}</div>
                <div style="font-size:.72rem">{{ auth()->user()->role }}</div>
            </div>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm w-100" style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.7);font-size:.8rem">
                <i class="bi bi-box-arrow-left me-1"></i>Logout
            </button>
        </form>
    </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

{{-- Main --}}
<div class="main-wrapper">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-md-none" onclick="toggleSidebar()">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h6 class="topbar-title">@yield('page-title', 'Dashboard')</h6>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if(request()->has('search'))
            <span class="badge bg-light text-muted small">
                Hasil: "{{ request('search') }}"
            </span>
            @endif
        </div>
    </div>

    <div class="content-area">
        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
</script>
@stack('scripts')
</body>
</html>
