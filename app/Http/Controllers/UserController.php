<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * User dashboard
     */
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
        ];

        $recentOrders = $user->orders()
            ->with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * List user's orders
     */
    public function orders()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $orders = $user->orders()
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    /**
     * Show order detail
     */
    public function orderDetail($id)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $order = $user->orders()
            ->with('product')
            ->findOrFail($id);

        return view('user.orders.detail', compact('order'));
    }

    /**
     * Create new order (buy product)
     */
    public function createOrder(Request $request, $productId)
    {
        $product = Product::available()->findOrFail($productId);

        $request->validate([
            'payment_method' => 'required|in:transfer,ewallet,other',
            'notes' => 'nullable|string|max:500',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'total_price' => $product->price,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Mark product as pending
        $product->update(['status' => 'pending']);

        return redirect()->route('user.order.detail', $order->id)
            ->with('success', 'Order berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof(Request $request, $id)
    {
        /** @var User $user */
        $user = Auth::user();
        $order = $user->orders()->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order ini tidak dapat diupdate!');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Delete old proof if exists
            if ($order->payment_proof) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $order->update(['payment_proof' => $path]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload!');
    }

    /**
     * Cancel order
     */
    public function cancelOrder($id)
    {
        /** @var User $user */
        $user = Auth::user();
        $order = $user->orders()->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order ini tidak dapat dibatalkan!');
        }

        $order->update(['status' => 'cancelled']);
        
        // Return product to available
        $order->product->update(['status' => 'available']);

        return redirect()->route('user.orders')
            ->with('success', 'Order berhasil dibatalkan!');
    }

    /**
     * Show profile page
     */
    public function profile()
    {
        return view('user.profile');
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'phone']);

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah!']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
