@extends('layouts.app')

@section('title', 'Profil Saya')

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
                    <a href="{{ route('topup.history') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-gem me-2"></i> Riwayat Top Up
                    </a>
                    <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action active">
                        <i class="bi bi-person me-2"></i> Profil
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <h4 class="fw-bold mb-4">Profil Saya</h4>
            
            <!-- Update Profile -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6c5ce7&color=fff&size=150' }}" 
                                     alt="{{ Auth::user()->name }}" 
                                     class="rounded-circle mb-3" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                                <div>
                                    <input type="file" class="form-control form-control-sm @error('avatar') is-invalid @enderror" 
                                           name="avatar" accept="image/*">
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                    <small class="text-muted">Email tidak dapat diubah</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">No. WhatsApp</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                                           placeholder="08xxxxxxxxxx">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Update Password -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-lock"></i> Ubah Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           name="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" 
                                           name="password_confirmation" required>
                                </div>
                                
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-lock"></i> Ubah Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
