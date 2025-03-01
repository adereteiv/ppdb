<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftarFormController;
use App\Http\Controllers\DashboardAdminController;
use Illuminate\Session\Middleware\AuthenticateSession;
use App\Http\Controllers\PendaftarUnggahDokumenController;
use App\Http\Controllers\PendaftarUnggahBuktiBayarController;

/*
  Route::get('/', function () {return view('welcome');});
*/

Route::get('/beranda', function () {return view('beranda');});
Route::get('/profil', function () {return view('profil');});
Route::get('/struktur', function () {return view('struktur');});

Route::get('/daftar', [RegisterController::class, 'showRegister']);
Route::post('/daftar', [RegisterController::class, 'store'])->middleware('throttle:register');

/*log in pendaftar*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('throttle:pendaftar_login');

/*log in admin*/
Route::get('/pintuadmin', [AuthController::class, 'showAdminLogin']);
Route::post('/pintuadmin', [AuthController::class, 'authenticateAdmin'])->middleware('throttle:admin_login');

/* Refactor to */
Route::middleware(['auth.must','role:1'])->group(function () {
    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index']);
    Route::get('/admin/ppdb', [DashboardAdminController::class, 'kelolaPPDB']);
    Route::get('/admin/ppdb/arsip', [DashboardAdminController::class, 'kelolaPPDBArsip']);
    Route::get('/admin/ppdb/aktif', [DashboardAdminController::class, 'kelolaPPDBAktif']);
    Route::get('/admin/ppdb/buat', [DashboardAdminController::class, 'buatPPDB']);
    Route::get('/admin/pengumuman', [DashboardAdminController::class, 'kelolaPengumuman']);
});

Route::middleware(['auth.must','role:2'])->group(function () {
    Route::get('/pendaftar/dashboard', [DashboardController::class, 'index']);

    Route::resource('/pendaftar/formulir', PendaftarFormController::class)->only(['index', 'update']);
    Route::put('/pendaftar/formulir/', [PendaftarFormController::class, 'update']);

    Route::resource('/pendaftar/dokumen', PendaftarUnggahDokumenController::class)->only(['index', 'update']);
    Route::put('/pendaftar/dokumen', [PendaftarUnggahDokumenController::class, 'update']);

    Route::resource('/pendaftar/buktibayar', PendaftarUnggahBuktiBayarController::class)->only(['index', 'update']);
    Route::put('/pendaftar/buktibayar', [PendaftarUnggahBuktiBayarController::class, 'update']);

    Route::get('/pendaftar/profil', [DashboardController::class, 'profil']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
Route::middleware(['auth.must'])->group(function (){
    Route::prefix('admin')->middleware(['role:1'])->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index']);

        Route::prefix('/ppdb')->group(function () {
            Route::get('/', [DashboardAdminController::class, 'kelolaPPDB']);
            Route::get('/arsip', [DashboardAdminController::class, 'kelolaPPDBArsip']);
            Route::get('/aktif', [DashboardAdminController::class, 'kelolaPPDBAktif']);
            Route::get('/buat', [DashboardAdminController::class, 'buatPPDB']);
        });

        Route::get('/pengumuman', [DashboardAdminController::class, 'kelolaPengumuman']);
    });

    Route::prefix('pendaftar')->middleware(['role:2'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/formulir', [DashboardController::class, 'formulir']);
        Route::get('/dokumen', [DashboardController::class, 'dokumen']);
        Route::get('/bukti-bayar', [DashboardController::class, 'buktiBayar']);
        Route::get('/profil', [DashboardController::class, 'profil']);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
*/
