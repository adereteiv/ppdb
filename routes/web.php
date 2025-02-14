<?php

use Illuminate\Support\Facades\Route;
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
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'authenticate']);

//log in admin
Route::get('/pintuadmin', [AuthController::class, 'showAdminLogin']);
Route::post('/pintuadmin', [AuthController::class, 'authenticateAdmin']);

//dashboard pendaftar
Route::get('/pendaftar/dashboard', [DashboardController::class, 'index']);
Route::get('/pendaftar/formulir"', [DashboardController::class, 'showFormulir']);
Route::get('/pendaftar/dokumen"', [DashboardController::class, 'shodDokumen']);
Route::get('/pendaftar/bukti-bayar', [DashboardController::class, 'showBuktiBayar']);
Route::get('/pendaftar/profil', [DashboardController::class, 'showProfil']);

//dashboard admin
Route::get('/admin/dashboard', [DashboardAdminController::class, 'index']);
Route::get('/admin/ppdb', [DashboardAdminController::class, 'kelolaPPDB']);
Route::get('/admin/pengumuman', [DashboardAdminController::class, 'kelolaPengumuman']);

//log out
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
