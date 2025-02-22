<?php

namespace App\Models;

use App\Models\Pendaftaran;
use App\Models\SyaratDokumen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchPPDB extends Model
{
    use HasFactory;
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
