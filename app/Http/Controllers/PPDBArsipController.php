<?php

namespace App\Http\Controllers;

use App\Models\BatchPPDB;
use App\Models\BuktiBayar;
use App\Models\Pendaftaran;
use App\Models\OrangTuaWali;
use App\Models\SyaratDokumen;
use App\Models\DokumenPersyaratan;
use App\Services\DataTableService;
use App\Exports\MaatExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

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
                ->with('infoAnak') // link it to infoAnak
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

        return redirect()->route('admin.ppdb.index')->with('success', 'Data berhasil dihapus.');
    }

    public function export()
    {
        $batch = $this->getData('batch');
        $tahunAjaranRaw = explode('/', $batch->tahun_ajaran);
        $tahunAjaran = implode('', array_map(fn($t) => substr($t, 2), $tahunAjaranRaw));

        $gelombang = $batch->gelombang;
        $prefix = $tahunAjaran . $gelombang;

        $data = $this->getData('pendaftaran')->get()->map(function($r) {
            return[
                'id_pendaftaran'        => $r->id,
                'status_pendaftaran'    => $r->status,
                'tanggal_mendaftar'     => $r->created_at->translatedFormat('d F Y'),
                'nama_anak'             => $r->infoAnak->nama_anak,
                'tempat_lahir'          => $r->infoAnak->tempat_lahir,
                'tanggal_lahir'         => $r->infoAnak->tanggal_lahir,
                'alamat'                => $r->infoAnak->alamat_anak,
                'jenis_kelamin'         => $r->infoAnak->jenis_kelamin,
                'kewarganegaraan'       => $r->infoAnak->kewarganegaraan,
                'agama'                 => $r->infoAnak->agama,
                'status_tinggal'        => $r->infoAnak->status_tinggal,
                'yang_mendaftarkan'     => $r->infoAnak->yang_mendaftarkan,
                'status_anak'           => $r->infoAnak->status_anak,
                'bahasa_di_rumah'       => $r->infoAnak->bahasa_di_rumah,
                'anak_ke'               => $r->infoAnak->anak_ke,
                'saudara_kandung'       => $r->infoAnak->saudara_kandung,
                'saudara_tiri'          => $r->infoAnak->saudara_tiri ?? '—',
                'saudara_angkat'        => $r->infoAnak->saudara_angkat ?? '—',
                'berat_badan'           => $r->infoAnak->berat_badan,
                'tinggi_badan'          => $r->infoAnak->tinggi_badan,
                'golongan_darah'        => $r->infoAnak->golongan_darah,
                'riwayat_penyakit'      => $r->infoAnak->riwayat_penyakit ?? '—',
                'mendaftar_sebagai'     => $r->infoAnak->mendaftar_sebagai,
                'sekolah_lama'          => $r->infoAnak->sekolah_lama ?? '—',
                'tanggal_pindah'        => $r->infoAnak->tanggal_pindah ?? '—',
                'dari_kelompok'         => $r->infoAnak->dari_kelompok ?? '—',
                'ke_kelompok'           => $r->infoAnak->ke_kelompok ?? '—',
            ];
        });
        $headings = [
            'ID Pendaftaran', 'Status Pendaftaran', 'Tanggal Mendaftar', 'Nama Anak',
            'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'Jenis Kelamin', 'Kewarganegaraan',
            'Agama', 'Status Tinggal', 'Yang Mendaftarkan', 'Status Anak', 'Bahasa di Rumah',
            'Anak ke-', 'Saudara Kandung', 'Saudara Tiri', 'Saudara Angkat', 'Berat Badan', 'Tinggi Badan',
            'Gol. Darah', 'Riwayat Penyakit', 'Mendaftar Sebagai', 'Sekolah Lama', 'Tanggal Pindah', 'Dari Kelompok', 'Ke Kelompok',
        ];
        $widths = [
            'A' => 15, 'B' => 15, 'C' => 20, 'D' => 20,
            'E' => 30, 'F' => 15, 'G' => 30, 'H' => 15, 'I' => 15,
            'J' => 20, 'K' => 10, 'L' => 15, 'M' => 15, 'N' => 15,
            'O' => 10, 'P' => 10, 'Q' => 10, 'R' => 10, 'S' => 10, 'T' => 10,
            'U' => 10, 'V' => 10, 'W' => 25, 'X' => 15, 'Y' => 20, 'Z' => 20, 'AA' => 15,
        ];
        $range = 'A1:AA1';
        $formats = [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Y' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];

        return Excel::download(new MaatExport($data, $range, $headings, $widths, $formats), 'ppdb_periode-gelombang_'."$prefix".'.xlsx');
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
