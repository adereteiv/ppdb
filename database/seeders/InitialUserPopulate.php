<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\{User,Pendaftaran,InfoAnak,BuktiBayar,BatchPPDB};

/**
 * Open source, made by adereteiv
 */
class InitialUserPopulate extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure batch exists
        $batch = BatchPPDB::firstOrCreate(['status' => true], [
            'nama' => 'Gelombang 1',
            'tanggal_mulai' => now()->subDays(10),
            'tanggal_akhir' => now()->addDays(10),
        ]);

        // Jumlah fake entries, CUSTOMIZABLE
        $count = 100;

        for ($i = 0; $i < $count; $i++) {
            // 1. Simulate user creation
            $user = User::factory()->create([
                'role_id' => 2,
            ]);

            // 2. Pendaftaran
            $pendaftaran = Pendaftaran::factory()->create([
                'user_id' => $user->id,
                'batch_id' => $batch->id,
            ]);

            // 3. Simulate partial InfoAnak data (refer to RegisterController, match that, in case changes happens)
            $infoAnak = InfoAnak::create([
                'pendaftaran_id' => $pendaftaran->id,
                'nama_anak' => fake()->name(),
                'panggilan_anak' => fake()->firstName(),
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->dateTimeBetween('-7 years', '-4 years')->format('Y-m-d'),
                'jarak_tempuh' => fake()->numberBetween(1, 20),
            ]);

            // 4. Create dummy file for BuktiBayar
            $filename = $user->id . '_bukti_bayar_' . Str::random(10) . '.jpg';
            $filePath = 'bukti_bayar/' . $filename;
            Storage::disk('public')->put($filePath, 'Dummy image for testing');

            BuktiBayar::create([
                'anak_id' => $infoAnak->id,
                'file_path' => $filePath,
            ]);
        }
    }
}
