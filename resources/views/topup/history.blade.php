@extends('layouts.app')

@section('title', 'Riwayat Top Up - Diks Store')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">Riwayat Top Up</h2>
                        <p class="text-muted mb-0">Daftar transaksi top up kamu</p>
                    </div>
                    <a href="{{ route('topup.index') }}" class="btn btn-primary">
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
                                            @if($order->topup->category->icon)
                                            <img src="{{ Storage::url($order->topup->category->icon) }}" 
                                                 alt="{{ $order->topup->category->name }}" 
                                                 class="rounded me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                            @endif
                                            <span>{{ $order->topup->category->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ number_format($order->topup->total_amount) }} {{ $order->topup->currency_name }}
                                    </td>
                                    <td>{{ $order->game_id }}</td>
                                    <td class="fw-semibold">{{ $order->formatted_total_price }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('topup.detail', $order->id) }}" class="btn btn-sm btn-outline-primary">
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
                        <i class="bi bi-receipt display-1 text-muted"></i>
                        <h4 class="mt-3">Belum ada transaksi</h4>
                        <p class="text-muted">Kamu belum melakukan top up apapun</p>
                        <a href="{{ route('topup.index') }}" class="btn btn-primary">
                            <i class="bi bi-gem me-1"></i>Top Up Sekarang
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
