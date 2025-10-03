<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginPendaftar'])->name('login.send');

Route::get('/pintuadmin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/pintuadmin', [AuthController::class, 'loginAdmin'])->name('login.admin.send');

Route::middleware('auth.secure')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
