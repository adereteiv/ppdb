<?php

namespace App\Models;

use App\Models\Pendaftaran;
use App\Models\BuktiBayar;
use App\Models\DokumenPersyaratan;
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
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }
    public function orangTuaWali()
    {
        return $this->hasMany(OrangTuaWali::class, 'anak_id');
    }
    public function dokumenPersyaratan()
    {
        return $this->hasMany(DokumenPersyaratan::class, 'anak_id');
    }
    public function buktiBayar()
    {
        return $this->hasMany(BuktiBayar::class, 'anak_id');
    }
}
