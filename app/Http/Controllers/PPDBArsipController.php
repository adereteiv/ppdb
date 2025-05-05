<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\BuktiBayar;
use App\Models\Pendaftaran;
use App\Models\OrangTuaWali;
use Illuminate\Http\Request;
use App\Models\SyaratDokumen;
use App\Models\DokumenPersyaratan;

class PPDBArsipController extends Controller
{
    private function getArsipKey() {
        $key = request()->cookie('arsip_key');

        if (!$key || !preg_match('/Periode (.+) - Gel\. (\d+)/', $key, $matches)) {
            return null;
        }
        $tahunAjaran = $matches[1];
        $gelombang = (int) $matches[2];

        return BatchPPDB::where('tahun_ajaran', $tahunAjaran)
            ->where('gelombang', $gelombang)
            ->where('status', false)
            ->first();
    }

    private function getData($key = null)
    {
        $batch = $this->getArsipKey();
        $pendaftaran = $batch // for sorting
            ? Pendaftaran::where('batch_id', $batch->id) // query builder instance
                ->leftJoin('info_anak', 'pendaftaran.id', '=', 'info_anak.pendaftaran_id') // join table, include related data, eager load infoAnak
                ->select('pendaftaran.*') // link it to Pendaftaran model
            : collect(); //looped
        $syaratDokumen = $batch
            ? SyaratDokumen::where('batch_id', $batch->id)->with('tipeDokumen')->orderBy('id', 'desc')->get()
            : collect(); //looped
        $data = compact(['batch', 'pendaftaran', 'syaratDokumen']);
        return $key ? ($data[$key] ?? null) : $data ;
    }

    public function passData(Request $request)
    {
        $batch = $this->getData('batch');
        if (!$batch) {return response(404);}

        $query = $this->getData('pendaftaran');

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $allowedSorts = ['created_at', 'id', 'nama_anak', 'status'];
        $sort = $request->input('sort', 'created_at');
        $sort = in_array($sort, $allowedSorts) ? $sort : 'created_at';

        $order = $request->input('order', 'desc');
        $order = in_array($order, ['asc', 'desc']) ? $order : 'desc';

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('pendaftaran.id', 'LIKE', "%{$search}%")
                  ->orWhereHas('infoAnak', function ($q) use ($search) {
                      $q->where('nama_anak', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($sort === 'status') {
            $statusOrder = $order === 'desc'
                ? ['Belum Lengkap', 'Lengkap', 'Terverifikasi']
                : ['Terverifikasi', 'Lengkap', 'Belum Lengkap'];
            $query->orderByRaw("FIELD(status, '" . implode("','", $statusOrder) . "')");
        } elseif ($sort === 'nama_anak') {
            $query->orderBy('info_anak.nama_anak', $order)->select('pendaftaran.*');
        } else {
            $query->orderBy($sort, $order);
        }

        $data = $query->paginate($perPage)->appends($request->all());

        return response()->json([ // Server-side render
            'html' => view('admin.ppdb-arsip', compact('data'))->render(),
			'pagination' => $data->links('components.my-pagination')->render(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.ppdb-rekam', ['batch' => $this->getData('batch')]);
    }

    public function showRincian()
    {
        return view('admin.ppdb-rincian', ['batch' => $this->getData('batch')]);
    }

    private function getEntry($id, $view)
    {
        $syaratDokumen = $this->getData('syaratDokumen');
        $pendaftaran = $this->getData('pendaftaran')->findOrFail($id);
        $infoAnak = $pendaftaran->infoAnak;

        /*
        $orangTuaWali = collect();
        $dokumenPersyaratan = collect();
        $buktiBayar = null;

        if ($infoAnak) {
            $orangTuaWali = OrangTuaWali::where('anak_id', $infoAnak->id)->get();
            $dokumenPersyaratan = DokumenPersyaratan::where('anak_id', $infoAnak->id)->get();
            $buktiBayar = BuktiBayar::where('anak_id', $infoAnak->id)->first();
        }
        */

        $orangTuaWali = $infoAnak
            ? OrangTuaWali::where('anak_id', $infoAnak->id)->get()
            : collect();
        $ayah = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'ayah')->first() : null;
        $ibu = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'ibu')->first() : null;
        $wali = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'wali')->first() : null;

        $dokumenPersyaratan = $infoAnak
            ? DokumenPersyaratan::where('anak_id', $infoAnak->id)->get()
            : collect();
        $buktiBayar = $infoAnak
            ? BuktiBayar::where('anak_id', $infoAnak->id)->first()
            : null;

        return view($view, compact( 'syaratDokumen', 'pendaftaran', 'infoAnak', 'orangTuaWali', 'ayah', 'ibu', 'wali', 'dokumenPersyaratan', 'buktiBayar'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->getEntry($id, 'admin.ppdb-profil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $batch = $this->getData('batch');
        if ($batch) {
            $batch->delete(); // allow skip to enable status change, residue from pendaftaran delete but works just okay
        }

        return redirect()->route('ppdb.')->with('success', 'Data berhasil dihapus.');
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
