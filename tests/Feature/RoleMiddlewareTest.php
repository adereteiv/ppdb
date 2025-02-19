<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleMiddlewareTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use DatabaseTransactions;
    public function test_admin_bisa_akses_route_untuk_admin(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_selain_admin_tidak_bisa_akses_route_untuk_admin(): void
    {
        $user = User::factory()->create(['role_id' => 2]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403)->assertViewIs('auth.unauthorized')->assertViewHas('redirect','/login');
    }

    public function test_pendaftar_bisa_akses_route_untuk_pendaftar(): void
    {
        $user = User::factory()->create(['role_id' => 2]);

        $response = $this->actingAs($user)->get('/pendaftar/dashboard');

        $response->assertStatus(200);
    }

    public function test_selain_pendaftar_tidak_bisa_akses_route_untuk_pendaftar(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);

        $response = $this->actingAs($admin)->get('/pendaftar/dashboard');

        $response->assertStatus(403)->assertViewIs('auth.unauthorized')->assertViewHas('redirect','/pintuadmin');
    }

    public function test_selain_pengguna_terautentikasi_tidak_bisa_akses_route_dengan_proteksi_middleware()
    {
        $response = $this->get('admin/dashboard');

        $response->assertRedirect('/login');
    }
}
