<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\Pengumuman;

class HomeController extends Controller
{
    public function beranda()
    {
        $batch = BatchPPDB::where('status', true)->latest()->first();
        $pengumuman = Pengumuman::where(['tipe_pengumuman'=> 'Umum'])->latest()->first();
        return view('beranda', compact('batch', 'pengumuman'));
    }

    public function profil()
    {
        return view('profil');
    }

    public function struktur()
    {
        return view('struktur');
    }
}
