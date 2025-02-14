<?php

namespace App\Models;

use App\Models\User;
use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = ['status','catatan_admin'];

    public function batchPPDB()
    {
        return $this->belongsTo(BatchPPDB::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function infoAnak()
    {
        return $this->hasOne(InfoAnak::class);
    }
}
