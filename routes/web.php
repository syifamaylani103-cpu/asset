<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BarangController;

Route::get('/', function () {
    return redirect()->route('barangs.index');
});

Route::resource('categories', CategoryController::class);
Route::resource('barangs', BarangController::class);