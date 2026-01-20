@extends('layouts.app')

@section('title', 'Top Up ' . $category->name . ' - Diks Store')

@section('content')
<!-- Hero Section -->
<section class="py-4 bg-dark text-white" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                @if($category->icon)
                <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" 
                     class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                @else
                <div class="rounded d-flex align-items-center justify-content-center" 
                     style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                    <i class="bi bi-controller text-white" style="font-size: 2rem;"></i>
                </div>
                @endif
            </div>
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('topup.index') }}" class="text-white-50">Top Up</a></li>
                        <li class="breadcrumb-item active text-white">{{ $category->name }}</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold mb-0">Top Up {{ $category->name }}</h1>
            </div>
        </div>
    </div>
</section>

<!-- Top Up Packages -->
<section class="py-5">
    <div class="container">
        @if($topups->count() > 0)
        @php
            $currencyName = $topups->first()->currency_name ?? 'Currency';
            $currencyIcon = $topups->first()->currency_icon;
        @endphp
        
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold">
                    <i class="bi bi-gem me-2 text-primary"></i>Pilih Nominal {{ $currencyName }}
                </h4>
            </div>
        </div>

        <div class="row g-3">
            @foreach($topups as $topup)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card topup-card h-100 border {{ $topup->is_popular ? 'border-primary' : '' }}" 
                     data-id="{{ $topup->id }}" data-price="{{ $topup->price }}">
                    @if($topup->is_popular)
                    <div class="popular-badge">
                        <span class="badge bg-primary">Populer</span>
                    </div>
                    @endif
                    @if($topup->has_discount)
                    <div class="discount-badge">
                        <span class="badge bg-danger">-{{ $topup->discount_percent }}%</span>
                    </div>
                    @endif
                    
                    <div class="card-body text-center p-3">
                        <div class="currency-icon mb-2">
                            @if($currencyIcon)
                            <img src="{{ Storage::url($currencyIcon) }}" alt="{{ $currencyName }}" style="width: 40px; height: 40px;">
                            @else
                            <i class="bi bi-gem text-warning" style="font-size: 2rem;"></i>
                            @endif
                        </div>
                        
                        <h5 class="fw-bold mb-1">{{ number_format($topup->amount) }}</h5>
                        @if($topup->bonus_amount > 0)
                        <p class="text-success small mb-2">
                            <i class="bi bi-plus-circle"></i> Bonus {{ number_format($topup->bonus_amount) }}
                        </p>
                        @else
                        <p class="text-muted small mb-2">{{ $currencyName }}</p>
                        @endif
                        
                        <div class="price-section">
                            @if($topup->has_discount)
                            <small class="text-muted text-decoration-line-through d-block">{{ $topup->formatted_original_price }}</small>
                            @endif
                            <span class="fw-bold text-primary">{{ $topup->formatted_price }}</span>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        @auth
                        <a href="{{ route('topup.order', $topup->id) }}" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-cart-plus me-1"></i>Beli
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
            <h4 class="mt-3">Belum ada paket tersedia</h4>
            <p class="text-muted">Paket top up untuk game ini akan segera tersedia</p>
            <a href="{{ route('topup.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
        @endif
    </div>
</section>

<!-- How to Top Up -->
<section class="py-5 bg-light">
    <div class="container">
        <h4 class="fw-bold text-center mb-4">Cara Top Up {{ $category->name }}</h4>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center">
                    <div class="step-number mx-auto mb-3">1</div>
                    <h6 class="fw-bold">Pilih Nominal</h6>
                    <p class="text-muted small mb-0">Pilih nominal {{ $currencyName ?? 'currency' }} yang ingin dibeli</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="step-number mx-auto mb-3">2</div>
                    <h6 class="fw-bold">Masukkan ID</h6>
                    <p class="text-muted small mb-0">Masukkan User ID dan Server ID game kamu</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="step-number mx-auto mb-3">3</div>
                    <h6 class="fw-bold">Bayar</h6>
                    <p class="text-muted small mb-0">Lakukan pembayaran dan upload bukti transfer</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="step-number mx-auto mb-3">4</div>
                    <h6 class="fw-bold">Selesai</h6>
                    <p class="text-muted small mb-0">{{ $currencyName ?? 'Currency' }} akan masuk ke akun game kamu</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .topup-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        position: relative;
        overflow: hidden;
    }
    
    .topup-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .popular-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 1;
    }
    
    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1;
    }
    
    .step-number {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
    }
</style>
@endpush
