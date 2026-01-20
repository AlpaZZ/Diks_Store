@extends('layouts.app')

@section('title', 'Riwayat Top Up - Diks Store')

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
                    <a href="{{ route('topup.history') }}" class="list-group-item list-group-item-action active">
                        <i class="bi bi-gem me-2"></i> Riwayat Top Up
                    </a>
                    <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action">
                        <i class="bi bi-person me-2"></i> Profil
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Riwayat Top Up</h4>
                <a href="{{ route('game.index') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Top Up Baru
                </a>
            </div>

            @if($orders->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Order</th>
                                <th>Game</th>
                                <th>Paket</th>
                                <th>User ID</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ $order->order_number }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($order->topup && $order->topup->category && $order->topup->category->icon)
                                        <img src="{{ asset('storage/' . $order->topup->category->icon) }}" 
                                             alt="{{ $order->topup->category->name }}" 
                                             class="rounded me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                        @endif
                                        <span>{{ $order->topup->category->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    {{ number_format($order->topup->total_amount ?? 0) }} {{ $order->topup->currency_name ?? '' }}
                                </td>
                                <td>{{ $order->game_id }}</td>
                                <td class="fw-semibold">{{ $order->formatted_total_price }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('topup.payment', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($order->status == 'pending')
                                    <a href="{{ route('topup.payment', $order->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-credit-card"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
            @else
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-gem display-1 text-muted"></i>
                    <h4 class="mt-3">Belum ada transaksi</h4>
                    <p class="text-muted">Kamu belum melakukan top up apapun</p>
                    <a href="{{ route('game.index') }}" class="btn btn-primary">
                        <i class="bi bi-gem me-1"></i>Top Up Sekarang
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
