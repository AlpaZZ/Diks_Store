@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<!-- Hero -->
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Tentang Diks Store</h1>
        <p class="lead">Platform jual beli akun game terpercaya di Indonesia</p>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- About -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">Siapa Kami?</h3>
                    <p>
                        <strong>Diks Store</strong> adalah platform marketplace terpercaya untuk jual beli akun game di Indonesia. 
                        Kami hadir untuk menjembatani para gamer yang ingin menjual atau membeli akun game dengan aman dan nyaman.
                    </p>
                    <p>
                        Didirikan pada tahun 2024, Diks Store telah melayani ribuan transaksi dengan tingkat kepuasan pelanggan 
                        yang tinggi. Kami berkomitmen untuk memberikan layanan terbaik dengan sistem keamanan yang terjamin.
                    </p>
                </div>
            </div>
            
            <!-- Vision Mission -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-eye text-primary fs-4"></i>
                            </div>
                            <h5 class="fw-bold">Visi</h5>
                            <p class="mb-0">Menjadi platform jual beli akun game nomor satu di Indonesia dengan layanan terpercaya dan aman.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-bullseye text-success fs-4"></i>
                            </div>
                            <h5 class="fw-bold">Misi</h5>
                            <p class="mb-0">Memberikan pengalaman transaksi yang aman, cepat, dan memuaskan bagi seluruh pengguna kami.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Why Choose Us -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">Mengapa Memilih Kami?</h3>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-shield-check text-primary fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Transaksi Aman</h6>
                                    <p class="text-muted small mb-0">Sistem keamanan terbaik untuk melindungi setiap transaksi.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-lightning text-warning fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Proses Cepat</h6>
                                    <p class="text-muted small mb-0">Verifikasi dan pengiriman akun dalam hitungan menit.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-headset text-success fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Support 24/7</h6>
                                    <p class="text-muted small mb-0">Tim support siap membantu kapanpun Anda butuhkan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-patch-check text-info fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Garansi Akun</h6>
                                    <p class="text-muted small mb-0">Garansi penuh untuk setiap akun yang dibeli.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="row g-4 text-center">
                <div class="col-4">
                    <div class="card border-0 shadow-sm py-4">
                        <h2 class="text-primary fw-bold mb-0">1000+</h2>
                        <p class="text-muted mb-0">Transaksi Sukses</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow-sm py-4">
                        <h2 class="text-primary fw-bold mb-0">500+</h2>
                        <p class="text-muted mb-0">Pelanggan Puas</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-0 shadow-sm py-4">
                        <h2 class="text-primary fw-bold mb-0">50+</h2>
                        <p class="text-muted mb-0">Game Tersedia</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
