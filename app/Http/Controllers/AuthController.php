<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin(){
        return view('auth.login');
    }

    public function showAdminLogin(){
        return view('auth.pintuadmin');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);

        /* dipastikan role = pendaftar */
        $user = User::where('id', $credentials['id'])->where('role_id', 2)->first();

        if (Auth::check()){
            // dd (Auth::user()?->role_id);
            return back()->with('error', 'Logout terlebih dahulu untuk menjalankan sesi baru.')->onlyInput('id');
        };

        if (!$user || !Auth::attempt(['id' => $credentials['id'], 'password' => $credentials['password']])) {
            return back()->with('error', 'Login gagal. Periksa kembali ID dan kata sandi Anda.')->onlyInput('id');
        }

        $request->session()->regenerate();
        return redirect()->intended('/pendaftar/dashboard');
    }

    public function authenticateAdmin(Request $request){
        $credentials = $request->validate([
            'email'=> 'required|email:rfc,dns',
            'password' => 'required',
        ],['email.email' => 'Mohon masukkan format email yang benar.']
        );

        /* dipastikan role = admin */
        $user = User::where('email', $credentials['email'])->where('role_id', 1)->first();

        if (Auth::check()){
            // dd (Auth::user()?->role_id);
            return back()->with('error', 'Logout terlebih dahulu untuk menjalankan sesi baru.')->onlyInput('id');
        };

        if (!$user || !Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            return back()->with('error', 'Login gagal. Periksa kembali email dan kata sandi Anda.')->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    public function logout(){
        $user = Auth::user();
        Auth::logout();

        // Does the same thing, so request() can be ignored
        /*
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        */

        session()->invalidate();
        session()->regenerateToken();

        return redirect($user?->role_id == 1 ? '/pintuadmin' : '/login');
    }
}
