<?php

namespace App\Console\Commands;

use App\Models\BatchPPDB;
use Illuminate\Console\Command;

class RegulateBatchPPDBStatus extends Command
{
    /**
     * The name and signature of the console command.
     * The task scheduler (start after Laravel boot in AppServiceProvider) will always try to get $batch, that's why (refer to: Possible cases)
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
        // BatchPPDB@boot status:false catcher

        /** ----- NOTE FOR DOCUMENTATION ----- !!!
         * Get $batch from batch_ppdb dengan batasan 'waktu_mulai <= now()' dan statusnya 'false':
         *
         * if ($latestActive = n) maka record(status false) berupa '..., [n-2], [n-1], [n+1], dst...' akan tersaring;
         *      - We want [n] to be deactivated and [n+1] is due to start in two days at noon, so we have to:
         *      - Select [n+1] by querying
         *      - orderBy('waktu_mulai', 'desc')->first();
         *      - sort the records in a descending order '[n+1], [n], [n-1]...' and pick the top result, which is [n+1].
         *
         * if (!$latestActive) then do this right away:
         *      - $batch->update(['status' => true]);
         *
         * if ($batch = n) maka record(status false) berupa '...[n-2], [n-1], [n]' akan tersaring;
         *      - We want [n] to be activated, so we have to:
         *      - Select [n] by querying
         *      - orderBy('waktu_mulai', 'desc')->first();
         *      - sort the records in a descending order '[n], [n-1], [n-2]...' and pick the top result, which is [n].
         *
         * As long as time is linear, this logic cannot be flawed (pun intended XD)
         */

        // welp, bug found
        /*
		$batch = BatchPPDB::where('waktu_mulai', '<=', now())
        ->where('status', false)
        ->orderBy('waktu_mulai', 'desc')
        ->first();

        $activeBatch = BatchPPDB::where('status', true)->first();

		if ($batch && (!$activeBatch || $batch->waktu_mulai > $activeBatch->waktu_mulai)) {
			if ($activeBatch) {
				$activeBatch->update(['status' => false]);
			}

			$batch->update(['status' => true]);

			$this->info('Status BatchPPDB terbaru berhasil diperbarui.');
		} else {
			$this->info('Skip. No relevant record needs updating.');
		}
        */

        // Commit 11 - Refactored logic, learn as we go
        // refer to sacred note
        // without try catch block, it will keep returning error alert
        try {
            $now = now();
            $batches = BatchPPDB::orderBy('waktu_mulai', 'desc')->get();

            // check if any batch is due to close
            $expiredActive = $batches->first(function ($batch) use ($now) {
                return $batch->status && $now >= $batch->waktu_tutup;
            });
            if ($expiredActive) {
                $expiredActive->update(['status' => false,'waktu_tutup' => $now]);
                $this->info("BatchPPDB:ID:{$expiredActive->id} expired and deactivated.");
            }

            // check if any batch is due to activate ((isn't active = hasn't started) + has waktu_tutup in the future) = planned to be activated
            $x = $batches->first(function ($batch) use ($now) {
                return !$batch->status && $batch->waktu_mulai <= $now && $now < $batch->waktu_tutup;
            });
            if ($x) {
                $activeBatch = $batches->firstWhere('status', true);
                if ($activeBatch && $activeBatch->id !== $x->id) {
                    $activeBatch->update(['status' => false, 'waktu_tutup' => $now,]);
                }
                $x->update(['status' => true]);

                $this->info('BatchPPDB:ID:{$x->id} activated.');
            } else {
                $this->info('Skip. No batch to activate.');
            }
        } catch (\Exception $e) {
            return;
        }
    }
}
    /** Possible cases:
     * $batch will always be status === false and has waktu_mulai <= now(), HOWEVERRRR....
     * if the $batch is not the one intended for status change, considering the filter, now this is where it gets tricky...
     * Because task scheduler always runs therefore it will always look for $batch:
     * Assume ($activeBatch = n) and it is currently in progress, so we don't want a sudden change, BUT...
     * [n-1], [n-2], [n-3], ...
     * It will then have $batch = [n-1] and this is leading to a big nuh-uh situation if it's allowed to progress even further...
     * So, hopefully by imposing this condition (assume b = $batch->waktu_mulai and a = $activeBatch->waktu_mulai):
     *      if ($batch && (!$activeBatch || b > a )) {}
     * it will enforce so that it will run ONLY if (it = batch-ppdb:regulate-status) is called during this timeframe:
     *      (b > it >= a)
     * So when n is in progress: the timeframe becomes (a > it >= b) and the condition is deemed invalid.
     * As long as time is linear, this logic cannot be flawed (it's serious now).
     *
     * if it passes : if ($batch && (!$activeBatch || a > b )) {}
     *      if $batch && $activeBatch, then update $activeBatch status to false, then hit the $batch->update().
     *      if $batch && !$activeBatch, the case for a fresh application with no batch_ppdb records, hit the $batch->update() straight away.
     */
