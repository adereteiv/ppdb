<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    PendaftarFormController,
    PendaftarUnggahDokumenController,
    PendaftarUnggahBuktiBayarController,
};

Route::middleware('auth.secure')->group(function () {
    Route::prefix('pendaftar')->middleware(['role:2', 'pendaftar'])->name('pendaftar.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
        Route::get('/profil', [DashboardController::class, 'showProfil'])->name('profil');
        Route::get('/recovery', [DashboardController::class, 'recovery'])->name('recovery');
        Route::post('/recovery', [DashboardController::class, 'store'])->name('recovery.store');

        Route::get('/formulir', [PendaftarFormController::class, 'index'])->name('formulir');
        Route::put('/formulir', [PendaftarFormController::class, 'update'])->name('formulir.update');

        Route::get('/dokumen', [PendaftarUnggahDokumenController::class, 'index'])->name('dokumen');
        Route::put('/dokumen', [PendaftarUnggahDokumenController::class, 'update'])->name('dokumen.update');

        Route::get('/buktibayar', [PendaftarUnggahBuktiBayarController::class, 'index'])->name('bukti_bayar');
        Route::put('/buktibayar', [PendaftarUnggahBuktiBayarController::class, 'update'])->name('bukti_bayar.update');
    });
});
