<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use App\Notifications\KirimUserIDNotification;

class RegisterController extends Controller
{
    public function showRegister(){
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();

        if (!$activeBatch) {
            return view('daftar', ['batchClosed' => true]);
        }

        return view('daftar', ['batchClosed' => false]);
    }

    public function store(Request $request){
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();

        $existingEmail = User::where('email', $request->email)->count();
        if ($existingEmail >= 2) {
            return back()->with('akunAda', 'Maksimal 2 pendaftaran anak per email. Silakan gunakan email lain.')->withInput();
        };

        $existingUser = User::where('email', $request->email)->where('name', $request->nama_anak)->first();
        if ($existingUser) {
            return back()->with('akunAda' , 'Anak dengan email ini sudah terdaftar. Jika ingin mendaftarkan anak lain, silakan cek kembali atau hubungi admin untuk bantuan.')->withInput();
        }

        $request->validate([
            'email' => ['required','email:rfc,dns,spoof,strict,indisposable','regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|edu|id|gov|co\.id)$/i',],
            'password' => 'required|confirmed|min:8|max:255',
            'nama_anak' => 'required|string|max:255',
            'panggilan_anak' => 'required|string|max:255',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => [
                'required','date',
                'before_or_equal:' . now()->subYears(4)->toDateString(),
                'after:' . now()->subYears(7)->toDateString(),
            ],
            'alamat_anak' => 'required|string',
        ],
        [
            'email.email' => 'Mohon masukkan format email yang benar.',
            'email.regex' => 'Hanya domain .com, .edu, .id, .gov, atau .co.id yang diperbolehkan.',
            'email.indisposable' => 'Harap masukkan alamat email Anda yang sebenarnya.',
            'password.confirmed' => 'Kata sandi tidak cocok.',
            'tanggal_lahir.before_or_equal' => 'Anak harus berusia minimal 4 tahun.',
            'tanggal_lahir.after' => 'Usia anak maksimal berada di bawah 7 tahun.',
        ],
        );

        $sanitize = [
            'nama_anak' => ucwords(strtolower(trim($request->input('nama_anak')))),
            'panggilan_anak' => ucwords(strtolower(trim($request->input('panggilan_anak')))),
            'email' => strtolower(trim($request->input('panggilan_anak'))),
        ];

        $user = User::create([
            'name' => $sanitize['nama_anak'],
            'email' => $sanitize['email'],
            'password' => Hash::make($request->password),
        ]);

        $pendaftaran = Pendaftaran::create([
            'user_id' => $user->id,
            'batch_id' => $activeBatch->id,
        ]);

        InfoAnak::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nama_anak' => $sanitize['nama_anak'],
            'panggilan_anak' => $sanitize['panggilan_anak'],
            'tempat_lahir'=> $request->tempat_lahir,
            'tanggal_lahir'=> $request->tanggal_lahir,
            'alamat_anak'=> $request->alamat_anak,
        ]);

        $user->notify(new KirimUserIDNotification($user->id));

        Session::flash('user_id', $user->id);

        $key = 'register:' . $request->ip();
        RateLimiter::hit($key, 14400);

        return redirect('/login')->with('success', 'Registrasi akun berhasil!');
    }
}
