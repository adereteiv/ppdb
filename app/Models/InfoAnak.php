<?php

namespace App\Models;

use App\Models\Dokumen;
use App\Models\BuktiBayar;
use App\Models\Pendaftaran;
use App\Models\OrangTuaWali;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoAnak extends Model
{
    use HasFactory;

    protected $table = 'info_anak';

    protected $guarded = ['id',];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
    public function orangTuaWali()
    {
        return $this->hasMany(OrangTuaWali::class);
    }
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }
    public function buktiBayar()
    {
        return $this->hasMany(BuktiBayar::class);
    }
}
