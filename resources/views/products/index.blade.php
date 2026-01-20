@extends('layouts.app')

@section('title', 'Semua Produk')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-funnel"></i> Filter</h5>
                    
                    <form action="{{ route('products') }}" method="GET">
                        <!-- Search -->
                        <div class="mb-3">
                            <label class="form-label">Cari Produk</label>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Nama produk...">
                        </div>
                        
                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="category">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Sort -->
                        <div class="mb-3">
                            <label class="form-label">Urutkan</label>
                            <select class="form-select" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Terapkan Filter
                        </button>
                        
                        @if(request()->hasAny(['search', 'category', 'sort']))
                            <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="bi bi-x"></i> Reset Filter
                            </a>
                        @endif
                    </form>
                </div>
            </div>
            
            <!-- Categories Quick Links -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-grid"></i> Kategori</h6>
                    <ul class="list-unstyled mb-0">
                        @foreach($categories as $category)
                        <li class="mb-2">
                            <a href="{{ route('category', $category->slug) }}" 
                               class="text-decoration-none text-muted d-flex justify-content-between">
                                <span>{{ $category->name }}</span>
                                <span class="badge bg-light text-dark">{{ $category->products()->available()->count() }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Semua Produk</h4>
                    <small class="text-muted">Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk</small>
                </div>
            </div>
            
            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                                 class="card-img-top" alt="{{ $product->name }}">
                            @if($product->hasDiscount())
                                <span class="badge-discount">-{{ $product->discount_percentage }}%</span>
                            @endif
                            @if($product->is_featured)
                                <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> Featured
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
                            <h6 class="card-title">{{ Str::limit($product->name, 45) }}</h6>
                            
                            @if($product->game_server || $product->game_level)
                            <p class="small text-muted mb-2">
                                @if($product->game_server)
                                    <i class="bi bi-geo-alt"></i> {{ $product->game_server }}
                                @endif
                                @if($product->game_level)
                                    | <i class="bi bi-trophy"></i> {{ $product->game_level }}
                                @endif
                            </p>
                            @endif
                            
                            <div class="d-flex align-items-center justify-content-between mt-auto">
                                <div>
                                    <span class="price">{{ $product->formatted_price }}</span>
                                    @if($product->hasDiscount())
                                        <br><span class="price-original">{{ $product->formatted_original_price }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                        <h5>Produk Tidak Ditemukan</h5>
                        <p class="text-muted">Coba ubah filter pencarian Anda</p>
                        <a href="{{ route('products') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> Lihat Semua Produk
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
