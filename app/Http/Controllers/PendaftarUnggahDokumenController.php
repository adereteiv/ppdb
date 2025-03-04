<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SyaratDokumen;
use App\Models\DokumenPersyaratan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftarUnggahDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->firstOrFail();;
        $batch = BatchPPDB::findOrFail($pendaftaran->batch_id);
        $syaratDokumen = SyaratDokumen::where('batch_id', $batch->id)->with('tipeDokumen')->get();
        $dokumenPersyaratan = DokumenPersyaratan::where('anak_id', $pendaftaran->infoAnak->id)->get();

        return view('pendaftar.dokumen', compact('syaratDokumen','dokumenPersyaratan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->firstOrFail();
        $anakId = $pendaftaran->infoAnak->id;
        $syaratDokumen = SyaratDokumen::where('batch_id', $pendaftaran->batch_id)->get();

        $nameMapping = [];
        foreach ($syaratDokumen as $syarat) {
            $nameFormat = Str::slug($syarat->tipeDokumen->tipe, '_');
            $nameMapping[$nameFormat] = $syarat->tipe_dokumen_id;
        };

        $rules = [];
        foreach ($nameMapping as $nameFormat => $tipeDokumenId) {
            $inputName = "dokumen.{$nameFormat}";

            $existingDokumen = DokumenPersyaratan::where([
                'anak_id' => $anakId,
                'tipe_dokumen_id' => $tipeDokumenId
            ])->exists();

            if (!$existingDokumen && $syaratDokumen->where('tipe_dokumen_id', $tipeDokumenId)->first()->is_wajib) {
                $rules[$inputName] = 'required|file|mimes:jpg,jpeg,png,pdf|max:1024';
            } elseif ($request->hasFile($inputName)) {
                $rules[$inputName] = 'file|mimes:jpg,jpeg,png,pdf|max:1024';
            }
        }

        $filterDokumen = SyaratDokumen::where('batch_id', $pendaftaran->batch_id)->pluck('tipe_dokumen_id')->toArray();

        $request->validate( $rules, [
            'dokumen.*.required' => 'Dokumen ini wajib diunggah.',
            'dokumen.*.mimes' => 'Format file tidak valid. Hanya JPG, JPEG, PNG, dan PDF yang diperbolehkan.',
            'dokumen.*.max' => 'Ukuran file maksimal 1MB.',
        ]);

        foreach ($request->file('dokumen', []) as $nameFormat => $file) {
            if(!isset($nameMapping[$nameFormat])) {continue;};

            $tipeDokumenId = $nameMapping[$nameFormat];

            if (!in_array($tipeDokumenId, $filterDokumen)) {
                abort(403, 'Kan error, silakan ikuti alur normalnya ya ;D');
            }

            $syarat = SyaratDokumen::where('tipe_dokumen_id', $tipeDokumenId)->first();
            $namaDokumen  = str_replace(' ', '_', strtolower($syarat->tipeDokumen->tipe));
            $fileName = $user->id . '_'. $namaDokumen . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('dokumen_persyaratan', $fileName, 'public');

            $existingDokumen = DokumenPersyaratan::where([
                'anak_id' => $anakId,
                'tipe_dokumen_id' => $tipeDokumenId
            ])->first();

            /* Hapus before update */
            // Kalau sudah production do adjust the storage
            if ($existingDokumen) {
                Storage::disk('public')->delete($existingDokumen->file_path);
            }

            DokumenPersyaratan::updateOrCreate(
                ['anak_id' => $anakId, 'tipe_dokumen_id' => $tipeDokumenId],
                ['file_path' => $filePath]
            );
        }

        return redirect()->back()->with('success', 'Dokumen berhasil disimpan!');
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
