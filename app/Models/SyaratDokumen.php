<?php

namespace App\Models;

use App\Models\BatchPPDB;
use App\Models\TipeDokumen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratDokumen extends Model
{
    use HasFactory;

    protected $table = 'syarat_dokumen';

    protected $guarded = ['id'];

    public function batchPPDB()
    {
        return $this->belongsTo(BatchPPDB::class, 'batch_id');
    }

    public function tipeDokumen()
    {
        return $this->belongsTo(TipeDokumen::class, 'tipe_dokumen_id');
    }
}
