@extends('layouts.app')

@section('title', 'Top Up Game - Diks Store')

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-dark text-white" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="bi bi-gem me-2"></i>Top Up Game
                </h1>
                <p class="lead mb-0">Top up diamond, UC, gems, dan mata uang game lainnya dengan harga terbaik!</p>
            </div>
        </div>
    </div>
</section>

<!-- Games Grid -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Pilih Game</h2>
                <p class="text-muted">Pilih game yang ingin kamu top up</p>
            </div>
        </div>

        @if($categories->count() > 0)
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('topup.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card h-100 game-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            @if($category->icon)
                            <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" 
                                 class="mb-3 rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                            <div class="mb-3 mx-auto rounded d-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                                <i class="bi bi-controller text-white" style="font-size: 2rem;"></i>
                            </div>
                            @endif
                            <h5 class="card-title fw-bold mb-2">{{ $category->name }}</h5>
                            <p class="text-muted small mb-0">{{ $category->topups_count }} paket tersedia</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center pb-3">
                            <span class="btn btn-sm btn-outline-primary">
                                Top Up <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-gem display-1 text-muted"></i>
            <h4 class="mt-3">Belum ada game tersedia</h4>
            <p class="text-muted">Top up game akan segera tersedia</p>
        </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-lightning-charge-fill text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold">Proses Cepat</h5>
                    <p class="text-muted mb-0">Top up diproses dalam hitungan menit setelah pembayaran dikonfirmasi</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-shield-check text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold">100% Aman</h5>
                    <p class="text-muted mb-0">Transaksi aman dengan berbagai metode pembayaran terpercaya</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-tags-fill text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold">Harga Terbaik</h5>
                    <p class="text-muted mb-0">Harga kompetitif dengan promo menarik setiap minggunya</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .game-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .game-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
    
    .game-card:hover .btn-outline-primary {
        background: var(--primary-color);
        color: white;
    }
</style>
@endpush
