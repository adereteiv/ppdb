<?php

namespace App\Http\Controllers;

use App\Models\BuktiBayar;
use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarFormController extends Controller
{
    /**
     * Moved InfoAnak and OrangTuaWali saving to PendaftaranService
     * @param \App\Services\PendaftaranService $pendaftaranService
     */
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
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();
        $batch = BatchPPDB::find($pendaftaran->batch_id);
        $infoAnak = $pendaftaran ? InfoAnak::where('pendaftaran_id', $pendaftaran->id)->first() : null;
        $buktiBayar = BuktiBayar::where('anak_id', $infoAnak->id)->exists();
        // flow, pay first
        // if (!$buktiBayar || $pendaftaran->status === 'Menunggu') return back()->with('warn', 'Silakan menyelesaikan tahap pembayaran dan mengunggah bukti pembayaran. Admin akan melakukan verifikasi secepatnya.');
        if (now() >= $batch->waktu_tenggat) {
            return back()->with('check', 'Masa tenggat pendaftaran sudah lewat. Silakan menghubungi Admin bila ingin merubah data pendaftaran.');
        } elseif ($pendaftaran->status === 'Terverifikasi') {
            return back()->with('check', 'Data Anda sudah terverifikasi. Silakan menghubungi Admin bila ingin merubah data pendaftaran.');
        } elseif (!$buktiBayar && $pendaftaran->status === 'Menunggu') {
            return back()->with('warn', 'Silakan menyelesaikan tahap pembayaran dan mengunggah bukti pembayaran. Admin akan melakukan verifikasi secepatnya.');
        } elseif ($buktiBayar && $pendaftaran->status === 'Menunggu') {
            return back()->with('warn', 'Admin akan melakukan verifikasi pembayaran secepatnya.');
        }

        $ayah = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'ayah')->first() : null;
        $ibu = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'ibu')->first() : null;
        $wali = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'wali')->first() : null;

        return view('pendaftar.formulir', compact('user','infoAnak', 'ayah', 'ibu', 'wali'));
    }

    /**
     * Uses update for easier naming, representing it's logic inside PendaftaranService
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();
        if (now() >= $activeBatch->waktu_tenggat) {
            return back()->with('error', 'Tidak dapat melakukan perubahan. Melewati masa tenggat periode PPDB.');
        }

        $pendaftaran = Pendaftaran::updateOrCreate(
            ['user_id' => $user->id],
            ['batch_id' => Pendaftaran::where('user_id', $user->id)->value('batch_id') ?? $activeBatch->id]
        );

        $this->pendaftaranService->saveFormulir($request, $pendaftaran);

        return back()->with('success', 'Formulir berhasil disimpan!');
    }
}
