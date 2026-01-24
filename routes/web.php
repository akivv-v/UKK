<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

// Default Redirect
Route::get('/', function () {
    if (session('is_login')) {
        if (session('role') == 'Pembeli') {
            return redirect('/home');
        }
        return redirect('/admin/dashboard');
    }
    return redirect('/login');
});

// Penjual / Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => function ($request, $next) {
    if (!session('is_login') || session('role') == 'Pembeli') {
        return redirect('/login');
    }
    return $next($request);
}], function () {
    Route::get('/dashboard', [PenjualController::class, 'dashboard']);
    
    // Produk CRUD
    Route::get('/produk', [PenjualController::class, 'indexProduk']);
    Route::get('/produk/create', [PenjualController::class, 'createProduk']);
    Route::post('/produk', [PenjualController::class, 'storeProduk']);
    Route::get('/produk/{id}/edit', [PenjualController::class, 'editProduk']);
    Route::put('/produk/{id}', [PenjualController::class, 'updateProduk']);
    Route::delete('/produk/{id}', [PenjualController::class, 'deleteProduk']);

    // Transaksi
    Route::get('/transaksi', [PenjualController::class, 'indexTransaksi']);
    Route::post('/transaksi/{id}/status', [PenjualController::class, 'updateStatusTransaksi']);
});

// Pelanggan / Pembeli Routes
Route::group(['middleware' => function ($request, $next) {
    if (!session('is_login') || session('role') != 'Pembeli') {
        return redirect('/login');
    }
    return $next($request);
}], function () {
    Route::get('/home', [PelangganController::class, 'index']);
    Route::get('/produk/{id}', [PelangganController::class, 'showProduk']);
    Route::post('/cart/{id}', [PelangganController::class, 'addToCart']);
    Route::get('/cart', [PelangganController::class, 'showCart']);
    Route::post('/checkout', [PelangganController::class, 'checkout']);
    Route::get('/history', [PelangganController::class, 'history']);
});
