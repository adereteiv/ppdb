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
    public function kelolaPengumuman(){
        return view('admin.pengumuman');
    }
}
