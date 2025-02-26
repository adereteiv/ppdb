<?php

namespace App\Models;

use App\Models\InfoAnak;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrangTuaWali extends Model
{
    use HasFactory;

    protected $table = 'orang_tua_wali';

    protected $guarded = ['id',];

    public function infoAnak()
    {
        return $this->belongsTo(InfoAnak::class, 'anak_id');
    }
}
