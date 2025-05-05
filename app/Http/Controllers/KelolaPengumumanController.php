<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Services\DataTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

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
                      ->or(function ($q) use ($search) {
                          $q->where('keterangan', 'LIKE', "%{$search}%");
                      });
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
        $entry = Pengumuman::where('id', $id);
        return view('admin.pengumuman-rincian', compact('entry'));
    }

    public function create()
    {
        return view('admin.pengumuman-buat');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'jadwal_posting' => 'nullable|date|after_or_equal:today',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:1024',
        ],[
            'judul.required' => 'Judul wajib diisi untuk membuat pengumuman',
            'keterangan.required' => 'Keterangan pengumuman wajib diisi',
        ]);

        $sanitize = [
            'judul' => trim(strip_tags($request->input('judul'))),
            'keterangan' => trim(strip_tags($request->input('keterangan'))),
        ];
        $jadwalPosting = $request->input('jadwal_posting');
        $filePath = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');

            $judulSlug = Str::slug($sanitize['judul']);
            $dateSlug = $jadwalPosting ? Carbon::parse($jadwalPosting)->format('Ymd_His') : now()->format('Ymd_His');

            $fileName = "lampiran-{$judulSlug}-{$dateSlug}." . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('lampiran', $fileName, 'public');
        }

        Pengumuman::create([
            'posted_by' => auth()->id(),
            'judul' => $sanitize['judul'],
            'keterangan' => $sanitize['keterangan'],
            'file_path' => $filePath,
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
}
