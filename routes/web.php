<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\GameController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/products/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// ==================== GAME ROUTES (Combined Top Up & Account) ====================
Route::get('/game', [GameController::class, 'index'])->name('game.index');
Route::get('/game/{slug}', [GameController::class, 'show'])->name('game.show');

// Legacy routes - redirect to new game routes
Route::get('/topup', function() { return redirect()->route('game.index'); })->name('topup.index');
Route::get('/topup/{slug}', function($slug) { return redirect()->route('game.show', $slug); })->name('topup.show');
Route::get('/category/{slug}', function($slug) { return redirect()->route('game.show', $slug . '#accounts'); })->name('category');

// ==================== AUTH ROUTES ====================
Route::middleware('guest')->group(function () {
    // User Auth
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Admin Auth
    Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== TOP UP ROUTES (Auth Required) ====================
Route::middleware('user')->prefix('topup')->name('topup.')->group(function () {
    Route::get('/order/{id}', [TopUpController::class, 'order'])->name('order');
    Route::post('/order/{id}', [TopUpController::class, 'processOrder'])->name('processOrder');
    Route::get('/payment/{id}', [TopUpController::class, 'payment'])->name('payment');
    Route::post('/payment/{id}', [TopUpController::class, 'uploadPayment'])->name('uploadPayment');
    Route::get('/history', [TopUpController::class, 'history'])->name('history');
    Route::get('/detail/{id}', [TopUpController::class, 'detail'])->name('detail');
});

// ==================== USER ROUTES ====================
Route::middleware('user')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    
    // Orders
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [UserController::class, 'orderDetail'])->name('order.detail');
    Route::post('/orders/create/{productId}', [UserController::class, 'createOrder'])->name('order.create');
    Route::post('/orders/{id}/upload-proof', [UserController::class, 'uploadPaymentProof'])->name('order.upload-proof');
    Route::post('/orders/{id}/cancel', [UserController::class, 'cancelOrder'])->name('order.cancel');
    
    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
});

// ==================== ADMIN ROUTES ====================
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
    
    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');
    
    // Top Up Packages
    Route::get('/topups', [AdminController::class, 'topups'])->name('topups');
    Route::get('/topups/create', [AdminController::class, 'createTopup'])->name('topups.create');
    Route::post('/topups', [AdminController::class, 'storeTopup'])->name('topups.store');
    Route::get('/topups/{id}/edit', [AdminController::class, 'editTopup'])->name('topups.edit');
    Route::put('/topups/{id}', [AdminController::class, 'updateTopup'])->name('topups.update');
    Route::delete('/topups/{id}', [AdminController::class, 'deleteTopup'])->name('topups.delete');
    
    // Top Up Orders
    Route::get('/topup-orders', [AdminController::class, 'topupOrders'])->name('topup-orders');
    Route::get('/topup-orders/{id}', [AdminController::class, 'topupOrderDetail'])->name('topup-orders.detail');
    Route::put('/topup-orders/{id}/status', [AdminController::class, 'updateTopupOrderStatus'])->name('topup-orders.update-status');
    
    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [AdminController::class, 'orderDetail'])->name('orders.detail');
    Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    
    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}', [AdminController::class, 'userDetail'])->name('users.detail');
    
    // Admin List
    Route::get('/admin-list', [AdminController::class, 'adminList'])->name('admin-list');
});
