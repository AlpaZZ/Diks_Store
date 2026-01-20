<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Dashboard - Diks Store</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 3px solid #6c5ce7; }
        .header h1 { color: #6c5ce7; font-size: 24px; margin-bottom: 5px; }
        .header p { color: #666; font-size: 11px; }
        .stats-grid { display: table; width: 100%; margin-bottom: 25px; }
        .stat-row { display: table-row; }
        .stat-box { display: table-cell; width: 25%; padding: 10px; text-align: center; border: 1px solid #ddd; }
        .stat-box h3 { font-size: 20px; color: #6c5ce7; margin-bottom: 5px; }
        .stat-box p { color: #666; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; }
        table th { background: #6c5ce7; color: white; }
        table tr:nth-child(even) { background: #f8f9fa; }
        .section-title { background: #f8f9fa; padding: 10px; margin: 15px 0 10px; font-weight: bold; border-left: 4px solid #6c5ce7; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 9px; color: white; }
        .badge-pending { background: #f39c12; }
        .badge-processing { background: #3498db; }
        .badge-completed { background: #27ae60; }
        .badge-cancelled, .badge-failed { background: #e74c3c; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #999; border-top: 1px solid #ddd; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎮 DIKS STORE</h1>
        <p>Laporan Dashboard</p>
        <p>Tanggal Export: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <div class="section-title">📊 Statistik Umum</div>
    <table>
        <tr>
            <td><strong>Total Produk</strong></td>
            <td class="text-right">{{ $stats['total_products'] }}</td>
            <td><strong>Produk Tersedia</strong></td>
            <td class="text-right">{{ $stats['available_products'] }}</td>
        </tr>
        <tr>
            <td><strong>Total Pesanan Akun</strong></td>
            <td class="text-right">{{ $stats['total_orders'] }}</td>
            <td><strong>Pesanan Pending</strong></td>
            <td class="text-right">{{ $stats['pending_orders'] }}</td>
        </tr>
        <tr>
            <td><strong>Total Pesanan Top Up</strong></td>
            <td class="text-right">{{ $stats['total_topup_orders'] }}</td>
            <td><strong>Total Pengguna</strong></td>
            <td class="text-right">{{ $stats['total_users'] }}</td>
        </tr>
        <tr>
            <td><strong>Pendapatan Akun</strong></td>
            <td class="text-right" style="color: #27ae60;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</td>
            <td><strong>Pendapatan Top Up</strong></td>
            <td class="text-right" style="color: #27ae60;">Rp {{ number_format($stats['total_topup_revenue'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Total Pendapatan</strong></td>
            <td colspan="2" class="text-right" style="color: #6c5ce7; font-size: 14px;"><strong>Rp {{ number_format($stats['total_revenue'] + $stats['total_topup_revenue'], 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <div class="section-title">🛒 Pesanan Akun Terbaru</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Pembeli</th>
                <th>Produk</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>{{ Str::limit($order->product->name ?? 'N/A', 25) }}</td>
                <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td><span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span></td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">💎 Pesanan Top Up Terbaru</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Pembeli</th>
                <th>Game</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentTopupOrders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>{{ $order->topup->category->name ?? 'N/A' }}</td>
                <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td><span class="badge badge-{{ $order->status }}">{{ $order->status_label }}</span></td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem Diks Store</p>
        <p>&copy; {{ date('Y') }} Diks Store - All Rights Reserved</p>
    </div>
</body>
</html>
