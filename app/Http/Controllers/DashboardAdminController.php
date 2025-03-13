<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function showDashboard(){
        $batch = BatchPPDB::latest()->first();
        if (!$batch) {$batch = BatchPPDB::where('status', true)->latest()->first();}

        $pendaftaran = Pendaftaran::where('batch_id', $batch->id)->get();
        $pendaftaranTotal = count($pendaftaran);
        $pendaftaranBelumLengkap = count($pendaftaran->where('status','Belum Lengkap'));
        $pendaftaranLengkap = count($pendaftaran->where('status','Lengkap'));
        $pendaftaranTerverifikasi = count($pendaftaran->where('status','Terverifikasi'));

        return view('admin.dashboard', compact('pendaftaran','pendaftaranTotal', 'pendaftaranBelumLengkap', 'pendaftaranLengkap', 'pendaftaranTerverifikasi'));
    }

    public function showPPDB(){
        // Fetch BatchPPDB records by 'tahun_ajaran' and 'gelombang' arranged in a descending order
        $arsipPPDB = BatchPPDB::where('status', false)->orderBy('tahun_ajaran', 'desc')->orderBy('gelombang', 'desc')->get();
        $aktifPPDB = BatchPPDB::where('status', true)->first();
        return view('admin.ppdb', compact('arsipPPDB', 'aktifPPDB'));
    }
}
