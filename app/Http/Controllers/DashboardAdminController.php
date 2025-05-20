<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DashboardAdminController extends Controller
{
    /**
     * Display summary from recent admission batch
     */
    public function showDashboard(){
        $batch = BatchPPDB::where('status', true)->latest()->first() ?? BatchPPDB::latest()->first();
        if (!$batch) {
            return view('admin.dashboard', [
                'batch' => 'Belum ada pembukaan gelombang PPDB',
                'pendaftaran' => collect(),
                'pendaftaranTotal' => 0,
                'pendaftaranMenunggu' => 0,
                'pendaftaranMengisi' => 0,
                'pendaftaranLengkap' => 0,
                'pendaftaranTerverifikasi' => 0,
            ]);
        }

        $pendaftaran = Pendaftaran::where('batch_id', $batch->id)->get();

        return view('admin.dashboard', [
            'batch' => 'Periode ' . $batch->tahun_ajaran . ' - Gel. ' . $batch->gelombang,
            'pendaftaran' => $pendaftaran,
            'pendaftaranTotal' => $pendaftaran->count(),
            'pendaftaranMenunggu' => $pendaftaran->where('status','Menunggu')->count(),
            'pendaftaranMengisi' => $pendaftaran->where('status','Mengisi')->count(),
            'pendaftaranLengkap' => $pendaftaran->where('status','Lengkap')->count(),
            'pendaftaranTerverifikasi' => $pendaftaran->where('status','Terverifikasi')->count(),
        ]);
    }

    /**
     * Display Kelola PPDB menu
     * Fetch BatchPPDB records by 'tahun_ajaran' and 'gelombang', pay attention to the arrangement order
     */
    public function showPPDB(){
        $arsipPPDB = BatchPPDB::where('status', false)
            ->where('waktu_tutup', '<', now())
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('gelombang', 'desc')
            ->get();
        $arsipOptions = $arsipPPDB->mapWithKeys(function ($batch) {
            return [$batch->id => "Periode {$batch->tahun_ajaran} - Gel. {$batch->gelombang}"];
        });

        $aktifPPDB = BatchPPDB::where('status', true)->first();

        return view('admin.ppdb', compact('arsipPPDB', 'aktifPPDB', 'arsipOptions'));
    }

    /**
     * arsip_key setter, used in PPDBArsipController, removed during log out
     */
    public function setArsipKey(Request $request) {
        $key = $request->validate(['periode' => 'string|required']);
        Cookie::queue('arsip_key', $key['periode'], 60 * 24 * 7); // 7 days

        return redirect()->route('admin.ppdb.arsip.index');
    }
}
