<?php

namespace App\Http\Controllers;

use App\Models\InfoAnak;
use App\Models\Pendaftaran;
use App\Models\OrangTuaWali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BatchPPDB;

class PendaftarFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();
        $infoAnak = $pendaftaran ? InfoAnak::where('pendaftaran_id', $pendaftaran->id)->first() : null;

        $ayah = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'ayah')->first() : null;
        $ibu = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'ibu')->first() : null;
        $wali = $infoAnak ? $infoAnak->orangTuaWali()->where('relasi', 'wali')->first() : null;

        return view('pendaftar.formulir', compact('user','infoAnak', 'ayah', 'ibu', 'wali'));
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

    public function update(Request $request)
    {
        $user = Auth::user();
        $activeBatch = BatchPPDB::where('status', true)->latest()->first();

        $pendaftaran = Pendaftaran::updateOrCreate(
            ['user_id' => $user->id],
            ['batch_id' => Pendaftaran::where('user_id', $user->id)->value('batch_id') ?? $activeBatch->id]
        );

        $rules = [
            'nama_anak'         =>  'required|string|max:255',
            'panggilan_anak'    =>  'required|string|max:255',
            'jenis_kelamin'     =>  'required|in:Perempuan,Laki-Laki',
            'tempat_lahir'      =>  'required|string',
            'tanggal_lahir'     =>  [
                                    'required','date',
                                    'before_or_equal:' . now()->subYears(4)->toDateString(),
                                    'after:' . now()->subYears(7)->toDateString(),
                                    ],
            'alamat_anak'       =>  'required|string',
            'kewarganegaraan'   =>  'required|in:WNI,WNA Keturunan',
            'bahasa_di_rumah'   =>  'required|string',
            'agama'             =>  'required|in:Buddha,Hindu,Islam,Katolik,Khonghucu,Kristen Protestan',
            'status_tinggal'    =>  'required|in:Bersama Orang Tua,Bersama Wali,Panti Asuhan',
            'yang_mendaftarkan' =>  'required|in:Orang Tua,Wali',
            'status_anak'       =>  'required|in:Anak Kandung,Bukan Anak Kandung',
            'anak_ke'           =>  'required|numeric|min:1|max:200',
            'saudara_kandung'   =>  'nullable|numeric|min:0|max:20',
            'saudara_tiri'      =>  'nullable|numeric|min:0|max:20',
            'saudara_angkat'    =>  'nullable|numeric|min:0|max:20',
            'berat_badan'       =>  'required|numeric|min:10|max:200',
            'tinggi_badan'      =>  'required|numeric|min:10|max:200',
            'golongan_darah'    =>  'required|in:Belum Periksa,O,AB,A,B',
            'riwayat_penyakit'  =>  'nullable|string',
            'mendaftar_sebagai' =>  'required|in:Murid Baru,Pindahan',
        ];

        if ($request->mendaftar_sebagai === 'Pindahan') {
            $rules += [
                'sekolah_lama'     => 'required|string',
                'tanggal_pindah'   => 'required|date',
                'dari_kelompok'    => 'required|in:TK A,TK B',
                'ke_kelompok'      => 'required|in:TK A,TK B',
            ];
        }

        if ($request->yang_mendaftarkan === 'Orang Tua') {
            $rules += [
                'nama_ayah'       => 'required|string',
                'pendidikan_ayah' => 'required|in:Tidak Sekolah,Paket A,Paket B,Paket C,SD/MI,SMP/MTs,SMA/SMK/MA,D-1,D-2,D-3,D-4,S-1,S-2,S-3',
                'pekerjaan_ayah'  => 'required|in:Sudah Meninggal,Mengurus Rumah Tangga,Petani,Nelayan,Peternak,Buruh,Pedagang Kecil,Pedagang Besar,Pegawai Swasta,Guru,PNS,Dokter,TNI,Polisi,Dosen,Karyawan BUMN,Wiraswasta,Tenaga Kerja Indonesia',
                'alamat_ayah'     => 'required|string',
                'nomor_hp_ayah'   => 'required|regex:/^(?:\+?\d{1,3})?[ -]?\d{10,15}$/|min:10|max:20',

                'nama_ibu'        => 'required|string',
                'pendidikan_ibu'  => 'required|in:Tidak Sekolah,Paket A,Paket B,Paket C,SD/MI,SMP/MTs,SMA/SMK/MA,D-1,D-2,D-3,D-4,S-1,S-2,S-3',
                'pekerjaan_ibu'   => 'required|in:Sudah Meninggal,Mengurus Rumah Tangga,Petani,Nelayan,Peternak,Buruh,Pedagang Kecil,Pedagang Besar,Pegawai Swasta,Guru,PNS,Dokter,TNI,Polisi,Dosen,Karyawan BUMN,Wiraswasta,Tenaga Kerja Indonesia',
                'alamat_ibu'      => 'required|string',
                'nomor_hp_ibu'    => 'required|regex:/^(?:\+?\d{1,3})?[ -]?\d{10,15}$/|min:10|max:20',
            ];
        } else if ($request->yang_mendaftarkan === 'Wali') {
            $rules += [
                'nama_wali'       => 'required|string',
                'pendidikan_wali' => 'required|in:Tidak Sekolah,Paket A,Paket B,Paket C,SD/MI,SMP/MTs,SMA/SMK/MA,D-1,D-2,D-3,D-4,S-1,S-2,S-3',
                'pekerjaan_wali'  => 'required|in:Sudah Meninggal,Mengurus Rumah Tangga,Petani,Nelayan,Peternak,Buruh,Pedagang Kecil,Pedagang Besar,Pegawai Swasta,Guru,PNS,Dokter,TNI,Polisi,Dosen,Karyawan BUMN,Wiraswasta,Tenaga Kerja Indonesia',
                'alamat_wali'     => 'required|string',
                'nomor_hp_wali'   => 'required|regex:/^(?:\+?\d{1,3})?[ -]?\d{10,15}$/|min:10|max:20',
            ];
        }

        $messages = [
            'nama_anak.required'         => 'Wajib diisi.',
            'panggilan_anak.required'    => 'Wajib diisi.',
            'jenis_kelamin.required'     => 'Wajib diisi.',
            'tempat_lahir.required'      => 'Wajib diisi.',
            'tanggal_lahir.required'     => 'Wajib diisi.',
            'alamat_anak.required'       => 'Wajib diisi.',
            'kewarganegaraan.required'   => 'Wajib diisi.',
            'bahasa_di_rumah.required'   => 'Wajib diisi.',
            'agama.required'             => 'Wajib diisi.',
            'status_tinggal.required'    => 'Wajib diisi.',
            'yang_mendaftarkan.required' => 'Wajib diisi.',
            'status_anak.required'       => 'Wajib diisi.',
            'anak_ke.required'           => 'Wajib diisi.',

            'saudara_kandung.numeric'    => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka.',
            'saudara_kandung.min'        => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka.',
            'saudara_kandung.max'        => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka.',
            'saudara_tiri.numeric'       => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka.',
            'saudara_tiri.min'           => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka.',
            'saudara_tiri.max'           => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka.',
            'saudara_angkat.numeric'     => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka.',
            'saudara_angkat.min'         => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka.',
            'saudara_angkat.max'         => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka.',

            'berat_badan.required'       => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (kg).',
            'berat_badan.numeric'        => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (kg).',
            'berat_badan.min'            => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (kg).',
            'berat_badan.max'            => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (kg).',
            'tinggi_badan.required'      => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (cm).',
            'tinggi_badan.numeric'       => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (cm).',
            'tinggi_badan.min'           => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (cm).',
            'tinggi_badan.max'           => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (cm).',
            'golongan_darah.required'    => 'Wajib diisi.',

            'mendaftar_sebagai.required' => 'Wajib diisi.',
            'sekolah_lama.required'      => 'Silakan diisi dengan nama sekolah lama.',
            'tanggal_pindah.required'    => 'Tanggal pindah dari sekolah yang lama',
            'dari_kelompok.required'     => 'Isi dengan kelompok umur dari TK yang lama',
            'ke_kelompok.required'       => 'Mendaftar pada kelompok umur baru',

            'nama_ayah.required'         => 'Nama Ayah wajib diisi.',
            'pendidikan_ayah.required'   => 'Silakan diisi sesuai kebenaran yang ada.',
            'pekerjaan_ayah.required'    => 'Silakan diisi sesuai kebenaran yang ada.',
            'alamat_ayah.required'       => 'Silakan diisi sesuai kebenaran yang ada.',
            'nomor_hp_ayah.required'     => 'Silakan diisi sesuai kebenaran yang ada.',
            'nomor_hp_ayah.regex'        => 'Silakan isi dengan format: +62XXXXXXXX.',

            'nama_ibu.required'          => 'Nama Ibu wajib diisi.',
            'pendidikan_ibu.required'    => 'Silakan diisi sesuai kebenaran yang ada.',
            'pekerjaan_ibu.required'     => 'Silakan diisi sesuai kebenaran yang ada.',
            'alamat_ibu.required'        => 'Silakan diisi sesuai kebenaran yang ada.',
            'nomor_hp_ibu.required'      => 'Silakan diisi sesuai kebenaran yang ada.',
            'nomor_hp_ibu.regex'         => 'Silakan isi dengan format: +62XXXXXXXX.',

            'nama_wali.required'         => 'Nama Wali wajib diisi.',
            'pendidikan_wali.required'   => 'Silakan diisi sesuai kebenaran yang ada.',
            'pekerjaan_wali.required'    => 'Silakan diisi sesuai kebenaran yang ada.',
            'alamat_wali.required'       => 'Silakan diisi sesuai kebenaran yang ada.',
            'nomor_hp_wali.required'     => 'Silakan diisi sesuai kebenaran yang ada.',
            'nomor_hp_wali.regex'        => 'Silakan isi dengan format: +62XXXXXXXX.',
        ];

        $validatedData = array_merge(
            $request->validate($rules,$messages),[
                'nama_anak' => ucwords(strtolower(trim($request->input('nama_anak')))),
                'panggilan_anak' => ucwords(strtolower(trim($request->input('panggilan_anak'))))
            ]
        );

        $infoAnak = InfoAnak::updateOrCreate(['pendaftaran_id' => $pendaftaran->id], $validatedData);

        $this->saveOrangTuaWali($infoAnak->id, 'ayah', $request->only(['nama_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'alamat_ayah', 'nomor_hp_ayah']));
        $this->saveOrangTuaWali($infoAnak->id, 'ibu', $request->only(['nama_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'alamat_ibu', 'nomor_hp_ibu']));
        $this->saveOrangTuaWali($infoAnak->id, 'wali', $request->only(['nama_wali', 'pendidikan_wali', 'pekerjaan_wali', 'alamat_wali', 'nomor_hp_wali']));

        return redirect('/pendaftar/formulir')->with('success', 'Formulir berhasil disimpan!');
    }

    private function saveOrangTuaWali($anakId, $relasi, $data){
        $default = [
            'nama' => null,
            'pendidikan' => null,
            'pekerjaan' => null,
            'alamat' => null,
            'nomor_hp' => null,
        ];

        $dbMapping = [
                'nama'       => ucwords(strtolower(trim($data["nama_{$relasi}"]))) ?? null,
                'pendidikan' => $data["pendidikan_{$relasi}"] ?? null,
                'pekerjaan'  => $data["pekerjaan_{$relasi}"] ?? null,
                'alamat'     => trim($data["alamat_{$relasi}"]) ?? null,
                'nomor_hp'   => trim($data["nomor_hp_{$relasi}"]) ?? null,
        ];

        $mapped = array_merge($default, $dbMapping);

        if (!empty(array_filter($dbMapping))) {
            OrangTuaWali::updateOrCreate(['anak_id' => $anakId, 'relasi' => $relasi],$mapped);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InfoAnak $infoAnak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InfoAnak $infoAnak)
    {
        //
    }

    /*
     * Update the specified resource in storage.
    public function update(Request $request, InfoAnak $infoAnak)
    {
        //
    }
    */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InfoAnak $infoAnak)
    {
        //
    }
}
