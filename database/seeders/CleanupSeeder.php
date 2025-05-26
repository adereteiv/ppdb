<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Pendaftaran,InfoAnak,User};

/**
 * Open source, made by adereteiv
 */
class CleanupSeeder extends Seeder
{
    public function run()
    {
        // Made to be used alongside InitialUserPopulate

        // Adjust the following conditions based on your case to target only seeded records (e.g., by created_at timestamp, or any special marker, you define.)
        // These records are deleted based on created_at, refer to InitialUserPopulate
        InfoAnak::where('created_at', '>=', now()->subMinutes(30))->delete();
        Pendaftaran::where('created_at', '>=', now()->subMinutes(30))->delete();
        User::where('created_at', '>=', now()->subMinutes(30))->delete();
    }
}
