<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SyaratDokumenController extends Controller
{
    public function create() {
        return view('admin.tambah-syarat-dokumen-form');
    }

    public function store() {
        return back()->with('success', 'Berhasil menambah syarat dokumen baru!')->withInput();
    }
}
