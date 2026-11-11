<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;

// ==============================
// HALAMAN PUBLIK
// ==============================

Route::get('/quick-search', [HomeController::class, 'quickSearch'])->name('quick-search');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cultures', [HomeController::class, 'cultures'])->name('cultures');
Route::get('/cultures/{slug}', [HomeController::class, 'cultureDetail'])->name('cultures.detail');

Route::get('/tourisms', [HomeController::class, 'tourisms'])->name('tourisms');
Route::get('/tourisms/{slug}', [HomeController::class, 'tourismDetail'])->name('tourisms.detail');

Route::get('/events', [HomeController::class, 'events'])->name('events');
Route::get('/events/{slug}', [HomeController::class, 'eventDetail'])->name('events.detail');

Route::post('/events/{eventId}/register', [EventController::class, 'register'])
    ->middleware('auth')
    ->name('events.register');

Route::get('/marketplace', [HomeController::class, 'marketplace'])->name('marketplace');
Route::get('/products/{slug}', [HomeController::class, 'productDetail'])->name('products.detail');
Route::get('/map', [HomeController::class, 'map'])->name('map');


// ==============================
// AUTENTIKASI
// ==============================

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==============================
// ROUTE PENGGUNA LOGIN
// ==============================

Route::middleware('auth')->group(function () {

    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/buy-now/{productId}', [CartController::class, 'buyNow'])->name('buy-now');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout dan pesanan
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'process'])->name('checkout.process');

    Route::get('/order/success/{id}', [OrderController::class, 'orderSuccess'])->name('order.success');
    Route::get('/orders/status', [OrderController::class, 'orderStatus'])->name('order.status');
    Route::get('/orders/history', [OrderController::class, 'orderHistory'])->name('order.history');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::post('/orders/{id}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::post('/orders/{id}/payment-proof', [OrderController::class, 'uploadPaymentProof'])->name('orders.payment-proof');
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Registrasi event
    Route::get('/events/registrations', [EventController::class, 'registrations'])->name('events.registrations');

    // Ulasan
    Route::get('/reviews/{orderId}/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/{orderId}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/products/{productId}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
});


// ==============================
// ROUTE SELLER / UMKM
// ==============================

Route::middleware(['auth', 'role:seller'])
    ->prefix('umkm')
    ->group(function () {

        // Setup UMKM
        Route::get('/setup', [UmkmController::class, 'showSetup'])->name('umkm.setup');
        Route::post('/setup', [UmkmController::class, 'storeSetup'])->name('umkm.setup.store');

        // Dashboard
        Route::get('/dashboard', [UmkmController::class, 'dashboard'])->name('umkm.dashboard');

        // Produk
        Route::get('/products', [UmkmController::class, 'products'])->name('umkm.products');
        Route::get('/products/create', [UmkmController::class, 'productCreate'])->name('umkm.products.create');
        Route::post('/products', [UmkmController::class, 'productStore'])->name('umkm.products.store');
        Route::get('/products/{id}/edit', [UmkmController::class, 'productEdit'])->name('umkm.products.edit');
        Route::put('/products/{id}', [UmkmController::class, 'productUpdate'])->name('umkm.products.update');
        Route::delete('/products/{id}', [UmkmController::class, 'productDestroy'])->name('umkm.products.destroy');

        // Pesanan
        Route::get('/orders', [UmkmController::class, 'orders'])->name('umkm.orders');

        Route::put('/order-items/{orderItem}', [UmkmController::class, 'orderUpdate'])
            ->name('umkm.order-items.update');

    });


// ==============================
// ROUTE ADMIN
// ==============================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // UMKM
        Route::get('/umkms', [AdminController::class, 'umkms'])->name('admin.umkms');
        Route::put('/umkms/{id}/approve', [AdminController::class, 'umkmApprove'])->name('admin.umkm.approve');
        Route::put('/umkms/{id}/reject', [AdminController::class, 'umkmReject'])->name('admin.umkm.reject');

        // Pengguna
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');

        // Pesanan
        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/orders/{id}', [AdminController::class, 'orderShow'])->name('admin.order.show');
        Route::put('/orders/{id}/status', [AdminController::class, 'orderStatusUpdate'])->name('admin.order.status');
        Route::put('/orders/{id}/payment-status', [AdminController::class, 'paymentStatusUpdate'])->name('admin.order.payment-status');
        Route::put('/orders/{id}/confirm-cod', [AdminController::class, 'confirmCodPayment'])
        ->name('admin.order.confirm-cod'); 
        
        // Ulasan
        Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');

        // CRUD Budaya
        Route::get('/cultures', [AdminController::class, 'cultures'])->name('admin.cultures');
        Route::get('/cultures/create', [AdminController::class, 'cultureCreate'])->name('admin.cultures.create');
        Route::post('/cultures', [AdminController::class, 'cultureStore'])->name('admin.cultures.store');
        Route::get('/cultures/{id}/edit', [AdminController::class, 'cultureEdit'])->name('admin.cultures.edit');
        Route::put('/cultures/{id}', [AdminController::class, 'cultureUpdate'])->name('admin.cultures.update');
        Route::delete('/cultures/{id}', [AdminController::class, 'cultureDestroy'])->name('admin.cultures.destroy');

        // CRUD Wisata
        Route::get('/tourisms', [AdminController::class, 'tourisms'])->name('admin.tourisms');
        Route::get('/tourisms/create', [AdminController::class, 'tourismCreate'])->name('admin.tourisms.create');
        Route::post('/tourisms', [AdminController::class, 'tourismStore'])->name('admin.tourisms.store');
        Route::get('/tourisms/{id}/edit', [AdminController::class, 'tourismEdit'])->name('admin.tourisms.edit');
        Route::put('/tourisms/{id}', [AdminController::class, 'tourismUpdate'])->name('admin.tourisms.update');
        Route::delete('/tourisms/{id}', [AdminController::class, 'tourismDestroy'])->name('admin.tourisms.destroy');

        // CRUD Event
        Route::get('/events', [AdminController::class, 'events'])->name('admin.events');
        Route::get('/events/create', [AdminController::class, 'eventCreate'])->name('admin.events.create');
        Route::post('/events', [AdminController::class, 'eventStore'])->name('admin.events.store');
        Route::get('/events/{id}/edit', [AdminController::class, 'eventEdit'])->name('admin.events.edit');
        Route::put('/events/{id}', [AdminController::class, 'eventUpdate'])->name('admin.events.update');
        Route::delete('/events/{id}', [AdminController::class, 'eventDestroy'])->name('admin.events.destroy');
    });
