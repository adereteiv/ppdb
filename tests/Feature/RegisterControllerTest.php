<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\InfoAnak;
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

    public function test_showRegister_batchClosed_false()
    {
        $batch = BatchPPDB::factory()->create(['status' => true]);

        $response = $this->get('/daftar');
        $response->assertStatus(200);
        $response->assertViewHas('batchClosed', false);
    }

    public function test_registrasi_akun_dengan_notifikasi_email_berisi_user_id_berhasil()
    {
        // Check log di tail -f storage/logs/laravel.log tapi run dulu di terminal artisan queue:work, lalu coba registrasi utk lihat log notif email
        Notification::fake();

        // registrasi memerlukan BatchPPDB dengan status true
        $batch = BatchPPDB::factory()->create(['status' => true]);

        $response = $this->post('/daftar', [
            'email' => 'pendaftar@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_anak' => 'Anak Orang',
            'panggilan_anak' => 'Anoor',
            'tempat_lahir' => 'Pontianak',
            'tanggal_lahir' => now()->subYears(5)->toDateString(), // Valid age
            'alamat_anak' => 'Jl. Merdeka No.1',
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

        Notification::assertSentTo($user, KirimUserIDNotification::class);

        $response->assertRedirect('/login');
        $response->assertSessionHas('registrasiAkunBerhasil', 'Registrasi akun berhasil!');
    }

    public function test_tidak_boleh_ada_data_pasangan_anak_dan_email_yang_double()
    {
        User::factory()->create([
            'email' => 'double@gmail.com',
            'name' => 'Anak Orang',
        ]);

        Notification::fake();

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
        $response->assertSessionHas('akunAda', 'Anak dengan email ini sudah terdaftar. Jika ingin mendaftarkan anak lain, silakan cek kembali atau hubungi admin untuk bantuan.');

        // Value old input
        $response->assertSessionHasInput('email', 'double@gmail.com');
        $response->assertSessionHasInput('nama_anak', 'Anak Orang');

        // Memastikan akun benar-benar tidak terbuat
        $this->assertEquals(1, User::where('email', 'double@gmail.com')->count());
    }

    public function test_registrasi_gagal_isian_kosong()
    {
        $response = $this->post('/daftar', [
            'email' => '',
            'password' => '',
            'nama_anak' => '',
            'tempat_lahir' => '',
            'tanggal_lahir' => '',
            'alamat_anak' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password', 'nama_anak', 'tempat_lahir', 'tanggal_lahir', 'alamat_anak']);
    }

    public function test_registrasi_gagal_format_email_tidak_tembus_validasi()
    {
        $response = $this->post('/daftar', [
            // email salah
            'email' => 'email@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_anak' => 'Anak Orang',
            'tempat_lahir' => 'Pontianak',
            'tanggal_lahir' => now()->subYears(5)->toDateString(),
            'alamat_anak' => 'Jl. Merdeka No.1',
        ]);

        $response->assertSessionHasErrors(['email' => 'Mohon masukkan format email yang benar.']);
    }

    public function test_registrasi_gagal_konfirmasi_password_tidak_cocok()
    {
        $response = $this->post('/daftar', [
            'email' => 'pendaftar@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'passwordlain',
            'nama_anak' => 'Anak Orang',
            'tempat_lahir' => 'Pontianak',
            'tanggal_lahir' => now()->subYears(5)->toDateString(),
            'alamat_anak' => 'Jl. Merdeka No.1',
        ]);

        $response->assertSessionHasErrors(['password' => 'Kata sandi tidak cocok.']);
    }

    public function test_registrasi_gagal_umur_anak_tidak_sesuai_kriteria()
    {
        $response = $this->post('/daftar', [
            'email' => 'pendaftar@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_anak' => 'Anak Orang',
            'tempat_lahir' => 'Pontianak',
            // Usia anak < 4 tahun, terlalu muda
            'tanggal_lahir' => now()->subYears(3)->toDateString(),
            'alamat_anak' => 'Jl. Merdeka No.1',
        ]);

        $response->assertSessionHasErrors(['tanggal_lahir' => 'Anak harus berusia minimal 4 tahun.']);

        $response = $this->post('/daftar', [
            'email' => 'pendaftar@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_anak' => 'Anak Orang',
            'tempat_lahir' => 'Pontianak',
            // Usia anak > 6 tahun, umur SD
            'tanggal_lahir' => now()->subYears(7)->toDateString(),
            'alamat_anak' => 'Jl. Merdeka No.1',
        ]);

        $response->assertSessionHasErrors(['tanggal_lahir' => 'Usia anak maksimal 6 tahun.']);
    }
}
