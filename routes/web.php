<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    RegisterController,
    PasswordResetController,
};

Route::get('/', [HomeController::class, 'beranda'])->name('home');
// Route::redirect('/beranda', '/');

Route::get('/profil',[HomeController::class, 'profil']);
Route::get('/struktur',[HomeController::class, 'struktur']);

Route::get('/daftar', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/daftar', [RegisterController::class, 'store'])->name('register.send')->middleware('throttle:3,5');
Route::get('/konfirmasi/{key}/{token}', [RegisterController::class, 'cred'])->name('cred');

Route::get('/password-reset/{token}', [PasswordResetController::class, 'index'])->name('password_reset');
Route::post('/password-reset/{token}', [PasswordResetController::class, 'confirm'])->name('password_reset.pin');
Route::get('/password-reset/{token}/{id}', [PasswordResetController::class, 'edit'])->name('password_reset.form');
Route::post('/password-reset/{token}/{id}', [PasswordResetController::class, 'update'])->name('password_reset.update');

// Route::get('/', function () {
//     return view('welcome');
// });
