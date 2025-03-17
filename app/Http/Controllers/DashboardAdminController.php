<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function showDashboard(){
        $batch = BatchPPDB::latest()->first() ?? BatchPPDB::where('status', true)->latest()->first();
        if (!$batch) {
            return view('admin.dashboard',[
                'batch' => 'Belum ada pembukaan gelombang PPDB',
                'pendaftaran' => collect(),
                'pendaftaranTotal' => 0,
                'pendaftaranBelumLengkap' => 0,
                'pendaftaranLengkap' => 0,
                'pendaftaranTerverifikasi' => 0,
            ]);
        }

        $pendaftaran = Pendaftaran::where('batch_id', $batch->id)->get();
        // $pendaftaranTotal = count($pendaftaran);
        // $pendaftaranBelumLengkap = count($pendaftaran->where('status','Belum Lengkap'));
        // $pendaftaranLengkap = count($pendaftaran->where('status','Lengkap'));
        // $pendaftaranTerverifikasi = count($pendaftaran->where('status','Terverifikasi'));

        return view('admin.dashboard',[
            'batch' => 'Periode ' . $batch->tahun_ajaran . ' - Gel. ' . $batch->gelombang,
            'pendaftaran' => $pendaftaran,
            'pendaftaranTotal' => $pendaftaran->count(),
            'pendaftaranBelumLengkap' => $pendaftaran->where('status','Belum Lengkap')->count(),
            'pendaftaranLengkap' => $pendaftaran->where('status','Lengkap')->count(),
            'pendaftaranTerverifikasi' => $pendaftaran->where('status','Terverifikasi')->count(),
        ]);
        // return view('admin.dashboard', compact('pendaftaran','pendaftaranTotal', 'pendaftaranBelumLengkap', 'pendaftaranLengkap', 'pendaftaranTerverifikasi'));
    }

    public function showPPDB(){
        // Fetch BatchPPDB records by 'tahun_ajaran' and 'gelombang' arranged in a descending order
        $arsipPPDB = BatchPPDB::where('status', false)
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('gelombang', 'desc')
            ->get();
        // $arsipPPDB->pluck('id', 'tahun_ajaran')->map(fn($tahun_ajaran, $id) => 'Tahun Ajaran ' . $tahun_ajaran . ' - Gel. ' . $arsipPPDB->where('id', $id)->first()->gelombang);
        $arsipOptions = $arsipPPDB->mapWithKeys(function ($batch) {
            return [$batch->id => "Periode {$batch->tahun_ajaran} - Gel. {$batch->gelombang}"];
        });

        $aktifPPDB = BatchPPDB::where('status', true)->first();

        return view('admin.ppdb', compact('arsipPPDB', 'aktifPPDB', 'arsipOptions'));
    }
}
