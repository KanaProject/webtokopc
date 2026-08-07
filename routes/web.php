<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSetting;
use Illuminate\Support\Facades\Route;

// ============================================================
// PUBLIC ROUTES
// ============================================================
Route::get('/fix-storage', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return 'Storage link berhasil dibuat! Silakan kembali ke halaman utama.';
    } catch (\Exception $e) {
        return 'Terjadi kesalahan: ' . $e->getMessage();
    }
});

Route::get('/migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return 'Migrasi database berhasil! Sistem ulasan sekarang sudah siap digunakan.';
    } catch (\Exception $e) {
        return 'Gagal memigrasi database: ' . $e->getMessage();
    }
});

Route::get('/debug-log', function () {
    try {
        $logFile = storage_path('logs/laravel.log');
        if (!file_exists($logFile)) return 'Log file not found.';
        
        $lines = file($logFile);
        $lastLines = array_slice($lines, -100); // Ambil 100 baris terakhir
        return '<pre style="word-wrap: break-word; white-space: pre-wrap;">' . htmlspecialchars(implode("", $lastLines)) . '</pre>';
    } catch (\Exception $e) {
        return 'Gagal membaca log: ' . $e->getMessage();
    }
});

Route::get('/clear-cache', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        return 'Cache berhasil dibersihkan! Silakan refresh halaman utama.';
    } catch (\Exception $e) {
        return 'Gagal membersihkan cache: ' . $e->getMessage();
    }
});

Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/kategori/{category:slug}', [ProductController::class, 'byCategory'])->name('categories.show');

// Cart
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/tambah/{product:slug}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/keranjang/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/keranjang', [CartController::class, 'clear'])->name('cart.clear');

// ============================================================
// AUTH ROUTES (Breeze)
// ============================================================
require __DIR__.'/auth.php';

// Breeze redirects to 'dashboard' by default after login
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    }
    return redirect()->route('login');
})->name('dashboard');

// ============================================================
// AUTHENTICATED USER ROUTES
// ============================================================
Route::middleware(['auth'])->group(function () {
    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/sukses/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Orders
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{order}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('orders.reviews.store');
});

// ============================================================
// ADMIN ROUTES
// ============================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProduct::class);

    // Categories
    Route::resource('categories', AdminCategory::class);

    // Orders
    Route::get('orders', [AdminOrder::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrder::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrder::class, 'updateStatus'])->name('orders.update-status');

    // Testimonials
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);

    // Reviews
    Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}/toggle', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleStatus'])->name('reviews.toggle');

    // Site Settings (Homepage Content)
    Route::get('settings', [AdminSiteSetting::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSiteSetting::class, 'update'])->name('settings.update');
    Route::delete('settings/logo', [AdminSiteSetting::class, 'deleteLogo'])->name('settings.logo.delete');
});
