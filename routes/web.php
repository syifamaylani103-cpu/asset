<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return redirect()->route('barangs.index');
});

Route::resource('categories', CategoryController::class);
Route::resource('barangs', BarangController::class);

Route::resource('jenis_barang', JenisBarangController::class);
Route::resource('stock_barang', StockController::class);