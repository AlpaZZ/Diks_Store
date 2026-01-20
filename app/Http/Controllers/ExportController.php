<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\TopUp;
use App\Models\TopUpOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    /**
     * Export dashboard report to PDF
     */
    public function dashboardPdf()
    {
        $data = $this->getDashboardData();
        
        $pdf = Pdf::loadView('exports.dashboard-pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-dashboard-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export dashboard report to Excel (CSV)
     */
    public function dashboardExcel()
    {
        $data = $this->getDashboardData();
        
        $filename = 'laporan-dashboard-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
            
            fputcsv($file, ['=== LAPORAN DASHBOARD DIKS STORE ===']);
            fputcsv($file, ['Tanggal Export', date('d/m/Y H:i:s')]);
            fputcsv($file, []);
            fputcsv($file, ['=== STATISTIK ===']);
            fputcsv($file, ['Total Produk', $data['stats']['total_products']]);
            fputcsv($file, ['Produk Tersedia', $data['stats']['available_products']]);
            fputcsv($file, ['Total Pesanan Akun', $data['stats']['total_orders']]);
            fputcsv($file, ['Total Pesanan Top Up', $data['stats']['total_topup_orders']]);
            fputcsv($file, ['Total User', $data['stats']['total_users']]);
            fputcsv($file, ['Pendapatan Akun', 'Rp ' . number_format($data['stats']['total_revenue'], 0, ',', '.')]);
            fputcsv($file, ['Pendapatan Top Up', 'Rp ' . number_format($data['stats']['total_topup_revenue'], 0, ',', '.')]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export orders to PDF
     */
    public function ordersPdf(Request $request)
    {
        $query = Order::with(['user', 'product.category']);
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        
        $orders = $query->latest()->get();
        
        $pdf = Pdf::loadView('exports.orders-pdf', [
            'orders' => $orders,
            'filters' => [
                'status' => $request->status,
                'from' => $request->from,
                'to' => $request->to,
            ]
        ]);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan-pesanan-akun-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export orders to Excel (CSV)
     */
    public function ordersExcel(Request $request)
    {
        $query = Order::with(['user', 'product.category']);
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        
        $orders = $query->latest()->get();
        
        $filename = 'laporan-pesanan-akun-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['No', 'Order ID', 'Pembeli', 'Email', 'Produk', 'Kategori', 'Total', 'Status', 'Tanggal']);
            
            $no = 1;
            foreach ($orders as $order) {
                fputcsv($file, [
                    $no++,
                    $order->order_number,
                    $order->user->name ?? 'N/A',
                    $order->user->email ?? 'N/A',
                    $order->product->name ?? 'N/A',
                    $order->product->category->name ?? 'N/A',
                    $order->total_price,
                    $order->status_label,
                    $order->created_at->format('d/m/Y H:i'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export top up orders to PDF
     */
    public function topupOrdersPdf(Request $request)
    {
        $query = TopUpOrder::with(['user', 'topup.category']);
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        
        $orders = $query->latest()->get();
        
        $pdf = Pdf::loadView('exports.topup-orders-pdf', [
            'orders' => $orders,
            'filters' => [
                'status' => $request->status,
                'from' => $request->from,
                'to' => $request->to,
            ]
        ]);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan-pesanan-topup-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export top up orders to Excel (CSV)
     */
    public function topupOrdersExcel(Request $request)
    {
        $query = TopUpOrder::with(['user', 'topup.category']);
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        
        $orders = $query->latest()->get();
        
        $filename = 'laporan-pesanan-topup-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['No', 'Order ID', 'Pembeli', 'Game', 'Paket', 'User ID Game', 'Total', 'Status', 'Tanggal']);
            
            $no = 1;
            foreach ($orders as $order) {
                fputcsv($file, [
                    $no++,
                    $order->order_number,
                    $order->user->name ?? 'N/A',
                    $order->topup->category->name ?? 'N/A',
                    ($order->topup->amount ?? 0) . ' ' . ($order->topup->currency_name ?? ''),
                    $order->game_id ?? 'N/A',
                    $order->total_price,
                    $order->status_label,
                    $order->created_at->format('d/m/Y H:i'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export products to PDF
     */
    public function productsPdf()
    {
        $products = Product::with('category')->get();
        
        $pdf = Pdf::loadView('exports.products-pdf', compact('products'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-produk-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export products to Excel (CSV)
     */
    public function productsExcel()
    {
        $products = Product::with('category')->get();
        
        $filename = 'laporan-produk-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['No', 'Nama Produk', 'Kategori', 'Harga', 'Stok', 'Status', 'Tanggal Dibuat']);
            
            $no = 1;
            foreach ($products as $product) {
                fputcsv($file, [
                    $no++,
                    $product->name,
                    $product->category->name ?? 'N/A',
                    $product->price,
                    $product->stock ?? 0,
                    $product->status,
                    $product->created_at->format('d/m/Y'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export users to PDF
     */
    public function usersPdf()
    {
        $users = User::where('role', 'user')
            ->withCount(['orders', 'topupOrders'])
            ->get();
        
        $pdf = Pdf::loadView('exports.users-pdf', compact('users'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-pengguna-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export users to Excel (CSV)
     */
    public function usersExcel()
    {
        $users = User::where('role', 'user')
            ->withCount(['orders', 'topupOrders'])
            ->get();
        
        $filename = 'laporan-pengguna-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['No', 'Nama', 'Email', 'NIM', 'Status', 'Total Transaksi Akun', 'Total Transaksi TopUp', 'Terdaftar']);
            
            $no = 1;
            foreach ($users as $user) {
                fputcsv($file, [
                    $no++,
                    $user->name,
                    $user->email,
                    $user->nim ?? '-',
                    $user->is_banned ? 'Banned' : 'Aktif',
                    $user->orders_count,
                    $user->topup_orders_count,
                    $user->created_at->format('d/m/Y'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get dashboard data
     */
    private function getDashboardData()
    {
        return [
            'stats' => [
                'total_products' => Product::count(),
                'available_products' => Product::where('status', 'available')->count(),
                'total_orders' => Order::count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'total_topup_orders' => TopUpOrder::count(),
                'total_users' => User::where('role', 'user')->count(),
                'total_categories' => Category::count(),
                'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
                'total_topup_revenue' => TopUpOrder::where('status', 'completed')->sum('total_price'),
            ],
            'recentOrders' => Order::with(['user', 'product'])->latest()->take(10)->get(),
            'recentTopupOrders' => TopUpOrder::with(['user', 'topup.category'])->latest()->take(10)->get(),
        ];
    }
}
