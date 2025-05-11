<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use App\Notifications\KirimUserIDNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function showRegister(){
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();

        $batchClosed = false;
        $batchEnd = false;

        if (!$activeBatch) {
            $batchClosed = true;
        } elseif (now() >= $activeBatch->waktu_tenggat) {
            $batchEnd = true;
        }

        return view('daftar', ['batchEnd' => $batchEnd, 'batchClosed' => $batchClosed, 'activeBatch' => $activeBatch]);
    }

    public function store(Request $request){
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();

        $existingEmail = User::where('email', $request->email)->where('role_id', 2)->count();
        if ($existingEmail >= 2) {
            return back()->with('akunAda', 'Maksimal 2 pendaftaran anak per email. Silakan gunakan email lain.')->withInput();
        };

        $existingUser = User::where('email', $request->email)->where('name', $request->nama_anak)->first();
        if ($existingUser) {
            return back()->with('akunAda' , 'Anak dengan email ini sudah terdaftar. Jika ingin mendaftarkan anak lain, silakan cek kembali atau hubungi admin untuk bantuan.')->withInput();
        }

        $request->validate([
                'email'             => ['required','email:rfc,dns,spoof,strict,indisposable','regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|edu|id|gov|co\.id)$/i',],
                'nomor_hp'          => 'required|regex:/^(?:\+?\d{1,3})?[ \-]?\d{10,15}$/|min:10|max:20',
                'password'          => 'required|confirmed|min:8|max:60',
                'nama_anak'         => 'required|string|max:255|regex:/^[a-zA-Z-\s]+$/',
                'panggilan_anak'    => 'required|string|max:30|regex:/^[a-zA-Z-\s]+$/',
                'tempat_lahir'      => 'required|string',
                'tanggal_lahir'     => [
                                        'required','date',
                                        'before_or_equal:' . now()->subYears(4)->toDateString(),
                                        'after:' . now()->subYears(7)->toDateString(),
                                    ],
                'alamat_anak'       => 'required|string|max:255',
            ],
            [
                'email.required'                => 'Email wajib diisi.',
                'email.email'                   => 'Mohon masukkan format email yang benar.',
                'email.regex'                   => 'Hanya domain .com, .edu, .id, .gov, atau .co.id yang diperbolehkan.',
                'email.indisposable'            => 'Harap masukkan alamat email Anda yang sebenarnya.',
                'nomor_hp.regex'                => 'Silakan isi dengan format: +62XXXXXXXXXX.',
                'password.required'             => 'Kata sandi wajib diisi.',
                'password.min'                  => 'Kata sandi minimal 8 karakter.',
                'password.max'                  => 'Kata sandi melebihi batas maksimal 60 karakter.',
                'password.confirmed'            => 'Kata sandi tidak cocok.',
                'nama_anak.required'            => 'Wajib diisi.',
                'nama_anak.max'                 => 'Melebihi batas maksimal 255 karakter.',
                'nama_anak.regex'               => 'Hanya huruf Aa-Zz dan tanda hubung (-) yang diperbolehkan.',
                'panggilan_anak.required'       => 'Wajib diisi.',
                'panggilan_anak.max'            => 'Melebihi batas maksimal 30 karakter.',
                'panggilan_anak.regex'          => 'Hanya huruf Aa-Zz dan tanda hubung (-) yang diperbolehkan.',
                'tanggal_lahir.required'        => 'Wajib diisi.',
                'tanggal_lahir.before_or_equal' => 'Anak harus berusia minimal 4 tahun.',
                'tanggal_lahir.after'           => 'Usia anak maksimal berada di bawah 7 tahun.',
                'alamat_anak.required'          => 'Alamat wajib diisi.',
                'alamat_anak.max'               => 'Melebihi batas maksimal 255 karakter.'
            ],
        );

        $sanitize = [
            'nama_anak' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('nama_anak'))))),
            'panggilan_anak' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('panggilan_anak'))))),
            'email' => strtolower(trim($request->input('email'))),
            'nomor_hp' => trim($request->input('nomor_hp')),
        ];

        $user = User::create([
            'name' => $sanitize['nama_anak'],
            'email' => $sanitize['email'],
            'nomor_hp' => $sanitize['nomor_hp'],
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

        return redirect('login')->with('success', 'Registrasi akun berhasil!');
    }
}
