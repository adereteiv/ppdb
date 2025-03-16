<?php

namespace App\Models;

use App\Models\Dokumen;
use App\Models\SyaratDokumen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeDokumen extends Model
{
    use HasFactory;

    protected $table = 'tipe_dokumen';

    protected $fillable = ['tipe'];

    public function syaratDokumen()
    {
        return $this->hasMany(SyaratDokumen::class,'tipe_dokumen_id');
    }

    public function dokumenPersyaratan()
    {
        return $this->hasMany(DokumenPersyaratan::class,'tipe_dokumen_id');
    }
}
