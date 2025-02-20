<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Session\Middleware\AuthenticateSession;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardAdminController;

// Route::get('/', function () {return view('welcome');});

Route::get('/beranda', function () {return view('beranda');});
Route::get('/profil', function () {return view('profil');});
Route::get('/struktur', function () {return view('struktur');});
Route::get('/daftar', [RegisterController::class, 'showRegister']);
Route::post('/daftar', [RegisterController::class, 'store']);

//log in pendaftar
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

//log in admin
Route::get('/pintuadmin', [AuthController::class, 'showAdminLogin']);
Route::post('/pintuadmin', [AuthController::class, 'authenticateAdmin']);

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
    Route::get('/pendaftar/formulir', [DashboardController::class, 'showFormulir']);
    Route::get('/pendaftar/dokumen', [DashboardController::class, 'showDokumen']);
    Route::get('/pendaftar/bukti-bayar', [DashboardController::class, 'showBuktiBayar']);
    Route::get('/pendaftar/profil', [DashboardController::class, 'showProfil']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
