@extends('layouts.app')

@section('title', 'Order Top Up - Diks Store')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('topup.index') }}">Top Up</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('topup.show', $topup->category->slug) }}">{{ $topup->category->name }}</a></li>
                        <li class="breadcrumb-item active">Order</li>
                    </ol>
                </nav>

                <div class="row g-4">
                    <!-- Order Form -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-controller me-2"></i>Masukkan Data Akun
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('topup.processOrder', $topup->id) }}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label for="game_id" class="form-label fw-semibold">
                                            User ID / Player ID <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('game_id') is-invalid @enderror" 
                                               id="game_id" name="game_id" value="{{ old('game_id') }}" 
                                               placeholder="Masukkan User ID game kamu" required>
                                        @error('game_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            @if($topup->category->slug == 'mobile-legends')
                                            Contoh: 123456789 (dapat dilihat di profil game)
                                            @elseif($topup->category->slug == 'free-fire')
                                            Contoh: 123456789 (dapat dilihat di profil game)
                                            @elseif($topup->category->slug == 'pubg-mobile')
                                            Contoh: 5123456789 (dapat dilihat di profil game)
                                            @elseif($topup->category->slug == 'genshin-impact')
                                            Contoh: 812345678 (dapat dilihat di Paimon Menu > Settings)
                                            @elseif($topup->category->slug == 'valorant')
                                            Masukkan Riot ID kamu (contoh: Player#TAG)
                                            @else
                                            Masukkan ID akun game kamu
                                            @endif
                                        </div>
                                    </div>

                                    @if(in_array($topup->category->slug, ['mobile-legends', 'genshin-impact']))
                                    <div class="mb-3">
                                        <label for="game_server" class="form-label fw-semibold">
                                            Server ID / Zone ID
                                        </label>
                                        <input type="text" class="form-control @error('game_server') is-invalid @enderror" 
                                               id="game_server" name="game_server" value="{{ old('game_server') }}" 
                                               placeholder="Masukkan Server/Zone ID">
                                        @error('game_server')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            @if($topup->category->slug == 'mobile-legends')
                                            Contoh: 1234 (Zone ID di sebelah User ID)
                                            @elseif($topup->category->slug == 'genshin-impact')
                                            Pilih server: os_asia, os_euro, os_usa, os_cht
                                            @endif
                                        </div>
                                    </div>
                                    @endif

                                    <div class="mb-4">
                                        <label for="game_nickname" class="form-label fw-semibold">
                                            Nickname (Opsional)
                                        </label>
                                        <input type="text" class="form-control @error('game_nickname') is-invalid @enderror" 
                                               id="game_nickname" name="game_nickname" value="{{ old('game_nickname') }}" 
                                               placeholder="Masukkan nickname untuk verifikasi">
                                        @error('game_nickname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Nickname akan digunakan untuk verifikasi akun</div>
                                    </div>

                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        <strong>Penting!</strong> Pastikan User ID dan Server ID sudah benar. Kesalahan input bukan tanggung jawab kami.
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-cart-check me-2"></i>Buat Pesanan
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
                                    <i class="bi bi-receipt me-2"></i>Ringkasan Pesanan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    @if($topup->category->icon)
                                    <img src="{{ Storage::url($topup->category->icon) }}" alt="{{ $topup->category->name }}" 
                                         class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                    <div class="rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                                        <i class="bi bi-controller text-white"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $topup->category->name }}</h6>
                                        <small class="text-muted">Top Up {{ $topup->currency_name }}</small>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Produk</span>
                                    <span class="fw-semibold">{{ number_format($topup->amount) }} {{ $topup->currency_name }}</span>
                                </div>

                                @if($topup->bonus_amount > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Bonus</span>
                                    <span class="text-success fw-semibold">+{{ number_format($topup->bonus_amount) }} {{ $topup->currency_name }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Total {{ $topup->currency_name }}</span>
                                    <span class="fw-bold">{{ number_format($topup->total_amount) }} {{ $topup->currency_name }}</span>
                                </div>
                                @endif

                                <hr>

                                @if($topup->has_discount)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Harga Normal</span>
                                    <span class="text-decoration-line-through">{{ $topup->formatted_original_price }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Diskon</span>
                                    <span class="text-success">-{{ $topup->discount_percent }}%</span>
                                </div>
                                @endif

                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">Total Bayar</span>
                                    <span class="fw-bold text-primary fs-5">{{ $topup->formatted_price }}</span>
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
