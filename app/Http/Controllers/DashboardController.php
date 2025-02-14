<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('pendaftar.dashboard');
    }
    public function showFormulir(){
        return view('pendaftar.formulir');
    }
    public function showDokumen(){
        return view('pendaftar.dokumen');
    }
    public function showBuktiBayar(){
        return view('pendaftar.bukti-bayar');
    }
    public function showProfil(){
        return view('pendaftar.profil');
    }
}
