@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container py-5">
    <!-- Category Header -->
    <div class="text-center mb-5">
        @if($category->icon)
            <img src="{{ asset('storage/' . $category->icon) }}" 
                 alt="{{ $category->name }}" 
                 class="mb-3" 
                 style="width: 80px; height: 80px; object-fit: contain;">
        @else
            <i class="bi bi-controller text-primary" style="font-size: 4rem;"></i>
        @endif
        <h2 class="fw-bold">{{ $category->name }}</h2>
        @if($category->description)
            <p class="text-muted">{{ $category->description }}</p>
        @endif
        <span class="badge bg-primary">{{ $products->total() }} produk tersedia</span>
    </div>
    
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-grid"></i> Kategori Lainnya</h6>
                    <ul class="list-unstyled mb-0">
                        @foreach($categories as $cat)
                        <li class="mb-2">
                            <a href="{{ route('category', $cat->slug) }}" 
                               class="text-decoration-none {{ $cat->id == $category->id ? 'text-primary fw-bold' : 'text-muted' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <img src="{{ $product->category && $product->category->icon ? asset('storage/' . $product->category->icon) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                                 class="card-img-top" alt="{{ $product->name }}">
                            @if($product->hasDiscount())
                                <span class="badge-discount">-{{ $product->discount_percentage }}%</span>
                            @endif
                        </div>
                        <div class="card-body">
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
                        <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                        <h5>Belum Ada Produk</h5>
                        <p class="text-muted">Kategori ini belum memiliki produk tersedia</p>
                        <a href="{{ route('products') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> Lihat Produk Lainnya
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
