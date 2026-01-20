@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4 {{ $user->is_banned ? 'border-danger border-2' : '' }}">
            <div class="card-body text-center">
                @if($user->is_banned)
                <div class="alert alert-danger mb-3">
                    <i class="bi bi-ban"></i> <strong>User Dibanned</strong>
                    @if($user->ban_reason)
                    <p class="mb-0 small mt-1">Alasan: {{ $user->ban_reason }}</p>
                    @endif
                    <p class="mb-0 small">Pada: {{ $user->banned_at->format('d M Y, H:i') }}</p>
                </div>
                @endif
                
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6c5ce7&color=fff&size=150' }}" 
                     alt="{{ $user->name }}" 
                     class="rounded-circle mb-3" 
                     style="width: 120px; height: 120px; object-fit: cover;">
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                
                <!-- Ban/Unban Button -->
                @if($user->is_banned)
                    <form action="{{ route('admin.users.unban', $user->id) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin meng-unban user ini?')">
                            <i class="bi bi-check-circle"></i> Unban User
                        </button>
                    </form>
                @else
                    <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#banModal">
                        <i class="bi bi-ban"></i> Ban User
                    </button>
                @endif
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="mb-0">{{ $user->orders->count() }}</h5>
                        <small class="text-muted">Total Pesanan</small>
                    </div>
                    <div class="col-6">
                        <h5 class="mb-0">{{ $user->orders->where('status', 'completed')->count() }}</h5>
                        <small class="text-muted">Selesai</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Informasi</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            @if($user->is_banned)
                                <span class="badge bg-danger"><i class="bi bi-ban"></i> Banned</span>
                            @else
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. Telepon</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Bergabung</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Total Belanja</td>
                        <td>Rp {{ number_format($user->orders->where('status', 'completed')->sum('total_price'), 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-bag"></i> Riwayat Pesanan</h5>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.detail', $order->id) }}">
                                    <strong>{{ $order->order_number }}</strong>
                                </a>
                            </td>
                            <td>{{ Str::limit($order->product->name, 30) }}</td>
                            <td>{{ $order->formatted_total_price }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Pengguna ini belum memiliki pesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pengguna
    </a>
</div>

<!-- Ban Modal -->
@if(!$user->is_banned)
<div class="modal fade" id="banModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.ban', $user->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-ban text-danger"></i> Ban User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin memban user <strong>{{ $user->name }}</strong>?</p>
                    <p class="text-muted small">User yang dibanned tidak akan bisa login ke dalam sistem.</p>
                    <div class="mb-3">
                        <label class="form-label">Alasan Ban (opsional)</label>
                        <textarea name="ban_reason" class="form-control" rows="3" 
                                  placeholder="Masukkan alasan ban..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-ban"></i> Ban User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
