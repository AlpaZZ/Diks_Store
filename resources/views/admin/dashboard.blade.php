@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label mb-1">Total Produk</p>
                    <h3 class="stat-value mb-0">{{ $stats['total_products'] }}</h3>
                </div>
                <div class="stat-icon bg-primary">
                    <i class="bi bi-box"></i>
                </div>
            </div>
            <small class="text-success">
                <i class="bi bi-check-circle"></i> {{ $stats['available_products'] }} tersedia
            </small>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label mb-1">Total Pesanan</p>
                    <h3 class="stat-value mb-0">{{ $stats['total_orders'] }}</h3>
                </div>
                <div class="stat-icon bg-success">
                    <i class="bi bi-bag"></i>
                </div>
            </div>
            <small class="text-warning">
                <i class="bi bi-clock"></i> {{ $stats['pending_orders'] }} menunggu
            </small>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label mb-1">Total User</p>
                    <h3 class="stat-value mb-0">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="stat-icon bg-info">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <small class="text-muted">
                <i class="bi bi-person-check"></i> Pengguna terdaftar
            </small>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="stat-label mb-1">Total Pendapatan</p>
                    <h3 class="stat-value mb-0">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                </div>
                <div class="stat-icon bg-warning">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
            <small class="text-success">
                <i class="bi bi-graph-up"></i> Dari transaksi selesai
            </small>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-bag"></i> Pesanan Terbaru</h5>
                <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Pembeli</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ Str::limit($order->product->name, 30) }}</td>
                            <td>{{ $order->formatted_total_price }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada pesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Recent Products -->
    <div class="col-lg-4">
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-box"></i> Produk Terbaru</h5>
                <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="p-3">
                @forelse($recentProducts as $product)
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <img src="{{ $product->category && $product->category->icon ? asset('storage/' . $product->category->icon) : 'https://via.placeholder.com/60x60?text=No+Image' }}" 
                         alt="{{ $product->name }}" 
                         class="rounded me-3" 
                         style="width: 50px; height: 50px; object-fit: cover;">
                    <div class="grow">
                        <h6 class="mb-1">{{ Str::limit($product->name, 25) }}</h6>
                        <small class="text-primary fw-bold">{{ $product->formatted_price }}</small>
                    </div>
                    <span class="badge badge-{{ $product->status }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-box fs-1 d-block mb-2"></i>
                    Belum ada produk
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><i class="bi bi-lightning"></i> Aksi Cepat</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Produk
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-grid-plus"></i> Tambah Kategori
                    </a>
                    <a href="{{ route('admin.orders') }}?status=pending" class="btn btn-outline-warning">
                        <i class="bi bi-clock"></i> Pesanan Pending
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary">
                        <i class="bi bi-globe"></i> Lihat Website
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
