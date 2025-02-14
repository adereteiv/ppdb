<?php

namespace App\Models;

use App\Models\InfoAnak;
use Illuminate\Database\Eloquent\Model;

class BuktiBayar extends Model
{
    protected $table = 'bukti_bayar';

    protected $guarded = ['id',];

    public function infoAnak()
    {
        return $this->belongsTo(InfoAnak::class);
    }
}
