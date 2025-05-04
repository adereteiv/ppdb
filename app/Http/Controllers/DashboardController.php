<?php

namespace App\Http\Controllers;

use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use App\Models\BuktiBayar;
use App\Models\Pendaftaran;
use App\Models\OrangTuaWali;
use App\Models\SyaratDokumen;
use App\Models\DokumenPersyaratan;
use App\Http\Controllers\Controller;
use App\Services\PendaftaranService;
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

        // Indicator bit
        if (!$pendaftaran) {
            return view('pendaftar.dashboard', ['formulirLengkap' => false, 'dokumenLengkap' => false, 'buktiBayarLengkap' => false]);
        }

        /* MOVED TO SERVICE CLASS FOR REUASABILITY
        // Indicator bit: $formulirLengkap check
        $infoAnak = $this->getData('infoAnak');
        $orangTuaWali = $this->getData('orangTuaWali');

        $requiredInfoAnak = [
            'nama_anak', 'panggilan_anak', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
            'alamat_anak', 'kewarganegaraan', 'bahasa_di_rumah', 'agama', 'status_tinggal',
            'yang_mendaftarkan', 'status_anak', 'anak_ke', 'berat_badan', 'tinggi_badan', 'golongan_darah'
        ];

        if (optional($infoAnak)->mendaftar_sebagai === 'Pindahan') {
            $requiredInfoAnak = array_merge($requiredInfoAnak, [
                'sekolah_lama', 'tanggal_pindah', 'dari_kelompok', 'ke_kelompok'
            ]);
        }

        $infoAnakLengkap = $infoAnak && collect($requiredInfoAnak)->every(fn($field) => !empty($infoAnak->$field));

        if ($infoAnak && $infoAnak->yang_mendaftarkan === 'Orang Tua') {
            $requiredRelasi = ['ayah', 'ibu'];
        } else {
            $requiredRelasi = ['wali'];
        }

        $orangTuaWaliLengkap = collect($requiredRelasi)->every(fn($relasi) => $orangTuaWali->contains('relasi', $relasi));

        $formulirLengkap = $infoAnakLengkap && $orangTuaWaliLengkap;

        // Indicator bit: $dokumenLengkap check
        $batch = $this->getData('batch');
        $syaratDokumen = $this->getData('syaratDokumen')->where('is_wajib', true)->pluck('tipe_dokumen_id');
        $dokumenUnggahan = $this->getData('dokumenPersyaratan')->pluck('tipe_dokumen_id');
        $dokumenLengkap = $syaratDokumen->diff($dokumenUnggahan)->isEmpty();

        // Indicator bit: $buktiBayarLengkap check
        $buktiBayarLengkap = optional($this->getData('buktiBayar'))->exists();

        // Update $pendaftaran->status jika seluruh requirement Lengkap
        if ($formulirLengkap && $dokumenLengkap && $buktiBayarLengkap && ($pendaftaran->status === 'Belum Lengkap')) {
            // $pendaftaran->status = 'Lengkap';
            // $pendaftaran->save();
            $pendaftaran->update(['status' => 'Lengkap']);
        }
        */

        $pendaftaranService = new PendaftaranService;
        $status = $pendaftaranService->checkStatusPendaftaran($pendaftaran);
        [
            'formulirLengkap' => $formulirLengkap,
            'dokumenLengkap' => $dokumenLengkap,
            'buktiBayarLengkap' => $buktiBayarLengkap
        ] = $status;
        $pendaftaran->refresh();

        return view('pendaftar.dashboard', compact('pendaftaran','formulirLengkap', 'dokumenLengkap', 'buktiBayarLengkap'));
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
}
