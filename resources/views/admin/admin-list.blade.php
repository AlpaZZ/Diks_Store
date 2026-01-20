@extends('layouts.admin')

@section('title', 'Daftar Admin - Diks Store')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Daftar Admin</h1>
            <p class="text-muted mb-0">Tim administrator Diks Store</p>
        </div>
        <div>
            <span class="badge bg-success me-2">
                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                Online: {{ $admins->filter(fn($a) => $a->isOnline())->count() }}
            </span>
            <span class="badge bg-secondary">
                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                Offline: {{ $admins->filter(fn($a) => !$a->isOnline())->count() }}
            </span>
        </div>
    </div>

    <div class="row">
        @foreach($admins as $admin)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="position-relative me-3">
                            @if($admin->avatar)
                                <img src="{{ asset('storage/' . $admin->avatar) }}" 
                                     alt="{{ $admin->name }}" 
                                     class="rounded-circle"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                                     style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); font-size: 1.5rem; font-weight: 600;">
                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                </div>
                            @endif
                            <!-- Online/Offline indicator -->
                            <span class="position-absolute bottom-0 end-0 translate-middle-x p-2 border border-white rounded-circle {{ $admin->isOnline() ? 'bg-success' : 'bg-secondary' }}"
                                  style="width: 16px; height: 16px;"
                                  title="{{ $admin->isOnline() ? 'Online' : 'Offline' }}">
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $admin->name }}</h5>
                            <span class="badge {{ $admin->isOnline() ? 'bg-success' : 'bg-secondary' }}">
                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                                {{ $admin->isOnline() ? 'Online' : 'Offline' }}
                            </span>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="d-flex align-items-center text-muted mb-2">
                                    <i class="bi bi-person-badge me-2"></i>
                                    <span class="small">NIM:</span>
                                    <span class="ms-auto fw-semibold text-dark">{{ $admin->nim ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center text-muted mb-2">
                                    <i class="bi bi-envelope me-2"></i>
                                    <span class="small">Email:</span>
                                    <span class="ms-auto fw-semibold text-dark small">{{ $admin->email }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center text-muted mb-2">
                                    <i class="bi bi-telephone me-2"></i>
                                    <span class="small">Phone:</span>
                                    <span class="ms-auto fw-semibold text-dark">{{ $admin->phone ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-clock-history me-2"></i>
                                    <span class="small">Terakhir Aktif:</span>
                                    <span class="ms-auto fw-semibold text-dark small">
                                        @if($admin->last_activity)
                                            {{ $admin->last_activity->diffForHumans() }}
                                        @else
                                            Belum pernah login
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i>
                        Bergabung: {{ $admin->created_at->format('d M Y') }}
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($admins->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-people display-1 text-muted mb-3"></i>
            <h5>Belum ada admin</h5>
            <p class="text-muted">Tidak ada data admin yang tersedia.</p>
        </div>
    </div>
    @endif
</div>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
