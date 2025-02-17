<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }
    public function kelolaPPDB(){
        return view('admin.ppdb');
    }
    // public function kelolaPPDBArsip(){
    //     return view('admin.ppdb-rekampendaftaran');
    // }
    // public function kelolaPPDBAktif(){
    //     return view('admin.ppdb-rekampendaftaran');
    // }
    // public function rincianPPDB(){
    //     return view('admin.ppdb-rekampendaftaran');
    // }
    // public function buatPPDB(){
    //     return view('admin.ppdb-buat');
    // }
    public function kelolaPengumuman(){
        return view('admin.pengumuman');
    }
}
