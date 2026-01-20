<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TopUp;
use App\Models\TopUpOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TopUpController extends Controller
{
    /**
     * Display top-up page with all games.
     */
    public function index()
    {
        $categories = Category::active()
            ->whereHas('topups', function($q) {
                $q->where('is_active', true);
            })
            ->withCount(['topups' => function($q) {
                $q->where('is_active', true);
            }])
            ->get();

        return view('topup.index', compact('categories'));
    }

    /**
     * Display top-up packages for a specific game.
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $topups = TopUp::where('category_id', $category->id)
            ->active()
            ->orderBy('sort_order')
            ->orderBy('amount')
            ->get();

        return view('topup.show', compact('category', 'topups'));
    }

    /**
     * Show order form for a specific top-up package.
     */
    public function order($id)
    {
        $topup = TopUp::with('category')->findOrFail($id);
        
        return view('topup.order', compact('topup'));
    }

    /**
     * Process top-up order.
     */
    public function processOrder(Request $request, $id)
    {
        $topup = TopUp::findOrFail($id);

        $request->validate([
            'game_id' => 'required|string|max:100',
            'game_server' => 'nullable|string|max:100',
            'game_nickname' => 'nullable|string|max:100',
        ], [
            'game_id.required' => 'ID Game wajib diisi',
        ]);

        $order = TopUpOrder::create([
            'user_id' => Auth::id(),
            'topup_id' => $topup->id,
            'game_id' => $request->game_id,
            'game_server' => $request->game_server,
            'game_nickname' => $request->game_nickname,
            'total_price' => $topup->price,
            'status' => 'pending',
        ]);

        return redirect()->route('topup.payment', $order->id)
            ->with('success', 'Order berhasil dibuat! Silakan upload bukti pembayaran.');
    }

    /**
     * Show payment page.
     */
    public function payment($id)
    {
        $order = TopUpOrder::with(['topup.category', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($order->status !== 'pending') {
            return redirect()->route('topup.history')
                ->with('info', 'Order ini sudah diproses.');
        }

        return view('topup.payment', compact('order'));
    }

    /**
     * Upload payment proof.
     */
    public function uploadPayment(Request $request, $id)
    {
        $order = TopUpOrder::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status !== 'pending') {
            return redirect()->route('topup.history')
                ->with('error', 'Order ini sudah diproses.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Delete old payment proof if exists
            if ($order->payment_proof) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment-proofs/topup', 'public');
            $order->update([
                'payment_proof' => $path,
                'status' => 'processing',
            ]);
        }

        return redirect()->route('topup.history')
            ->with('success', 'Bukti pembayaran berhasil diupload! Pesanan sedang diproses.');
    }

    /**
     * Show order history.
     */
    public function history()
    {
        $orders = TopUpOrder::with(['topup.category'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('topup.history', compact('orders'));
    }

    /**
     * Show order detail.
     */
    public function detail($id)
    {
        $order = TopUpOrder::with(['topup.category', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('topup.detail', compact('order'));
    }
}
