<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    RegisterController,
    PasswordResetController,
    AuthController,
    DashboardController,
    PendaftarFormController,
    PendaftarUnggahDokumenController,
    PendaftarUnggahBuktiBayarController,
    DashboardAdminController,
    BatchPPDBController,
    SyaratDokumenController,
    PPDBAktifController,
    PPDBArsipController,
    KelolaPengumumanController,
};

Route::get('/', [HomeController::class, 'beranda'])->name('home');
Route::redirect('/beranda', '/');

Route::get('/profil',[HomeController::class, 'profil']);
Route::get('/struktur',[HomeController::class, 'struktur']);

Route::get('/daftar', [RegisterController::class, 'showRegister']);
Route::post('/daftar', [RegisterController::class, 'store'])->name('register')->middleware('throttle:3,5');
Route::get('/konfirmasi/{key}/{token}', [RegisterController::class, 'cred'])->name('cred');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginPendaftar'])->name('loginPendaftar');

Route::get('/pintuadmin', [AuthController::class, 'showAdminLogin']);
Route::post('/pintuadmin', [AuthController::class, 'loginAdmin'])->name('loginAdmin');

Route::get('/password-reset/{token}', [PasswordResetController::class, 'index'])->name('passwordReset');
Route::post('/password-reset/{token}', [PasswordResetController::class, 'confirm'])->name('passwordResetPIN');
Route::get('/password-reset/{token}/{id}', [PasswordResetController::class, 'edit'])->name('changePassword');
Route::post('/password-reset/{token}/{id}', [PasswordResetController::class, 'update'])->name('saveNewPassword');

Route::middleware('auth.secure')->group(function () {
    Route::prefix('admin')->middleware('role:1')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'showDashboard'])->name('dashboard');

        Route::prefix('/ppdb')->name('ppdb.')->group(function (){
            Route::get('/', [DashboardAdminController::class, 'showPPDB'])->name('index');
            Route::post('/', [DashboardAdminController::class, 'setArsipKey'])->name('arsipKey');

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
                Route::get('/ganti-password/{id}', [PasswordResetController::class, 'setToken'])->name('setToken');
                Route::get('/ganti-password/link/{token}', [PasswordResetController::class, 'getLink'])->name('getPasswordResetLink');
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
            Route::get('/data', [KelolaPengumumanController::class, 'passData'])->middleware('throttle:pengumuman')->name('data');
            Route::get('/export', [KelolaPengumumanController::class, 'export'])->name('export');
            Route::resource('/', KelolaPengumumanController::class)->parameters(['' => 'id'])->except(['edit', 'update']);
        });
    });

    Route::prefix('pendaftar')->middleware(['role:2', 'pendaftar'])->name('pendaftar.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
        Route::get('/profil', [DashboardController::class, 'showProfil'])->name('profil');
        Route::get('/recovery', [DashboardController::class, 'recovery'])->name('recovery');
        Route::post('/recovery', [DashboardController::class, 'store'])->name('recovery.store');

        Route::get('/formulir', [PendaftarFormController::class, 'index'])->name('formulir');
        Route::put('/formulir', [PendaftarFormController::class, 'update'])->name('formulir.update');

        Route::get('/dokumen', [PendaftarUnggahDokumenController::class, 'index'])->name('dokumen');
        Route::put('/dokumen', [PendaftarUnggahDokumenController::class, 'update'])->name('dokumen.update');

        Route::get('/buktibayar', [PendaftarUnggahBuktiBayarController::class, 'index'])->name('buktiBayar');
        Route::put('/buktibayar', [PendaftarUnggahBuktiBayarController::class, 'update'])->name('buktiBayar.update');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
