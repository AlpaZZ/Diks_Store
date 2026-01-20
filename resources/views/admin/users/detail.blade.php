@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6c5ce7&color=fff&size=150' }}" 
                     alt="{{ $user->name }}" 
                     class="rounded-circle mb-3" 
                     style="width: 120px; height: 120px; object-fit: cover;">
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                
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
@endsection
