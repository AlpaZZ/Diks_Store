@extends('layouts.admin')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">Kelola semua pesanan dari pembeli</p>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.orders') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" class="form-control" name="search" 
                       placeholder="Cari nomor order..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Filter
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
                    <th>Order ID</th>
                    <th>Pembeli</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>
                        {{ $order->user->name }}
                        <br><small class="text-muted">{{ $order->user->email }}</small>
                    </td>
                    <td>{{ Str::limit($order->product->name, 30) }}</td>
                    <td><strong class="text-primary">{{ $order->formatted_total_price }}</strong></td>
                    <td>
                        <span class="badge bg-secondary">{{ ucfirst($order->payment_method) }}</span>
                        @if($order->payment_proof)
                            <br><a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="small">
                                <i class="bi bi-image"></i> Lihat Bukti
                            </a>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $order->status }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td>
                        {{ $order->created_at->format('d M Y') }}
                        <br><small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.detail', $order->id) }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-bag fs-1 text-muted d-block mb-3"></i>
                        <p class="text-muted">Belum ada pesanan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
    <div class="card-footer bg-white d-flex justify-content-center">
        {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<style>
    .pagination { margin-bottom: 0; }
    .pagination .page-link { padding: 0.375rem 0.75rem; font-size: 0.875rem; }
    .pagination .page-item.active .page-link { background: linear-gradient(135deg, #6c5ce7, #a29bfe); border-color: #6c5ce7; }
</style>
@endsection
