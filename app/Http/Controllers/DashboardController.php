<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\{Facades\Auth,Str};
use App\Models\{BatchPPDB,Pendaftaran,SyaratDokumen,InfoAnak,BuktiBayar,OrangTuaWali,DokumenPersyaratan,Pengumuman};
use App\Services\PendaftaranService;

class DashboardController extends Controller
{
    protected $pendaftaranService;
    public function __construct(PendaftaranService $pendaftaranService)
    {
        $this->pendaftaranService = $pendaftaranService;
    }

    /**
     * Centralized data getter.
     */
    private function getData($key = null) {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();
        $batch = optional($pendaftaran)->batch_id
            ? BatchPPDB::find($pendaftaran->batch_id)
            : null;
        $syaratDokumen = $batch
            ? SyaratDokumen::where('batch_id', $batch->id)
            : collect(); //looped
        $infoAnak = optional($pendaftaran)->id
            ? InfoAnak::where('pendaftaran_id', $pendaftaran->id)->first()
            : null;
        $dokumenPersyaratan = $infoAnak
            ? DokumenPersyaratan::where('anak_id', optional($infoAnak)->id)->get()
            : collect(); //looped
        $orangTuaWali = $infoAnak
            ? OrangTuaWali::where('anak_id', optional($infoAnak)->id)->get()
            : collect(); //looped
        $buktiBayar = $infoAnak
            ? BuktiBayar::where('anak_id', optional($infoAnak)->id)->first()
            : null;

        $data = compact(['user', 'pendaftaran', 'batch', 'syaratDokumen', 'infoAnak', 'dokumenPersyaratan', 'orangTuaWali', 'buktiBayar']);
        return $key ? ($data[$key] ?? null) : $data ;
    }

    /**
     * Display pendaftar dashboard, checks for `pendaftaran`->status, logic refer to PendaftaranService class
     */
    public function showDashboard(){
        $user = $this->getData('user');
        $pendaftaran = $this->getData('pendaftaran');
        $batch = $this->getData('batch');
        $pengumuman = Pengumuman::where(['tipe_pengumuman'=> 'Khusus Pendaftar'])->latest()->first();

        if (!$pendaftaran) return view('pendaftar.dashboard', ['formulirLengkap' => false, 'dokumenLengkap' => false, 'buktiBayarLengkap' => false]);

        $status = $this->pendaftaranService->checkStatusPendaftaran($pendaftaran);
        [
            'formulirLengkap' => $formulirLengkap,
            'dokumenLengkap' => $dokumenLengkap,
            'buktiBayarLengkap' => $buktiBayarLengkap
        ] = $status;
        $pendaftaran->refresh();

        return view('pendaftar.dashboard', compact('pendaftaran','batch',  'pengumuman', 'formulirLengkap', 'dokumenLengkap', 'buktiBayarLengkap'));
    }

    /**
     * Display pendaftar profil, fetch all data related to the pendaftaran
     */
    public function showProfil(){
        $user = $this->getData('user');
        $pendaftaran = $this->getData('pendaftaran');

        if (!$pendaftaran) {
            return view('pendaftar.profil', [
                'user' => $user,
                'pendaftaran' => null,
                'infoAnak' => null,
                'orangTuaWali' => collect(),
                'syaratDokumen' => collect(),
                'dokumenPersyaratan' => collect(),
                'buktiBayar' => null,
            ]);
        }

        $batch = $this->getData('batch');
        $syaratDokumen = $this->getData('syaratDokumen')->with('tipeDokumen')->orderBy('id', 'desc')->get();

        $infoAnak = $this->getData('infoAnak');
        $orangTuaWali = $this->getData('orangTuaWali');
        $dokumenPersyaratan = $this->getData('dokumenPersyaratan');
        $buktiBayar = $this->getData('buktiBayar');

        return view('pendaftar.profil', compact('user','pendaftaran', 'infoAnak', 'orangTuaWali', 'syaratDokumen', 'dokumenPersyaratan', 'buktiBayar'));
    }

    /**
     * Display pendaftaran recovery form in case pendaftaran is deleted refer to PPDBAktifController@destroy
     */
    public function recovery() {
        return view('pendaftar.form-recovery');
    }

    /**
     * Stores initial `pendaftaran` record from form-recovery, a.k.a, back-up registration without creating user record
     */
    public function store(Request $request){
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();

        $request->validate([
                'nama_anak'         => 'required|string|max:255|regex:/^[a-zA-Z-\s]+$/',
                'panggilan_anak'    => 'required|string|max:30|regex:/^[a-zA-Z-\s]+$/',
                'tempat_lahir'      => 'required|string',
                'tanggal_lahir'     => [
                                        'required','date',
                                        'before_or_equal:' . now()->subYears(4)->toDateString(),
                                        'after:' . now()->subYears(7)->toDateString(),
                                    ],
                'jarak_tempuh'       => 'required|numeric|min:1|max:20',
                'alamat_anak'       => 'required|string|max:255',
            ],
            [
                'nama_anak.required'            => 'Wajib diisi.',
                'nama_anak.max'                 => 'Melebihi batas maksimal 255 karakter.',
                'nama_anak.regex'               => 'Hanya huruf Aa-Zz dan tanda hubung (-) yang diperbolehkan.',
                'panggilan_anak.required'       => 'Wajib diisi.',
                'panggilan_anak.max'            => 'Melebihi batas maksimal 30 karakter.',
                'panggilan_anak.regex'          => 'Hanya huruf Aa-Zz dan tanda hubung (-) yang diperbolehkan.',
                'tanggal_lahir.required'        => 'Wajib diisi.',
                'tanggal_lahir.before_or_equal' => 'Anak harus berusia minimal 4 tahun.',
                'tanggal_lahir.after'           => 'Usia anak maksimal berada di bawah 7 tahun.',
                'jarak_tempuh.required'         => 'Wajib diisi.',
                'jarak_tempuh.min'              => 'Jarak tempuh dimulai dari 1km.',
                'jarak_tempuh.max'              => 'Jarak rumah melebihi 20km.',
                'alamat_anak.required'          => 'Alamat wajib diisi.',
                'alamat_anak.max'               => 'Melebihi batas maksimal 255 karakter.',

            ],
        );

        $sanitize = [
            'nama_anak' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('nama_anak'))))),
            'panggilan_anak' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('panggilan_anak'))))),
        ];

        // Enables username change, safe because nomor_hp and email is made via register where differentiation happens, refer to PendaftaranService
        $user = Auth::user();
        $user->update(['name' => $sanitize['nama_anak']]);
        $pendaftaran = $this->pendaftaranService->savePendaftaran($user->id,$activeBatch->id);

        InfoAnak::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nama_anak' => $sanitize['nama_anak'],
            'panggilan_anak' => $sanitize['panggilan_anak'],
            'tempat_lahir'=> $request->tempat_lahir,
            'tanggal_lahir'=> $request->tanggal_lahir,
            'jarak_tempuh'=> $request->jarak_tempuh,
            'alamat_anak'=> $request->alamat_anak,
        ]);

        return redirect()->route('pendaftar.dashboard')->with('success', 'Pembuatan rekam pendaftaran berhasil!');
    }
}
