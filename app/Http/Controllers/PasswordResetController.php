<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\{Facades\Cache,Str};
use App\Models\{User,Pendaftaran};

class PasswordResetController extends Controller
{
    // Safeguard
    private function getOrAbort($key)
    {
        return Cache::get("reset_password:{$key}") ?? abort(404, 'Token sudah kedaluwarsa.');
    }

    /**
     * Set password reset link/{token} with confirmation PIN
     */
    public function setToken($id)
    {
        $token = Str::random(30);
        $pin = random_int(100000, 999999);
        $expiry = now()->addMinutes(30);
        Cache::put("reset_password:{$token}",[
            'user_id' => $id,
            'pin' => $pin,
            'ttl' => $expiry,
        ], $expiry);

        return redirect()->route('admin.ppdb.aktif.getPasswordResetLink', ['token' => $token]);
    }
    public function getLink($token) {
        $data = $this->getOrAbort($token);

        $link = route('passwordReset', ['token' => $token]);
        $pendaftaran = Pendaftaran::where('user_id', $data['user_id'])->first();

        return view('auth.password-reset-link', ['data' => $data, 'link' => $link, 'pendaftaran' => $pendaftaran]);
    }

    /**
     * Pendaftar enters link/{token} and confirms the password reset PIN, system matches token['pin'] with the inserted PIN and redirects to password change form
     */
    public function index($token){
        $this->getOrAbort($token);
        return view('auth.password-reset-pin', ['token' => $token]);
    }
    public function confirm(Request $request, $token)
    {
        $data = Cache::get("reset_password:{$token}");
        $request->validate(['pin' => 'required|digits:6'],['pin.required' => 'PIN wajib diisi', 'pin.digits' => 'Harap masukkan PIN yang diberikan oleh operator.']);

        if (!$data || $request->input('pin') != $data['pin']) {
            return back()->with('error', 'PIN salah atau kedaluwarsa.')->withInput();
        }

        return redirect()->route('changePassword', ['id' => $data['user_id'], 'token' => $token]);
    }

    /**
     * Saves password change, forgets the cache key, and send a new cache for confirmation page, refer to RegisterController@cred
     */
    public function edit($token, string $id){
        $this->getOrAbort($token);
        return view('auth.password-reset', ['id' => $id, 'token' => $token]);
    }
    public function update(Request $request, $token, string $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8|max:60'
        ],[
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 8 karakter.',
            'password.max'      => 'Kata sandi melebihi batas maksimal 60 karakter.',
            'password.confirmed'=> 'Kata sandi tidak cocok.',
        ]);

        $user = User::find($id);
        $user->update(['password' => $request->input('password')]);

        $key = 'password_confirm';
        $newToken = Str::random(40);
        $expiry = now()->addMinutes(30);
        Cache::put("{$key}:{$newToken}", [
            'title'     => 'Berhasil Memperbarui Kata Sandi',
            'user_id'   => $user->id,
            'nama'      => $user->name,
            'nomor_hp'  => $user->nomor_hp,
            'password'  => $request->password,
            'ttl'       => $expiry,
        ], $expiry);

        Cache::forget("reset_password:{$token}");
        return redirect()->route('cred', ['key' => $key, 'token' => $newToken]);
    }
}
