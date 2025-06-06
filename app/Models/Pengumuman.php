<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $guarded = ['id'];

    protected $casts = [
        'jadwal_posting' => 'datetime',
        'file_paths' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }
}
