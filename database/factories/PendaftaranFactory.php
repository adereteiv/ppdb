<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\BatchPPDB;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'status'   => fake()->randomElement(['Mengisi', 'Lengkap', 'Terverifikasi']),
        ];
    }
}
