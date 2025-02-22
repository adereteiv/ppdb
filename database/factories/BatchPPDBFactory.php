<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BatchPPDB>
 */
class BatchPPDBFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tahun_ajaran' => now()->year . '/' . (now()->year + 1),
            'gelombang' => 2,
            'status' => fake()->boolean(),
            'waktu_mulai' => now(),
            'waktu_tenggat' => now()->addDays(30),
            'waktu_tutup' => now()->addDays(60),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
