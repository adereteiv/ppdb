<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class ModelUserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_id_dari_nama_pengguna()
    {
        $user = User::factory()->create(['name' => 'Anak Orang']);

        $generatedId = $user->id;

        // Assert/dicek bahwa format id-nya sesuai dgn yg diatur di Models/User.php
        $this->assertMatchesRegularExpression('/^[A-Z]{3}[A-Z0-9]{8}$/', $generatedId);
        // $this->assertMatchesRegularExpression('/^ANA\d{4}$/', $generatedId);
    }

    public function test_user_id_harus_unik()
    {
        // Tes buat user dengan nama sama, yang mana emailnya asumsikan beda
        // Sehingga barangkali ada anak yang namanya sama dari orang tua yg beda lolos pengecekan  di controller
        $user1 = User::factory()->create(['name' => 'Siti Kusmini']);
        $userId1 = $user1->id;

        $user2 = User::factory()->create(['name' => 'Siti Kusmini']);
        $userId2 = $user2->id;

        $this->assertNotEquals($userId1, $userId2);
    }

    public function test_default_role()
    {
        $user = User::factory()->create(['role_id' => null]);

        $this->assertEquals(2, $user->role_id);
    }
}
