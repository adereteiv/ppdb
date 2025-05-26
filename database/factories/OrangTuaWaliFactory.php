<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InfoAnak;

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
            'penghasilan'=> fake()->randomElement(['Kurang dari Rp500.000','Rp500.000 - Rp1.000.000','Rp1.000.000 - Rp3.000.000','Rp3.000.000 - Rp5.000.000','Lebih dari Rp5.000.000']),
            'alamat'     => fake()->address(),
            'nomor_hp'   => '+62' . fake()->numerify('8###########')
        ];
    }
}
