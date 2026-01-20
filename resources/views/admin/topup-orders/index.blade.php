@extends('layouts.admin')

@section('title', 'Order Top Up')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Order Top Up</h2>
        <p class="text-muted mb-0">Kelola pesanan top up dari pelanggan</p>
    </div>
</div>

<!-- Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.topup-orders') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari no order, game ID, atau nama..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="{{ route('admin.topup-orders') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Orders List -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No. Order</th>
                    <th>User</th>
                    <th>Game</th>
                    <th>Paket</th>
                    <th>Game ID</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <span class="fw-semibold">{{ $order->order_number }}</span>
                    </td>
                    <td>
                        <span>{{ $order->user->name }}</span>
                        <br><small class="text-muted">{{ $order->user->email }}</small>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($order->topup->category->icon)
                            <img src="{{ Storage::url($order->topup->category->icon) }}" 
                                 alt="{{ $order->topup->category->name }}" 
                                 class="rounded me-2" style="width: 25px; height: 25px; object-fit: cover;">
                            @endif
                            <span>{{ $order->topup->category->name }}</span>
                        </div>
                    </td>
                    <td>{{ number_format($order->topup->total_amount) }} {{ $order->topup->currency_name }}</td>
                    <td>
                        <span class="fw-semibold">{{ $order->game_id }}</span>
                        @if($order->game_server)
                        <br><small class="text-muted">Server: {{ $order->game_server }}</small>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $order->formatted_total_price }}</td>
                    <td>
                        <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.topup-orders.detail', $order->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <i class="bi bi-receipt display-4 text-muted"></i>
                        <p class="mt-2 mb-0">Belum ada order top up</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($orders->hasPages())
<div class="mt-4 d-flex justify-content-center">
    {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endif

<style>
    .pagination { margin-bottom: 0; }
    .pagination .page-link { padding: 0.375rem 0.75rem; font-size: 0.875rem; }
    .pagination .page-item.active .page-link { background: linear-gradient(135deg, #6c5ce7, #a29bfe); border-color: #6c5ce7; }
</style>
@endsection
