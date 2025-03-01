<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->first();
        return view('pendaftar.dashboard',compact('pendaftaran'));
    }

    public function profil(){
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->first();

        return view('pendaftar.profil',compact('user','pendaftaran'));
    }
}
