<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BatchPPDB;
use App\Models\BuktiBayar;
use App\Models\Pendaftaran;
use App\Models\OrangTuaWali;
use App\Models\SyaratDokumen;
use App\Models\DokumenPersyaratan;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PPDBAktifController extends Controller
{
    protected $pendaftaranService;

    public function __construct(PendaftaranService $pendaftaranService)
    {
        $this->pendaftaranService = $pendaftaranService;
    }

    private function getData($key = null)
    {
        $batch = BatchPPDB::where('status', true)->firstOrFail();
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

    /**
     * Pass queried data as an ajax response.
     */
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

        // update each $pendaftaran
        foreach ($data as $pendaftaran) {
            $this->pendaftaranService->checkStatusPendaftaran($pendaftaran);
        }

        return response()->json([ // Server-side render
            'html' => view('admin.ppdb-aktif', compact('data'))->render(),
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

    public function tutupPPDB()
    {
        $batch = $this->getData('batch');
        $batch->update([ 'waktu_tutup' => now(), 'status' => false]);

        return redirect('/admin/ppdb/')->with('success', 'Gelombang PPDB berhasil ditutup');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $batch = $this->getData('batch');
        $syaratDokumen = $this->getData('syaratDokumen');
        return view('admin.form-tambah-pendaftaran', compact('batch', 'syaratDokumen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $batch = $this->getData('batch');

        $existingEmail = User::where('email', $request->email)->where('role_id', 2)->count();
        if ($existingEmail >= 2) {
            return back()->with('akunAda', 'Maksimal 2 pendaftaran anak per email. Silakan gunakan email lain.')->withInput();
        };

        $existingUser = User::where('email', $request->email)->where('name', $request->nama_anak)->first();
        if ($existingUser) {
            return back()->with('akunAda' , 'Anak dengan email ini sudah terdaftar.')->withInput();
        }

        $request->validate(
            [
                'nama_anak'         => 'required|string|max:255|regex:/^[a-zA-Z-\s]+$/',
                'email'             => ['required','email:rfc,dns,spoof,strict,indisposable','regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|edu|id|gov|co\.id)$/i',],
                'password'          => 'required|confirmed|min:8|max:255',
            ],
            [
                'email.email'                   => 'Mohon masukkan format email yang benar.',
                'email.regex'                   => 'Hanya domain .com, .edu, .id, .gov, atau .co.id yang diperbolehkan.',
                'email.indisposable'            => 'Harap masukkan alamat email Anda yang sebenarnya.',
                'password.confirmed'            => 'Kata sandi tidak cocok.',
            ]
        );

        $user = User::create([
            'name' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('nama_anak'))))),
            'email' => strtolower(trim($request->input('email'))),
            'password' => Hash::make($request->password),
        ]);

        $pendaftaran = Pendaftaran::create([
            'user_id' => $user->id,
            'batch_id' => $batch->id,
        ]);

        $this->pendaftaranService->saveFormulir($request, $pendaftaran);
        $this->pendaftaranService->saveDokumenPersyaratan($request, $pendaftaran);
        $this->pendaftaranService->saveBuktiBayar($request, $pendaftaran);
        $this->pendaftaranService->checkStatusPendaftaran($pendaftaran);

        return redirect('/admin/ppdb/aktif/')->with('success', 'Rekam pendaftaran baru berhasil dibuat');
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->getEntry($id, 'admin.form-edit-pendaftaran');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pendaftaran = $this->getData('pendaftaran')->with('user')->findOrFail($id);
        $this->pendaftaranService->saveFormulir($request, $pendaftaran);
        $this->pendaftaranService->saveDokumenPersyaratan($request, $pendaftaran);
        $this->pendaftaranService->saveBuktiBayar($request, $pendaftaran);

        return back()->with('success', 'Formulir berhasil disimpan.');
    }

    public function patch(Request $request, string $id)
    {
        $pendaftaran = $this->getData('pendaftaran')->with('user')->findOrFail($id);

        $request->validate([
            'status' => 'nullable|string|in:Lengkap,Terverifikasi',
            'catatan_admin' => 'nullable|string|max:255',
        ], [
            'catatan_admin.max' => 'Melebihi batas maksimal 255 karakter.',
        ]);

        $data = [];
        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }
        $data['catatan_admin'] = $request->catatan_admin;
        $pendaftaran->update($data);
        // return back();
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pendaftaran = $this->getData('pendaftaran')->findOrFail($id);

        if ($pendaftaran) {
            $pendaftaran->infoAnak?->delete(); // allow skip to enable status change, residue from pendaftaran delete but works just okay
        }

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
