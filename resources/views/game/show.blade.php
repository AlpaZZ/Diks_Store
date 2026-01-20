@extends('layouts.app')

@section('title', $category->name . ' - Diks Store')

@section('content')
<!-- Hero Section -->
<section class="py-4 bg-dark text-white" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                @if($category->icon)
                <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" 
                     class="rounded-circle border border-3 border-white" style="width: 80px; height: 80px; object-fit: cover;">
                @else
                <div class="rounded-circle d-flex align-items-center justify-content-center border border-3 border-white" 
                     style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                    <i class="bi bi-controller text-white" style="font-size: 2rem;"></i>
                </div>
                @endif
            </div>
            <div class="col">
                <h1 class="h3 fw-bold mb-1">{{ $category->name }}</h1>
                <p class="mb-0 text-white-50">{{ $category->description }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Content with Tabs -->
<section class="py-4">
    <div class="container">
        <!-- Tab Navigation -->
        <ul class="nav nav-pills nav-fill game-tabs mb-4" id="gameTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="topup-tab" data-bs-toggle="tab" data-bs-target="#topup" type="button" role="tab">
                    <i class="bi bi-gem me-2"></i>Top Up {{ $currencyName }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="accounts-tab" data-bs-toggle="tab" data-bs-target="#accounts" type="button" role="tab">
                    <i class="bi bi-shop me-2"></i>Jual Beli Akun
                    @if($products->count() > 0)
                    <span class="badge bg-danger ms-1">{{ $products->count() }}</span>
                    @endif
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="gameTabContent">
            <!-- TOP UP TAB -->
            <div class="tab-pane fade show active" id="topup" role="tabpanel">
                @if($topups->count() > 0)
                <!-- Top Up Info -->
                <div class="alert alert-info mb-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle fs-4 me-3"></i>
                        <div>
                            <strong>Cara Top Up {{ $category->name }}:</strong>
                            <ol class="mb-0 mt-1">
                                <li>Pilih nominal {{ $currencyName }} yang diinginkan</li>
                                <li>Masukkan User ID {{ $category->slug == 'mobile-legends' ? 'dan Zone ID' : '' }} game kamu</li>
                                <li>Lakukan pembayaran dan upload bukti transfer</li>
                                <li>{{ $currencyName }} akan masuk ke akun dalam 1-5 menit</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Top Up Packages Grid -->
                <div class="row g-3">
                    @foreach($topups as $topup)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card topup-card h-100 {{ $topup->is_popular ? 'border-primary border-2' : 'border' }}">
                            @if($topup->is_popular)
                            <div class="popular-ribbon">
                                <span>POPULER</span>
                            </div>
                            @endif
                            @if($topup->has_discount)
                            <div class="discount-ribbon">
                                <span>-{{ $topup->discount_percent }}%</span>
                            </div>
                            @endif
                            
                            <div class="card-body text-center p-3">
                                <div class="topup-icon mb-2">
                                    <i class="bi bi-gem text-warning" style="font-size: 2.5rem;"></i>
                                </div>
                                
                                <h4 class="fw-bold mb-0 text-primary">{{ number_format($topup->amount) }}</h4>
                                @if($topup->bonus_amount > 0)
                                <p class="text-success small mb-2 fw-semibold">
                                    <i class="bi bi-plus-circle-fill"></i> {{ number_format($topup->bonus_amount) }} Bonus
                                </p>
                                @else
                                <p class="text-muted small mb-2">{{ $currencyName }}</p>
                                @endif
                                
                                <div class="price-section mt-3">
                                    @if($topup->has_discount)
                                    <small class="text-muted text-decoration-line-through d-block">{{ $topup->formatted_original_price }}</small>
                                    @endif
                                    <span class="fw-bold fs-5">{{ $topup->formatted_price }}</span>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-transparent border-0 p-3 pt-0">
                                @auth
                                <a href="{{ route('topup.order', $topup->id) }}" class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-cart-plus me-1"></i>Beli Sekarang
                                </a>
                                @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100">
                                    Login untuk Beli
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-gem display-1 text-muted"></i>
                    <h4 class="mt-3">Top Up Belum Tersedia</h4>
                    <p class="text-muted">Paket top up {{ $currencyName }} untuk {{ $category->name }} akan segera tersedia</p>
                </div>
                @endif
            </div>

            <!-- ACCOUNTS TAB -->
            <div class="tab-pane fade" id="accounts" role="tabpanel">
                @if($products->count() > 0)
                <div class="row g-4">
                    @foreach($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="card product-card h-100 border-0 shadow-sm">
                            @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-controller text-white" style="font-size: 4rem;"></i>
                            </div>
                            @endif
                            
                            @if($product->is_featured)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> Featured
                                </span>
                            </div>
                            @endif
                            
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-{{ $product->status == 'available' ? 'success' : ($product->status == 'sold' ? 'danger' : 'warning') }}">
                                    {{ $product->status_label }}
                                </span>
                            </div>
                            
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ Str::limit($product->name, 40) }}</h5>
                                
                                <div class="d-flex gap-2 mb-2 flex-wrap">
                                    @if($product->game_server)
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-globe"></i> {{ $product->game_server }}
                                    </span>
                                    @endif
                                    @if($product->game_level)
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-trophy"></i> {{ $product->game_level }}
                                    </span>
                                    @endif
                                </div>
                                
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        @if($product->original_price && $product->original_price > $product->price)
                                        <small class="text-muted text-decoration-line-through d-block">{{ $product->formatted_original_price }}</small>
                                        @endif
                                        <span class="h5 text-primary mb-0 fw-bold">{{ $product->formatted_price }}</span>
                                    </div>
                                    <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($products->hasPages())
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
                @endif
                @else
                <div class="text-center py-5">
                    <i class="bi bi-shop display-1 text-muted"></i>
                    <h4 class="mt-3">Belum Ada Akun Dijual</h4>
                    <p class="text-muted">Akun {{ $category->name }} yang dijual akan muncul di sini</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5 bg-light">
    <div class="container">
        <h4 class="fw-bold text-center mb-4">Kenapa Pilih Diks Store?</h4>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon mx-auto mb-3">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <h6 class="fw-bold">Proses Cepat</h6>
                    <p class="text-muted small mb-0">Top up masuk dalam hitungan menit</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon mx-auto mb-3">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h6 class="fw-bold">100% Aman</h6>
                    <p class="text-muted small mb-0">Transaksi dijamin keamanannya</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon mx-auto mb-3">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h6 class="fw-bold">Harga Terbaik</h6>
                    <p class="text-muted small mb-0">Harga kompetitif & banyak promo</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon mx-auto mb-3">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h6 class="fw-bold">Support 24/7</h6>
                    <p class="text-muted small mb-0">Admin siap membantu kapanpun</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .game-tabs {
        background: white;
        border-radius: 15px;
        padding: 8px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }
    
    .game-tabs .nav-link {
        border-radius: 10px;
        color: #666;
        font-weight: 600;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }
    
    .game-tabs .nav-link:hover {
        background: #f8f9fa;
        color: var(--primary-color);
    }
    
    .game-tabs .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
    }
    
    .topup-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .topup-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .popular-ribbon {
        position: absolute;
        top: 10px;
        left: -30px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 5px 40px;
        font-size: 10px;
        font-weight: bold;
        transform: rotate(-45deg);
        z-index: 1;
    }
    
    .discount-ribbon {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1;
    }
    
    .discount-ribbon span {
        background: #e74c3c;
        color: white;
        padding: 3px 8px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: bold;
    }
    
    .topup-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
    
    .product-card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .product-card .card-img-top {
        height: 180px;
        object-fit: cover;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@push('scripts')
<script>
    // Check if URL has hash for tab
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash === '#accounts') {
            const accountsTab = new bootstrap.Tab(document.getElementById('accounts-tab'));
            accountsTab.show();
        }
    });
    
    // Update URL hash when tab changes
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(tab) {
        tab.addEventListener('shown.bs.tab', function(e) {
            const target = e.target.getAttribute('data-bs-target');
            history.replaceState(null, null, target);
        });
    });
</script>
@endpush
