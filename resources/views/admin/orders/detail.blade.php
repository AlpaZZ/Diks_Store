@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Order Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-bag"></i> Pesanan #{{ $order->order_number }}
                </h5>
                <span class="badge badge-{{ $order->status }} fs-6">{{ $order->status_label }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Informasi Pembeli</h6>
                        <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                        <p class="mb-1"><i class="bi bi-envelope"></i> {{ $order->user->email }}</p>
                        @if($order->user->phone)
                            <p class="mb-0"><i class="bi bi-whatsapp"></i> {{ $order->user->phone }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Informasi Pesanan</h6>
                        <p class="mb-1"><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                        <p class="mb-1"><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method) }}</p>
                        @if($order->paid_at)
                            <p class="mb-0"><strong>Dibayar:</strong> {{ $order->paid_at->format('d M Y, H:i') }}</p>
                        @endif
                    </div>
                </div>
                
                @if($order->notes)
                    <hr>
                    <h6 class="text-muted mb-2">Catatan dari Pembeli</h6>
                    <p class="mb-0">{{ $order->notes }}</p>
                @endif
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-box"></i> Produk yang Dibeli</h5>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    @if($order->product->image)
                        <img src="{{ asset('storage/' . $order->product->image) }}" 
                             alt="{{ $order->product->name }}" 
                             class="rounded me-3" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                    @endif
                    <div class="grow">
                        <h5>{{ $order->product->name }}</h5>
                        <p class="text-muted mb-2">{{ $order->product->category->name }}</p>
                        @if($order->product->game_server || $order->product->game_level)
                            <p class="mb-0">
                                @if($order->product->game_server)
                                    <span class="badge bg-secondary">Server: {{ $order->product->game_server }}</span>
                                @endif
                                @if($order->product->game_level)
                                    <span class="badge bg-secondary">Level: {{ $order->product->game_level }}</span>
                                @endif
                            </p>
                        @endif
                    </div>
                    <div class="text-end">
                        <h4 class="text-primary mb-0">{{ $order->formatted_total_price }}</h4>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Payment Proof -->
        @if($order->payment_proof)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-image"></i> Bukti Pembayaran</h5>
            </div>
            <div class="card-body text-center">
                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                         alt="Bukti Pembayaran" 
                         class="img-fluid rounded" 
                         style="max-height: 400px;">
                </a>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-lg-4">
        <!-- Update Status -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Update Status</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pesanan</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                Menunggu Pembayaran
                            </option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                Diproses
                            </option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="credentialsField" @if($order->status == 'completed') style="display: none;" @endif>
                        <label for="account_credentials" class="form-label">
                            Kredensial Akun (untuk pembeli)
                        </label>
                        <textarea class="form-control" id="account_credentials" name="account_credentials" 
                                  rows="4" placeholder="Email: xxx&#10;Password: xxx">{{ $order->account_credentials }}</textarea>
                        <small class="text-muted">Akan dikirim ke pembeli setelah status "Selesai"</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Timeline -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item mb-3">
                        <div class="d-flex">
                            <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 30px; height: 30px; font-size: 12px;">
                                <i class="bi bi-bag"></i>
                            </div>
                            <div>
                                <strong>Pesanan Dibuat</strong>
                                <br><small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    
                    @if($order->paid_at)
                    <div class="timeline-item mb-3">
                        <div class="d-flex">
                            <div class="timeline-icon bg-info text-white rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 30px; height: 30px; font-size: 12px;">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div>
                                <strong>Pembayaran Dikonfirmasi</strong>
                                <br><small class="text-muted">{{ $order->paid_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($order->completed_at)
                    <div class="timeline-item">
                        <div class="d-flex">
                            <div class="timeline-icon bg-success text-white rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 30px; height: 30px; font-size: 12px;">
                                <i class="bi bi-check"></i>
                            </div>
                            <div>
                                <strong>Pesanan Selesai</strong>
                                <br><small class="text-muted">{{ $order->completed_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
    </a>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('status').addEventListener('change', function() {
        const credentialsField = document.getElementById('credentialsField');
        if (this.value === 'completed') {
            credentialsField.style.display = 'block';
        } else {
            credentialsField.style.display = 'none';
        }
    });
</script>
@endpush
