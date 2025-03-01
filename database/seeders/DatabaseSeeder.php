<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BatchPPDB;
use App\Models\TipeDokumen;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insertOrIgnore([
            ['id' => 1, 'role' => 'admin'],
            ['id' => 2, 'role' => 'pendaftar'],
        ]);

        $users = [
            [
                'id' => 'ADM000001',
                'role_id' => 1,
                'email' => 'admin@gmail.com',
                'password' => 'adminpassword',
                'name' => 'Admin User',
            ],
            [
                'id' => 'PEN100000',
                'role_id' => 2,
                'email' => 'user@gmail.com',
                'password' => 'userpassword',
                'name' => 'Pendaftar',
            ],
            [
                'id' => 'GHO100000',
                'role_id' => 2,
                'email' => 'vadim@gmail.com',
                'password' => 'password',
                'name' => 'Ghofur Gulam',
            ],
        ];
        collect($users)->each(function ($userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'id' => $userData['id'],
                    'role_id' => $userData['role_id'],
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                ]
            );
        });

        TipeDokumen::insert([
            ['id' => 1, 'tipe' => 'Foto Anak'],
            ['id' => 2, 'tipe' => 'Kartu Keluarga'],
            ['id' => 3, 'tipe' => 'Akta Kelahiran'],
            ['id' => 4, 'tipe' => 'Kartu Tanda Penduduk'],
            ['id' => 5, 'tipe' => 'Kartu Identitas Anak'],
            ['id' => 6, 'tipe' => 'Surat Pernyataan'],
        ]);

        // $tahun_ajaran =  now()->year . '/' . (now()->year + 1);
        BatchPPDB::insert([
            'tahun_ajaran' => '2025/2026',
            'gelombang' => 1,
            'status' => true,
            'waktu_mulai' => now(),
            'waktu_tenggat' => now()->addDays(30),
            'waktu_tutup' => now()->addDays(60),
        ]);
    }
}
