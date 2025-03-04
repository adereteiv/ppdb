<?php

namespace App\Models;

use App\Models\InfoAnak;
use App\Models\TipeDokumen;
use Illuminate\Database\Eloquent\Model;

class DokumenPersyaratan extends Model
{
    protected $table = 'dokumen_persyaratan';

    protected $guarded = ['id'];

    public function infoAnak()
    {
        return $this->belongsTo(InfoAnak::class, 'anak_id');
    }

    public function tipeDokumen()
    {
        return $this->belongsTo(TipeDokumen::class, 'tipe_dokumen_id');
    }
}
