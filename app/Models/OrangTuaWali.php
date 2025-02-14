<?php

namespace App\Models;

use App\Models\InfoAnak;
use Illuminate\Database\Eloquent\Model;

class OrangTuaWali extends Model
{
    protected $table = 'orang_tua_wali';

    protected $guarded = ['id',];

    public function infoAnak()
    {
        return $this->belongsTo(InfoAnak::class);
    }
}
