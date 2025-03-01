<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function showLogin(){
        return view('auth.login');
    }

    public function showAdminLogin(){
        return view('auth.pintuadmin');
    }

    public function authenticate(Request $request){
        if (Auth::check()){
            return back()->with('error', 'Logout terlebih dahulu untuk menjalankan sesi baru.')->onlyInput('id');
        };

        $credentials = $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('id', $credentials['id'])->where('role_id', 2)->first();

        if (!$user || !Auth::attempt(['id' => $credentials['id'], 'password' => $credentials['password'], 'role_id' => 2])) {
            return back()->with('error', 'Login gagal. Periksa kembali ID dan kata sandi Anda.')->onlyInput('id');
        }

        $key = 'login:pendaftar:' . $request->ip() . ':' . $request->input('id','');
        RateLimiter::clear($key);

        $request->session()->regenerate();
        return redirect()->intended('/pendaftar/dashboard');
    }

    public function authenticateAdmin(Request $request){
        if (Auth::check()){
            return back()->with('error', 'Logout terlebih dahulu untuk menjalankan sesi baru.')->onlyInput('id');
        };

        $credentials = $request->validate([
            'email' => ['required','email:rfc,strict,dns,spoof,indisposable','regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|edu|id|gov|co\.id)$/i'],
            'password' => 'required',
        ],[
            'email.email' => 'Mohon masukkan format email yang benar.',
            'email.regex' => 'Domain email tidak ditemukan. Harap masukkan alamat email Anda yang sebenarnya!',
            'email.indisposable' => 'Harap masukkan alamat email Anda yang sebenarnya.',
        ]);

        $user = User::where('email', $credentials['email'])->where('role_id', 1)->first();

        if (!$user || !Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role_id' => 1])) {
            return back()->with('error', 'Login gagal. Periksa kembali email dan kata sandi Anda.')->onlyInput('email');
        }

        $key = 'login:admin:' . $request->ip() . ':' . strtolower($request->email);
        RateLimiter::clear($key);

        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    public function logout(){
        $user = Auth::user();
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect($user?->role_id == 1 ? '/pintuadmin' : '/login');
    }
}
