<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengguna - Diks Store</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e17055; }
        .header h1 { color: #e17055; font-size: 20px; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table th, table td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 9px; }
        table th { background: #e17055; color: white; }
        table tr:nth-child(even) { background: #fafafa; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 8px; color: white; }
        .badge-aktif { background: #27ae60; }
        .badge-banned { background: #e74c3c; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .summary { background: #ffeaa7; border: 1px solid #e17055; padding: 10px; margin-top: 10px; }
        .footer { margin-top: 20px; text-align: center; font-size: 9px; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DIKS STORE</h1>
        <p>Laporan Data Pengguna</p>
        <p>Tanggal Export: {{ date('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 18%;">Nama</th>
                <th style="width: 22%;">Email</th>
                <th style="width: 12%;">NIM</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Transaksi Akun</th>
                <th style="width: 10%;">Transaksi TopUp</th>
                <th style="width: 14%;">Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @php $activeCount = 0; $bannedCount = 0; @endphp
            @forelse($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->nim ?? '-' }}</td>
                <td>
                    @if($user->is_banned)
                        <span class="badge badge-banned">Banned</span>
                        @php $bannedCount++; @endphp
                    @else
                        <span class="badge badge-aktif">Aktif</span>
                        @php $activeCount++; @endphp
                    @endif
                </td>
                <td class="text-center">{{ $user->orders_count ?? 0 }}</td>
                <td class="text-center">{{ $user->topup_orders_count ?? 0 }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;">Tidak ada data pengguna</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Pengguna:</strong> {{ count($users) }} orang<br>
        <strong>Aktif:</strong> {{ $activeCount }} orang | <strong>Banned:</strong> {{ $bannedCount }} orang
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Diks Store - All Rights Reserved</p>
    </div>
</body>
</html>
