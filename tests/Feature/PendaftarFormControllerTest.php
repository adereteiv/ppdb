<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use App\Models\Pendaftaran;
use App\Models\OrangTuaWali;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PendaftarFormControllerTest extends TestCase
{
    use DatabaseTransactions;

    private function createUserAndPendaftaran(array $infoAnakOverrides = [])
    {
        $user = User::factory()->create(['role_id' => 2]);
        $pendaftaran = Pendaftaran::factory()->create(['user_id' => $user->id]);

        $infoAnak = InfoAnak::factory()->create(array_merge(
            ['pendaftaran_id' => $pendaftaran->id],
            $infoAnakOverrides
        ));
        // $infoAnak = InfoAnak::factory()->create(['pendaftaran_id' => $pendaftaran->id]);
        return [$user, $pendaftaran, $infoAnak];
    }

    public function test_redirect_pendaftar_terautentikasi_ke_halaman_formulir()
    {
        [$user, $pendaftaran, $infoAnak] = $this->createUserAndPendaftaran();

        $response = $this->actingAs($user)->get('/pendaftar/formulir');

        $response->assertStatus(200);
        $response->assertViewIs('pendaftar.formulir');
        $response->assertViewHas('infoAnak');
    }

    public function test_redirect_pendaftar_tidak_terautentikasi_ke_halaman_login()
    {
        $response = $this->get('/pendaftar/formulir');
        $response->assertRedirect('/login');
    }

    public function test_formulir_invalid_tidak_bisa_submit()
    {
        [$user, $pendaftaran, $infoAnak] = $this->createUserAndPendaftaran();

        $response = $this->actingAs($user)->put('/pendaftar/formulir', []);

        $response->assertSessionHasErrors(['nama_anak', 'jenis_kelamin']);
    }

    //this test is turbulent
    public function test_detail_pindahan_required_jika_murid_pindahan()
    {
        [$user, $pendaftaran, $infoAnak] = $this->createUserAndPendaftaran([
            'mendaftar_sebagai' => 'Pindahan',
            'yang_mendaftarkan' => 'Wali',
        ]);

        $wali = OrangTuaWali::factory()->state(['relasi' => 'wali'])->make()->toArray();
        $dataWali = [
            'nama_wali'       => $wali['nama'],
            'pendidikan_wali' => $wali['pendidikan'],
            'pekerjaan_wali'  => $wali['pekerjaan'],
            'alamat_wali'     => $wali['alamat'],
            'nomor_hp_wali'   => $wali['nomor_hp'],
        ];

        // [$user, $pendaftaran, $infoAnak] = $this->createUserAndPendaftaran();

        // $data = InfoAnak::factory()->state(['mendaftar_sebagai' => 'Pindahan'])->make()->toArray();

        // $response = $this->actingAs($user)->put('/pendaftar/formulir', $data);
        $response = $this->actingAs($user)->put('/pendaftar/formulir', array_merge($infoAnak->toArray(), $dataWali));

        $response->assertSessionHasErrors(['sekolah_lama', 'tanggal_pindah', 'dari_kelompok', 'di_kelompok']);
    }

    public function test_partially_filled_wali_data_is_saved_even_when_orang_tua_is_selected()
    {
        [$user, $pendaftaran, $infoAnak] = $this->createUserAndPendaftaran([
            'yang_mendaftarkan' => 'Orang Tua',
        ]);

        $infoAnakData = $infoAnak->toArray();

        $ayah = OrangTuaWali::factory()->state(['relasi' => 'ayah'])->make()->toArray();
        $dataAyah = [
            'nama_ayah'       => $ayah['nama'],
            'pendidikan_ayah' => $ayah['pendidikan'],
            'pekerjaan_ayah'  => $ayah['pekerjaan'],
            'alamat_ayah'     => $ayah['alamat'],
            'nomor_hp_ayah'   => $ayah['nomor_hp'],
        ];

        $ibu = OrangTuaWali::factory()->state(['relasi' => 'ibu'])->make()->toArray();
        $dataIbu = [
            'nama_ibu'       => $ibu['nama'],
            'pendidikan_ibu' => $ibu['pendidikan'],
            'pekerjaan_ibu'  => $ibu['pekerjaan'],
            'alamat_ibu'     => $ibu['alamat'],
            'nomor_hp_ibu'   => $ibu['nomor_hp'],
        ];

        $dataWali = [
            'nama_wali' => 'Nama Wali',
        ];

        $data = array_merge($infoAnakData, $dataAyah, $dataIbu, $dataWali);

        $this->actingAs($user)->put('/pendaftar/formulir', $data);

        $this->assertDatabaseHas('orang_tua_wali', [
            'anak_id'    => $infoAnak->id,
            'relasi'     => 'wali',
            'nama'       => 'Nama Wali',
            'pendidikan' => null,
            'pekerjaan'  => null,
            'alamat'     => null,
            'nomor_hp'   => null,
        ]);
    }

    public function test_partially_filled_data_orang_tua_is_saved_even_when_wali_is_selected()
    {
        [$user, $pendaftaran, $infoAnak] = $this->createUserAndPendaftaran([
            'yang_mendaftarkan' => 'Wali',
        ]);

        $infoAnakData = $infoAnak->toArray();

        $wali = OrangTuaWali::factory()->state(['relasi' => 'wali'])->make()->toArray();
        $dataWali = [
            'nama_wali'       => $wali['nama'],
            'pendidikan_wali' => $wali['pendidikan'],
            'pekerjaan_wali'  => $wali['pekerjaan'],
            'alamat_wali'     => $wali['alamat'],
            'nomor_hp_wali'   => $wali['nomor_hp'],
        ];

        $dataAyah = [
            'nama_ayah' => 'Nama Ayah',
        ];

        $dataIbu = [
            'nama_ibu' => 'Nama Ibu',
        ];

        $data = array_merge($infoAnakData, $dataAyah, $dataIbu, $dataWali);
        $this->actingAs($user)->put('/pendaftar/formulir', $data);

        $this->assertDatabaseHas('orang_tua_wali', [
            'anak_id'    => $infoAnak->id,
            'relasi'     => 'ayah',
            'nama'       => 'Nama Ayah',
            'pendidikan' => null,
            'pekerjaan'  => null,
            'alamat'     => null,
            'nomor_hp'   => null,
        ]);

        $this->assertDatabaseHas('orang_tua_wali', [
            'anak_id'    => $infoAnak->id,
            'relasi'     => 'ibu',
            'nama'       => 'Nama Ibu',
            'pendidikan' => null,
            'pekerjaan'  => null,
            'alamat'     => null,
            'nomor_hp'   => null,
        ]);
    }

    public function test_empty_data_ayah_ibu_is_not_saved_when_wali_is_selected()
    {
       [$user, $pendaftaran, $infoAnak] = $this->createUserAndPendaftaran([
            'yang_mendaftarkan' => 'Wali',
        ]);

        $infoAnakData = $infoAnak->toArray();

        $wali = OrangTuaWali::factory()->state(['relasi' => 'wali'])->make()->toArray();
        $dataWali = [
            'nama_wali'       => $wali['nama'],
            'pendidikan_wali' => $wali['pendidikan'],
            'pekerjaan_wali'  => $wali['pekerjaan'],
            'alamat_wali'     => $wali['alamat'],
            'nomor_hp_wali'   => $wali['nomor_hp'],
        ];

        $data = array_merge($infoAnakData, $dataWali);

        $this->actingAs($user)->put('/pendaftar/formulir', $data);

        $this->assertDatabaseMissing('orang_tua_wali', [ 'anak_id' => $infoAnak->id, 'relasi' => 'ayah', ]);
        $this->assertDatabaseMissing('orang_tua_wali', [ 'anak_id' => $infoAnak->id, 'relasi' => 'ibu',]);
        $this->assertDatabaseHas('orang_tua_wali', [ 'anak_id' => $infoAnak->id, 'relasi' => 'wali', ]);
    }

    public function test_empty_wali_data_is_not_saved_when_orang_tua_is_selected()
    {
       [$user, $pendaftaran, $infoAnak] = $this->createUserAndPendaftaran([
            'yang_mendaftarkan' => 'Orang Tua',
        ]);

        $infoAnakData = $infoAnak->toArray();

        $ayah = OrangTuaWali::factory()->state(['relasi' => 'ayah'])->make()->toArray();
        $dataAyah = [
            'nama_ayah'       => $ayah['nama'],
            'pendidikan_ayah' => $ayah['pendidikan'],
            'pekerjaan_ayah'  => $ayah['pekerjaan'],
            'alamat_ayah'     => $ayah['alamat'],
            'nomor_hp_ayah'   => $ayah['nomor_hp'],
        ];

        $ibu = OrangTuaWali::factory()->state(['relasi' => 'ibu'])->make()->toArray();
        $dataIbu = [
            'nama_ibu'       => $ibu['nama'],
            'pendidikan_ibu' => $ibu['pendidikan'],
            'pekerjaan_ibu'  => $ibu['pekerjaan'],
            'alamat_ibu'     => $ibu['alamat'],
            'nomor_hp_ibu'   => $ibu['nomor_hp'],
        ];

        $data = array_merge($infoAnakData, $dataAyah, $dataIbu);

        $this->actingAs($user)->put('/pendaftar/formulir', $data);

        $this->assertDatabaseHas('orang_tua_wali', [ 'anak_id' => $infoAnak->id, 'relasi' => 'ayah', ]);
        $this->assertDatabaseHas('orang_tua_wali', [ 'anak_id' => $infoAnak->id, 'relasi' => 'ibu', ]);
        $this->assertDatabaseMissing('orang_tua_wali', [ 'anak_id' => $infoAnak->id, 'relasi' => 'wali', ]);
    }

    public function test_user_without_any_pendaftaran_record()
    {
        [$user, ,] = $this->createUserAndPendaftaran([]);

        $activeBatch = BatchPPDB::where('status', true)->latest()->first();
        $this->assertNotNull($activeBatch);

        $this->actingAs($user)->put('/pendaftar/formulir', []);

        $this->assertDatabaseHas('pendaftaran', [ 'user_id' => $user->id, 'batch_id' => $activeBatch->id,
        ]);
    }
}
