<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomizeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
// Admin controllers are referenced with full namespace
use Illuminate\Support\Facades\Route;

// Home page with featured products
Route::get('/', [ProductController::class, 'featured'])->name('home');

// API Documentation
Route::get('/api/docs', function () {
    return view('api.documentation');
})->name('api.docs');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/orders', [ProfileController::class, 'orderHistory'])->name('profile.orders');
    Route::get('/profile/orders/{id}', [ProfileController::class, 'orderDetails'])->name('profile.orders.details');
    Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');

    // Cart routes
    Route::middleware('auth')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/place-order', [CartController::class, 'placeOrder'])->name('place.order');
        Route::get('/order-confirmation', function () {
            return view('cart.confirmation', request()->all());
        })->name('order.confirmation');
    });
    
    // Customize pizza routes
    Route::get('/customize', [CustomizeController::class, 'index'])->name('customize.index');
    Route::post('/customize', [CustomizeController::class, 'store'])->name('customize.store');
    
    // Add to cart routes
    Route::post('/products/{id}/add-to-cart', [ProductController::class, 'addToCart'])->name('products.addToCart');
    Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add'); // Added for compatibility with existing views
});

// Product routes (some are public, some require authentication)
Route::get('/menu', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Admin routes - protected by auth and admin middleware
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Admin Product Management
    Route::get('/products', [\App\Http\Controllers\Admin\AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [\App\Http\Controllers\Admin\AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [\App\Http\Controllers\Admin\AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [\App\Http\Controllers\Admin\AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [\App\Http\Controllers\Admin\AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [\App\Http\Controllers\Admin\AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Admin User Management
    Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [\App\Http\Controllers\Admin\AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [\App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('users.update');
    
    // Admin Order Management
    Route::get('/orders', [\App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'update'])->name('orders.update');
    
    // Admin Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\AdminSettingController::class, 'index'])->name('settings');
    Route::get('/settings/index', [\App\Http\Controllers\Admin\AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\AdminSettingController::class, 'update'])->name('settings.update');
    
    // Admin API Documentation
    Route::get('/api-docs', [\App\Http\Controllers\Admin\AdminApiController::class, 'index'])->name('api.index');
    
    // Admin Analytics
    Route::get('/analytics', [\App\Http\Controllers\Admin\AdminAnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/index', [\App\Http\Controllers\Admin\AdminAnalyticsController::class, 'index'])->name('analytics.index');
    
    // Admin Activity Logs (MongoDB)
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\AdminActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/product/{productId}', [\App\Http\Controllers\Admin\AdminActivityLogController::class, 'productDetails'])->name('activity-logs.product')->where('productId', '[0-9]+');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
