<?php

namespace App\Http\Controllers;

use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use App\Models\BuktiBayar;
use App\Models\Pengumuman;
use App\Models\Pendaftaran;
use App\Models\OrangTuaWali;
use App\Models\SyaratDokumen;
use App\Models\DokumenPersyaratan;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
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

    public function showDashboard(){
        $user = $this->getData('user');
        $pendaftaran = $this->getData('pendaftaran');
        $pengumuman = Pengumuman::where(['tipe_pengumuman'=> 'Khusus Pendaftar'])->latest()->first();

        if (!$pendaftaran) return view('pendaftar.dashboard', ['formulirLengkap' => false, 'dokumenLengkap' => false, 'buktiBayarLengkap' => false]);

        $pendaftaranService = new PendaftaranService;
        $status = $pendaftaranService->checkStatusPendaftaran($pendaftaran);
        [
            'formulirLengkap' => $formulirLengkap,
            'dokumenLengkap' => $dokumenLengkap,
            'buktiBayarLengkap' => $buktiBayarLengkap
        ] = $status;
        $pendaftaran->refresh();

        return view('pendaftar.dashboard', compact('pendaftaran', 'pengumuman', 'formulirLengkap', 'dokumenLengkap', 'buktiBayarLengkap'));
    }

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

    public function recovery() {
        return view('pendaftar.form-recovery');
    }

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
                'alamat_anak.required'          => 'Alamat wajib diisi.',
                'alamat_anak.max'               => 'Melebihi batas maksimal 255 karakter.'
            ],
        );

        $sanitize = [
            'nama_anak' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('nama_anak'))))),
            'panggilan_anak' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('panggilan_anak'))))),
        ];

        $pendaftaran = Pendaftaran::create([
            'user_id' => Auth::user()->id,
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

        return redirect()->route('pendaftar.dashboard')->with('success', 'Pembuatan rekam pendaftaran berhasil!');
    }
}
