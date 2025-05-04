<?php

namespace App\Http\Controllers;

use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use App\Models\OrangTuaWali;
use App\Services\PendaftaranService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarFormController extends Controller
{
    protected $pendaftaranService;

    public function __construct(PendaftaranService $pendaftaranService)
    {
        $this->pendaftaranService = $pendaftaranService;
    }

    public function index()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();
        $infoAnak = $pendaftaran ? InfoAnak::where('pendaftaran_id', $pendaftaran->id)->first() : null;

        $ayah = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'ayah')->first() : null;
        $ibu = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'ibu')->first() : null;
        $wali = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'wali')->first() : null;

        return view('pendaftar.formulir', compact('user','infoAnak', 'ayah', 'ibu', 'wali'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();

        $pendaftaran = Pendaftaran::updateOrCreate(
            ['user_id' => $user->id],
            ['batch_id' => Pendaftaran::where('user_id', $user->id)->value('batch_id') ?? $activeBatch->id]
        );

        $this->pendaftaranService->saveFormulir($request, $pendaftaran);

        return back()->with('success', 'Formulir berhasil disimpan!');
    }
}
