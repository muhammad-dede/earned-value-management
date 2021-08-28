<?php

use App\Http\Controllers\Aplikasi\Admin\BerandaController;
use App\Http\Controllers\Aplikasi\Admin\LaporanController;
use App\Http\Controllers\Aplikasi\Admin\PegawaiController;
use App\Http\Controllers\Aplikasi\Admin\ProjekController;
use App\Http\Controllers\Aplikasi\Admin\UserController;
use App\Http\Controllers\Aplikasi\Admin\VendorController;
use App\Http\Controllers\Aplikasi\Admin\VendorPTController;
use Illuminate\Support\Facades\Route;


Auth::routes(['verify' => false, 'register' => false, 'confirm' => false]);

Route::group(['middleware' => 'auth'], function () {
    // Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/', [BerandaController::class, 'index'])->name('beranda');

    Route::group(['middleware' => 'akses_admin'], function () {
        Route::resource('/user', UserController::class, ['except' => ['show']]);
        Route::resource('/pegawai', PegawaiController::class, ['except' => ['show']]);
        Route::resource('/vendor-pt', VendorPTController::class, ['except' => ['show']]);
        Route::resource('/vendors', VendorController::class, ['except' => ['show']]);
    });

    Route::resource('/projek', ProjekController::class, ['except' => ['store']]);
    Route::get('/projek/kurva/{projek}', [ProjekController::class, 'kurva'])->name('projek.kurva');
    Route::get('/projek/laporan-pengeluaran/{laporan_pekerjaan}', [ProjekController::class, 'detail_laporan_pengeluaran'])->name('projek.laporan-pengeluaran');
    Route::get('/projek/tambah-surat-jalan/{projek}', [ProjekController::class, 'tambah_surat_jalan'])->name('projek.tambah-surat-jalan');
    Route::put('/projek/upload-surat-jalan/{projek}', [ProjekController::class, 'upload_surat_jalan'])->name('projek.upload-surat-jalan');
    Route::get('/projek/edit-surat-jalan/{surat_jalan}', [ProjekController::class, 'edit_surat_jalan'])->name('projek.edit-surat-jalan');
    Route::put('/projek/update-surat-jalan/{surat_jalan}', [ProjekController::class, 'update_surat_jalan'])->name('projek.update-surat-jalan');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/print-pdf/{projek}', [LaporanController::class, 'print_pdf'])->name('print-pdf');
});
