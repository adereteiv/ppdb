<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Models\SyaratDokumen;

class PPDBArsipController extends Controller
{
    private function getData($key = null)
    {
        $batch = session('akses_arsip');
        $pendaftaran = Pendaftaran::where('batch_id', $batch->id)->with('infoAnak', 'user')->orderBy('created_at', 'desc')->get();
        $syaratDokumen = SyaratDokumen::where('batch_id', $batch->id)->with('tipeDokumen')->orderBy('id', 'desc')->get(); // Sesuaikan dengan BatchPPDBController

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
            $query->orderBy('info_anak.nama_anak', $order);
        } else {
            $query->orderBy($sort, $order);
        }

        $data = $query->paginate($perPage)->appends($request->all());

        return response()->json([ // Server-side render
            'html' => view('admin.ppdb-arsip', compact('data'))->render(),
			'pagination' => $data->links('components.my-pagination')->render(),
            // 'pagination' => [
            //     'total' => $data->total(),
            //     'per_page' => $data->perPage(),
            //     'current_page' => $data->currentPage(),
            //     'last_page' => $data->lastPage(),
            //     'from' => $data->firstItem(),
	        //     'to' => $data->lastItem(),
            //     'next_page' => $data->nextPageUrl(),
            //     'prev_page' => $data->previousPageUrl(),
            // ],
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.ppdb-rekam', ['batch' => $this->getData('batch')]);
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
        return view('admin.ppdb-rincian', ['batch' => $this->getData('batch')]);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
