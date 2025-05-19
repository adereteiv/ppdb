<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\Pengumuman;

class HomeController extends Controller
{
    /**
     * Display beranda, includes `batch` & `pengumuman`
     */
    public function beranda()
    {
        $batch = BatchPPDB::where('status', true)->latest()->first();
        $pengumuman = Pengumuman::where(['tipe_pengumuman'=> 'Umum'])->latest()->first();
        return view('beranda', compact('batch', 'pengumuman'));
    }

    /**
     * Display profil
     */
    public function profil(){return view('profil');}

    /**
     * Display struktur
     */
    public function struktur(){return view('struktur');}
}
