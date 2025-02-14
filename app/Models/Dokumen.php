<?php

namespace App\Models;

use App\Models\InfoAnak;
use App\Models\TipeDokumen;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumen';

    protected $guarded = 'id';

    public function infoAnak()
    {
        return $this->belongsTo(InfoAnak::class);
    }

    public function tipeDokumen()
    {
        return $this->belongsTo(TipeDokumen::class);
    }
}
