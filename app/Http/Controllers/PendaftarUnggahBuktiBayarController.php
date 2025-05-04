<?php

namespace App\Http\Controllers;

use App\Models\BuktiBayar;
use App\Models\Pendaftaran;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftarUnggahBuktiBayarController extends Controller
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
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->firstOrFail();
        $buktiBayar = BuktiBayar::where('anak_id', optional($pendaftaran->infoAnak)->id)->first();

        return view('pendaftar.buktibayar', compact('buktiBayar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->with('user')->firstOrFail();

        // if ($pendaftaran->user_id !== $user->id) {
        //     abort(403, 'Unauthorized action.');
        // }

        $this->pendaftaranService->saveBuktiBayar($request, $pendaftaran);

        return back()->with('success', 'Bukti Pembayaran berhasil disimpan!');
    }
}
