<?php

namespace App\Models;

use App\Models\User;
use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $guarded = ['id'];

    protected $keyType = 'string'; // important for custom ID assignment

    public $incrementing = false; // important for custom ID assignment

    protected static function booted()
    {
        static::creating(function($pendaftaran) {
            $batch = BatchPPDB::find($pendaftaran->batch_id);

            $tahunAjaranRaw = explode('/', $batch->tahun_ajaran);
            $tahunAjaran = implode('', array_map(fn($t) => substr($t, 2), $tahunAjaranRaw));

            $gelombang = $batch->gelombang;
            $prefix = $tahunAjaran . $gelombang;

            do{ //Refined using do-while block, refer to Models/User
                $latestId = self::where('id', 'like', "$prefix%")
                    ->orderByDesc('id')
                    ->value('id');

                if ($latestId) {
                    $lastNumber = (int) substr($latestId, -3);
                    $nextNumber = $lastNumber + 1;
                } else {
                    $nextNumber = 1;
                }

                $sequence = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                $newId = $prefix . $sequence;
            } while ((self::where('id', $newId)->exists()));

            $pendaftaran->id = $newId;
        });
    }

    public function batchPPDB()
    {
        return $this->belongsTo(BatchPPDB::class, 'batch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function infoAnak()
    {
        return $this->hasOne(InfoAnak::class, 'pendaftaran_id');
    }
}
