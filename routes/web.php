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
    Route::prefix('admin')->middleware('role:1')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'showDashboard'])->name('dashboard');

        Route::prefix('/ppdb')->name('ppdb.')->group(function (){
            Route::get('/', [DashboardAdminController::class, 'showPPDB'])->name('index');
            Route::post('/', [DashboardAdminController::class, 'setArsipKey'])->name('arsipKey');

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

            Route::prefix('/buat')->name('buat.')->group(function (){
                Route::get('/', [BatchPPDBController::class, 'index'])->name('index');
                Route::post('/', [BatchPPDBController::class, 'store'])->name('store');
                Route::get('/syarat-dokumen', [SyaratDokumenController::class, 'create'])->name('syaratDokumen');
                Route::post('/syarat-dokumen', [SyaratDokumenController::class, 'store'])->name('syaratDokumen.store');
            });
        });

        Route::prefix('/pengumuman')->name('pengumuman.')->group(function (){
            Route::get('/', [KelolaPengumumanController::class, 'index'])->name('index');
            Route::get('/data', [KelolaPengumumanController::class, 'passData'])->middleware('throttle:30,1')->name('data');;
            Route::resource('/', KelolaPengumumanController::class)->parameters(['' => 'id'])->except(['edit', 'update']);
        });
    });

    Route::prefix('pendaftar')->middleware(['role:2'])->name('pendaftar.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
        Route::get('/profil', [DashboardController::class, 'showProfil'])->name('profil');

        Route::get('/formulir', [PendaftarFormController::class, 'index'])->name('formulir');
        Route::put('/formulir', [PendaftarFormController::class, 'update'])->name('formulir.update');

        Route::get('/dokumen', [PendaftarUnggahDokumenController::class, 'index'])->name('dokumen');
        Route::put('/dokumen', [PendaftarUnggahDokumenController::class, 'update'])->name('dokumen.update');

        Route::get('/buktibayar', [PendaftarUnggahBuktiBayarController::class, 'index'])->name('buktiBayar');
        Route::put('/buktibayar', [PendaftarUnggahBuktiBayarController::class, 'update'])->name('buktiBayar.update');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', function() {return redirect('login');});
});
