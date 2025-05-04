<?php

namespace App\Http\Controllers;

class KelolaPengumumanController extends Controller
{
    public function index(){

        return view('admin.pengumuman');
    }

    public function create(){
        return view('admin.pengumuman-buat');
    }

    public function store() {
        redirect('/admin/pengumuman')->with('success', "Berhasil membuat pengumuman");
    }
}
