<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\TopUp;
use App\Models\TopUpOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'available_products' => Product::available()->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_categories' => Category::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
        ];

        $recentOrders = Order::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();

        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentProducts'));
    }

    // ==================== CATEGORY MANAGEMENT ====================

    /**
     * List all categories
     */
    public function categories()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show create category form
     */
    public function createCategory()
    {
        return view('admin.categories.create');
    }

    /**
     * Store new category
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Show edit category form
     */
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update category
     */
    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            $data['icon'] = $request->file('icon')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Delete category
     */
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk!');
        }

        if ($category->icon) {
            Storage::disk('public')->delete($category->icon);
        }

        $category->delete();

        return redirect()->route('admin.categories')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    // ==================== PRODUCT MANAGEMENT ====================

    /**
     * List all products
     */
    public function products(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show create product form
     */
    public function createProduct()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store new product
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'game_server' => 'nullable|string|max:255',
            'game_level' => 'nullable|string|max:255',
            'account_details' => 'nullable|string',
            'status' => 'required|in:available,sold,pending',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
        ]);

        $data = $request->only([
            'category_id', 'name', 'description', 'price', 'original_price',
            'game_server', 'game_level', 'account_details', 'status', 'stock'
        ]);
        
        $data['slug'] = Str::slug($request->name) . '-' . Str::random(5);
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show edit product form
     */
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'game_server' => 'nullable|string|max:255',
            'game_level' => 'nullable|string|max:255',
            'account_details' => 'nullable|string',
            'status' => 'required|in:available,sold,pending',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
        ]);

        $data = $request->only([
            'category_id', 'name', 'description', 'price', 'original_price',
            'game_server', 'game_level', 'account_details', 'status', 'stock'
        ]);
        
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Delete product
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->orders()->whereIn('status', ['pending', 'processing'])->count() > 0) {
            return back()->with('error', 'Produk tidak dapat dihapus karena masih memiliki order aktif!');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil dihapus!');
    }

    // ==================== ORDER MANAGEMENT ====================

    /**
     * List all orders
     */
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'product']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order detail
     */
    public function orderDetail($id)
    {
        $order = Order::with(['user', 'product'])->findOrFail($id);
        return view('admin.orders.detail', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'account_credentials' => 'nullable|string',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'completed') {
            $data['completed_at'] = now();
            $data['account_credentials'] = $request->account_credentials;
            
            // Update product status to sold
            $order->product->update(['status' => 'sold']);
        }

        if ($request->status === 'processing') {
            $data['paid_at'] = now();
        }

        $order->update($data);

        return redirect()->route('admin.orders')
            ->with('success', 'Status order berhasil diperbarui!');
    }

    // ==================== USER MANAGEMENT ====================

    /**
     * List all users
     */
    public function users(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->withCount('orders')->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user detail
     */
    public function userDetail($id)
    {
        $user = User::with('orders.product')->findOrFail($id);
        return view('admin.users.detail', compact('user'));
    }

    // ==================== TOP UP MANAGEMENT ====================

    /**
     * List all top-up packages
     */
    public function topups(Request $request)
    {
        $query = TopUp::with('category');

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $topups = $query->orderBy('category_id')->orderBy('sort_order')->orderBy('amount')->paginate(15);
        $categories = Category::active()->get();

        return view('admin.topups.index', compact('topups', 'categories'));
    }

    /**
     * Show create top-up form
     */
    public function createTopup()
    {
        $categories = Category::active()->get();
        return view('admin.topups.create', compact('categories'));
    }

    /**
     * Store new top-up package
     */
    public function storeTopup(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'currency_name' => 'required|string|max:100',
            'amount' => 'required|integer|min:1',
            'bonus_amount' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        TopUp::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'currency_name' => $request->currency_name,
            'amount' => $request->amount,
            'bonus_amount' => $request->bonus_amount ?? 0,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'description' => $request->description,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.topups')
            ->with('success', 'Paket top up berhasil ditambahkan!');
    }

    /**
     * Show edit top-up form
     */
    public function editTopup($id)
    {
        $topup = TopUp::findOrFail($id);
        $categories = Category::active()->get();
        return view('admin.topups.edit', compact('topup', 'categories'));
    }

    /**
     * Update top-up package
     */
    public function updateTopup(Request $request, $id)
    {
        $topup = TopUp::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'currency_name' => 'required|string|max:100',
            'amount' => 'required|integer|min:1',
            'bonus_amount' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $topup->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'currency_name' => $request->currency_name,
            'amount' => $request->amount,
            'bonus_amount' => $request->bonus_amount ?? 0,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'description' => $request->description,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.topups')
            ->with('success', 'Paket top up berhasil diperbarui!');
    }

    /**
     * Delete top-up package
     */
    public function deleteTopup($id)
    {
        $topup = TopUp::findOrFail($id);
        $topup->delete();

        return redirect()->route('admin.topups')
            ->with('success', 'Paket top up berhasil dihapus!');
    }

    // ==================== TOP UP ORDER MANAGEMENT ====================

    /**
     * List all top-up orders
     */
    public function topupOrders(Request $request)
    {
        $query = TopUpOrder::with(['user', 'topup.category']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('game_id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.topup-orders.index', compact('orders'));
    }

    /**
     * Show top-up order detail
     */
    public function topupOrderDetail($id)
    {
        $order = TopUpOrder::with(['user', 'topup.category'])->findOrFail($id);
        return view('admin.topup-orders.detail', compact('order'));
    }

    /**
     * Update top-up order status
     */
    public function updateTopupOrderStatus(Request $request, $id)
    {
        $order = TopUpOrder::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,completed,failed,refunded',
            'admin_notes' => 'nullable|string',
        ]);

        $data = [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ];

        if ($request->status === 'completed') {
            $data['completed_at'] = now();
        }

        $order->update($data);

        return redirect()->route('admin.topup-orders')
            ->with('success', 'Status order top up berhasil diperbarui!');
    }

    // ==================== ADMIN LIST ====================

    /**
     * Display list of admin users
     */
    public function adminList()
    {
        $admins = User::where('role', 'admin')
            ->orderBy('name')
            ->get();

        return view('admin.admin-list', compact('admins'));
    }
}
