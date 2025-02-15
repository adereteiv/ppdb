<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
     /**
      * A basic feature test example.
      */
    use DatabaseTransactions;

    public function test_authenticate_berhasil()
    {
        $user = User::factory()->create([
            'role_id' => 2,
            'password' => Hash::make('passwordtest'),
        ]);

        $response = $this->post('/login', [
            'id' => $user->id,
            'password' => 'passwordtest',
        ]);

        $response->assertRedirect('/pendaftar/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticate_gagal_user_id_tidak_ada()
    {
        $response = $this->post('/login', [
            'id' => 9999,
            'password' => 'passwordtest',
        ]);

        $response->assertSessionHas('loginError', 'Login gagal. Periksa kembali ID dan kata sandi Anda.');
        $this->assertGuest();
    }

    public function test_authenticate_gagal_password_salah()
    {
        $user = User::factory()->create([
            'role_id' => 2,
            'password' => Hash::make('passwordtest'),
        ]);

        $response = $this->post('/login', [
            'id' => $user->id,
            'password' => 'passwordlain',
        ]);

        $response->assertSessionHas('loginError', 'Login gagal. Periksa kembali ID dan kata sandi Anda.');
        $this->assertGuest();
    }

    public function test_authenticate_admin_berhasil()
    {
        $admin = User::factory()->create([
            'role_id' => 1, // Admin
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/pintuadmin', [
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
    }

	public function test_authenticate_admin_gagal_format_email_keliru()
    {
        $admin = User::factory()->create([
            'role_id' => 1, // Admin
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/pintuadmin', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email' => 'Mohon masukkan format email yang benar.']);
        $this->assertGuest();
    }

    public function test_authenticate_admin_gagal_bukan_admin()
    {
        User::factory()->create([
            'role_id' => 2, // Pendaftar
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/pintuadmin', [
            'email' => 'user@gmail.com',
            'password' => 'password',
        ]);

        $response->assertSessionHas('loginError', 'Login gagal. Periksa kembali email dan kata sandi Anda.');
        $this->assertGuest();
    }

    public function test_authenticate_admin_gagal_email_salah()
    {
        $response = $this->post('/pintuadmin', [
            'email' => 'admin1@gmail.com',
            'password' => 'password',
        ]);

        $response->assertSessionHas('loginError', 'Login gagal. Periksa kembali email dan kata sandi Anda.');
        $this->assertGuest();
    }

    public function test_authenticate_admin_gagal_password_salah()
	{
        $admin = User::factory()->create([
            'role_id' => 1,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/pintuadmin', [
            'email' => 'admin@gmail.com',
            'password' => 'passwordlain',
        ]);

        $response->assertSessionHas('loginError', 'Login gagal. Periksa kembali email dan kata sandi Anda.');
        $this->assertGuest();
    }

    public function test_logout_pendaftar_redirect_ke_login()
    {
        $registrant = User::factory()->create(['role_id' => 2]);

        $this->actingAs($registrant);
        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_logout_admin_redirect_ke_login_admin()
    {
        $admin = User::factory()->create(['role_id' => 1]);

        $this->actingAs($admin);
        $response = $this->post('/logout');

        $response->assertRedirect('/pintuadmin');
        $this->assertGuest();
    }
}
