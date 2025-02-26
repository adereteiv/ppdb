<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use App\Notifications\KirimUserIDNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

        $existingUser = User::where('email', $request->email)
            ->where('name', $request->nama_anak)
            ->first();

        if ($existingUser) {
            return back()->with('akunAda' , 'Anak dengan email ini sudah terdaftar. Jika ingin mendaftarkan anak lain, silakan cek kembali atau hubungi admin untuk bantuan.')->withInput();
        }

        $request->validate([
            // enforce stronger email validation to prevent bot spam
            'email' => 'required|email:rfc,dns',
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
            'password.confirmed' => 'Kata sandi tidak cocok.',
            'tanggal_lahir.before_or_equal' => 'Anak harus berusia minimal 4 tahun.',
            'tanggal_lahir.after' => 'Usia anak maksimal 6 tahun.',
        ],
        );

        $user = User::create([
            'name' => $request->nama_anak,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);

        $pendaftaran = Pendaftaran::create([
            'user_id' => $user->id,
            'batch_id' => $activeBatch->id,
        ]);

        InfoAnak::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nama_anak' => ucwords(strtolower($request->nama_anak)),
            'panggilan_anak' => ucwords(strtolower($request->panggilan_anak)),
            'tempat_lahir'=> $request->tempat_lahir,
            'tanggal_lahir'=> $request->tanggal_lahir,
            'alamat_anak'=> $request->alamat_anak,
        ]);

        $user->notify(new KirimUserIDNotification($user->id));

        Session::flash('user_id', $user->id);

        return redirect('/login')->with('success', 'Registrasi akun berhasil!');
    }
}
