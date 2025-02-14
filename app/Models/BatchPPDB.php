<?php

namespace App\Models;

use App\Models\Pendaftaran;
use App\Models\SyaratDokumen;
use Illuminate\Database\Eloquent\Model;

class BatchPPDB extends Model
{
    protected $table = 'batch_ppdb';

    protected $guarded = ['id',];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
    public function syaratDokumen()
    {
        return $this->hasMany(SyaratDokumen::class);
    }
}
