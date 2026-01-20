@extends('layouts.admin')

@section('title', 'Detail Order Top Up')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.topup-orders') }}">Order Top Up</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Order Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">{{ $order->order_number }}</h5>
                    <span class="badge bg-{{ $order->status_badge }} fs-6">{{ $order->status_label }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-person me-1"></i>Informasi Pembeli
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted" width="120">Nama</td>
                                <td class="fw-semibold">{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Telepon</td>
                                <td>{{ $order->user->phone ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-controller me-1"></i>Informasi Game
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted" width="120">Game</td>
                                <td class="fw-semibold">{{ $order->topup->category->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">User ID</td>
                                <td class="fw-semibold">{{ $order->game_id }}</td>
                            </tr>
                            @if($order->game_server)
                            <tr>
                                <td class="text-muted">Server</td>
                                <td>{{ $order->game_server }}</td>
                            </tr>
                            @endif
                            @if($order->game_nickname)
                            <tr>
                                <td class="text-muted">Nickname</td>
                                <td>{{ $order->game_nickname }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <hr>

                <h6 class="fw-bold mb-3">
                    <i class="bi bi-gem me-1"></i>Detail Paket
                </h6>
                <div class="d-flex align-items-center">
                    @if($order->topup->category->icon)
                    <img src="{{ Storage::url($order->topup->category->icon) }}" 
                         alt="{{ $order->topup->category->name }}" 
                         class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                    <div class="rounded me-3 d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: var(--primary-color);">
                        <i class="bi bi-gem text-white fs-4"></i>
                    </div>
                    @endif
                    <div>
                        <h5 class="mb-1">{{ $order->topup->name }}</h5>
                        <p class="mb-0 text-muted">
                            {{ number_format($order->topup->amount) }} {{ $order->topup->currency_name }}
                            @if($order->topup->bonus_amount > 0)
                            <span class="text-success">+ {{ number_format($order->topup->bonus_amount) }} Bonus</span>
                            @endif
                        </p>
                    </div>
                    <div class="ms-auto text-end">
                        <h4 class="mb-0 text-primary">{{ $order->formatted_total_price }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Proof -->
        @if($order->payment_proof)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-image me-1"></i>Bukti Pembayaran
                </h6>
            </div>
            <div class="card-body text-center">
                <img src="{{ Storage::url($order->payment_proof) }}" alt="Bukti Pembayaran" 
                     class="img-fluid rounded" style="max-height: 500px;">
            </div>
        </div>
        @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-image display-1 text-muted"></i>
                <p class="mt-3 mb-0 text-muted">Belum ada bukti pembayaran</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Update Status -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-gear me-1"></i>Update Status
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.topup-orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label fw-semibold">Catatan Admin</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">{{ $order->admin_notes }}</textarea>
                        <div class="form-text">Catatan ini akan terlihat oleh user</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg me-1"></i>Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-clock-history me-1"></i>Timeline
                </h6>
            </div>
            <div class="card-body">
                <div class="timeline-admin">
                    <div class="timeline-item">
                        <div class="timeline-icon bg-primary">
                            <i class="bi bi-cart-check text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Order Dibuat</h6>
                            <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                        </div>
                    </div>
                    @if($order->payment_proof)
                    <div class="timeline-item">
                        <div class="timeline-icon bg-info">
                            <i class="bi bi-upload text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Bukti Pembayaran</h6>
                            <small class="text-muted">Telah diupload</small>
                        </div>
                    </div>
                    @endif
                    @if($order->completed_at)
                    <div class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <i class="bi bi-check-circle text-white"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-0">Selesai</h6>
                            <small class="text-muted">{{ $order->completed_at->format('d M Y, H:i') }}</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline-admin {
        position: relative;
        padding-left: 40px;
    }
    
    .timeline-admin .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-admin .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-admin .timeline-item::before {
        content: '';
        position: absolute;
        left: -32px;
        top: 30px;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-admin .timeline-item:last-child::before {
        display: none;
    }
    
    .timeline-admin .timeline-icon {
        position: absolute;
        left: -40px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
</style>
@endpush
