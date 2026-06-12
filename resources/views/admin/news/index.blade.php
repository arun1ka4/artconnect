@extends('layouts.admin')

@section('title', 'Berita')
@section('page-title', 'Manajemen Berita')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center py-3 px-4">
        <form action="{{ route('admin.news.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group" style="width:280px">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0"
                       placeholder="Cari judul berita..." value="{{ $search }}">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            @if($search)
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Berita
        </a>
    </div>
    <div class="card-body p-0">
        @if($news->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-newspaper fs-2 d-block mb-2"></i>
            {{ $search ? 'Tidak ada hasil untuk "' . $search . '"' : 'Belum ada berita.' }}
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" width="55">#</th>
                        <th width="60">Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th class="pe-4" width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $i => $item)
                    <tr>
                        <td class="ps-4 text-muted">{{ $news->firstItem() + $i }}</td>
                        <td>
                            @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="img-thumb" alt="">
                            @else
                            <div class="img-thumb bg-light d-flex align-items-center justify-content-center text-muted">
                                <i class="bi bi-image"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-500">{{ Str::limit($item->title, 45) }}</div>
                            <div class="text-muted small">{{ $item->slug }}</div>
                        </td>
                        <td>
                            <span class="badge" style="background:#6F42C1;font-size:.72rem">{{ $item->category->name }}</span>
                        </td>
                        <td class="text-muted">{{ $item->user->name }}</td>
                        <td class="text-muted">{{ $item->publish_date->format('d M Y') }}</td>
                        <td class="pe-4">
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($news->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $news->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
