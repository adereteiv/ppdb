<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BatchPPDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    /**
     * Summary of showLogin
     * @return mixed|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     *
     * Fetches active batch and determines access to login page
     */
    public function showLogin(){
        return view('auth.login');
    }

    /**
     * Summary of showAdminLogin
     * @return \Illuminate\Contracts\View\View
     */
    public function showAdminLogin(){
        return view('auth.pintuadmin');
    }

    /**
     * Summary of loginPendaftar
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     *
     * Passes $request and $roleType to authenticate()
     */
    public function loginPendaftar(Request $request){
        return $this->authenticate($request, 'pendaftar');
    }
    public function loginAdmin(Request $request){
       return $this->authenticate($request, 'admin');
    }

    /**
     * Summary of authenticate
     * @param \Illuminate\Http\Request $request
     * @param string $roleType
     * @return mixed|\Illuminate\Http\RedirectResponse
     *
     * Joint helper for authentication purpose
     */
    private function authenticate(Request $request, string $roleType) {
        $isAdmin = $roleType === 'admin';
        $authField = $isAdmin ? 'email' : 'id';
        $roleId = $isAdmin ? 1 : 2;

        // Check if user has already logged in
        if (Auth::check()) {
            return back()->with('error', 'Logout terlebih dahulu untuk menjalankan sesi baru.')->onlyInput($authField);
        }

        /** Login Throttling
         * Previously conflicted with RateLimiter::for()
         * The goal is using fixed waiting period and using cache is more suitable
         * So, we go full controller handling
         * The Flow:
         * 1. Determine $roleType and it's related $key
         * 2-pre. Determine $wait period and infer it's $cooldown from now encase it in $time format
         * 2. Check >> Is user in a lockout period? YES, return back with $time : NO, continue
         * 3. Check >> Does $key exist? YES, increment existing $key : NO, set $key
         */
        // Step 1
        $key = $isAdmin
            ? 'login:admin:' . $request->ip() . ':' . strtolower($request->input('email'))
            : 'login:pendaftar:' . $request->ip() . ':' . $request->input('id','');
        $lockoutKey = "lockout:$key";
        $attempts = Cache::get($key);
        $wait = match (true) {
            $attempts == 11 => 300,
            $attempts == 9 => 120,
            $attempts == 7 => 60,
            $attempts == 4 => 30,
            default => 0
        };
        // Step 2 | Prevent doing unnecessary steps
        if (Cache::has($lockoutKey)) {
            $cooldown = Cache::get($lockoutKey) - time(); // subtract by time() is necessary to show real countdown, UNIX timestamp is needed on $lockoutKey setter
            // $timeString = $cooldown > 60
            //     ? gmdate("i:s", $cooldown) . ' menit'
            //     : $cooldown . ' detik';
            // return back()->with('error', "Terlalu banyak percobaan. Coba lagi dalam {$timeString}.")->onlyInput($authField);
            return back()->with(['error' => 'Terlalu banyak percobaan. Coba lagi dalam', 'ttl' => $cooldown])->onlyInput($authField);
        }
        // Step 3
        if (Cache::has($key)) {
            Cache::increment($key);
        } else {
            Cache::put($key, 1, 600); // 10 min expiry
        }

        /* Validation */
        $rules = [
            'password' => 'required',
        ];
        if ($isAdmin) {
            $rules['email'] = ['required','email:rfc,strict,dns,spoof,indisposable','regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|edu|id|gov|co\.id)$/i'];
        } else {
            $rules['id'] = 'required';
        }
        $messages = [
            'email.email' => 'Mohon masukkan format email yang benar.',
            'email.regex' => 'Domain email tidak ditemukan. Harap masukkan alamat email Anda yang sebenarnya!',
            'email.indisposable' => 'Harap masukkan alamat email Anda yang sebenarnya.',
            'password.required' => 'Kata sandi wajib diisi.',
        ];
        $credentials = $request->validate($rules, $messages);

        /* Authentication */
        // Check User record from table 'users'
        $user = User::where(
            function($q) use($isAdmin, $credentials){
                if ($isAdmin) {
                    $q->where('email', $credentials['email']);
                } else {
                    $q->where('id', $credentials['id'])
                    ->orWhere('nomor_hp', $credentials['id']);
                }
            }
            // [
            //     [$authField, '=', $credentials[$authField]],
            //     ['role_id', '=', $roleId]
            // ]
        )
        ->where('role_id', $roleId)
        ->first();
        $activeBatch = BatchPPDB::where('status', true)->first();

        if ($user && $user->role_id === 2) {
            if ($user->pendaftaran && $user->pendaftaran->batch_id !== optional($activeBatch)->id) {
                return back()->with('error', 'Anda sudah memiliki rekam pendaftaran pada gelombang PPDB sebelumnya. Silakan buat Akun baru untuk melanjutkan proses pendaftaran.');
            }
        }

        if (!$user || !Hash::check($credentials['password'], $user->password))
            // !Auth::attempt([
            //     $authField => $credentials[$authField],
            //     'password' => $credentials['password'],
            //     'role_id' => $roleId,
            // ]
        {
            // CONSIDER USING REDIS CACHING ON DEPLOYMENT
            Cache::put($lockoutKey, time() + $wait, $wait); // $value requires time() to check $lockoutKey, expires according to $wait seconds
            // dd("Key: ". $key, "Key Value: " . $attempts, "Lockout Key: " . $lockoutKey, "Lockout Key Value: " . Cache::get($lockoutKey));
            return back()->with('error', 'Login gagal. Periksa kembali '. ($isAdmin ? 'email' : 'ID') . ' dan kata sandi Anda.')->onlyInput($authField);
        }
        Auth::login($user);

        if ($user->role_id === 2 && !$user->pendaftaran) return redirect()->route('pendaftar.recovery');

        Cache::forget($key);
        Cache::forget($lockoutKey);

        $request->session()->regenerate();
        return redirect()->intended($isAdmin ? '/admin/dashboard' : '/pendaftar/dashboard');
    }

    /**
     * Summary of logout
     * @return \Illuminate\Http\RedirectResponse
     *
     * Logs user out, cleanse all stored data such as cookies
     */
    public function logout(){
        $user = Auth::user();
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();
        Cookie::queue(Cookie::forget('arsip_key'));

        return redirect($user?->role_id == 1 ? '/pintuadmin' : '/login');
    }
}
