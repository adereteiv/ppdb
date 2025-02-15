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
        return view('login');
    }

    public function showAdminLogin(){
        return view('admin.login');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);

        /*
        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/pendaftar/dashboard');
        };
        */

        $user = User::where('id', $credentials['id'])->where('role_id', 2)->first();

        /* dipastikan role = pendaftar */
        /* Dua pengecekan + error
        if (!$user){
            return back()->withErrors(['id' => 'Periksa kembali ID yang dimasukkan.'])->onlyInput('id');
        }

        if (!Auth::attempt($credentials)){
            return back()->withErrors(['password' => 'Login gagal. Periksa kembali ID dan kata sandi Anda.'])->onlyInput('id');
        }
        */

        /* Digabung
        if (!$user || !Auth::attempt($credentials)) {
            return back()->with('loginError', 'Login gagal. Periksa kembali ID dan kata sandi Anda.')->onlyInput('id');
        }
        */

        /*Digabung lebih jauh*/
        if (!$user || !Auth::attempt(['id' => $credentials['id'], 'password' => $credentials['password']])) {
            return back()->with('loginError', 'Login gagal. Periksa kembali ID dan kata sandi Anda.')->onlyInput('id');
        }

        $request->session()->regenerate();
        return redirect()->intended('/pendaftar/dashboard');
    }

    public function authenticateAdmin(Request $request){
        $credentials = $request->validate([
            /*
            'email'=> 'required|email',
            */
            'email'=> 'required|email:rfc,dns',
            'password' => 'required',
        ],['email.email' => 'Mohon masukkan format email yang benar.']
        );

        /*
        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        };
        */

        /* dipastikan role = admin */
        $user = User::where('email', $credentials['email'])->where('role_id', 1)->first();

        /* Dua pengecekan + error
        if (!$user){
            return back()->withErrors(['email' => "Email tidak cocok, silakan coba lagi."])->onlyInput('email');
            }

        if (!Auth::attempt($credentials)){
            return back()->withErrors(['password' => 'Login gagal.'])->onlyInput('email');
        }
        */

        /* Fusion! */
        if (!$user || !Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            return back()->with('loginError', 'Login gagal. Periksa kembali email dan kata sandi Anda.')->onlyInput('email');
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

        // Still sama fungsinya, trim trim cut cut
        /*
        if ($user && $user->role_id == 1){
            return redirect('/pintuadmin');
        }

        return redirect('/login');
        */

        /* Masih bisa di-trim, STREAMLINE GAS
        return redirect($user && $user->role_id == 1 ? '/pintuadmin' : '/login');
        */

        /* Perfecto! */
        return redirect($user?->role_id == 1 ? '/pintuadmin' : '/login');
    }
}
