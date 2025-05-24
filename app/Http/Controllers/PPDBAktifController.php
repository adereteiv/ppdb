<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User,BatchPPDB,BuktiBayar,Pendaftaran,OrangTuaWali,SyaratDokumen,DokumenPersyaratan};
use App\Services\DataTableService;
use App\Services\PendaftaranService;
use App\Exports\MaatExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PPDBAktifController extends Controller
{
    /**
     * Enabling PendaftaranService to be used throughout this controller.
     * @param \App\Services\PendaftaranService $pendaftaranService
     */
    protected $pendaftaranService;
    public function __construct(PendaftaranService $pendaftaranService)
    {
        $this->pendaftaranService = $pendaftaranService;
    }

    /**
     * Centralized data getter.
     * @param mixed $key
     */
    private function getData($key = null)
    {
        $batch = BatchPPDB::where('status', true)->firstOrFail();
        $pendaftaran = $batch // for sorting
            ? Pendaftaran::where('batch_id', $batch->id) // query builder instance
                ->with('infoAnak') // link it to infoAnak
            : collect(); //looped
        $syaratDokumen = $batch
            ? SyaratDokumen::where('batch_id', $batch->id)->with('tipeDokumen')->orderBy('id', 'desc')->get()
            : collect(); //looped
        $data = compact(['batch', 'pendaftaran', 'syaratDokumen']);
        return $key ? ($data[$key] ?? null) : $data ;
    }

    /**
     * Pass queried data as an ajax response, uses DataTableService.
     */
    public function passData(Request $request)
    {
        $batch = $this->getData('batch');
        if (!$batch) {return response(404);}

        $dataTable = new DataTableService;
        $data = $dataTable->initDataTable(
            $request,
            $this->getData('pendaftaran'),
            ['created_at', 'id', 'nama_anak', 'status'],
            function($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('pendaftaran.id', 'LIKE', "%{$search}%")
                      ->orWhereHas('infoAnak', function ($q) use ($search) {
                          $q->where('nama_anak', 'LIKE', "%{$search}%");
                      });
                });
            },
            function($query, $sort, $order) {
                switch($sort){
                    case 'status':
                        $statusOrder = $order === 'desc'
                            ? ['Menunggu', 'Mengisi', 'Lengkap', 'Terverifikasi']
                            : ['Terverifikasi', 'Lengkap', 'Mengisi', 'Menunggu'];
                        $query->orderByRaw("FIELD(status, '" . implode("','", $statusOrder) . "')");
                        break;
                    case 'nama_anak':
                        $query->leftJoin('info_anak', 'pendaftaran.id', '=', 'info_anak.pendaftaran_id') // join table, include related data, eager load infoAnak
                            ->orderBy('info_anak.nama_anak', $order)
                            ->select('pendaftaran.*');
                        break;
                    default:
                        $query->orderBy($sort, $order);
                        break;
                }
            }
        );

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
    public function index(){return view('admin.ppdb-rekam', ['batch' => $this->getData('batch')]);}

    /**
     * Display batch detail.
     */
    public function showRincian(){return view('admin.ppdb-rincian', ['batch' => $this->getData('batch')]);}

    /**
     * Close active admission batch.
     */
    public function tutupPPDB()
    {
        $batch = $this->getData('batch');
        $batch->update([ 'waktu_tutup' => now(), 'status' => false]);

        return redirect()->route('admin.ppdb.index')->with('success', 'Gelombang PPDB berhasil ditutup');
    }

    /**
     * Show the form for creating a new `pendaftaran`.
     */
    public function create()
    {
        $batch = $this->getData('batch');
        $syaratDokumen = $this->getData('syaratDokumen');
        return view('admin.form-tambah-pendaftaran', compact('batch', 'syaratDokumen'));
    }

    /**
     * Store newly created pendaftaran.
     */
    public function store(Request $request)
    {
        $batch = $this->getData('batch');

        // Existing email check, prevents duplicate records
        if ($request->filled('email')) {
            $existingEmail = User::where('email', $request->email)->where('role_id', 2)->count();
            if ($existingEmail >= 2) {
                return back()
                    ->with('akunAda', 'Email telah digunakan dalam dua pendaftaran. Silakan masukkan email lain.')
                    ->withInput();
            }
        }

        // Existing user check, determined by matching 'name' field, 'name' - 'email' pair, or 'name' - 'nomor-hp' pair
        $existingUser = User::where('name', $request->nama_anak)
            ->where(function ($query) use ($request) {
                $query->where('email', $request->email)
                    ->orWhere('nomor_hp', $request->nomor_hp);
            })->first();
        if ($existingUser) {
            return back()
            ->with('akunAda', 'Anak dengan data ini sudah terdaftar. Silakan gunakan email atau nomor HP yang berbeda.')
            ->withInput();
        }

        $user = $this->pendaftaranService->saveAkun($request);
        $pendaftaran = $this->pendaftaranService->savePendaftaran($user->id, $batch->id);

        $this->pendaftaranService->saveFormulir($request, $pendaftaran);
        $this->pendaftaranService->saveDokumenPersyaratan($request, $pendaftaran);
        $this->pendaftaranService->saveBuktiBayar($request, $pendaftaran);
        $pendaftaran->update(['status' => 'Lengkap']);

        return redirect()->route('admin.ppdb.aktif.index')->with('success', 'Rekam pendaftaran baru berhasil dibuat');
    }

    /**
     * Centralized entry fetching.
     * @param mixed $id
     * @param mixed $view
     * @return \Illuminate\Contracts\View\Factory
     */
    private function getEntry($id, $view)
    {
        $syaratDokumen = $this->getData('syaratDokumen');
        $pendaftaran = $this->getData('pendaftaran')->findOrFail($id);
        $infoAnak = $pendaftaran->infoAnak;

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
        $this->pendaftaranService->checkStatusPendaftaran($pendaftaran);

        return view($view, compact( 'syaratDokumen', 'pendaftaran', 'infoAnak', 'orangTuaWali', 'ayah', 'ibu', 'wali', 'dokumenPersyaratan', 'buktiBayar'));
    }

    /**
     * Display the detail of a selected `pendaftaran` entry.
     */
    public function show(string $id){return $this->getEntry($id, 'admin.ppdb-profil');}

    /**
     * Show the form for editing `pendaftaran` from the selected entry.
     */
    public function edit(string $id){return $this->getEntry($id, 'admin.form-edit-pendaftaran');}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pendaftaran = $this->getData('pendaftaran')->with('user')->findOrFail($id);
        $this->pendaftaranService->saveFormulir($request, $pendaftaran);
        $this->pendaftaranService->saveDokumenPersyaratan($request, $pendaftaran);
        $this->pendaftaranService->saveBuktiBayar($request, $pendaftaran);

        $this->pendaftaranService->checkStatusPendaftaran($pendaftaran);
        // refresh for the view to immediately use the updated $pendaftaran->status
        $pendaftaran->refresh();

        return back()->with('success', 'Formulir berhasil disimpan.');
    }

    /**
     * Allow editing catatan_admin and status without form submitting.
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function patch(Request $request, string $id)
    {
        $pendaftaran = $this->getData('pendaftaran')->with('user')->findOrFail($id);

        $request->validate([
            'status' => 'nullable|string|in:Menunggu,Mengisi,Lengkap,Terverifikasi',
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

        return response()->json(['data' => $data]);
    }

    /**
     * Remove `pendaftaran` entry.
     * and also run this DB query, check for `dangling` users records
     * SELECT * FROM users WHERE role_id = 2 AND NOT EXISTS (SELECT 1 FROM pendaftaran WHERE pendaftaran.user_id = users.id);
     */
    public function destroy(string $id)
    {
        $pendaftaran = $this->getData('pendaftaran')->findOrFail($id);

        if ($pendaftaran) {
            $pendaftaran->delete();
        }

        return back()->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Export the data, based on defined headers as stated below.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        $batch = $this->getData('batch');
        $tahunAjaranRaw = explode('/', $batch->tahun_ajaran);
        $tahunAjaran = implode('', array_map(fn($t) => substr($t, 2), $tahunAjaranRaw));

        $gelombang = $batch->gelombang;
        $prefix = $tahunAjaran . $gelombang;

        $data = $this->getData('pendaftaran')->get()->map(function($p) {
            return[
                'id_pendaftaran'        => $p->id,
                'status_pendaftaran'    => $p->status,
                'tanggal_mendaftar'     => $p->created_at->translatedFormat('d F Y'),
                'nama_anak'             => $p->infoAnak->nama_anak,
                'tempat_lahir'          => $p->infoAnak->tempat_lahir,
                'tanggal_lahir'         => $p->infoAnak->tanggal_lahir,
                'alamat'                => $p->infoAnak->alamat_anak,
                'jenis_kelamin'         => $p->infoAnak->jenis_kelamin,
                'kewarganegaraan'       => $p->infoAnak->kewarganegaraan,
                'agama'                 => $p->infoAnak->agama,
                'status_tinggal'        => $p->infoAnak->status_tinggal,
                'yang_mendaftarkan'     => $p->infoAnak->yang_mendaftarkan,
                'status_anak'           => $p->infoAnak->status_anak,
                'bahasa_di_rumah'       => $p->infoAnak->bahasa_di_rumah,
                'anak_ke'               => $p->infoAnak->anak_ke,
                'saudara_kandung'       => $p->infoAnak->saudara_kandung,
                'saudara_tiri'          => $p->infoAnak->saudara_tiri ?? '—',
                'saudara_angkat'        => $p->infoAnak->saudara_angkat ?? '—',
                'berat_badan'           => $p->infoAnak->berat_badan,
                'tinggi_badan'          => $p->infoAnak->tinggi_badan,
                'golongan_darah'        => $p->infoAnak->golongan_darah,
                'riwayat_penyakit'      => $p->infoAnak->riwayat_penyakit ?? '—',
                'mendaftar_sebagai'     => $p->infoAnak->mendaftar_sebagai,
                'sekolah_lama'          => $p->infoAnak->sekolah_lama ?? '—',
                'tanggal_pindah'        => $p->infoAnak->tanggal_pindah ?? '—',
                'dari_kelompok'         => $p->infoAnak->dari_kelompok ?? '—',
                'ke_kelompok'           => $p->infoAnak->ke_kelompok ?? '—',

                'nama_ayah'             => $p->infoAnak->orangTuaWali('ayah')->nama ?? '—',
                'pendidikan_ayah'       => $p->infoAnak->orangTuaWali('ayah')->pendidikan ?? '—',
                'pekerjaan_ayah'        => $p->infoAnak->orangTuaWali('ayah')->pekerjaan ?? '—',
                'penghasilan_ayah'      => $p->infoAnak->orangTuaWali('ayah')->penghasilan ?? '—',
                'nomor_hp_ayah'         => $p->infoAnak->orangTuaWali('ayah')->nomor_hp ?? '—',

                'nama_ibu'              => $p->infoAnak->orangTuaWali('ibu')->nama ?? '—',
                'pendidikan_ibu'        => $p->infoAnak->orangTuaWali('ibu')->pendidikan ?? '—',
                'pekerjaan_ibu'         => $p->infoAnak->orangTuaWali('ibu')->pekerjaan ?? '—',
                'penghasilan_ibu'       => $p->infoAnak->orangTuaWali('ibu')->penghasilan ?? '—',
                'nomor_hp_ibu'          => $p->infoAnak->orangTuaWali('ibu')->nomor_hp ?? '—',

                'nama_wali'             => $p->infoAnak->orangTuaWali('wali')->nama ?? '—',
                'pendidikan_wali'       => $p->infoAnak->orangTuaWali('wali')->pendidikan ?? '—',
                'pekerjaan_wali'        => $p->infoAnak->orangTuaWali('wali')->pekerjaan ?? '—',
                'penghasilan_wali'      => $p->infoAnak->orangTuaWali('wali')->penghasilan ?? '—',
                'nomor_hp_wali'         => $p->infoAnak->orangTuaWali('wali')->nomor_hp ?? '—',
            ];
        });
        $headings = [
            'ID Pendaftaran', 'Status Pendaftaran', 'Tanggal Mendaftar', 'Nama Anak',
            'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'Jenis Kelamin', 'Kewarganegaraan',
            'Agama', 'Status Tinggal', 'Yang Mendaftarkan', 'Status Anak', 'Bahasa di Rumah',
            'Anak ke-', 'Saudara Kandung', 'Saudara Tiri', 'Saudara Angkat', 'Berat Badan', 'Tinggi Badan',
            'Gol. Darah', 'Riwayat Penyakit', 'Mendaftar Sebagai', 'Sekolah Lama', 'Tanggal Pindah', 'Dari Kelompok', 'Ke Kelompok',
            'Nama Ayah', 'Pendidikan Ayah', 'Pekerjaan Ayah', 'Penghasilan Ayah', 'No. HP Ayah',
            'Nama Ibu', 'Pendidikan Ibu', 'Pekerjaan Ibu', 'Penghasilan Ibu', 'No. HP Ibu',
            'Nama Wali', 'Pendidikan Wali', 'Pekerjaan Wali', 'Penghasilan Wali', 'No. HP Wali',
        ];
        $widths = [
            'A' => 15, 'B' => 15, 'C' => 20, 'D' => 20,
            'E' => 30, 'F' => 15, 'G' => 30, 'H' => 15, 'I' => 15,
            'J' => 20, 'K' => 10, 'L' => 15, 'M' => 15, 'N' => 15,
            'O' => 10, 'P' => 10, 'Q' => 10, 'R' => 10, 'S' => 10, 'T' => 10,
            'U' => 10, 'V' => 10, 'W' => 25, 'X' => 15, 'Y' => 20, 'Z' => 20, 'AA' => 15,
            'AB'=> 10, 'AC'=> 10, 'AD'=> 10, 'AE'=> 10, 'AF'=> 10,
            'AG'=> 10, 'AH'=> 10, 'AI'=> 10, 'AJ'=> 10, 'AK'=> 10,
            'AL'=> 10, 'AM'=> 10, 'AN'=> 10, 'AO'=> 10, 'AP'=> 10,
        ];
        $range = 'A1:AP1';
        $formats = [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Y' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];

        return Excel::download(new MaatExport($data, $range, $headings, $widths, $formats), 'ppdb_periode-gelombang_'."$prefix".'.xlsx');
    }
}
