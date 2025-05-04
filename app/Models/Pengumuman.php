<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $guarded = ['id'];

    protected $casts = ['jadwal_posting' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }
}
