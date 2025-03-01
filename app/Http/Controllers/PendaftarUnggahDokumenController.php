<?php

namespace App\Http\Controllers;

use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarUnggahDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();
        $infoAnak = $pendaftaran ? InfoAnak::where('pendaftaran_id', $pendaftaran->id)->first() : null;

        return view('pendaftar.dokumen', compact('user','infoAnak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();

        $pendaftaran = Pendaftaran::updateOrCreate(
            ['user_id' => $user->id],
            ['batch_id' => Pendaftaran::where('user_id', $user->id)->value('batch_id') ?? $activeBatch->id]
        );
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
