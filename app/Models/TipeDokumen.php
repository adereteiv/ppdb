<?php

namespace App\Models;

use App\Models\Dokumen;
use App\Models\SyaratDokumen;
use Illuminate\Database\Eloquent\Model;

class TipeDokumen extends Model
{
    protected $table = 'tipe_dokumen';
    protected $fillable = ['tipe'];

    public function syaratDokumen()
    {
        return $this->hasMany(SyaratDokumen::class,'tipe_dokumen_id');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class,'tipe_dokumen_id');
    }
}
