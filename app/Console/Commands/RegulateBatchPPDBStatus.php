<?php

namespace App\Console\Commands;

use App\Models\BatchPPDB;
use Illuminate\Console\Command;

class RegulateBatchPPDBStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch-ppdb:regulate-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memperbarui status BatchPPDB based on waktu_mulai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $previousActive = BatchPPDB::where('status', true)->first();
		// Find all batches where waktu_mulai has passed but status is still false
		$batch = BatchPPDB::where('waktu_mulai', '<=', now())
			->where('status', false)
			->first();

		if ($batch) {
			// Deactivate previous active batch if any
			if ($previousActive) {
				$previousActive->update(['status' => false]);
			}

			// Activate new batch
			$batch->update(['status' => true]);

			$this->info('Status BatchPPDB terbaru berhasil diperbarui.');
		} else {
			$this->info('Skip. No relevant record found.');
		}
    }
}
