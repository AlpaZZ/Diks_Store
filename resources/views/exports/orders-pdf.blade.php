<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pesanan Akun - Diks Store</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #6c5ce7; }
        .header h1 { color: #6c5ce7; font-size: 20px; margin-bottom: 5px; }
        .filters { background: #f8f9fa; padding: 10px; margin-bottom: 15px; font-size: 9px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table th, table td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 9px; }
        table th { background: #6c5ce7; color: white; }
        table tr:nth-child(even) { background: #fafafa; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 8px; color: white; }
        .badge-pending { background: #f39c12; }
        .badge-processing { background: #3498db; }
        .badge-completed { background: #27ae60; }
        .badge-cancelled, .badge-failed { background: #e74c3c; }
        .text-right { text-align: right; }
        .summary { background: #e8f5e9; border: 1px solid #27ae60; padding: 10px; margin-top: 10px; }
        .footer { margin-top: 20px; text-align: center; font-size: 9px; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DIKS STORE</h1>
        <p>Laporan Pesanan Jual Beli Akun</p>
        <p>Tanggal Export: {{ date('d F Y, H:i') }}</p>
    </div>

    @if($filters['status'] || $filters['from'] || $filters['to'])
    <div class="filters">
        <strong>Filter:</strong>
        @if($filters['status']) Status: {{ ucfirst($filters['status']) }} | @endif
        @if($filters['from']) Dari: {{ $filters['from'] }} | @endif
        @if($filters['to']) Sampai: {{ $filters['to'] }} @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 14%;">Order ID</th>
                <th style="width: 14%;">Pembeli</th>
                <th style="width: 20%;">Produk</th>
                <th style="width: 12%;">Kategori</th>
                <th style="width: 12%;">Total</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 14%;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php $totalRevenue = 0; @endphp
            @forelse($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>{{ Str::limit($order->product->name ?? 'N/A', 30) }}</td>
                <td>{{ $order->product->category->name ?? 'N/A' }}</td>
                <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td><span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span></td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @if($order->status == 'completed') @php $totalRevenue += $order->total_price; @endphp @endif
            @empty
            <tr><td colspan="8" style="text-align:center;">Tidak ada data pesanan</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Pesanan:</strong> {{ count($orders) }} pesanan<br>
        <strong>Total Pendapatan (Selesai):</strong> <span style="color: #27ae60;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Diks Store - All Rights Reserved</p>
    </div>
</body>
</html>
