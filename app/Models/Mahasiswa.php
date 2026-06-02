<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'phone',
        'jurusan',
        'skill',
        'minat_belajar',
        'jadwal_kosong',
        'program_studi',
        'universitas',
        'foto_profil',
        'topik_minat',
        'keahlian_custom',
 
        'profile_completed',
        'reset_code',
        'reset_code_expires_at',
        // Google OAuth
        'google_id',
        'avatar',
        'provider',
        'angkatan',
        'bio',
        'portfolio_link',
        'is_profile_public',
        'is_online_visible',
        'message_permission',
        'tingkat_kemampuan',
        'waktu_belajar',
    ];

    protected $hidden = [
        'password',
        'reset_code',
    ];

    protected $casts = [
        'profile_completed' => 'boolean',
        'reset_code_expires_at' => 'datetime',
        'is_profile_public' => 'boolean',
        'is_online_visible' => 'boolean',
        'waktu_belajar' => 'array',
    ];
}