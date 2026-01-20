@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">Daftar pengguna terdaftar di Diks Store</p>
    </div>
</div>

<!-- Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.users') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" class="form-control" name="search" 
                       placeholder="Cari nama atau email pengguna..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 60px;">Avatar</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Total Pesanan</th>
                    <th>Bergabung</th>
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6c5ce7&color=fff' }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle" 
                             style="width: 45px; height: 45px; object-fit: cover;">
                    </td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $user->orders_count }} pesanan</span>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.users.detail', $user->id) }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-people fs-1 text-muted d-block mb-3"></i>
                        <p class="text-muted">Belum ada pengguna terdaftar</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="card-footer bg-white d-flex justify-content-center">
        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<style>
    .pagination { margin-bottom: 0; }
    .pagination .page-link { padding: 0.375rem 0.75rem; font-size: 0.875rem; }
    .pagination .page-item.active .page-link { background: linear-gradient(135deg, #6c5ce7, #a29bfe); border-color: #6c5ce7; }
</style>
@endsection
