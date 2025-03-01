<?php

namespace Database\Factories;

use App\Models\Pendaftaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InfoAnak>
 */
class InfoAnakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mendaftarSebagai = fake()->randomElement(['Murid Baru', 'Pindahan']);
        $data =  [
            'pendaftaran_id'    => Pendaftaran::factory(),
            'nama_anak'         => fake()->name(),
            'panggilan_anak'    => fake()->firstName(),
            'tempat_lahir'      => fake()->city(),
            'tanggal_lahir'     => fake()->dateTimeBetween('-7 years', '-4 years')->format('Y-m-d'),
            'alamat_anak'       => fake()->address(),
            'jenis_kelamin'     => fake()->randomElement(['Laki-Laki', 'Perempuan']),
            'kewarganegaraan'   => fake()->randomElement(['WNI', 'WNA Keturunan']),
            'bahasa_di_rumah'   => fake()->randomElement(['Bahasa Indonesia', 'Bahasa Asing', 'Bahasa Daerah']),
            'agama'             => fake()->randomElement(['Buddha', 'Hindu', 'Islam', 'Katolik', 'Khonghucu', 'Kristen Protestan']),
            'status_tinggal'    => fake()->randomElement(['Bersama Orang Tua', 'Bersama Wali']),
            'yang_mendaftarkan' => fake()->randomElement(['Orang Tua', 'Wali']),
            'status_anak'       => fake()->randomElement(['Anak Kandung', 'Bukan Anak Kandung']),
            'anak_ke'           => fake()->numberBetween(1, 5),
            'saudara_kandung'   => fake()->numberBetween(0, 5),
            'saudara_tiri'      => fake()->numberBetween(0, 5),
            'saudara_angkat'    => fake()->numberBetween(0, 5),
            'berat_badan'       => fake()->randomFloat(2, 10, 50),
            'tinggi_badan'      => fake()->randomFloat(2, 80, 150),
            'golongan_darah'    => fake()->randomElement(['Belum Periksa', 'O', 'AB', 'A', 'B', ]),
            'riwayat_penyakit'  => fake()->optional()->sentence(),
            'mendaftar_sebagai' => $mendaftarSebagai,
        ];
        if ($mendaftarSebagai === 'Pindahan') {
            $data = array_merge($data, [
                'sekolah_lama'     => fake()->company(),
                'tanggal_pindah'   => fake()->date(),
                'dari_kelompok'    => fake()->randomElement(['TK A', 'TK B']),
                // 'tanggal_diterima' => fake()->date(),
                'ke_kelompok'      => fake()->randomElement(['TK A', 'TK B']),
            ]);
        }
        return $data;
    }
}
