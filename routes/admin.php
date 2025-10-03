<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PasswordResetController,
    DashboardAdminController,
    BatchPPDBController,
    SyaratDokumenController,
    PPDBAktifController,
    PPDBArsipController,
    KelolaPengumumanController,
};

Route::middleware('auth.secure')->group(function () {
    Route::prefix('admin')->middleware('role:1')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'showDashboard'])->name('dashboard');

        Route::prefix('/ppdb')->name('ppdb.')->group(function (){
            Route::get('/', [DashboardAdminController::class, 'showPPDB'])->name('index');
            Route::post('/', [DashboardAdminController::class, 'setArsipKey'])->name('arsip_key');

            Route::prefix('/arsip')->name('arsip.')->group(function() {
                Route::get('/data', [PPDBArsipController::class, 'passData'])->middleware('throttle:ppdb-arsip')->name('data'); // Route for AJAX request
                Route::get('/rincian', [PPDBArsipController::class, 'showRincian'])->name('rincian');
                Route::get('/export/{id}', [PPDBArsipController::class, 'export'])->name('export');
                Route::resource('/', PPDBArsipController::class)->parameters(['' => 'id'])->except(['create', 'store', 'edit', 'update']);
            });

            Route::prefix('/aktif')->name('aktif.')->group(function() {
                Route::get('/data', [PPDBAktifController::class, 'passData'])->middleware('throttle:ppdb-aktif')->name('data'); // Route for AJAX request
                Route::get('/rincian', [PPDBAktifController::class, 'showRincian'])->name('rincian');
                Route::get('/export', [PPDBAktifController::class, 'export'])->name('export');
                Route::post('/tutup', [PPDBAktifController::class, 'tutupPPDB'])->name('tutup');
                Route::patch('/patch/{id}', [PPDBAktifController::class, 'patch'])->name('patch');
                Route::get('/ganti-password/{id}', [PasswordResetController::class, 'setToken'])->name('password_reset.set_token');
                Route::get('/ganti-password/link/{token}', [PasswordResetController::class, 'getLink'])->name('password_reset.link');
                Route::resource('/', PPDBAktifController::class)->parameters(['' => 'id']);
            });

            Route::prefix('/buat')->name('buat.')->group(function (){
                Route::get('/', [BatchPPDBController::class, 'index'])->name('index');
                Route::post('/', [BatchPPDBController::class, 'store'])->name('store');
                Route::get('/syarat-dokumen', [SyaratDokumenController::class, 'create'])->name('syarat_dokumen');
                Route::post('/syarat-dokumen', [SyaratDokumenController::class, 'store'])->name('syarat_dokumen.store');
            });
        });

        Route::prefix('/pengumuman')->name('pengumuman.')->group(function (){
            Route::get('/', [KelolaPengumumanController::class, 'index'])->name('index');
            Route::get('/data', [KelolaPengumumanController::class, 'passData'])->middleware('throttle:pengumuman')->name('data');
            Route::get('/export', [KelolaPengumumanController::class, 'export'])->name('export');
            Route::resource('/', KelolaPengumumanController::class)->parameters(['' => 'id'])->except(['edit', 'update']);
        });
    });
});
