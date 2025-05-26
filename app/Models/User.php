<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Pendaftaran;
use App\Models\Pengumuman;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';

    protected $guarded = ['id'];
    // protected $fillable = ['name','email','password','role_id'];

    // https://medium.com/@online-web-tutor/laravel-how-to-disable-primary-key-auto-increment-in-model-ee6416b49871
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password','remember_token',];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        /**
         * Semua akun yang dibuat lewat create event, then role otomatis 'pendaftar' and the id of that is 2
         */
        static::creating(function ($user) {
            if (!isset($user->id)){
                do{
                    $firstname = explode(' ',trim($user->name))[0];
                    $inisial = strtoupper(substr($firstname ?? 'PD', 0, 3));
                    $random = strtoupper(substr(Str::uuid()->toString(), 0, 8));
                    $userId = $inisial . $random;
                } while ((self::where('id', $userId)->exists()));

                $user->id = $userId;
            }

            if (!isset($user->role_id)){
                $user->role_id = 2;
            }
        });
    }

    public function Pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class,'user_id');
    }

    public function Pengumuman(){
        return $this->hasMany(Pengumuman::class,'posted_by');
    }
}
