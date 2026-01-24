<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualController;
use Illuminate\Support\Facades\Route;

// Halaman Landing (Bisa diakses Guest & Pembeli)
Route::get('/', [PelangganController::class, 'index'])->name('landing');

// Auth Routes Umum
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Registrasi Pembeli
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Registrasi Admin (Akses via klik title "JabVis")
Route::get('/register-admin', [AuthController::class, 'showRegisterAdmin']);
Route::post('/register-admin', [AuthController::class, 'registerAdmin']);

// Penjual / Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => function ($request, $next) {
    if (!session('is_login') || session('role') != 'Penjual') { // Pastikan hanya Penjual
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
});

// Pelanggan / Pembeli Authenticated Routes (Harus Login)
Route::group(['middleware' => function ($request, $next) {
    if (!session('is_login')) {
        return redirect('/login')->with('error', 'Silahkan login terlebih dahulu.');
    }
    return $next($request);
}], function () {
    Route::get('/home', [PelangganController::class, 'index']); // Sama dengan landing tapi versi login
    Route::get('/produk/{id}', [PelangganController::class, 'showProduk']);
    Route::post('/cart/{id}', [PelangganController::class, 'addToCart']);
    Route::get('/cart', [PelangganController::class, 'showCart']);
    Route::post('/checkout', [PelangganController::class, 'checkout']);
    Route::get('/history', [PelangganController::class, 'history']);
});
