@extends('layouts.app')

@section('title', 'Dashboard')

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
                    <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.orders*') ? 'active' : '' }}">
                        <i class="bi bi-bag me-2"></i> Pesanan Saya
                    </a>
                    <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                        <i class="bi bi-person me-2"></i> Profil
                    </a>
                    <a href="{{ route('products') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-shop me-2"></i> Belanja
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <h4 class="fw-bold mb-4">Dashboard</h4>
            
            <!-- Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center py-4">
                        <i class="bi bi-bag text-primary" style="font-size: 2.5rem;"></i>
                        <h3 class="fw-bold mt-2 mb-0">{{ $stats['total_orders'] }}</h3>
                        <small class="text-muted">Total Pesanan</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center py-4">
                        <i class="bi bi-clock text-warning" style="font-size: 2.5rem;"></i>
                        <h3 class="fw-bold mt-2 mb-0">{{ $stats['pending_orders'] }}</h3>
                        <small class="text-muted">Menunggu Pembayaran</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center py-4">
                        <i class="bi bi-check-circle text-success" style="font-size: 2.5rem;"></i>
                        <h3 class="fw-bold mt-2 mb-0">{{ $stats['completed_orders'] }}</h3>
                        <small class="text-muted">Pesanan Selesai</small>
                    </div>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-bag"></i> Pesanan Terbaru</h5>
                    <a href="{{ route('user.orders') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Produk</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>{{ Str::limit($order->product->name, 30) }}</td>
                                <td>{{ $order->formatted_total_price }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_badge }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('user.order.detail', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-bag fs-1 d-block mb-2"></i>
                                    Belum ada pesanan. <a href="{{ route('products') }}">Belanja sekarang!</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
