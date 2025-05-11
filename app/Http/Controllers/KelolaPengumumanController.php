<?php

namespace App\Http\Controllers;

use App\Exports\MaatExport;
use App\Models\Pengumuman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\DataTableService;
use Mews\Purifier\Facades\Purifier;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KelolaPengumumanController extends Controller
{
    public function passData(Request $request)
    {
        $dataTable = new DataTableService;
        $data = $dataTable->initDataTable(
            $request,
            Pengumuman::with('user'),
            ['jadwal_posting'],
            function($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'LIKE', "%{$search}%")
                      ->orWhere('keterangan', 'LIKE', "%{$search}%");
                });
            },
            function($query, $sort, $order) {
                $query->orderBy($sort, $order);
            }
        );

        return response()->json([ // Server-side render
            'html' => view('admin.pengumuman-list', compact('data'))->render(),
			'pagination' => $data->links('components.my-pagination')->render(),
        ]);
    }

    public function index()
    {
        return view('admin.pengumuman');
    }

    public function show(string $id)
    {
        $pengumuman = Pengumuman::where('id', $id)->with('user')->first();
        return view('admin.pengumuman-rincian', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman-buat');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_pengumuman' => 'required|in:Umum,Khusus Pendaftar',
            'judul' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'jadwal_posting' => 'nullable|date|after_or_equal:today',
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:1024',
        ],[
            'tipe_pengumuman.required' => 'Tipe pengumuman wajib dipilih.',
            'judul.required' => 'Judul wajib diisi untuk membuat pengumuman',
            'keterangan.required' => 'Keterangan pengumuman wajib diisi',
        ]);
        $judul = trim(strip_tags($request->input('judul')));
        $keterangan = Purifier::clean($request->input('keterangan'));
        $jadwalPosting = $request->input('jadwal_posting');

        $paths = [];
        // $filePath = null;
        if ($request->hasFile('lampiran')) {
            $files = $request->file('lampiran');

            foreach ($files as $file) {
                $slug = Str::slug($judul);
                $date = $jadwalPosting ? Carbon::parse($jadwalPosting)->format('Ymd_His') : now()->format('Ymd_His');
                $fileName = "lampiran-{$slug}-{$date}-" . uniqid() . '.' . $file->getClientOriginalExtension();
                $paths[] = $file->storeAs('lampiran', $fileName, 'public');
            }
            // $judulSlug = Str::slug($judul);
            // $dateSlug = $jadwalPosting ? Carbon::parse($jadwalPosting)->format('Ymd_His') : now()->format('Ymd_His');

            // $fileName = "lampiran-{$judulSlug}-{$dateSlug}." . $files->getClientOriginalExtension();
            // $filePath = $files->storeAs('lampiran', $fileName, 'public');
            // dd($filePath);
        }

        Pengumuman::create([
            'posted_by' => auth()->id(),
            'tipe_pengumuman' => $request->tipe_pengumuman,
            'judul' => $judul,
            'keterangan' => $keterangan,
            // 'file_path' => $filePath,
            'file_paths' => $paths,
            'jadwal_posting' => $jadwalPosting ?? now(),
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', "Berhasil membuat pengumuman");
    }

    public function destroy(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        if ($pengumuman) {$pengumuman->delete();}

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $data = Pengumuman::with('user')->latest()->get()->map(function($r) {
            return[
                'judul' => $r->judul,
                'keterangan' => $r->keterangan,
                'jadwal_posting' => $r->jadwal_posting->translatedFormat('d F Y'),
                'tujuan' => $r->tipe_pengumuman,
                'direktori_penyimpanan' => $r->file_paths
                    ? implode(PHP_EOL, $r->file_paths ?? [])
                    : '—',
            ];
        });
        $headings = ['Judul', 'Keterangan', 'Jadwal Posting', 'Tujuan', 'Direktori Penyimpanan'];
        $range = 'A1:E1';
        $widths = ['A' => 25, 'B' => 50, 'C' => 25, 'D' => 20, 'E' => 50];
        $formats = ['C' => NumberFormat::FORMAT_DATE_DDMMYYYY];

        return Excel::download(new MaatExport($data, $range, $headings, $widths, $formats), 'daftar-pengumuman.xlsx');
    }
}
