@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6c5ce7&color=fff&size=100' }}" 
                         alt="{{ Auth::user()->name }}" 
                         class="rounded-circle mb-3" 
                         style="width: 100px; height: 100px; object-fit: cover;">
                    <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small">{{ Auth::user()->email }}</p>
                </div>
                <hr class="my-0">
                <div class="list-group list-group-flush">
                    <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action active">
                        <i class="bi bi-bag me-2"></i> Pesanan Akun
                    </a>
                    <a href="{{ route('topup.history') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-gem me-2"></i> Riwayat Top Up
                    </a>
                    <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-person me-2"></i> Profil
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Detail Pesanan</h4>
                <a href="{{ route('user.orders') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            
            <!-- Order Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $order->order_number }}</h5>
                        <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                    </div>
                    <span class="badge bg-{{ $order->status_badge }} fs-6">{{ $order->status_label }}</span>
                </div>
                <div class="card-body">
                    <!-- Product -->
                    <div class="d-flex mb-4">
                        <img src="{{ $order->product->image ? asset('storage/' . $order->product->image) : 'https://via.placeholder.com/100x100' }}" 
                             alt="{{ $order->product->name }}" 
                             class="rounded me-3" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h5>{{ $order->product->name }}</h5>
                            <p class="text-muted mb-1">{{ $order->product->category->name }}</p>
                            @if($order->product->game_server || $order->product->game_level)
                                <p class="mb-0 small">
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
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Metode Pembayaran</h6>
                            <p>{{ ucfirst($order->payment_method) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Catatan</h6>
                            <p>{{ $order->notes ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions based on status -->
            @if($order->status === 'pending')
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-credit-card"></i> Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle"></i> Silakan lakukan pembayaran dan upload bukti pembayaran.
                    </div>
                    
                    <div class="bg-light p-3 rounded mb-4">
                        <h6>Transfer ke:</h6>
                        <p class="mb-1"><strong>Bank BCA</strong> - 1234567890</p>
                        <p class="mb-1"><strong>Bank BRI</strong> - 0987654321</p>
                        <p class="mb-0">a.n. <strong>Diks Store</strong></p>
                    </div>
                    
                    @if($order->payment_proof)
                        <div class="mb-4">
                            <h6>Bukti Pembayaran Anda:</h6>
                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                                     alt="Bukti Pembayaran" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px;">
                            </a>
                        </div>
                    @endif
                    
                    <form action="{{ route('user.order.upload-proof', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Upload Bukti Pembayaran</label>
                            <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" 
                                   name="payment_proof" accept="image/*" required>
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload"></i> Upload Bukti
                        </button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <form action="{{ route('user.order.cancel', $order->id) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-x-circle"></i> Batalkan Pesanan
                        </button>
                    </form>
                </div>
            </div>
            @endif
            
            @if($order->status === 'processing')
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-hourglass-split"></i> Pembayaran Anda sedang diverifikasi. Harap tunggu konfirmasi dari admin.
                    </div>
                </div>
            </div>
            @endif
            
            @if($order->status === 'completed' && $order->account_credentials)
            <div class="card border-0 shadow-sm mb-4 border-success">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-key"></i> Kredensial Akun</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> <strong>PENTING!</strong> Segera ganti password dan data keamanan akun setelah menerima.
                    </div>
                    <div class="bg-light p-3 rounded" style="white-space: pre-line;">{{ $order->account_credentials }}</div>
                </div>
            </div>
            @endif
            
            <!-- Contact -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <p class="mb-3">Ada pertanyaan tentang pesanan ini?</p>
                    <a href="https://wa.me/6281234567890?text=Halo, saya ingin bertanya tentang pesanan {{ $order->order_number }}" 
                       target="_blank" class="btn btn-success">
                        <i class="bi bi-whatsapp"></i> Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
