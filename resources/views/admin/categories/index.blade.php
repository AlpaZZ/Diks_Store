@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">Kelola kategori game untuk produk Anda</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Kategori
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">Icon</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Produk</th>
                    <th>Status</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        @if($category->icon)
                            <img src="{{ asset('storage/' . $category->icon) }}" 
                                 alt="{{ $category->name }}" 
                                 class="rounded" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="bi bi-grid text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $category->name }}</strong>
                        @if($category->description)
                            <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                        @endif
                    </td>
                    <td><code>{{ $category->slug }}</code></td>
                    <td>
                        <span class="badge bg-primary">{{ $category->products_count }} produk</span>
                    </td>
                    <td>
                        @if($category->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                           class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.categories.delete', $category->id) }}" 
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="bi bi-grid fs-1 text-muted d-block mb-3"></i>
                        <p class="text-muted mb-3">Belum ada kategori</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Kategori Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($categories->hasPages())
    <div class="card-footer bg-white d-flex justify-content-center">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<style>
    .pagination { margin-bottom: 0; }
    .pagination .page-link { padding: 0.375rem 0.75rem; font-size: 0.875rem; }
    .pagination .page-item.active .page-link { background: linear-gradient(135deg, #6c5ce7, #a29bfe); border-color: #6c5ce7; }
</style>
@endsection
