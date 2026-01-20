@extends('layouts.app')

@section('title', 'Beranda - Diks Store')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Top Up & Jual Beli Akun Game <span style="color: #ffeaa7;">Terpercaya</span></h1>
                <p class="lead mb-4">Top up Diamond, UC, Gems dan beli akun game sultan dengan harga terbaik. Transaksi aman, cepat, dan terpercaya!</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('game.index') }}" class="btn btn-light btn-lg px-4">
                        <i class="bi bi-controller"></i> Pilih Game
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-person-plus"></i> Daftar Sekarang
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <i class="bi bi-controller" style="font-size: 15rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Game Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Pilih Game</h2>
            <p class="text-muted">Top Up & Jual Beli Akun dalam satu tempat</p>
        </div>
        
        <div class="row g-4">
            @forelse($categories as $category)
            <div class="col-lg-2 col-md-3 col-4">
                <a href="{{ route('game.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card game-card-home h-100 border-0 shadow-sm text-center">
                        <div class="card-body p-3">
                            @if($category->icon)
                            <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" 
                                 class="rounded-circle mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                                <i class="bi bi-controller text-white fs-4"></i>
                            </div>
                            @endif
                            <h6 class="card-title mb-0 text-dark fw-semibold small">{{ $category->name }}</h6>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada game tersedia</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('game.index') }}" class="btn btn-outline-primary">
                Lihat Semua Game <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 service-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="service-icon bg-primary me-3">
                                <i class="bi bi-gem text-white"></i>
                            </div>
                            <h4 class="mb-0 fw-bold">Top Up Game</h4>
                        </div>
                        <p class="text-muted mb-3">
                            Top up Diamond Mobile Legends, UC PUBG, Genesis Crystal Genshin Impact, VP Valorant, dan mata uang game lainnya dengan harga termurah!
                        </p>
                        <ul class="list-unstyled text-muted small">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Proses cepat 1-5 menit</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Harga termurah</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>100% Legal & Aman</li>
                        </ul>
                        <a href="{{ route('game.index') }}" class="btn btn-primary">
                            <i class="bi bi-gem me-1"></i>Top Up Sekarang
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 service-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="service-icon bg-success me-3">
                                <i class="bi bi-shop text-white"></i>
                            </div>
                            <h4 class="mb-0 fw-bold">Jual Beli Akun</h4>
                        </div>
                        <p class="text-muted mb-3">
                            Beli akun game sultan dengan skin langka, rank tinggi, dan koleksi lengkap. Semua akun dijamin aman dengan garansi!
                        </p>
                        <ul class="list-unstyled text-muted small">
                            <li><i class="bi bi-check-circle text-success me-2"></i>Akun sultan berkualitas</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Garansi keamanan akun</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Harga nego & terjangkau</li>
                        </ul>
                        <a href="{{ route('game.index') }}" class="btn btn-success">
                            <i class="bi bi-shop me-1"></i>Lihat Akun
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0"><i class="bi bi-star-fill text-warning"></i> Akun Unggulan</h2>
                <p class="text-muted mb-0">Akun game pilihan terbaik untuk kamu</p>
            </div>
            <a href="{{ route('game.index') }}" class="btn btn-outline-primary">Lihat Semua</a>
        </div>
        
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <img src="{{ $product->image ? Storage::url($product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                             class="card-img-top" alt="{{ $product->name }}">
                        @if($product->hasDiscount())
                        <span class="badge-discount">-{{ $product->discount_percentage }}%</span>
                        @endif
                        <span class="badge bg-dark position-absolute top-0 start-0 m-2">
                            {{ $product->category->name }}
                        </span>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">{{ Str::limit($product->name, 35) }}</h6>
                        <div class="d-flex gap-1 mb-2 flex-wrap">
                            @if($product->game_level)
                            <span class="badge bg-light text-dark small">{{ $product->game_level }}</span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="price fw-bold">{{ $product->formatted_price }}</span>
                                @if($product->hasDiscount())
                                <br><span class="price-original small">{{ $product->formatted_original_price }}</span>
                                @endif
                            </div>
                            <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Why Choose Us -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Kenapa Pilih Diks Store?</h2>
            <p class="text-muted">Keunggulan berbelanja di tempat kami</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-shield-check text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <h5>Aman & Terpercaya</h5>
                    <p class="text-muted">Transaksi dijamin aman dengan sistem keamanan terbaik</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-lightning text-success" style="font-size: 2rem;"></i>
                    </div>
                    <h5>Proses Cepat</h5>
                    <p class="text-muted">Top up masuk dalam hitungan menit</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-headset text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <h5>Support 24/7</h5>
                    <p class="text-muted">Tim support siap membantu kapanpun</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-cash-stack text-info" style="font-size: 2rem;"></i>
                    </div>
                    <h5>Harga Terbaik</h5>
                    <p class="text-muted">Harga kompetitif dengan banyak promo</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #6c5ce7, #a29bfe);">
    <div class="container text-center text-white">
        <h2 class="fw-bold mb-3">Siap Memulai?</h2>
        <p class="lead mb-4">Daftar sekarang dan nikmati kemudahan top up & beli akun game!</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('game.index') }}" class="btn btn-light btn-lg px-4">
                <i class="bi bi-controller"></i> Pilih Game
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                <i class="bi bi-person-plus"></i> Daftar Gratis
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .game-card-home {
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .game-card-home:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
    
    .service-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .service-card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
