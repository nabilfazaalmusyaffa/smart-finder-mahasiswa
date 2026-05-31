<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'provider',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            'last_seen' => 'datetime',
            'is_online' => 'boolean',
        ];
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function getOnlineStatusAttribute()
    {
        if (!$this->last_seen) {
            return 'offline';
        }
        return $this->last_seen->gt(now()->subMinutes(5)) ? 'online' : 'offline';
    }

    public function getIsCurrentlyOnlineAttribute()
    {
        return $this->last_seen && $this->last_seen->gt(now()->subMinutes(5));
    }
}
