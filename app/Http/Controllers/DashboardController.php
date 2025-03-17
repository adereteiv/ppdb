<?php

namespace App\Http\Controllers;

use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use App\Models\BuktiBayar;
use App\Models\Pendaftaran;
use App\Models\OrangTuaWali;
use Illuminate\Http\Request;
use App\Models\SyaratDokumen;
use App\Models\DokumenPersyaratan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showDashboard(){
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->first();

        // Indicator bit
        if(!$pendaftaran) {
            return view('pendaftar.dashboard',['formulirLengkap' => false, 'dokumenLengkap' => false, 'buktiBayarLengkap' => false]);
        }

        // Indicator bit: $formulirLengkap check
        $infoAnak = InfoAnak::where('pendaftaran_id', $pendaftaran->infoAnak->id)->firstOrFail();
        $orangTuaWali = OrangTuaWali::where('anak_id', optional($infoAnak)->id)->get();

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
        $batch = BatchPPDB::find($pendaftaran->batch_id);
        $syaratDokumen = SyaratDokumen::where('batch_id', $batch->id)->where('is_wajib', true)->pluck('tipe_dokumen_id');
        $unggahDokumen = DokumenPersyaratan::where('anak_id', $infoAnak->id)->pluck('tipe_dokumen_id');
        $dokumenLengkap = $syaratDokumen->diff($unggahDokumen)->isEmpty();

        // Indicator bit: $buktiBayarLengkap check
        $buktiBayarLengkap = BuktiBayar::where('anak_id', $infoAnak->id)->exists();

        // Update $pendaftaran->status jika seluruh requirement Lengkap
        if($formulirLengkap && $dokumenLengkap && $buktiBayarLengkap && ($pendaftaran->status === 'Belum Lengkap')) {
            $pendaftaran->status = 'Lengkap';
            $pendaftaran->save();
        }
        $pendaftaran->refresh();

        return view('pendaftar.dashboard',compact('pendaftaran','formulirLengkap', 'dokumenLengkap', 'buktiBayarLengkap'));
    }

    public function showProfil(){
        $user = Auth::user();

        $pendaftaran = Pendaftaran::where('user_id', $user->id)->firstOrFail();
        $infoAnak = InfoAnak::where('pendaftaran_id', $pendaftaran->infoAnak->id)->firstOrFail();
        $orangTuaWali = OrangTuaWali::where('anak_id', $infoAnak->id)->get();

        $batch = BatchPPDB::findOrFail($pendaftaran->batch_id);
        $syaratDokumen = SyaratDokumen::where('batch_id', $batch->id)->with('tipeDokumen')->get();
        $dokumenPersyaratan = DokumenPersyaratan::where('anak_id', $infoAnak->id)->get();
        $buktiBayar = BuktiBayar::where('anak_id', $infoAnak->id)->first();

        return view('pendaftar.profil',compact('user','pendaftaran', 'infoAnak', 'orangTuaWali', 'syaratDokumen', 'dokumenPersyaratan', 'buktiBayar'));
    }
}
