<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BatchPPDBController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PPDBAktifController;
use App\Http\Controllers\PPDBArsipController;
use App\Http\Controllers\PendaftarFormController;
use App\Http\Controllers\SyaratDokumenController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\KelolaPengumumanController;
use App\Http\Controllers\PendaftarUnggahDokumenController;
use App\Http\Controllers\PendaftarUnggahBuktiBayarController;
// use Illuminate\Session\Middleware\AuthenticateSession;

/*
  Route::get('/', function () {return view('welcome');});
*/

Route::get('/beranda', function () {return view('beranda');});
Route::get('/profil', function () {return view('profil');});
Route::get('/struktur', function () {return view('struktur');});

Route::get('/daftar', [RegisterController::class, 'showRegister']);
Route::post('/daftar', [RegisterController::class, 'store']);
// ->middleware('throttle:1,5');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginPendaftar']);

Route::get('/pintuadmin', [AuthController::class, 'showAdminLogin']);
Route::post('/pintuadmin', [AuthController::class, 'loginAdmin']);

Route::middleware('auth.secure')->group(function () {
    Route::prefix('admin')->middleware('role:1')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'showDashboard']);

        Route::prefix('/ppdb')->name('ppdb.')->group(function (){
            Route::get('/', [DashboardAdminController::class, 'showPPDB']);
            Route::post('/', [DashboardAdminController::class, 'setArsipKey']);

            Route::prefix('/arsip')->name('arsip.')->group(function() {
                Route::get('/data', [PPDBArsipController::class, 'passData'])->middleware('throttle:30,1')->name('data'); // Route for AJAX request
                Route::get('/rincian', [PPDBArsipController::class, 'showRincian'])->name('rincian');
                Route::resource('/', PPDBArsipController::class)->parameters(['' => 'id'])->except(['create', 'store', 'edit', 'update']);
            });

            Route::prefix('/aktif')->name('aktif.')->group(function() {
                Route::get('/data', [PPDBAktifController::class, 'passData'])->middleware('throttle:30,1')->name('data'); // Route for AJAX request
                Route::get('/rincian', [PPDBAktifController::class, 'showRincian'])->name('rincian');
                Route::post('/tutup', [PPDBAktifController::class, 'tutupPPDB'])->name('tutup');
                Route::patch('/patch/{id}', [PPDBAktifController::class, 'patch'])->name('patch');
                Route::resource('/', PPDBAktifController::class)->parameters(['' => 'id']);
            });

            Route::prefix('/buat')->group(function (){
                Route::get('/', [BatchPPDBController::class, 'index']);
                Route::post('/', [BatchPPDBController::class, 'store']);
                Route::get('/syarat-dokumen', [SyaratDokumenController::class, 'create']);
                Route::post('/syarat-dokumen', [SyaratDokumenController::class, 'store']);
            });
        });

        Route::prefix('/pengumuman')->group(function (){
            Route::get('/', [KelolaPengumumanController::class, 'index']);
            Route::get('/buat', [KelolaPengumumanController::class, 'create']);
            Route::post('/buat', [KelolaPengumumanController::class, 'store']);
        });
    });

    Route::prefix('pendaftar')->middleware(['role:2'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'showDashboard']);
        Route::get('/profil', [DashboardController::class, 'showProfil']);

        Route::get('/formulir', [PendaftarFormController::class, 'index']);
        Route::put('/formulir', [PendaftarFormController::class, 'update']);

        Route::get('/dokumen', [PendaftarUnggahDokumenController::class, 'index']);
        Route::put('/dokumen', [PendaftarUnggahDokumenController::class, 'update']);

        Route::get('/buktibayar', [PendaftarUnggahBuktiBayarController::class, 'index']);
        Route::put('/buktibayar', [PendaftarUnggahBuktiBayarController::class, 'update']);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', function() {return redirect('login');});
});
