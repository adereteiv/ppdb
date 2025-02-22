<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthMustMiddlewareTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_akses_dashboard_admin_belum_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login')->assertSessionHas('loginDulu', 'Silakan login terlebih dahulu.');
    }
    public function test_akses_dashboard_pendaftar_belum_login(): void
    {
        $response = $this->get('/pendaftar/dashboard');

        $response->assertRedirect('/login')->assertSessionHas('loginDulu', 'Silakan login terlebih dahulu.');
    }
}
