@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#6F42C1,#9b6dff);color:#fff">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75 fw-500">Total Berita</div>
                    <div class="fs-2 fw-700">{{ $stats['news'] }}</div>
                </div>
                <div style="font-size:2.5rem;opacity:.4"><i class="bi bi-newspaper"></i></div>
            </div>
            <a href="{{ route('admin.news.index') }}" class="text-white-50 small mt-2 d-inline-block text-decoration-none">
                Kelola berita <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#e83e8c,#ff6bb5);color:#fff">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75 fw-500">Total Kategori</div>
                    <div class="fs-2 fw-700">{{ $stats['categories'] }}</div>
                </div>
                <div style="font-size:2.5rem;opacity:.4"><i class="bi bi-tags"></i></div>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="text-white-50 small mt-2 d-inline-block text-decoration-none">
                Kelola kategori <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#0dcaf0,#36d9f5);color:#fff">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75 fw-500">Total Galeri</div>
                    <div class="fs-2 fw-700">{{ $stats['galleries'] }}</div>
                </div>
                <div style="font-size:2.5rem;opacity:.4"><i class="bi bi-images"></i></div>
            </div>
            <a href="{{ route('admin.galleries.index') }}" class="text-white-50 small mt-2 d-inline-block text-decoration-none">
                Kelola galeri <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#198754,#2ecc71);color:#fff">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75 fw-500">Total Foto</div>
                    <div class="fs-2 fw-700">{{ $stats['gallery_images'] }}</div>
                </div>
                <div style="font-size:2.5rem;opacity:.4"><i class="bi bi-image"></i></div>
            </div>
            <a href="{{ route('admin.galleries.index') }}" class="text-white-50 small mt-2 d-inline-block text-decoration-none">
                Lihat galeri <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

{{-- Latest News --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3 px-4">
        <span><i class="bi bi-newspaper me-2 text-primary"></i>Berita Terbaru</span>
        <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Berita
        </a>
    </div>
    <div class="card-body p-0">
        @if($latestNews->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada berita.
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th class="pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestNews as $item)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-500">{{ Str::limit($item->title, 45) }}</div>
                        </td>
                        <td>
                            <span class="badge" style="background:#6F42C1;font-size:.72rem">{{ $item->category->name }}</span>
                        </td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->publish_date->format('d M Y') }}</td>
                        <td class="pe-4">
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2 border-top">
            <a href="{{ route('admin.news.index') }}" class="small text-decoration-none" style="color:#6F42C1">
                Lihat semua berita <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
