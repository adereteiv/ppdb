<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\TipeDokumen;

class SyaratDokumenController extends Controller
{
    /**
     * Displays tambah-syarat-dokumen form in a modal via [data-url] attribute
     * @return \Illuminate\Contracts\View\View
     */
    public function create() {return view('admin.partials.form-tambah-syarat-dokumen');}

    /**
     * Refer to form.js@appendSyaratDokumen
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        try {
            $request->validate([
                'nama_dokumen' => 'required|string|max:255|regex:/^[\p{L}\p{N}\/\s()]+$/u',
            ],[
                'nama_dokumen.required' => 'Nama dokumen tidak boleh kosong.',
                'nama_dokumen.regex' => 'Nama dokumen mengandung karakter yang tidak valid.',
            ]);

            $dokumen = preg_replace('/[^\p{L}\p{N}\/\s()]+/u', '', trim(strip_tags($request->input('nama_dokumen'))));
            $existingDokumen = TipeDokumen::where('tipe', $dokumen)->first();
            if ($existingDokumen) {return response()->json(['error' => 'Persyaratan ini sudah ada']);}

            $tipeDokumen = TipeDokumen::create(['tipe' => $dokumen]);

            $html = view('components.checkmenu', [
                'checkboxName'  => "include[{$tipeDokumen->tipe}]",
                'checkboxId'    => "checkbox_{$tipeDokumen->tipe}",
                'checkboxValue' => $tipeDokumen->id,
                'label'         => $tipeDokumen->tipe,
                'keteranganName'=> "keterangan[{$tipeDokumen->tipe}]",
                'keteranganId'  => "keterangan_{$tipeDokumen->tipe}",
                'keterangan'    => '',
                'wajibId'       => "wajib_{$tipeDokumen->tipe}",
                'wajibName'     => "is_wajib[{$tipeDokumen->tipe}]",
                'wajibChecked'  => false,
            ])->render();

            return response()->json([
                'success' => 'Berhasil menambah syarat dokumen baru!',
                'html' => $html, //json key passed to syaratDokumen.js
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        }
    }
}
