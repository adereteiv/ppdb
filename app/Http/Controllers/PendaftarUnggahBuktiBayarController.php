<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\BuktiBayar;
use App\Models\Pendaftaran;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarUnggahBuktiBayarController extends Controller
{
    /**
     * Moved BuktiBayar saving to PendaftaranService
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
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->firstOrFail();
        $buktiBayar = BuktiBayar::where('anak_id', optional($pendaftaran->infoAnak)->id)->first();

        return view('pendaftar.buktibayar', compact('pendaftaran', 'buktiBayar'));
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

        $this->pendaftaranService->saveBuktiBayar($request, $pendaftaran);

        return back()->with('success', 'Bukti Pembayaran berhasil disimpan!');
    }
}
