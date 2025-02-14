<?php

namespace App\Models;

use App\Models\BatchPPDB;
use App\Models\TipeDokumen;
use Illuminate\Database\Eloquent\Model;

class SyaratDokumen extends Model
{
    protected $table = 'syarat_dokumen';

    protected $fillable = ['is_wajib','keterangan_dokumen'];

    public function batchPPDB()
    {
        return $this->belongsTo(BatchPPDB::class);
    }

    public function tipeDokumen()
    {
        return $this->belongsTo(related: TipeDokumen::class);
    }
}
