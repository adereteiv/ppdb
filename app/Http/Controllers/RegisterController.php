<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Services\PendaftaranService;
use App\Models\{User,InfoAnak,BatchPPDB};

class RegisterController extends Controller
{
    /**
     * Display registration form, accessible during active batch before it's due waktu_tenggat
     * @return \Illuminate\Contracts\View\View
     */
    public function showRegister(){
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();

        $batchEnd = $activeBatch && now() >= $activeBatch->waktu_tenggat;
        $batchClosed = !$activeBatch;

        return view('daftar', ['batchEnd' => $batchEnd, 'batchClosed' => $batchClosed, 'activeBatch' => $activeBatch]);
    }

    /**
     * Stores user registration, uses PendaftaranService.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        // Active batch check, if no active batch is found, access is blocked via above method
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();

        // Immediately sanitize user inputs, merged later to $request object
        $sanitize = [
            'nomor_hp' => trim($request->input('nomor_hp')),
            'email' => strtolower(trim($request->input('email'))),
            'nama_anak' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('nama_anak'))))),
            'panggilan_anak' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('panggilan_anak'))))),
            'tempat_lahir' => trim(strip_tags($request->input('tempat_lahir'))),
        ];

        // Overwriting $request values
        $request->merge([
            'nomor_hp' => $sanitize['nomor_hp'],
            'email' => $sanitize['email'],
            'nama_anak' => $sanitize['nama_anak'],
            'panggilan_anak' => $sanitize['panggilan_anak'],
            'tempat_lahir' => $sanitize['tempat_lahir'],
        ]);

        // Existing email and nomor_hp check, prevents duplicate records, limited to 2
        if ($request->filled('nomor_hp')) {
            $existingNomorHP = User::where('nomor_hp', $request->nomor_hp)->where('role_id', 2)->count();
            if ($existingNomorHP >= 2) {
                return back()
                    ->with('akunAda', 'Nomor HP telah digunakan dalam dua pendaftaran. Silakan masukkan nomor lain.')
                    ->withInput();
            }
        }
        if ($request->filled('email')) {
            $existingEmail = User::where('email', $request->email)->where('role_id', 2)->count();
            if ($existingEmail >= 2) {
                return back()
                    ->with('akunAda', 'Email telah digunakan dalam dua pendaftaran. Silakan masukkan email lain.')
                    ->withInput();
            }
        }

        // Existing user check, determined by matching 'name' field, 'name' - 'email' pair, or 'name' - 'nomor-hp' pair
        // If another user exists with the same name, differentiate the nomor_hp or email, people having the same name is possible
        $existingUser = User::where('name', $request->nama_anak)
            ->where(function ($query) use ($request) {
                if ($request->filled('email')) {
                    $query->where('email', $request->email)
                        ->orWhere('nomor_hp', $request->nomor_hp);
                } else {
                    $query->where('nomor_hp', $request->nomor_hp);
                }
            })->first();
        if ($existingUser) {
            return back()
            ->with('akunAda', 'Anak dengan data ini sudah terdaftar. Silakan gunakan email atau nomor HP yang berbeda.')
            ->withInput();
        }

        // Model creations
        $request->validate([
                'nama_anak'         => 'required|string|max:255|regex:/^[a-zA-Z-\s]+$/',
                'panggilan_anak'    => 'required|string|max:30|regex:/^[a-zA-Z-\s]+$/',
                'tempat_lahir'      => 'required|string|max:60',
                'tanggal_lahir'     => [
                                        'required','date',
                                        'before_or_equal:' . now()->subYears(4)->toDateString(),
                                        'after:' . now()->subYears(7)->toDateString(),
                                    ],
                'jarak_tempuh'       => 'required|numeric|min:1|max:20',
            ],
            [
                'nomor_hp.required'             => 'Nomor HP/WA wajib diisi.',
                'nomor_hp.regex'                => 'Silakan isi dengan format: +62XXXXXXXXXX atau 08XXXXXXXXXX.',
                'email.email'                   => 'Mohon masukkan format email yang benar.',
                'email.regex'                   => 'Hanya domain .com, .edu, .id, .gov, atau .co.id yang diperbolehkan.',
                'email.indisposable'            => 'Harap masukkan alamat email Anda yang sebenarnya.',
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
                'tempat_lahir.required'         => 'Tempat lahir wajib diisi.',
                'tempat_lahir.max'              => 'Melebihi batas maksimal 60 karakter.',
                'tanggal_lahir.required'        => 'Tanggal lahir wajib diisi.',
                'tanggal_lahir.before_or_equal' => 'Anak harus berusia minimal 4 tahun.',
                'tanggal_lahir.after'           => 'Usia anak maksimal berada di bawah 7 tahun.',
                'jarak_tempuh.required'         => 'Wajib diisi.',
                'jarak_tempuh.min'              => 'Jarak tempuh dimulai dari 1km.',
                'jarak_tempuh.max'              => 'Jarak rumah melebihi 20km.',
            ],
        );
        $pendaftaranService = new PendaftaranService;
        $user = $pendaftaranService->saveAkun($request);
        $pendaftaran = $pendaftaranService->savePendaftaran($user->id, $activeBatch->id);
        InfoAnak::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nama_anak' => $sanitize['nama_anak'],
            'panggilan_anak' => $sanitize['panggilan_anak'],
            'tempat_lahir'=> $sanitize['tempat_lahir'],
            'tanggal_lahir'=> $request->tanggal_lahir,
            'jarak_tempuh'=> $request->jarak_tempuh,
        ]);

        // Gunakan service khusus kirim email disini
        $pendaftaranService->sendEmailWithQueue($user->toArray(), $request->password);

        // Display user credentials for login via temporary token
        $key = 'regis_confirm';
        $token = Str::random(40);
        $expiry = now()->addMinutes(30);
        Cache::put("{$key}:{$token}", [
            'title'     => 'Registrasi Berhasil',
            'user_id'   => $user->id,
            'nama'      => $user->name,
            'nomor_hp'  => $user->nomor_hp,
            'password'  => $request->password,
            'ttl'       => $expiry,
        ], $expiry);
        return redirect()->route('cred', ['key' => $key, 'token' => $token]);
    }

    /**
     * Display confirmation page passing token data from user creation
     * @param mixed $token
     * @return \Illuminate\Contracts\View\View
     */
    public function cred($key, $token) {
        $data = Cache::get("{$key}:{$token}") ?? abort(404, 'Token sudah kedaluwarsa.');

        return view('auth.cred', $data);
    }
}
