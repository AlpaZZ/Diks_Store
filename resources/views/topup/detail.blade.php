@extends('layouts.app')

@section('title', 'Detail Top Up - Diks Store')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('topup.history') }}">Riwayat Top Up</a></li>
                        <li class="breadcrumb-item active">{{ $order->order_number }}</li>
                    </ol>
                </nav>

                <div class="row g-4">
                    <!-- Order Details -->
                    <div class="col-lg-7">
                        <!-- Status Card -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ $order->order_number }}</h5>
                                        <p class="text-muted mb-0">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <span class="badge bg-{{ $order->status_badge }} fs-6 px-3 py-2">
                                        {{ $order->status_label }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Game Info -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-controller me-2"></i>Informasi Game
                                </h6>
                            </div>
                            <div class="card-body">
                                @if($order->topup)
                                <div class="d-flex align-items-center mb-3">
                                    @if($order->topup->category?->icon)
                                    <img src="{{ Storage::url($order->topup->category->icon) }}" 
                                         alt="{{ $order->topup->category->name }}" 
                                         class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                    <div class="rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px; background: var(--primary-color);">
                                        <i class="bi bi-controller text-white fs-4"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <h5 class="mb-1 fw-bold">{{ $order->topup->category?->name ?? 'Kategori Dihapus' }}</h5>
                                        <p class="mb-0 text-primary fw-semibold">
                                            {{ number_format($order->topup->total_amount) }} {{ $order->topup->currency_name }}
                                        </p>
                                    </div>
                                </div>
                                @else
                                <div class="alert alert-warning mb-3">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Paket top up ini sudah tidak tersedia.
                                </div>
                                @endif

                                <hr>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">User ID</small>
                                        <span class="fw-semibold">{{ $order->game_id }}</span>
                                    </div>
                                    @if($order->game_server)
                                    <div class="col-6">
                                        <small class="text-muted d-block">Server ID</small>
                                        <span class="fw-semibold">{{ $order->game_server }}</span>
                                    </div>
                                    @endif
                                    @if($order->game_nickname)
                                    <div class="col-6">
                                        <small class="text-muted d-block">Nickname</small>
                                        <span class="fw-semibold">{{ $order->game_nickname }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Payment Proof -->
                        @if($order->payment_proof)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-image me-2"></i>Bukti Pembayaran
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                <img src="{{ Storage::url($order->payment_proof) }}" alt="Bukti Pembayaran" 
                                     class="img-fluid rounded" style="max-height: 400px;">
                            </div>
                        </div>
                        @endif

                        <!-- Admin Notes -->
                        @if($order->admin_notes)
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-chat-left-text me-2"></i>Catatan Admin
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $order->admin_notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-receipt me-2"></i>Ringkasan Pesanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Produk</span>
                                    <span>{{ $order->topup ? number_format($order->topup->amount) . ' ' . $order->topup->currency_name : '-' }}</span>
                                </div>
                                @if($order->topup && $order->topup->bonus_amount > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Bonus</span>
                                    <span class="text-success">+{{ number_format($order->topup->bonus_amount) }}</span>
                                </div>
                                @endif

                                <hr>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fw-bold">Total Bayar</span>
                                    <span class="fw-bold text-primary fs-5">{{ $order->formatted_total_price }}</span>
                                </div>

                                @if($order->status == 'pending')
                                <a href="{{ route('topup.payment', $order->id) }}" class="btn btn-primary w-100">
                                    <i class="bi bi-credit-card me-1"></i>Upload Bukti Pembayaran
                                </a>
                                @endif

                                @if($order->completed_at)
                                <div class="alert alert-success mb-0 mt-3">
                                    <small>
                                        <i class="bi bi-check-circle me-1"></i>
                                        Selesai pada {{ $order->completed_at->format('d M Y, H:i') }}
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-clock-history me-2"></i>Status Pesanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item {{ in_array($order->status, ['pending', 'processing', 'completed']) ? 'active' : '' }}">
                                        <div class="timeline-icon">
                                            <i class="bi bi-cart-check"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="mb-0">Pesanan Dibuat</h6>
                                            <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                        </div>
                                    </div>
                                    <div class="timeline-item {{ in_array($order->status, ['processing', 'completed']) ? 'active' : '' }}">
                                        <div class="timeline-icon">
                                            <i class="bi bi-hourglass-split"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="mb-0">Sedang Diproses</h6>
                                            <small class="text-muted">Menunggu verifikasi pembayaran</small>
                                        </div>
                                    </div>
                                    <div class="timeline-item {{ $order->status == 'completed' ? 'active' : '' }}">
                                        <div class="timeline-icon">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="mb-0">Selesai</h6>
                                            <small class="text-muted">
                                                @if($order->completed_at)
                                                {{ $order->completed_at->format('d M Y, H:i') }}
                                                @elseif($order->topup)
                                                {{ $order->topup->currency_name }} telah dikirim
                                                @else
                                                Pesanan selesai
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
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
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -23px;
        top: 25px;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item:last-child::before {
        display: none;
    }
    
    .timeline-icon {
        position: absolute;
        left: -30px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #6c757d;
    }
    
    .timeline-item.active .timeline-icon {
        background: var(--primary-color);
        color: white;
    }
    
    .timeline-item.active::before {
        background: var(--primary-color);
    }
</style>
@endpush
