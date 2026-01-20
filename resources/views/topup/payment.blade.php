@extends('layouts.app')

@section('title', 'Pembayaran Top Up - Diks Store')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row g-4">
                    <!-- Payment Info -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-credit-card me-2"></i>Informasi Pembayaran
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="alert alert-info">
                                    <h6 class="fw-bold mb-2">
                                        <i class="bi bi-info-circle me-1"></i>Silakan Transfer ke:
                                    </h6>
                                    <div class="bg-white p-3 rounded">
                                        <p class="mb-1"><strong>Bank BCA</strong></p>
                                        <p class="mb-1">No. Rekening: <strong>1234567890</strong></p>
                                        <p class="mb-1">Atas Nama: <strong>Diks Store</strong></p>
                                        <p class="mb-0 text-primary fw-bold">Jumlah: {{ $order->formatted_total_price }}</p>
                                    </div>
                                </div>

                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    <strong>Penting!</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>Transfer sesuai nominal yang tertera</li>
                                        <li>Simpan bukti transfer untuk diupload</li>
                                        <li>Pembayaran akan diverifikasi dalam 1x24 jam</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Payment Proof -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('topup.uploadPayment', $order->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <label for="payment_proof" class="form-label fw-semibold">
                                            Bukti Transfer <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" 
                                               id="payment_proof" name="payment_proof" accept="image/*" required>
                                        @error('payment_proof')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Format: JPG, PNG. Maksimal 2MB</div>
                                    </div>

                                    <div id="preview-container" class="mb-4 d-none">
                                        <label class="form-label fw-semibold">Preview</label>
                                        <img id="preview-image" src="" alt="Preview" class="img-fluid rounded border" style="max-height: 300px;">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-check-circle me-2"></i>Konfirmasi Pembayaran
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-receipt me-2"></i>Detail Pesanan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">No. Order</small>
                                    <p class="fw-bold mb-0">{{ $order->order_number }}</p>
                                </div>

                                <hr>

                                <div class="d-flex align-items-center mb-3">
                                    @if($order->topup->category->icon)
                                    <img src="{{ Storage::url($order->topup->category->icon) }}" alt="{{ $order->topup->category->name }}" 
                                         class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                    <div class="rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px; background: var(--primary-color);">
                                        <i class="bi bi-controller text-white"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $order->topup->category->name }}</h6>
                                        <small class="text-muted">{{ number_format($order->topup->total_amount) }} {{ $order->topup->currency_name }}</small>
                                    </div>
                                </div>

                                <div class="bg-light p-3 rounded mb-3">
                                    <div class="mb-2">
                                        <small class="text-muted">User ID</small>
                                        <p class="mb-0 fw-semibold">{{ $order->game_id }}</p>
                                    </div>
                                    @if($order->game_server)
                                    <div class="mb-2">
                                        <small class="text-muted">Server ID</small>
                                        <p class="mb-0 fw-semibold">{{ $order->game_server }}</p>
                                    </div>
                                    @endif
                                    @if($order->game_nickname)
                                    <div>
                                        <small class="text-muted">Nickname</small>
                                        <p class="mb-0 fw-semibold">{{ $order->game_nickname }}</p>
                                    </div>
                                    @endif
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Status</span>
                                    <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">Total Bayar</span>
                                    <span class="fw-bold text-primary fs-5">{{ $order->formatted_total_price }}</span>
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

@push('scripts')
<script>
    document.getElementById('payment_proof').addEventListener('change', function(e) {
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
