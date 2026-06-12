@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center py-3 px-4">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group" style="width:260px">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0"
                       placeholder="Cari kategori..." value="{{ $search }}">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            @if($search)
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
        </a>
    </div>
    <div class="card-body p-0">
        @if($categories->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-tags fs-2 d-block mb-2"></i>
            {{ $search ? 'Tidak ada hasil untuk "' . $search . '"' : 'Belum ada kategori.' }}
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" width="60">#</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Berita</th>
                        <th>Dibuat</th>
                        <th class="pe-4" width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $i => $category)
                    <tr>
                        <td class="ps-4 text-muted">{{ $categories->firstItem() + $i }}</td>
                        <td class="fw-500">{{ $category->name }}</td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $category->news_count }} berita</span>
                        </td>
                        <td class="text-muted">{{ $category->created_at->format('d M Y') }}</td>
                        <td class="pe-4">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $categories->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
