@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Produk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 30) }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="{{ $product->category && $product->category->icon ? asset('storage/' . $product->category->icon) : 'https://via.placeholder.com/500x400?text=No+Image' }}" 
                     class="card-img-top rounded" 
                     alt="{{ $product->name }}"
                     style="object-fit: cover; height: 400px;">
                
                @if($product->hasDiscount())
                    <span class="position-absolute top-0 end-0 m-3 badge bg-danger fs-6">
                        -{{ $product->discount_percentage }}% OFF
                    </span>
                @endif
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
                    @if($product->is_featured)
                        <span class="badge bg-warning text-dark mb-2"><i class="bi bi-star-fill"></i> Featured</span>
                    @endif
                    
                    <h2 class="fw-bold mb-3">{{ $product->name }}</h2>
                    
                    <!-- Price -->
                    <div class="mb-4">
                        @if($product->hasDiscount())
                            <span class="text-muted text-decoration-line-through fs-5 me-2">
                                {{ $product->formatted_original_price }}
                            </span>
                        @endif
                        <span class="text-primary fw-bold" style="font-size: 2rem;">
                            {{ $product->formatted_price }}
                        </span>
                    </div>
                    
                    <!-- Product Details -->
                    <div class="row mb-4">
                        @if($product->game_server)
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-2">
                                    <i class="bi bi-geo-alt text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Server</small>
                                    <strong>{{ $product->game_server }}</strong>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($product->game_level)
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-2">
                                    <i class="bi bi-trophy text-warning"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Level/Rank</small>
                                    <strong>{{ $product->game_level }}</strong>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-2">
                                    <i class="bi bi-eye text-info"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Dilihat</small>
                                    <strong>{{ $product->view_count }}x</strong>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-2">
                                    <i class="bi bi-check-circle text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Status</small>
                                    <span class="status-badge status-{{ $product->status }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Buy Button -->
                    @if($product->status === 'available')
                        @auth
                            <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#buyModal">
                                <i class="bi bi-cart-plus"></i> Beli Sekarang
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-box-arrow-in-right"></i> Login untuk Membeli
                            </a>
                        @endauth
                    @elseif($product->status === 'sold')
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="bi bi-x-circle"></i> Produk Sudah Terjual
                        </button>
                    @else
                        <button class="btn btn-warning btn-lg w-100" disabled>
                            <i class="bi bi-clock"></i> Produk Sedang Diproses
                        </button>
                    @endif
                    
                    <!-- Contact -->
                    <div class="mt-3">
                        <a href="https://wa.me/6281234567890?text=Halo, saya tertarik dengan produk: {{ $product->name }}" 
                           target="_blank" class="btn btn-outline-success w-100">
                            <i class="bi bi-whatsapp"></i> Tanya via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Description -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-file-text"></i> Deskripsi Produk</h5>
                </div>
                <div class="card-body">
                    <div style="white-space: pre-line;">{{ $product->description }}</div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-shield-check"></i> Keamanan Transaksi</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Akun dijamin tidak hasil phising
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Garansi akun 1x24 jam
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Proses cepat setelah pembayaran
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Support via WhatsApp
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h4 class="fw-bold mb-4">Produk Serupa</h4>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                             class="card-img-top" alt="{{ $related->name }}">
                        @if($related->hasDiscount())
                            <span class="badge-discount">-{{ $related->discount_percentage }}%</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ Str::limit($related->name, 40) }}</h6>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="price">{{ $related->formatted_price }}</span>
                            <a href="{{ route('product.detail', $related->slug) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Buy Modal -->
@auth
<div class="modal fade" id="buyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-cart"></i> Konfirmasi Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('user.order.create', $product->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="d-flex mb-4">
                        <img src="{{ $product->category && $product->category->icon ? asset('storage/' . $product->category->icon) : 'https://via.placeholder.com/80x80?text=No+Image' }}" 
                             alt="{{ $product->name }}" 
                             class="rounded me-3" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h6>{{ $product->name }}</h6>
                            <span class="text-primary fw-bold fs-5">{{ $product->formatted_price }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-select" name="payment_method" required>
                            <option value="transfer">Transfer Bank</option>
                            <option value="ewallet">E-Wallet (GoPay, OVO, DANA)</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" name="notes" rows="2" 
                                  placeholder="Catatan tambahan untuk penjual"></textarea>
                    </div>
                    
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> Setelah melakukan order, Anda akan mendapatkan instruksi pembayaran.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Konfirmasi Beli
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth
@endsection
