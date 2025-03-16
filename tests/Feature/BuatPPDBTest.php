<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\BatchPPDB;
use App\Models\TipeDokumen;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BuatPPDBTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'role_id' => 1,
        ]);

        $this->actingAs($user);
    }

    public function test_buat_ppdb_dan_update_status_ppdb_sebelumnya(): void
    {
       $ppdbData = [
            'tahun_ajaran' => '2025/2026',
            'gelombang' => 2,
            'waktu_mulai' => now(),
            'waktu_tenggat' => now()->addDays(60),
            'waktu_tutup' => now()->addDays(70),
        ];

        $existingTipeDokumen = TipeDokumen::pluck('id', 'tipe');

        $request['include'] = $existingTipeDokumen->only([
            'Foto Anak', 'Kartu Keluarga', 'Akta Kelahiran', 'Kartu Tanda Penduduk', 'Kartu Identitas Anak', 'Surat Pernyataan'
        ])->toArray();

        $request['is_wajib'] = [
            'Foto Anak' => true,
            'Kartu Keluarga' => true,
            'Akta Kelahiran' => true,
            'Kartu Tanda Penduduk' => true,
            'Kartu Identitas Anak' => false,
            'Surat Pernyataan' => true,
        ];

        $request = array_merge($ppdbData, [
            'include' => $request['include'],
            'is_wajib' => $request['is_wajib']
        ]);

        $this->post('/admin/ppdb/buat', $request)->assertRedirect('/admin/ppdb/aktif');

        $this->assertDatabaseHas('batch_ppdb', [
            'tahun_ajaran' => '2025/2026',
            'gelombang' => 2,
            'status' => true,
        ]);

        $this->assertDatabaseHas('batch_ppdb', [
            'tahun_ajaran' => '2025/2026',
            'gelombang' => 1,
            'status' => false,
        ]);

        $batch = BatchPPDB::where('tahun_ajaran', '2025/2026')->where('gelombang', 2)->first();
        $this->assertDatabaseHas('syarat_dokumen', [
            'batch_id' => $batch->id,
            'tipe_dokumen_id' => 1,
        ]);
    }
    public function test_tambah_syarat_baru_dan_jalankan_test_sebelumnya(): void
    {
        $response = $this->post('/admin/ppdb/buat/syarat-dokumen', [
            'nama_dokumen' => 'Foto Orang Tua/Wali',
        ]);

        $response->assertJson(['success' => 'Berhasil menambah syarat dokumen baru!']);

        $this->assertDatabaseHas('tipe_dokumen', [
            'tipe' => 'Foto Orang Tua/Wali',
        ]);

        $ppdbData = [
            'tahun_ajaran' => '2025/2026',
            'gelombang' => 2,
            'waktu_mulai' => now(),
            'waktu_tenggat' => now()->addDays(60),
            'waktu_tutup' => now()->addDays(70),
        ];

        $tipeDokumen = TipeDokumen::pluck('id', 'tipe');
        $requestData = array_merge($ppdbData, [
            'include' => [
                'Foto Orang Tua/Wali' => $tipeDokumen['Foto Orang Tua/Wali'],
            ],
            'is_wajib' => [
                'Foto Orang Tua/Wali' => true,
            ],
        ]);

        $this->post('/admin/ppdb/buat', $requestData)->assertRedirect('/admin/ppdb/aktif');
        $this->assertDatabaseHas('batch_ppdb', ['tahun_ajaran' => '2025/2026']);
        $this->assertDatabaseHas('syarat_dokumen', ['tipe_dokumen_id' => $tipeDokumen['Foto Orang Tua/Wali']]);

        $response = $this->get('/admin/ppdb/buat');
        $response->assertSee('name="include[Foto Orang Tua/Wali]"', false);
    }
    public function test_buat_ppdb_untuk_nanti_dan_update_status_ppdb_sebelumnya(): void
    {
        $this->assertDatabaseHas('batch_ppdb', [
            'tahun_ajaran' => '2025/2026',
            'gelombang' => 1,
            'status' => true,
        ]);

        BatchPPDB::create([
            'tahun_ajaran' => '2025/2026',
            'gelombang' => 2,
            'waktu_mulai' => now()->addDays(7),
            'waktu_tenggat' => now()->addDays(37),
            'waktu_tutup' => now()->addDays(47),
        ]);

        $this->assertDatabaseHas('batch_ppdb', [
            'tahun_ajaran' => '2025/2026',
            'gelombang' => 2,
            'status' => false,
        ]);

        $this->travelTo(now()->addDays(8));

        $this->artisan('batch-ppdb:regulate-status');

        $this->assertDatabaseHas('batch_ppdb', [
            'tahun_ajaran' => '2025/2026',
            'gelombang' => 2,
            'status' => true,
        ]);

        $this->assertDatabaseHas('batch_ppdb', [
            'tahun_ajaran' => '2025/2026',
            'gelombang' => 1,
            'status' => false,
        ]);
    }
}
