<?php

namespace App\Models;

use App\Models\Pendaftaran;
use App\Models\SyaratDokumen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchPPDB extends Model
{
    use HasFactory;
    protected $table = 'batch_ppdb';

    protected $guarded = ['id'];

    /** Commit 11
     * Agar tidak dianggap sebagai string dan real Carbon datetime instance
     */
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_tenggat' => 'datetime',
        'waktu_tutup' => 'datetime',
    ];

    protected static function booted()
    {
        // Get its parameter from Model::create($parameter), status true if now() hit waktu_mulai
        static::creating(function ($batch) {
            $batch->status = now() >= $batch->waktu_mulai;
        });

        static::created(function ($batch) { // $batch auto-assigned from event BatchPPDB::create
            /** ----- NOTE FOR DOCUMENTATION ----- !!!
             * Possible cases:
             * 1. if $batch->status === true :
             *      - update(['status'=>false]) untuk ppdb lain yang masih aktif,
             *      - jika tidak ada rekam ppdb lain then all's good;
             *      - && $previousBatch, regardless of status true/false, update it's waktu_tutup if it's >= $batch->waktu_mulai,
             *      - !$previousBatch->status === false, jalankan ini;
             * 2. if $batch->status === false:
             *      - maka akan ditangkap oleh RegulateBatchPPDBStatus (safety net);
             */

            // Only one active batch
            // If $batch->status === true, nonaktifkan PPDB yang sedang aktif
            if ($batch->status) {
                self::where('id', '!=', $batch->id)->where('status', true)->update(['status' => false]);
            }

            // Separate if because waktu_tutup update is a separate matter, so it can't and shouldn't depend on the above if ($batch->status){}
            // If it does, then it would only work when $batch->status === true, while we also want it to work when ($batch->status === false) so the timeline doesn't overlap with each other
            $previousBatch = self::where('waktu_mulai', '<', $batch->waktu_mulai)->orderBy('waktu_mulai', 'desc')->first();
            if ($previousBatch && $previousBatch->waktu_tutup >= $batch->waktu_mulai) {
                $previousBatch->update(['waktu_tutup' => $batch->waktu_mulai->copy()->subSecond()]);
            }

            /** ---- NOTE ---- !!!
             * Update previous batch if ($previousBatch->waktu_tutup >= $batch->waktu_mulai) agar tutupnya pas sebelum waktu_mulai, rencana waktu_tenggat unaffected,
             * HOWEVER waktu_tenggat regulates form acceptance, SO !!REFACTOR!! Iteration 1 and Iteration 2,
             * tapi nanti paling ganti "Periode pendaftaran sudah usai, silakan menunggu pengumuman"
             * itupun dengan asumsi (waktu_tenggat < waktu_tutup), karena kalau (waktu_tenggat >= waktu_tutup) ya udah ketutup mana bisa ngapa-ngapain.
             * Impact lainnya juga adalah ketika now() >= waktu_tutup, maka admin tidak bisa melakukan perubahan apapun pada rekam-rekam yang terkait ke dalam batch tersebut
             */
        });
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'batch_id');
    }

    public function syaratDokumen()
    {
        return $this->hasMany(SyaratDokumen::class, 'batch_id');
    }
}
