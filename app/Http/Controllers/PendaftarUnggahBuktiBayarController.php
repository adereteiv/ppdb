<?php

namespace App\Http\Controllers;

use App\Models\BuktiBayar;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftarUnggahBuktiBayarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->firstOrFail();
        $buktiBayar = BuktiBayar::where('anak_id', $pendaftaran->infoAnak->id)->first();

        return view('pendaftar.buktibayar', compact('buktiBayar'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->firstOrFail();

        if ($pendaftaran->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $anakId = $pendaftaran->infoAnak->id;

        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:1024',
        ], [
            'bukti_bayar.required' => 'Anda wajib mengunggah bukti pembayaran.',
            'bukti_bayar.mimes' => 'Format file tidak valid. Hanya JPG, JPEG, PNG, dan PDF diperbolehkan.',
            'bukti_bayar.max' => 'Ukuran file maksimal 1MB.',
        ]);

        $file = $request->file('bukti_bayar');
        $fileName = $user->id . '_bukti_bayar_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('bukti_bayar', $fileName, 'public');

        $buktiBayar = BuktiBayar::firstOrNew(['anak_id' => $anakId,]);
        // $existingBuktiBayar = BuktiBayar::where(['anak_id' => $anakId,])->first();

        if($buktiBayar->file_path) {
            Storage::disk('public')->delete($buktiBayar->file_path);
        };

        // dd($request->all());

        // BuktiBayar::updateOrCreate(
        //     ['anak_id' => $anakId],
        //     ['file_path' => $filePath],
        // );
        $buktiBayar->file_path = $filePath;
        $buktiBayar->save();

        return redirect()->back()->with('success', 'Bukti Pembayaran berhasil disimpan!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
