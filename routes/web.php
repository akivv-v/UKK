<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PelangganController::class, 'index'])->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/register-admin', [AuthController::class, 'showRegisterAdmin']);
Route::post('/register-admin', [AuthController::class, 'registerAdmin']);


Route::group(['prefix' => 'admin', 'middleware' => function ($request, $next) {
    if (!session('is_login') || session('role') == 'Pembeli') {
        return redirect('/login')->with('error', 'Akses khusus Admin.');
    }
    return $next($request);
}], function () {
    Route::get('/dashboard', [PenjualController::class, 'dashboard']);

    Route::get('/produk', [PenjualController::class, 'indexProduk']);
    Route::get('/produk/create', [PenjualController::class, 'createProduk']);
    Route::post('/produk', [PenjualController::class, 'storeProduk']);
    Route::get('/produk/{id}/edit', [PenjualController::class, 'editProduk']);
    Route::put('/produk/{id}', [PenjualController::class, 'updateProduk']);
    Route::delete('/produk/{id}', [PenjualController::class, 'deleteProduk']);

    Route::get('/transaksi', [PenjualController::class, 'indexTransaksi']);
    Route::post('/transaksi/{id}/status', [PenjualController::class, 'updateStatusTransaksi']);

    Route::get('/ongkir', [PenjualController::class, 'indexOngkir']);
    Route::post('/ongkir', [PenjualController::class, 'storeOngkir']);
    Route::put('/ongkir/{id}', [PenjualController::class, 'updateOngkir']);
    Route::delete('/ongkir/{id}', [PenjualController::class, 'deleteOngkir']);

    Route::get('/laporan', [PenjualController::class, 'indexLaporan']);
});


Route::group(['middleware' => function ($request, $next) {
    if (!session('is_login')) {
        return redirect('/login')->with('error', 'Silahkan login terlebih dahulu.');
    }

    if (session('role') != 'Pembeli') {
        return redirect('/admin/dashboard');
    }

    return $next($request);
}], function () {
    Route::get('/home', [PelangganController::class, 'index']);

    Route::get('/produk/{id}', [PelangganController::class, 'showProduk']);

    Route::post('/cart/{id}', [PelangganController::class, 'addToCart']);
    Route::get('/cart', [PelangganController::class, 'showCart']);
    Route::post('/update-cart', [PelangganController::class, 'updateCart']);
    Route::delete('/remove-from-cart', [PelangganController::class, 'removeFromCart']);

    Route::post('/checkout', [PelangganController::class, 'checkout']);

    Route::get('/invoice/{id}', [PelangganController::class, 'showInvoice']);

    Route::get('/history', [PelangganController::class, 'history']);
});
