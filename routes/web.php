<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\PPDBAktifController;
use App\Http\Controllers\PPDBArsipController;
use App\Http\Controllers\BatchPPDBController;
use App\Http\Controllers\SyaratDokumenController;
use App\Http\Controllers\KelolaPengumumanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftarFormController;
use App\Http\Controllers\PendaftarUnggahDokumenController;
use App\Http\Controllers\PendaftarUnggahBuktiBayarController;
use Illuminate\Session\Middleware\AuthenticateSession;

/*
  Route::get('/', function () {return view('welcome');});
*/

Route::get('/beranda', function () {return view('beranda');});
Route::get('/profil', function () {return view('profil');});
Route::get('/struktur', function () {return view('struktur');});

Route::get('/daftar', [RegisterController::class, 'showRegister']);
Route::post('/daftar', [RegisterController::class, 'store']);
// ->middleware('throttle:register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('throttle:pendaftar_login');

Route::get('/pintuadmin', [AuthController::class, 'showAdminLogin']);
Route::post('/pintuadmin', [AuthController::class, 'authenticateAdmin'])->middleware('throttle:admin_login');

Route::middleware('auth.must')->group(function () {
    Route::prefix('admin')->middleware('role:1')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'showDashboard']);

        Route::prefix('/ppdb')->group(function (){
            Route::get('/', [DashboardAdminController::class, 'showPPDB']);

            Route::get('/arsip', [PPDBArsipController::class, 'index']);

            Route::get('/aktif', [PPDBAktifController::class, 'index']);

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
        });
    });

    Route::prefix('pendaftar')->middleware(['role:2'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'showDashboard']);
        Route::get('/profil', [DashboardController::class, 'showProfil']);

        Route::resource('/formulir', PendaftarFormController::class)->only(['index', 'update']);
        Route::put('/formulir', [PendaftarFormController::class, 'update']);

        Route::resource('/dokumen', PendaftarUnggahDokumenController::class)->only(['index', 'update']);
        Route::put('/dokumen', [PendaftarUnggahDokumenController::class, 'update']);

        Route::resource('/buktibayar', PendaftarUnggahBuktiBayarController::class)->only(['index', 'update']);
        Route::put('/buktibayar', [PendaftarUnggahBuktiBayarController::class, 'update']);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', function() {return redirect('login');});
});
