<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use App\Models\SyaratDokumen;
use App\Models\DokumenPersyaratan;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Storage;

class PendaftarUnggahDokumenController extends Controller
{
    protected $pendaftaranService;

    public function __construct(PendaftaranService $pendaftaranService)
    {
        $this->pendaftaranService = $pendaftaranService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();;
        $batch = BatchPPDB::findOrFail($pendaftaran->batch_id);
        $syaratDokumen = SyaratDokumen::where('batch_id', $batch->id)->with('tipeDokumen')->orderBy('id', 'desc')->get(); // Sesuaikan dengan BatchPPDBController
        $dokumenPersyaratan = DokumenPersyaratan::where('anak_id', optional($pendaftaran->infoAnak)->id)->get();

        return view('pendaftar.dokumen', compact('syaratDokumen','dokumenPersyaratan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->with('user')->firstOrFail();

        $this->pendaftaranService->saveDokumenPersyaratan($request, $pendaftaran);

        return back()->with('success', 'Dokumen berhasil disimpan!');
    }
}
