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

    protected static function boot()
    {
        parent::boot();

        // Commit 9
        // Get its parameter from Model::create($parameter), status true if now() hit waktu_mulai
        static::creating(function ($batch) {
            $batch->status = now() >= $batch->waktu_mulai;
        });

        static::created(function ($batch) {
            // Only one active batch
            BatchPPDB::where('id', '!=', $batch->id)->where('status', true)->update(['status' => false]);

            // Update previous batch if waktu_tutup nya >= $batch->waktu_mulai, biar tutupnya pas sebelum waktu_mulai, rencana waktu_tenggat unaffected,
            // HOWEVER waktu_tenggat regulates form acceptance, SO !!REFACTOR!! Iteration 1 and Iteration 2,
            // tapi nanti paling ganti "Periode pendaftaran sudah usai, silakan menunggu pengumuman"
            // itupun dengan asumsi waktu_tenggat < waktu_tutup, karena kalau >= waktu_tutup ya udah ketutup, mana bisa ngapa-ngapain.
            // Impact lainnya juga adalah ketika now >= waktu_tutup maka admin tidak bisa melakukan perubahan apapun pada rekam-rekam yang terkait ke dalam batch tersebut
            $previousBatch = BatchPPDB::where('id', '<', $batch->id)->orderBy('id', 'desc')->first();
            if($previousBatch && $previousBatch->waktu_tutup >= $batch->waktu_mulai) {
                $previousBatch->update(['waktu_tutup' => $batch->waktu_mulai->subSecond()]);
            }
        });
        //Safety net RegulateBatchPPDBStatus
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
