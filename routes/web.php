<?php

use App\Http\Controllers\Aplikasi\Admin\BerandaController;
use App\Http\Controllers\Aplikasi\Admin\PegawaiController;
use App\Http\Controllers\Aplikasi\Admin\ProjekController;
use App\Http\Controllers\Aplikasi\Admin\VendorController;
use App\Http\Controllers\Aplikasi\Admin\VendorPTController;
use App\Http\Controllers\Aplikasi\Vendor\BerandaController as VendorBerandaController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;


Auth::routes(['verify' => false, 'register' => false, 'confirm' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::group(['middleware' => 'menu_admin'], function () {
        Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
        Route::resource('/pegawai', PegawaiController::class, ['except' => ['show']]);
        Route::resource('/vendor-pt', VendorPTController::class, ['except' => ['show']]);
        Route::resource('/vendors', VendorController::class, ['except' => ['show']]);
        Route::resource('/projek', ProjekController::class, ['except' => ['store']]);
        Route::get('/projek/kurva/{projek}', [ProjekController::class, 'kurva'])->name('projek.kurva');
        Route::get('/projek/laporan-pengeluaran/{laporan_pekerjaan}', [ProjekController::class, 'detail_laporan_pengeluaran'])->name('projek.laporan-pengeluaran');
    });

    Route::group(['middleware' => 'menu_vendor', 'prefix' => 'vendor', 'as' => 'vendor.'], function () {
        Route::get('/beranda', [VendorBerandaController::class, 'index'])->name('beranda');
    });
});
