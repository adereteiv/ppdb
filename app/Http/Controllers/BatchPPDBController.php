<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{BatchPPDB,SyaratDokumen,TipeDokumen};

class BatchPPDBController extends Controller
{
    /**
     * Display batch creation form
     */
    public function index() {
        $tahunAjaran = now()->year;
        $periodeNow = "$tahunAjaran/".($tahunAjaran+1);
        $periodeNext = ($tahunAjaran+1)."/".($tahunAjaran+2);
        $options = [$periodeNow, $periodeNext];

        $existingBatch = BatchPPDB::select('tahun_ajaran','gelombang')->orderBy('tahun_ajaran', 'desc')->orderBy('gelombang', 'desc')->get()->groupBy('tahun_ajaran');

        $gelombang = [];
        foreach ($options as $periode) {
            if (isset($existingBatch[$periode])) {
                $periodeAjaran = $existingBatch[$periode];
                $latestGelombang = $periodeAjaran->first()->gelombang;
                $gelombang[$periode] = $latestGelombang + 1;
            } else {
                $gelombang[$periode] = 1;
            }
        }

        $tipeDokumen = TipeDokumen::with('syaratDokumen')
        ->orderBy('id', 'desc') // sesuaikan value desc/asc untuk tampil ke admin.ppdb-buat
        ->get()
        ->values();

        return view('admin.ppdb-buat', compact('options', 'existingBatch', 'tipeDokumen', 'gelombang'));
    }

    /**
     * Stores newly created batch, watch out for BatchPPDB model and Commands/RegulateBatchPPDBStatus
     */
    public function store(Request $request) {
        $existingBatch = BatchPPDB::where('tahun_ajaran', $request->tahun_ajaran)->where('gelombang', $request->gelombang)->exists();
        if ($existingBatch) {
            return back()->with('gelombangAda', 'Gelombang pendaftaran ini sudah ada.')->withInput();
        }

        $rules = [
            'tahun_ajaran'  => 'required|string',
            'gelombang'     => 'required|integer|min:1',
            'waktu_mulai'   => 'required|date|after_or_equal:today',
            'waktu_tenggat' => [
                'required','date',
                'after:waktu_mulai',
                'after_or_equal:' . now()->addMonth(),
                'before_or_equal:' . now()->addMonths(4),
            ],
            'waktu_tutup'   => 'required|date|after_or_equal:waktu_tenggat',
        ];

        $nameMapping = [];
        foreach ($request->input('include',[]) as $index => $tipeDokumenId) {
            $rules["include.$index"]    = 'required|exists:tipe_dokumen,id';
            $rules["keterangan.$index"] = 'nullable|string|max:255';
            $rules["is_wajib.$index"]   = 'boolean';
            $nameMapping[$index] = $tipeDokumenId;
        };

        $messages = [
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'gelombang.required' => 'Gelombang wajib diisi.',
            'waktu_mulai.required' => 'Tanggal mulai wajib diisi.',
            'waktu_tenggat.required' => 'Tanggal tenggat wajib diisi.',
            'waktu_tutup.required' => 'Tanggal tutup wajib diisi.',
            'waktu_mulai.after_or_equal' => 'Tanggal mulai harus hari ini atau lebih.',
            'waktu_tenggat.after' => 'Tanggal tenggat harus setelah tanggal mulai.',
            'waktu_tenggat.after_or_equal' => 'Tanggal tenggat minimal 1 bulan setelah waktu mulai.',
            'waktu_tenggat.before_or_equal' => 'Tanggal tenggat maksimal 4 bulan setelah waktu mulai.',
            'waktu_tutup.after_or_equal' => 'Tanggal tutup harus setelah atau sama dengan waktu tenggat.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $batch = BatchPPDB::create([
            'tahun_ajaran' => $validatedData['tahun_ajaran'],
            'gelombang' => $validatedData['gelombang'],
            'waktu_mulai' => $validatedData['waktu_mulai'],
            'waktu_tenggat' => $validatedData['waktu_tenggat'],
            'waktu_tutup' => $validatedData['waktu_tutup'],
            //status is set via @boot
        ]);

        foreach ($nameMapping as $index => $tipeDokumenId) {
            SyaratDokumen::create([
                'batch_id'          => $batch->id,
                'tipe_dokumen_id'   => $tipeDokumenId,
                'is_wajib'          => $validatedData['is_wajib'][$index] ?? false,
                'keterangan'        => $validatedData['keterangan'][$index] ?? null,
            ]);
        }

        $alertMessage = 'Periode PPDB berhasil dibuat!';
        if ($batch->status) {
            return redirect()->route('admin.ppdb.aktif.index')->with('success', $alertMessage );
        } else {
            return redirect()->route('admin.ppdb.index')->with('success', $alertMessage);
        }
    }
}
