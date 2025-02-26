<?php

namespace Database\Factories;

use App\Models\InfoAnak;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrangTuaWali>
 */
class OrangTuaWaliFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anak_id'    => InfoAnak::factory(),
            'relasi'     => fake()->randomElement(['ayah', 'ibu', 'wali']),
            'nama'       => fake()->name(),
            'pendidikan' => fake()->randomElement(['Tidak Sekolah', 'Paket A', 'Paket B', 'Paket C', 'SD/MI', 'SMP/MTs', 'SMA/SMK/MA', 'D-1', 'D-2', 'D-3', 'D-4', 'S-1', 'S-2', 'S-3']),
            'pekerjaan'  => fake()->randomElement(['Sudah Meninggal', 'Mengurus Rumah Tangga', 'Petani', 'Nelayan', 'Peternak', 'Buruh', 'Pedagang Kecil', 'Pedagang Besar', 'Pegawai Swasta','Guru', 'PNS', 'Dokter', 'TNI', 'Polisi', 'Dosen', 'Karyawan BUMN', 'Wiraswasta', 'Tenaga Kerja Indonesia']),
            'alamat'     => fake()->address(),
            'nomor_hp'   => fake()->regexify('/\+62[0-9]{12,15}/'),
        ];
    }
}
