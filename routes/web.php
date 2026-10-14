<?php

use Illuminate\Support\Facades\Route;

// =====================================================
// CONTROLLERS
// =====================================================

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\ReportController;

// =====================================================
// CUSTOMER CHAT CONTROLLER
// =====================================================

use App\Http\Controllers\Customer\ChatController as CustomerChatController;

// =====================================================
// ADMIN CHAT CONTROLLER
// =====================================================

use App\Http\Controllers\Admin\ChatController as AdminChatController;


/*
|--------------------------------------------------------------------------
| PUBLIC - TOKO
|--------------------------------------------------------------------------
*/

Route::get('/store', [StoreController::class, 'index'])
    ->name('store.home');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

// LOGIN
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// REGISTER
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
| Hanya user login dengan role admin.
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // DASHBOARD
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // LAPORAN PENJUALAN
    Route::get('/admin/laporan', [ReportController::class, 'index'])
        ->name('admin.reports.index');

    // KATEGORI
    Route::resource('categories', CategoryController::class);

    // MEREK
    Route::resource('brands', BrandController::class);

    // PRODUK
    Route::resource('products', ProductController::class);

    /*
    |--------------------------------------------------------------------------
    | PESANAN ADMIN
    |--------------------------------------------------------------------------
    */

    // Daftar pesanan
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    // Verifikasi pembayaran DANA
    Route::patch(
        '/orders/{order}/verify-payment',
        [OrderController::class, 'verifyPayment']
    )->name('orders.verify-payment');

    // Tolak pembayaran DANA
    Route::patch(
        '/orders/{order}/reject-payment',
        [OrderController::class, 'rejectPayment']
    )->name('orders.reject-payment');

    // Form edit pesanan
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])
        ->name('orders.edit');

    // Update pesanan
    Route::put('/orders/{order}', [OrderController::class, 'update'])
        ->name('orders.update');

    // Hapus pesanan
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])
        ->name('orders.destroy');

    // Detail pesanan
    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

    /*
    |--------------------------------------------------------------------------
    | MANAJEMEN CUSTOMER
    |--------------------------------------------------------------------------
    */

    Route::resource('customers', CustomerController::class);

    /*
    |--------------------------------------------------------------------------
    | CHAT ADMIN
    |--------------------------------------------------------------------------
    */

    // Semua percakapan
    Route::get('/admin/chat', [AdminChatController::class, 'index'])
        ->name('admin.chat.index');

    // Percakapan belum dijawab
    Route::get(
        '/admin/chat/unanswered',
        [AdminChatController::class, 'unanswered']
    )->name('admin.chat.unanswered');

    // Percakapan sudah dijawab
    Route::get(
        '/admin/chat/answered',
        [AdminChatController::class, 'answered']
    )->name('admin.chat.answered');

    // Detail percakapan
    Route::get(
        '/admin/chat/{conversation}',
        [AdminChatController::class, 'show']
    )->name('admin.chat.show');

    // Admin mengirim pesan
    Route::post(
        '/admin/chat/{conversation}/message',
        [AdminChatController::class, 'sendMessage']
    )->name('admin.chat.message');

    // Menutup percakapan
    Route::patch(
        '/admin/chat/{conversation}/close',
        [AdminChatController::class, 'close']
    )->name('admin.chat.close');

    // Mengarsipkan percakapan
    Route::patch(
        '/admin/chat/{conversation}/archive',
        [AdminChatController::class, 'archive']
    )->name('admin.chat.archive');
});


/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
| Hanya user login dengan role customer.
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | KERANJANG
    |--------------------------------------------------------------------------
    */

    // Halaman keranjang
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    // Tambahkan produk ke keranjang
    Route::post('/cart/add/{product}', [CartController::class, 'add'])
        ->name('cart.add');

    // Update jumlah produk
    Route::patch('/cart/{cart}', [CartController::class, 'update'])
        ->name('cart.update');

    // Hapus produk dari keranjang
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])
        ->name('cart.destroy');


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    // Halaman checkout
    Route::get('/checkout', [OrderController::class, 'create'])
        ->name('checkout');

    // Proses checkout
    Route::post('/checkout', [OrderController::class, 'store'])
        ->name('checkout.store');


    /*
    |--------------------------------------------------------------------------
    | PESANAN CUSTOMER
    |--------------------------------------------------------------------------
    */

    // Semua pesanan pelanggan
    Route::get('/pesanan', [OrderController::class, 'customerOrders'])
        ->name('customer.orders');

    // Detail pesanan pelanggan
    Route::get('/pesanan/{order}', [OrderController::class, 'customerShow'])
        ->name('customer.orders.show');

    // Batalkan pesanan
    Route::patch(
        '/pesanan/{order}/batal',
        [OrderController::class, 'cancel']
    )->name('customer.orders.cancel');

    Route::delete('/pesanan/{order}/hapus', [OrderController::class, 'customerDestroy'])
    ->name('customer.orders.destroy');

    // Upload bukti pembayaran DANA
    Route::post(
        '/pesanan/{order}/payment-proof',
        [OrderController::class, 'uploadPaymentProof']
    )->name('customer.orders.payment-proof');

    // Konfirmasi pesanan diterima (COD)
    Route::patch(
        '/pesanan/{order}/received',
        [OrderController::class, 'received']
    )->name('customer.orders.received');


    /*
    |--------------------------------------------------------------------------
    | CHAT CUSTOMER
    |--------------------------------------------------------------------------
    */

    // Halaman chat
    Route::get('/chat', [CustomerChatController::class, 'index'])
        ->name('customer.chat');

    // Customer mengirim pesan
    Route::post(
        '/chat/message',
        [CustomerChatController::class, 'sendMessage']
    )->name('customer.chat.message');

});