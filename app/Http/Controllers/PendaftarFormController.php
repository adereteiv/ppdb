<?php

namespace App\Http\Controllers;

use App\Models\BuktiBayar;
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
        $buktiBayar = BuktiBayar::where('anak_id', $infoAnak->id)->exists();
        // flow, pay first
        // if (!$buktiBayar || $pendaftaran->status === 'Menunggu') return back()->with('warn', 'Silakan menyelesaikan tahap pembayaran dan mengunggah bukti pembayaran. Admin akan melakukan verifikasi secepatnya.');
        if (!$buktiBayar && $pendaftaran->status === 'Menunggu') {
            return back()->with('warn', 'Silakan menyelesaikan tahap pembayaran dan mengunggah bukti pembayaran. Admin akan melakukan verifikasi secepatnya.');
        } elseif ($buktiBayar && $pendaftaran->status === 'Menunggu') {
            return back()->with('warn', 'Admin akan melakukan verifikasi pembayaran secepatnya.');
        }

        $ayah = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'ayah')->first() : null;
        $ibu = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'ibu')->first() : null;
        $wali = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'wali')->first() : null;

        return view('pendaftar.formulir', compact('user','infoAnak', 'ayah', 'ibu', 'wali'));
    }

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
