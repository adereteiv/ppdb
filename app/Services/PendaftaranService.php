<?php

namespace App\Services;

use App\Models\BatchPPDB;
use App\Models\SyaratDokumen;
use App\Models\Pendaftaran;
use App\Models\InfoAnak;
use App\Models\BuktiBayar;
use App\Models\OrangTuaWali;
use App\Models\DokumenPersyaratan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PendaftaranService
{
    public function checkStatusPendaftaran(Pendaftaran $pendaftaran)
    {
        if (!$pendaftaran) return;
        $infoAnak = $pendaftaran->infoAnak;
        if (!$infoAnak) return $pendaftaran->update(['status' =>'Menunggu']);

        // $buktiBayarLengkap check, belum bayar = Menunggu
        $buktiBayar = $infoAnak->buktiBayar->first();
        if (!$buktiBayar) return $pendaftaran->update(['status' =>'Menunggu']);
        $buktiBayarLengkap = optional($buktiBayar)->exists();

        // Admin has to manually update $pendaftaran->status, kalau tidak, statusnya akan tetap Menunggu kamu >o<
        if (!$buktiBayarLengkap && !$pendaftaran->status === 'Mengisi') return;

        // $formulirLengkap check
        $orangTuaWali = $infoAnak->orangTuaWali;
        $requiredInfoAnak = [
            'nama_anak', 'panggilan_anak', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
            'alamat_anak', 'kewarganegaraan', 'bahasa_di_rumah', 'agama', 'status_tinggal',
            'yang_mendaftarkan', 'status_anak', 'anak_ke', 'berat_badan', 'tinggi_badan', 'golongan_darah'
        ];
        if (optional($infoAnak)->mendaftar_sebagai === 'Pindahan') {
            $requiredInfoAnak = array_merge($requiredInfoAnak, [
                'sekolah_lama', 'tanggal_pindah', 'dari_kelompok', 'ke_kelompok'
            ]);
        }
        $infoAnakLengkap = $infoAnak && collect($requiredInfoAnak)->every(fn($field) => !empty($infoAnak->$field));
        if ($infoAnak && $infoAnak->yang_mendaftarkan === 'Orang Tua') {
            $requiredRelasi = ['ayah', 'ibu'];
        } else {
            $requiredRelasi = ['wali'];
        }
        $orangTuaWaliLengkap = collect($requiredRelasi)->every(fn($relasi) => $orangTuaWali->contains('relasi', $relasi));
        $formulirLengkap = $infoAnakLengkap && $orangTuaWaliLengkap;

        // $dokumenLengkap check
        $batch = $pendaftaran->batchPPDB;
        $syaratDokumen = $batch->syaratDokumen;
        $dokumenPersyaratan = $infoAnak->dokumenPersyaratan;
        $dokumenUnggahan = $dokumenPersyaratan->pluck('tipe_dokumen_id');
        $filterDokumen  = $syaratDokumen->where('is_wajib', true)->pluck('tipe_dokumen_id');
        $dokumenLengkap = $filterDokumen->diff($dokumenUnggahan)->isEmpty();

        // Update $pendaftaran->status jika seluruh requirement Lengkap
        if ($formulirLengkap && $dokumenLengkap && $buktiBayarLengkap && ($pendaftaran->status === 'Mengisi')) {
            $pendaftaran->update(['status' => 'Lengkap']);
        }

        return  ['formulirLengkap' => $formulirLengkap, 'dokumenLengkap' => $dokumenLengkap, 'buktiBayarLengkap' => $buktiBayarLengkap];
    }

    public function saveFormulir(Request $request, Pendaftaran $pendaftaran)
    {
        $rules = [
            'nama_anak'         =>  'required|string|max:255|regex:/^[a-zA-Z-\s]+$/',
            'panggilan_anak'    =>  'required|string|max:255|regex:/^[a-zA-Z-\s]+$/',
            'jenis_kelamin'     =>  'required|in:Perempuan,Laki-Laki',
            'tempat_lahir'      =>  'required|string',
            'tanggal_lahir'     =>  [
                                    'required','date',
                                    'before_or_equal:' . now()->subYears(4)->toDateString(),
                                    'after:' . now()->subYears(7)->toDateString(),
                                    ],
            'alamat_anak'       =>  'required|string|max:255',
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
            'tinggi_badan'      =>  'required|numeric|min:50|max:200',
            'golongan_darah'    =>  'required|in:Belum Periksa,O,AB,A,B',
            'riwayat_penyakit'  =>  'nullable|string',
            'mendaftar_sebagai' =>  'required|in:Murid Baru,Pindahan',
        ];

        if ($request->mendaftar_sebagai === 'Pindahan') {
            $rules += [
                'sekolah_lama'     => 'required|string',
                'tanggal_pindah'   => 'required|date',
                'dari_kelompok'    => 'required|in:TK A,TK B',
                'ke_kelompok'      => [
                    'required','in:TK A,TK B',
                    function ($attribute, $value, $message) use ($request) {
                        if ($request->dari_kelompok === "TK B" && $value !== 'TK B') {
                            $message("Kepindahan dari TK B masuk ke kelompok TK B");
                        }
                    }
                ],
            ];
        }

        if ($request->yang_mendaftarkan === 'Orang Tua') {
            $rules += [
                'nama_ayah'       => 'required|string',
                'pendidikan_ayah' => 'required|in:Tidak Sekolah,Paket A,Paket B,Paket C,SD/MI,SMP/MTs,SMA/SMK/MA,D-1,D-2,D-3,D-4,S-1,S-2,S-3',
                'pekerjaan_ayah'  => 'required|in:Sudah Meninggal,Mengurus Rumah Tangga,Petani,Nelayan,Peternak,Buruh,Pedagang Kecil,Pedagang Besar,Pegawai Swasta,Guru,PNS,Dokter,TNI,Polisi,Dosen,Karyawan BUMN,Wiraswasta,Tenaga Kerja Indonesia',
                'alamat_ayah'     => 'required|string|max:255',
                'nomor_hp_ayah'   => 'required|regex:/^(?:\+?\d{1,3})?[ \-]?\d{10,15}$/|min:10|max:20',

                'nama_ibu'        => 'required|string',
                'pendidikan_ibu'  => 'required|in:Tidak Sekolah,Paket A,Paket B,Paket C,SD/MI,SMP/MTs,SMA/SMK/MA,D-1,D-2,D-3,D-4,S-1,S-2,S-3',
                'pekerjaan_ibu'   => 'required|in:Sudah Meninggal,Mengurus Rumah Tangga,Petani,Nelayan,Peternak,Buruh,Pedagang Kecil,Pedagang Besar,Pegawai Swasta,Guru,PNS,Dokter,TNI,Polisi,Dosen,Karyawan BUMN,Wiraswasta,Tenaga Kerja Indonesia',
                'alamat_ibu'      => 'required|string|max:255',
                'nomor_hp_ibu'    => 'required|regex:/^(?:\+?\d{1,3})?[ \-]?\d{10,15}$/|min:10|max:20',
            ];
        } else if ($request->yang_mendaftarkan === 'Wali') {
            $rules += [
                'nama_wali'       => 'required|string',
                'pendidikan_wali' => 'required|in:Tidak Sekolah,Paket A,Paket B,Paket C,SD/MI,SMP/MTs,SMA/SMK/MA,D-1,D-2,D-3,D-4,S-1,S-2,S-3',
                'pekerjaan_wali'  => 'required|in:Sudah Meninggal,Mengurus Rumah Tangga,Petani,Nelayan,Peternak,Buruh,Pedagang Kecil,Pedagang Besar,Pegawai Swasta,Guru,PNS,Dokter,TNI,Polisi,Dosen,Karyawan BUMN,Wiraswasta,Tenaga Kerja Indonesia',
                'alamat_wali'     => 'required|string|max:255',
                'nomor_hp_wali'   => 'required|regex:/^(?:\+?\d{1,3})?[ \-]?\d{10,15}$/|min:10|max:20',
            ];
        }

        $messages = [
            'nama_anak.required'         => 'Wajib diisi.',
            'nama_anak.max'              => 'Melebihi batas maksimal 255 karakter.',
            'nama_anak.regex'            => 'Hanya huruf Aa-Zz dan tanda hubung (-) yang diperbolehkan.',
            'panggilan_anak.required'    => 'Wajib diisi.',
            'panggilan_anak.max'         => 'Melebihi batas maksimal 255 karakter.',
            'panggilan_anak.regex'       => 'Hanya huruf Aa-Zz dan tanda hubung (-) yang diperbolehkan.',
            'jenis_kelamin.required'     => 'Wajib diisi.',
            'tempat_lahir.required'      => 'Wajib diisi.',
            'tanggal_lahir.required'     => 'Wajib diisi.',
            'tanggal_lahir.before_or_equal' => 'Anak harus berusia minimal 4 tahun.',
            'tanggal_lahir.after'        => 'Usia anak maksimal berada di bawah 7 tahun.',
            'alamat_anak.required'       => 'Wajib diisi.',
            'alamat_anak.max'            => 'Melebihi batas maksimal 255 karakter.',
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
            'berat_badan.min'            => 'Tidak boleh negatif. Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (kg).',
            'berat_badan.max'            => 'Melebihi batas maksimal. Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (kg).',
            'tinggi_badan.required'      => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (cm).',
            'tinggi_badan.numeric'       => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (cm).',
            'tinggi_badan.min'           => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (cm).',
            'tinggi_badan.max'           => 'Silakan diisi sesuai kebenaran yang ada dan isi dengan angka sesuai satuan (cm).',
            'golongan_darah.required'    => 'Wajib diisi.',

            'mendaftar_sebagai.required' => 'Wajib diisi.',
            'sekolah_lama.required'      => 'Silakan diisi dengan nama sekolah lama.',
            'dari_kelompok.required'     => 'Isi dengan kelompok umur dari TK lama',
            'ke_kelompok.required'       => 'Isi dengan kelompok umur pada TK sekarang',

            'nama_ayah.required'         => 'Nama Ayah wajib diisi.',
            'pendidikan_ayah.required'   => 'Silakan diisi sesuai kebenaran yang ada.',
            'pekerjaan_ayah.required'    => 'Silakan diisi sesuai kebenaran yang ada.',
            'alamat_ayah.required'       => 'Silakan diisi sesuai kebenaran yang ada.',
            'alamat_ayah.max'            => 'Melebihi batas maksimal 255 karakter.',
            'nomor_hp_ayah.required'     => 'Silakan diisi sesuai kebenaran yang ada.',
            'nomor_hp_ayah.regex'        => 'Silakan isi dengan format: +62XXXXXXXXXX.',

            'nama_ibu.required'          => 'Nama Ibu wajib diisi.',
            'pendidikan_ibu.required'    => 'Silakan diisi sesuai kebenaran yang ada.',
            'pekerjaan_ibu.required'     => 'Silakan diisi sesuai kebenaran yang ada.',
            'alamat_ibu.required'        => 'Silakan diisi sesuai kebenaran yang ada.',
            'alamat_ibu.max'             => 'Melebihi batas maksimal 255 karakter.',
            'nomor_hp_ibu.required'      => 'Silakan diisi sesuai kebenaran yang ada.',
            'nomor_hp_ibu.regex'         => 'Silakan isi dengan format: +62XXXXXXXXXX.',

            'nama_wali.required'         => 'Nama Wali wajib diisi.',
            'pendidikan_wali.required'   => 'Silakan diisi sesuai kebenaran yang ada.',
            'pekerjaan_wali.required'    => 'Silakan diisi sesuai kebenaran yang ada.',
            'alamat_wali.required'       => 'Silakan diisi sesuai kebenaran yang ada.',
            'alamat_wali.max'            => 'Melebihi batas maksimal 255 karakter.',
            'nomor_hp_wali.required'     => 'Silakan diisi sesuai kebenaran yang ada.',
            'nomor_hp_wali.regex'        => 'Silakan isi dengan format: +62XXXXXXXXXX.',
        ];

        $sanitize = [
            /*Commit 10*/
            'nama_anak' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('nama_anak'))))),
            // 'nama_anak' => ucwords(strtolower(trim($request->input('nama_anak')))),
            'panggilan_anak' => Str::title(preg_replace('/\s+/', ' ', trim(strip_tags($request->input('panggilan_anak'))))),
            // 'panggilan_anak' => ucwords(strtolower(trim($request->input('panggilan_anak'))))
        ];

        $validatedData = array_merge($request->validate($rules, $messages), [
            $sanitize['nama_anak'],
            $sanitize['panggilan_anak'],
        ]);

        $infoAnak = InfoAnak::updateOrCreate(['pendaftaran_id' => $pendaftaran->id], $validatedData);

        $this->saveOrangTuaWali($infoAnak->id, 'ayah', $request->only(['nama_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'alamat_ayah', 'nomor_hp_ayah']));
        $this->saveOrangTuaWali($infoAnak->id, 'ibu', $request->only(['nama_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'alamat_ibu', 'nomor_hp_ibu']));
        $this->saveOrangTuaWali($infoAnak->id, 'wali', $request->only(['nama_wali', 'pendidikan_wali', 'pekerjaan_wali', 'alamat_wali', 'nomor_hp_wali']));
    }

    private function saveOrangTuaWali($anakId, $relasi, $data)
    {
        $default = [
            'nama' => null,
            'pendidikan' => null,
            'pekerjaan' => null,
            'alamat' => null,
            'nomor_hp' => null,
        ];

        $dbMapping = [
                'nama'       => Str::title(preg_replace('/\s+/', ' ', trim($data["nama_{$relasi}"]))) ?? null,
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

    public function saveDokumenPersyaratan(Request $request, Pendaftaran $pendaftaran)
    {
        $anakId = $pendaftaran->infoAnak->id;
        $syaratDokumen = SyaratDokumen::where('batch_id', $pendaftaran->batch_id)->get();

        $nameMapping = [];
        foreach ($syaratDokumen as $syarat) {
            $nameFormat = Str::slug($syarat->tipeDokumen->tipe, '_');
            $nameMapping[$nameFormat] = $syarat->tipe_dokumen_id;
        };

        $rules = [];
        foreach ($nameMapping as $nameFormat => $tipeDokumenId) {
            $inputName = "dokumen.{$nameFormat}";

            $existingDokumen = DokumenPersyaratan::where([
                'anak_id' => $anakId,
                'tipe_dokumen_id' => $tipeDokumenId
            ])->exists();

            if (!$existingDokumen && $syaratDokumen->where('tipe_dokumen_id', $tipeDokumenId)->first()->is_wajib) {
                $rules[$inputName] = 'required|file|mimes:jpg,jpeg,png,pdf|max:1024';
            } elseif ($request->hasFile($inputName)) {
                $rules[$inputName] = 'file|mimes:jpg,jpeg,png,pdf|max:1024';
            }
        }

        $filterDokumen = SyaratDokumen::where('batch_id', $pendaftaran->batch_id)->pluck('tipe_dokumen_id')->toArray();

        $request->validate( $rules, [
            'dokumen.*.required' => 'Dokumen ini wajib diunggah.',
            'dokumen.*.mimes' => 'Format file tidak valid. Hanya JPG, JPEG, PNG, dan PDF yang diperbolehkan.',
            'dokumen.*.max' => 'Ukuran file maksimal 1MB.',
        ]);

        foreach ($request->file('dokumen', []) as $nameFormat => $file) {
            if (!isset($nameMapping[$nameFormat])) {continue;};

            $tipeDokumenId = $nameMapping[$nameFormat];

            if (!in_array($tipeDokumenId, $filterDokumen)) {
                abort(403, 'Kan error, silakan ikuti alur normalnya ya ;D');
            }

            $syarat = SyaratDokumen::where('tipe_dokumen_id', $tipeDokumenId)->first();
            $namaDokumen  = str_replace(' ', '_', strtolower($syarat->tipeDokumen->tipe));
            $fileName = $pendaftaran->user->id . '_'. $namaDokumen . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('dokumen_persyaratan', $fileName, 'public');

            $existingDokumen = DokumenPersyaratan::where([
                'anak_id' => $anakId,
                'tipe_dokumen_id' => $tipeDokumenId
            ])->first();

            /* Hapus before update */
            // Kalau sudah production do adjust the storage
            if ($existingDokumen) {
                Storage::disk('public')->delete($existingDokumen->file_path);
            }

            DokumenPersyaratan::updateOrCreate(
                ['anak_id' => $anakId, 'tipe_dokumen_id' => $tipeDokumenId],
                ['file_path' => $filePath]
            );
        }
    }

    public function saveBuktiBayar(Request $request, Pendaftaran $pendaftaran)
    {
        $anakId = $pendaftaran->infoAnak->id;
        $buktiBayar = BuktiBayar::where(['anak_id' => $anakId,])->first();

        $request->validate([
            'bukti_bayar' => [$buktiBayar ? 'nullable' : 'required','file','mimes:jpg,jpeg,png,pdf','max:1024'],
        ], [
            'bukti_bayar.required' => 'Anda wajib mengunggah bukti pembayaran.',
            'bukti_bayar.mimes' => 'Format file tidak valid. Hanya JPG, JPEG, PNG, dan PDF diperbolehkan.',
            'bukti_bayar.max' => 'Ukuran file maksimal 1MB.',
        ]);

        $file = $request->file('bukti_bayar');
        if ($file) {
            $fileName = $pendaftaran->user->id . '_bukti_bayar_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti_bayar', $fileName, 'public');

            $buktiBayar = BuktiBayar::firstOrNew(['anak_id' => $anakId,]);

            if ($buktiBayar->file_path) {
                Storage::disk('public')->delete($buktiBayar->file_path);
            };

            // dd($request->all());

            // BuktiBayar::updateOrCreate(
            //     ['anak_id' => $anakId],
            //     ['file_path' => $filePath],
            // );
            $buktiBayar->file_path = $filePath;
            $buktiBayar->save();
            // if (!$buktiBayar) {
            // }
        }
    }
}
