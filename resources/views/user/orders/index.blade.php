@extends('layouts.app')

@section('title', 'Pesanan Saya - Diks Store')

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
                    <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action active">
                        <i class="bi bi-bag me-2"></i> Pesanan Saya
                    </a>
                    <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action">
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Pesanan Saya</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('products') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-bag-plus"></i> Beli Akun
                    </a>
                    <a href="{{ route('game.index') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-gem"></i> Top Up
                    </a>
                </div>
            </div>
            
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" id="ordersTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $tab == 'account' ? 'active' : '' }}" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab">
                        <i class="bi bi-bag me-1"></i> Pesanan Akun
                        @if($accountOrders->total() > 0)
                        <span class="badge bg-primary ms-1">{{ $accountOrders->total() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $tab == 'topup' ? 'active' : '' }}" id="topup-tab" data-bs-toggle="tab" data-bs-target="#topup" type="button" role="tab">
                        <i class="bi bi-gem me-1"></i> Riwayat Top Up
                        @if($topupOrders->total() > 0)
                        <span class="badge bg-warning text-dark ms-1">{{ $topupOrders->total() }}</span>
                        @endif
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="ordersTabContent">
                <!-- Account Orders Tab -->
                <div class="tab-pane fade {{ $tab == 'account' ? 'show active' : '' }}" id="account" role="tabpanel">
                    <div class="card border-0 shadow-sm">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Produk</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($accountOrders as $order)
                                    <tr>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($order->product?->category?->icon)
                                                <img src="{{ asset('storage/' . $order->product->category->icon) }}" 
                                                     alt="{{ $order->product->name }}" 
                                                     class="rounded me-2" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                <div class="rounded me-2 bg-secondary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-box text-white"></i>
                                                </div>
                                                @endif
                                                <span>{{ $order->product ? Str::limit($order->product->name, 25) : 'Produk Dihapus' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $order->formatted_total_price }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status_badge }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('user.order.detail', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-bag fs-1 d-block mb-2"></i>
                                            <p>Belum ada pesanan akun</p>
                                            <a href="{{ route('products') }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-shop"></i> Belanja Sekarang
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if($accountOrders->hasPages())
                        <div class="card-footer bg-white">
                            {{ $accountOrders->appends(['tab' => 'account'])->links() }}
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Top Up Orders Tab -->
                <div class="tab-pane fade {{ $tab == 'topup' ? 'show active' : '' }}" id="topup" role="tabpanel">
                    <div class="card border-0 shadow-sm">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Order</th>
                                        <th>Game</th>
                                        <th>Paket</th>
                                        <th>User ID</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topupOrders as $order)
                                    <tr>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($order->topup?->category?->icon)
                                                <img src="{{ asset('storage/' . $order->topup->category->icon) }}" 
                                                     alt="{{ $order->topup->category->name }}" 
                                                     class="rounded me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                                @else
                                                <div class="rounded me-2 bg-warning d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                    <i class="bi bi-gem text-white small"></i>
                                                </div>
                                                @endif
                                                <span>{{ $order->topup?->category?->name ?? 'Paket Dihapus' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($order->topup)
                                                {{ number_format($order->topup->total_amount ?? 0) }} {{ $order->topup->currency_name ?? '' }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td><code>{{ $order->game_id }}</code></td>
                                        <td class="fw-semibold">{{ $order->formatted_total_price }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
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
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="bi bi-gem fs-1 d-block mb-2"></i>
                                            <p>Belum ada transaksi top up</p>
                                            <a href="{{ route('game.index') }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-gem"></i> Top Up Sekarang
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if($topupOrders->hasPages())
                        <div class="card-footer bg-white">
                            {{ $topupOrders->appends(['tab' => 'topup'])->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Handle tab persistence via URL
    document.querySelectorAll('#ordersTab button').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            const tabName = e.target.id.replace('-tab', '');
            const url = new URL(window.location);
            url.searchParams.set('tab', tabName);
            window.history.replaceState({}, '', url);
        });
    });
</script>
@endpush
