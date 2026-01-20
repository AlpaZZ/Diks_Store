@extends('layouts.app')

@section('title', 'Pembayaran Top Up - Diks Store')

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
                    <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-bag me-2"></i> Pesanan Akun
                    </a>
                    <a href="{{ route('topup.history') }}" class="list-group-item list-group-item-action active">
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
                <h4 class="fw-bold mb-0">Pembayaran Top Up</h4>
                <a href="{{ route('topup.history') }}" class="btn btn-outline-secondary btn-sm">
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
                        @if($order->topup->category->icon)
                        <img src="{{ asset('storage/' . $order->topup->category->icon) }}" 
                             alt="{{ $order->topup->category->name }}" 
                             class="rounded me-3" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                        <div class="rounded me-3 d-flex align-items-center justify-content-center bg-primary" 
                             style="width: 100px; height: 100px;">
                            <i class="bi bi-gem text-white" style="font-size: 2.5rem;"></i>
                        </div>
                        @endif
                        <div class="flex-grow-1">
                            <h5>{{ $order->topup->category->name }}</h5>
                            <p class="text-primary fw-bold mb-1">
                                {{ number_format($order->topup->amount) }} 
                                @if($order->topup->bonus_amount > 0)
                                    + {{ number_format($order->topup->bonus_amount) }} Bonus
                                @endif
                                {{ $order->topup->currency_name }}
                            </p>
                            <p class="mb-0 small">
                                <span class="badge bg-secondary">User ID: {{ $order->game_id }}</span>
                                @if($order->game_server)
                                    <span class="badge bg-secondary">Server: {{ $order->game_server }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="text-end">
                            <h4 class="text-primary mb-0">{{ $order->formatted_total_price }}</h4>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">User ID Game</h6>
                            <p class="fw-semibold">{{ $order->game_id }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Nickname</h6>
                            <p>{{ $order->game_nickname ?? '-' }}</p>
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
                        <p class="mb-1"><strong>DANA</strong> - 081234567890</p>
                        <p class="mb-0">a.n. <strong>Diks Store</strong></p>
                        <hr>
                        <p class="mb-0 text-primary fw-bold">Jumlah: {{ $order->formatted_total_price }}</p>
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
                    
                    <form action="{{ route('topup.uploadPayment', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" 
                                   id="payment_proof" name="payment_proof" accept="image/*" required>
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format: JPG, PNG. Maksimal 2MB</div>
                        </div>
                        
                        <div id="preview-container" class="mb-4 d-none">
                            <label class="form-label fw-semibold">Preview</label>
                            <img id="preview-image" src="" alt="Preview" class="img-fluid rounded border" style="max-height: 200px;">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload"></i> Upload Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
            @endif
            
            @if($order->status === 'processing')
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-hourglass-split"></i> Pembayaran Anda sedang diverifikasi. {{ $order->topup->currency_name }} akan dikirim dalam 1-5 menit setelah verifikasi.
                    </div>
                    
                    @if($order->payment_proof)
                    <div class="mt-3">
                        <h6>Bukti Pembayaran:</h6>
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                                 alt="Bukti Pembayaran" 
                                 class="img-fluid rounded" 
                                 style="max-height: 200px;">
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            @if($order->status === 'completed')
            <div class="card border-0 shadow-sm mb-4 border-success">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-check-circle"></i> Top Up Berhasil</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="bi bi-gem"></i> <strong>Selamat!</strong> 
                        {{ number_format($order->topup->total_amount) }} {{ $order->topup->currency_name }} telah dikirim ke akun Anda.
                    </div>
                    @if($order->admin_notes)
                    <div class="bg-light p-3 rounded">
                        <strong>Catatan Admin:</strong><br>
                        {{ $order->admin_notes }}
                    </div>
                    @endif
                    @if($order->completed_at)
                    <p class="text-muted small mt-2 mb-0">
                        Selesai pada: {{ $order->completed_at->format('d M Y, H:i') }}
                    </p>
                    @endif
                </div>
            </div>
            @endif
            
            @if($order->status === 'failed')
            <div class="card border-0 shadow-sm mb-4 border-danger">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-x-circle"></i> Top Up Gagal</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> Maaf, top up gagal diproses.
                    </div>
                    @if($order->admin_notes)
                    <div class="bg-light p-3 rounded">
                        <strong>Alasan:</strong><br>
                        {{ $order->admin_notes }}
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Contact -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <p class="mb-3">Ada pertanyaan tentang pesanan ini?</p>
                    <a href="https://wa.me/6281234567890?text=Halo, saya ingin bertanya tentang top up {{ $order->order_number }}" 
                       target="_blank" class="btn btn-success">
                        <i class="bi bi-whatsapp"></i> Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('payment_proof')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-container').classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
