<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\BatchPPDB;
use App\Notifications\KirimUserIDNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_showRegister_batchClosed_true()
    {
        BatchPPDB::query()->update(['status' => false]);

        $response = $this->get('/daftar');
        $response->assertStatus(200);
        $response->assertViewHas('batchClosed', true);
    }

    public function test_registrasi_akun_berhasil()
    {
        // registrasi memerlukan BatchPPDB dengan status true
        $batch = BatchPPDB::where('status', true)->first();

        $response = $this->post('/daftar', [
            'email' => 'pendaftar@gmail.com',
            'nomor_hp' => '+6282145789098',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_anak' => 'Anak Orang',
            'panggilan_anak' => 'Anoor',
            'tempat_lahir' => 'Pontianak',
            'tanggal_lahir' => now()->subYears(5)->toDateString(), // Valid age
            'jarak_tempuh' => 18,
        ]);

        // check metode store()
        // user terbuat, pendaftaran terbuat, info_anak terbuat lalu email notifikasi terkirim dan redirect ke /login
        $user = User::where('email', 'pendaftar@gmail.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Anak Orang', $user->name);

        $this->assertDatabaseHas('pendaftaran', [
            'user_id' => $user->id,
            'batch_id' => $batch->id,
        ]);

        $this->assertDatabaseHas('info_anak', [
            'nama_anak' => 'Anak Orang',
            'panggilan_anak' => 'Anoor',
        ]);
    }

    public function test_tidak_boleh_ada_data_pasangan_anak_dan_email_yang_double()
    {
        User::factory()->create([
            'email' => 'double@gmail.com',
            'name' => 'Anak Orang',
        ]);

        $response = $this->post('/daftar', [
            'email' => 'double@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_anak' => 'Anak Orang',
            'panggilan_anak' => 'Anoor',
            'tempat_lahir' => 'Pontianak',
            'tanggal_lahir' => now()->subYears(5)->toDateString(),
            'alamat_anak' => 'Jl. Merdeka No.1',
        ]);

        // Check pasangan email dan nama anak di store()
        // $response->assertSessionHas('akunAda', 'Anak dengan email ini sudah terdaftar. Jika ingin mendaftarkan anak lain, silakan cek kembali atau hubungi admin untuk bantuan.');

        // Value old input
        $response->assertSessionHasInput('email', 'double@gmail.com');
        $response->assertSessionHasInput('nama_anak', 'Anak Orang');

        // Memastikan akun benar-benar tidak terbuat
        $this->assertEquals(1, User::where('email', 'double@gmail.com')->count());
    }

}
