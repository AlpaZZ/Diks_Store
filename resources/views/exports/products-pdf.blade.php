<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk - Diks Store</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #00cec9; }
        .header h1 { color: #00cec9; font-size: 20px; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table th, table td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 9px; }
        table th { background: #00cec9; color: white; }
        table tr:nth-child(even) { background: #fafafa; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 8px; color: white; }
        .badge-available { background: #27ae60; }
        .badge-sold { background: #e74c3c; }
        .badge-reserved { background: #f39c12; }
        .text-right { text-align: right; }
        .summary { background: #e0f7fa; border: 1px solid #00cec9; padding: 10px; margin-top: 10px; }
        .footer { margin-top: 20px; text-align: center; font-size: 9px; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DIKS STORE</h1>
        <p>Laporan Data Produk (Akun Game)</p>
        <p>Tanggal Export: {{ date('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 28%;">Nama Produk</th>
                <th style="width: 14%;">Kategori</th>
                <th style="width: 14%;">Harga</th>
                <th style="width: 8%;">Stok</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 12%;">Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @php $totalValue = 0; $totalStock = 0; @endphp
            @forelse($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ Str::limit($product->name, 40) }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ $product->stock ?? 0 }}</td>
                <td><span class="badge badge-{{ $product->status }}">{{ ucfirst($product->status) }}</span></td>
                <td>{{ $product->created_at->format('d/m/Y') }}</td>
            </tr>
            @php $totalValue += $product->price * ($product->stock ?? 0); $totalStock += $product->stock ?? 0; @endphp
            @empty
            <tr><td colspan="7" style="text-align:center;">Tidak ada data produk</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Produk:</strong> {{ count($products) }} produk<br>
        <strong>Total Stok:</strong> {{ $totalStock }} unit<br>
        <strong>Nilai Inventori:</strong> <span style="color: #00cec9;">Rp {{ number_format($totalValue, 0, ',', '.') }}</span>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Diks Store - All Rights Reserved</p>
    </div>
</body>
</html>
