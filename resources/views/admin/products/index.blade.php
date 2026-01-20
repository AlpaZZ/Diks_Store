@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">Kelola akun game yang dijual</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Produk
    </a>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" name="search" 
                       placeholder="Cari produk..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="category">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->category && $product->category->icon)
                            <img src="{{ asset('storage/' . $product->category->icon) }}" 
                                 alt="{{ $product->name }}" 
                                 class="rounded" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ Str::limit($product->name, 40) }}</strong>
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark ms-1">Featured</span>
                        @endif
                        <br>
                        <small class="text-muted">
                            @if($product->game_server)
                                Server: {{ $product->game_server }}
                            @endif
                            @if($product->game_level)
                                | Level: {{ $product->game_level }}
                            @endif
                        </small>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                    </td>
                    <td>
                        <strong class="text-primary">{{ $product->formatted_price }}</strong>
                        @if($product->hasDiscount())
                            <br><small class="text-decoration-line-through text-muted">
                                {{ $product->formatted_original_price }}
                            </small>
                        @endif
                    </td>
                    <td>
                        @if($product->stock > 5)
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">Habis</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $product->status }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td>
                        <i class="bi bi-eye"></i> {{ $product->view_count }}
                    </td>
                    <td>
                        <a href="{{ route('product.detail', $product->slug) }}" 
                           class="btn btn-sm btn-outline-secondary" title="Lihat" target="_blank">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                           class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.products.delete', $product->id) }}" 
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
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
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-box fs-1 text-muted d-block mb-3"></i>
                        <p class="text-muted mb-3">Belum ada produk</p>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Produk Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
    <div class="card-footer bg-white d-flex justify-content-center">
        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<style>
    .pagination { margin-bottom: 0; }
    .pagination .page-link { padding: 0.375rem 0.75rem; font-size: 0.875rem; }
    .pagination .page-item.active .page-link { background: linear-gradient(135deg, #6c5ce7, #a29bfe); border-color: #6c5ce7; }
</style>
@endsection
