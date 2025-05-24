<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InfoAnak;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BuktiBayar>
 */
class BuktiBayarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fake storage for tests
        // Storage::fake('public');
        // Ensure the 'bukti_bayar' directory exists in storage/app/public
        Storage::disk('public')->makeDirectory('bukti_bayar');

        // Generate fake file (image or PDF)
        $filename = 'fake_' . $this->faker->unique()->uuid() . '.jpg';
        $filepath = 'bukti_bayar/' . $filename;

        // Actually create a dummy file
        Storage::disk('public')->put($filepath, 'Fake content');

        return [
            'anak_id' => InfoAnak::inRandomOrder()->first()?->id ?? InfoAnak::factory(),
            'file_path' => $filepath,
        ];
    }
}
