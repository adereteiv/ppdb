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
            return view('admin.dashboard', [
                'batch' => 'Belum ada pembukaan gelombang PPDB',
                'pendaftaran' => collect(),
                'pendaftaranTotal' => 0,
                'pendaftaranBelumLengkap' => 0,
                'pendaftaranLengkap' => 0,
                'pendaftaranTerverifikasi' => 0,
            ]);
        }

        $pendaftaran = Pendaftaran::where('batch_id', $batch->id)->get();

        return view('admin.dashboard', [
            'batch' => 'Periode ' . $batch->tahun_ajaran . ' - Gel. ' . $batch->gelombang,
            'pendaftaran' => $pendaftaran,
            'pendaftaranTotal' => $pendaftaran->count(),
            'pendaftaranBelumLengkap' => $pendaftaran->where('status','Belum Lengkap')->count(),
            'pendaftaranLengkap' => $pendaftaran->where('status','Lengkap')->count(),
            'pendaftaranTerverifikasi' => $pendaftaran->where('status','Terverifikasi')->count(),
        ]);
    }

    public function showPPDB(){
        // Fetch BatchPPDB records by 'tahun_ajaran' and 'gelombang', pay attention to the arrangement order
        $arsipPPDB = BatchPPDB::where('status', false)
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('gelombang', 'desc')
            ->get();
        $arsipOptions = $arsipPPDB->mapWithKeys(function ($batch) {
            return [$batch->id => "Periode {$batch->tahun_ajaran} - Gel. {$batch->gelombang}"];
        });

        $aktifPPDB = BatchPPDB::where('status', true)->first();

        return view('admin.ppdb', compact('arsipPPDB', 'aktifPPDB', 'arsipOptions'));
    }

    public function setAksesArsip(Request $request) {
        $request->validate(['periode'=> 'required|exists:batch_ppdb,id']);
        // session(['akses_arsip' => $request->periode]);
        // session itu membebani server dan db, cookies saja agar client-side
        return redirect('/admin/ppdb/arsip');
    }
}
