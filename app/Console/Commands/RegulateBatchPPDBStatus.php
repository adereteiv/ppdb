<?php

namespace App\Console\Commands;

use App\Models\BatchPPDB;
use Illuminate\Console\Command;

class RegulateBatchPPDBStatus extends Command
{
    /**
     * The name and signature of the console command.
     * The task scheduler (start after Laravel boot in AppServiceProvider) will always try to get $batch, that's why refer to handle() note
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
        /*
            - Automatically deactivate batch that hits expiry and activate the next eligible batch if its waktu_mulai has arrived.
            - If an active batch exists and another batch is being activated, deactivate the previous one.
            - In case of initial condition:
                1. Single batch, when the batch is closed, automatically (via this class) or manually (refer to PPDBAktifController@tutupPPDB):
                    -> It won't be reopened (check `Activate Eligible Batch` logic when no $x is found);
                2. No $batches whatsoever, do nothing;
            - In case of later condition:
                1. Batch that are set to close on a designated date will be automatically closed (status set to false) when it has:
                    -> status = true
                    -> waktu_mulai <= now()
                    -> waktu_tutup <= now();
                2. Multiple batches, get $batches:
                    -> Prioritize the ones that fulfils any (of the following) imposed conditions:
                        -> If any batch are past it's waktu_tutup then terminate those;
                        -> If any are to be activated, refer to Activate Eligible Batch;
            - Errors are silently ignored (Consider logging for better visibility, but maybe after sidang)
        */
        try {
            $now = now();
            $batches = BatchPPDB::orderBy('waktu_mulai', 'desc')->get();

            /*
                Deactivate Expired Batch
                1. Looks for an active batch (`status == true`) whose closing time (`waktu_tutup`) has passed.
                2. If found, marks it as inactive (`status == false`) and updates its closing time to now.
            */
            $expiredActive = $batches->first(function ($batch) use ($now) {
                return $batch->status && $now >= $batch->waktu_tutup;
            });
            if ($expiredActive) {
                $expiredActive->update(['status' => false,'waktu_tutup' => $now]);
                $this->info("BatchPPDB:ID:{$expiredActive->id} expired and deactivated.");
            }

            /*
                Activate Eligible Batch
                1. Finds a batch that:
                    - Is currently inactive or isn't yet in progress (`status == false`)
                    - Should be started (`waktu_mulai <= now`)
                    - Is not yet expired (`now < waktu_tutup`)
                2. If such a batch exists (hence the naming $x, the target batch):
                    - Deactivate any currently active batch (to enforce a one active batch at a time).
                    - Activate $x (update `status == true`)
                3. If no batch is eligible for activation, logs a 'skip' message.
            */
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
