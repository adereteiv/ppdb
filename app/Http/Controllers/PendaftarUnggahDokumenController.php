<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\BuktiBayar;
use App\Models\Pendaftaran;
use App\Models\SyaratDokumen;
use App\Models\DokumenPersyaratan;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarUnggahDokumenController extends Controller
{
    /**
     * Moved DokumenPersyaratan saving to PendaftaranService
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
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->with('infoAnak')->first();
        $buktiBayar = BuktiBayar::where('anak_id', $pendaftaran->infoAnak->id)->exists();
        // flow, pay first
        // if (!$buktiBayar || $pendaftaran->status === 'Menunggu') return back()->with('warn', 'Silakan menyelesaikan tahap pembayaran dan mengunggah bukti pembayaran. Admin akan melakukan verifikasi secepatnya.');
        if (!$buktiBayar && $pendaftaran->status === 'Menunggu') {
            return back()->with('warn', 'Silakan menyelesaikan tahap pembayaran dan mengunggah bukti pembayaran. Admin akan melakukan verifikasi secepatnya.');
        } elseif ($buktiBayar && $pendaftaran->status === 'Menunggu') {
            return back()->with('warn', 'Admin akan melakukan verifikasi pembayaran secepatnya.');
        }

        $batch = BatchPPDB::findOrFail($pendaftaran->batch_id);
        $syaratDokumen = SyaratDokumen::where('batch_id', $batch->id)->with('tipeDokumen')->orderBy('id', 'desc')->get(); // Sesuaikan dengan BatchPPDBController
        $dokumenPersyaratan = DokumenPersyaratan::where('anak_id', optional($pendaftaran->infoAnak)->id)->get();

        return view('pendaftar.dokumen', compact('syaratDokumen','dokumenPersyaratan'));
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

        $pendaftaran = Pendaftaran::where('user_id', $user->id)->with('user')->firstOrFail();

        $this->pendaftaranService->saveDokumenPersyaratan($request, $pendaftaran);

        return back()->with('success', 'Dokumen berhasil disimpan!');
    }
}
