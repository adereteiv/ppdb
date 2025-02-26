<?php

namespace App\Models;

use App\Models\User;
use App\Models\InfoAnak;
use App\Models\BatchPPDB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $guarded = ['id'];

    public function batchPPDB()
    {
        return $this->belongsTo(BatchPPDB::class, 'batch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function infoAnak()
    {
        return $this->hasOne(InfoAnak::class,'pendaftaran_id');
    }
}
