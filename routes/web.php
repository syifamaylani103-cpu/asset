<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Public Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Auth Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Only Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('barangs', BarangController::class);
        Route::resource('jenis_barang', JenisBarangController::class);
        Route::resource('stock_barang', StockController::class);
        Route::resource('barang_masuk', BarangMasukController::class);
        Route::resource('barang_keluar', BarangKeluarController::class);
        
        Route::post('pengajuan/{id}/approve', [PengajuanController::class, 'approve'])->name('pengajuan.approve');
        Route::post('pengajuan/{id}/reject', [PengajuanController::class, 'reject'])->name('pengajuan.reject');
    });

    // Routes accessible by both Admin and User
    Route::resource('pengajuan', PengajuanController::class);

    // User Only Routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('katalog', [BarangController::class, 'katalog'])->name('katalog.index');
    });
});