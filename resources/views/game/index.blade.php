@extends('layouts.app')

@section('title', 'Pilih Game - Diks Store')

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-dark text-white" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="bi bi-controller me-2"></i>Pilih Game
                </h1>
                <p class="lead mb-0">Top Up Diamond, UC, Gems & Jual Beli Akun Game Terpercaya</p>
            </div>
        </div>
    </div>
</section>

<!-- Games Grid -->
<section class="py-5">
    <div class="container">
        @if($categories->count() > 0)
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('game.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card game-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            @if($category->icon)
                            <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" 
                                 class="mb-3 rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                            <div class="mb-3 mx-auto rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                                <i class="bi bi-controller text-white" style="font-size: 2rem;"></i>
                            </div>
                            @endif
                            <h5 class="card-title fw-bold mb-2 text-dark">{{ $category->name }}</h5>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                @if($category->topups_count > 0)
                                <span class="badge bg-primary-subtle text-primary">
                                    <i class="bi bi-gem"></i> Top Up
                                </span>
                                @endif
                                @if($category->products_count > 0)
                                <span class="badge bg-success-subtle text-success">
                                    <i class="bi bi-shop"></i> {{ $category->products_count }} Akun
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center pb-3">
                            <span class="btn btn-sm btn-primary px-4">
                                Lihat <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-controller display-1 text-muted"></i>
            <h4 class="mt-3">Belum ada game tersedia</h4>
            <p class="text-muted">Game akan segera ditambahkan</p>
        </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="fw-bold text-center mb-5">Layanan Kami</h3>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <div class="feature-icon me-4">
                                <i class="bi bi-gem"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold">Top Up Game</h5>
                                <p class="text-muted mb-0">
                                    Top up Diamond, UC, Genesis Crystals, VP, Gems dan mata uang game lainnya dengan harga termurah dan proses cepat.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <div class="feature-icon me-4">
                                <i class="bi bi-shop"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold">Jual Beli Akun</h5>
                                <p class="text-muted mb-0">
                                    Beli akun game sultan dengan skin langka, rank tinggi, dan koleksi lengkap. Semua akun dijamin aman dan legal.
                                </p>
                            </div>
                        </div>
                    </div>
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
        border-radius: 20px;
        overflow: hidden;
    }
    
    .game-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15) !important;
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        min-width: 60px;
        border-radius: 15px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
    
    .bg-primary-subtle {
        background-color: rgba(108, 92, 231, 0.15) !important;
    }
    
    .bg-success-subtle {
        background-color: rgba(0, 184, 148, 0.15) !important;
    }
</style>
@endpush
