<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/',       [AuthController::class, 'showLogin'])->name('home');
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// User
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard',        [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/jasa',             [UserController::class, 'jasaIndex'])->name('jasa');
    Route::get('/booking',          [UserController::class, 'bookingIndex'])->name('booking');
    Route::get('/booking/buat',     [UserController::class, 'bookingCreate'])->name('booking.create');
    Route::post('/booking',         [UserController::class, 'bookingStore'])->name('booking.store');
    Route::get('/booking/{booking}',[UserController::class, 'bookingShow'])->name('booking.show');
    Route::get('/booking/{booking}/sertifikat', [UserController::class, 'bookingSertifikat'])->name('booking.sertifikat');
    Route::post('/booking/{booking}/batal', [UserController::class, 'bookingCancel'])->name('booking.cancel');
});

// Mekanik
Route::middleware(['auth', 'role:mekanik'])->prefix('mekanik')->name('mekanik.')->group(function () {
    Route::get('/dashboard',  [MekanikController::class, 'dashboard'])->name('dashboard');
    Route::get('/service',    [MekanikController::class, 'daftarService'])->name('service');
    Route::post('/service/{booking}/status', [MekanikController::class, 'updateStatus'])->name('service.status');
});

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/booking',                        [AdminController::class, 'bookingIndex'])->name('booking');
    Route::post('/booking/{booking}/assign',      [AdminController::class, 'bookingAssign'])->name('booking.assign');

    Route::get('/service',                        [AdminController::class, 'serviceIndex'])->name('service');
    Route::post('/service',                       [AdminController::class, 'serviceStore'])->name('service.store');
    Route::put('/service/{service}',              [AdminController::class, 'serviceUpdate'])->name('service.update');
    Route::delete('/service/{service}',           [AdminController::class, 'serviceDestroy'])->name('service.destroy');

    Route::get('/barang',                         [AdminController::class, 'barangIndex'])->name('barang');
    Route::post('/barang',                        [AdminController::class, 'barangStore'])->name('barang.store');
    Route::put('/barang/{barang}',                [AdminController::class, 'barangUpdate'])->name('barang.update');
    Route::delete('/barang/{barang}',             [AdminController::class, 'barangDestroy'])->name('barang.destroy');

    Route::get('/pelanggan',                      [AdminController::class, 'pelangganIndex'])->name('pelanggan');

    Route::get('/mekanik',                        [AdminController::class, 'mekanikIndex'])->name('mekanik');
    Route::post('/mekanik',                       [AdminController::class, 'mekanikStore'])->name('mekanik.store');
    Route::delete('/mekanik/{user}',              [AdminController::class, 'mekanikDestroy'])->name('mekanik.destroy');

    Route::get('/transaksi',                      [AdminController::class, 'transaksiIndex'])->name('transaksi');
    Route::post('/transaksi/{transaksi}/lunas',   [AdminController::class, 'transaksiLunas'])->name('transaksi.lunas');
});
