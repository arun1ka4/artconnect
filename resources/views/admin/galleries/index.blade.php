@extends('layouts.admin')

@section('title', 'Galeri')
@section('page-title', 'Manajemen Galeri')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center py-3 px-4">
        <form action="{{ route('admin.galleries.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group" style="width:280px">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0"
                       placeholder="Cari galeri..." value="{{ $search }}">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            @if($search)
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Galeri
        </a>
    </div>
    <div class="card-body p-0">
        @if($galleries->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-images fs-2 d-block mb-2"></i>
            {{ $search ? 'Tidak ada hasil untuk "' . $search . '"' : 'Belum ada galeri.' }}
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" width="55">#</th>
                        <th width="70">Cover</th>
                        <th>Judul</th>
                        <th>Jumlah Foto</th>
                        <th>Dibuat</th>
                        <th class="pe-4" width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($galleries as $i => $gallery)
                    <tr>
                        <td class="ps-4 text-muted">{{ $galleries->firstItem() + $i }}</td>
                        <td>
                            @if($gallery->cover_image)
                            <img src="{{ asset('storage/' . $gallery->cover_image) }}" class="img-thumb" alt="">
                            @else
                            <div class="img-thumb bg-light d-flex align-items-center justify-content-center text-muted">
                                <i class="bi bi-image"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-500">{{ $gallery->title }}</div>
                            @if($gallery->description)
                            <div class="text-muted small">{{ Str::limit($gallery->description, 50) }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $gallery->images_count }} foto</span>
                        </td>
                        <td class="text-muted">{{ $gallery->created_at->format('d M Y') }}</td>
                        <td class="pe-4">
                            <a href="{{ route('admin.galleries.show', $gallery) }}"
                               class="btn btn-sm btn-outline-secondary me-1" title="Kelola Foto">
                                <i class="bi bi-images"></i>
                            </a>
                            <a href="{{ route('admin.galleries.edit', $gallery) }}"
                               class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Hapus galeri ini beserta semua fotonya?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($galleries->hasPages())
        <div class="px-4 py-3 border-top">{{ $galleries->links() }}</div>
        @endif
        @endif
    </div>
</div>
@endsection
