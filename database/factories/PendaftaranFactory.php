<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{User,BatchPPDB};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendaftaran>
 */
class PendaftaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'batch_id' => BatchPPDB::latest('id')->value('id') ?? BatchPPDB::factory(),
            'user_id'  => User::factory(),
            // 'status'   => fake()->randomElement(['Mengisi', 'Lengkap', 'Terverifikasi']),
            'catatan_admin'  => fake()->optional()->sentence(),
        ];
    }
}
