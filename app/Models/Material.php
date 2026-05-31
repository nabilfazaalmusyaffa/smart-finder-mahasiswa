<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'topic',
        'type',
        'description',
        'file_path',
        'file_name',
        'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            'pdf' => 'PDF Modul',
            'video' => 'Video Rekaman',
            'modul' => 'Modul Belajar',
            'link' => 'Link Materi',
            default => strtoupper($this->type),
        };
    }

    public function getTypeBadgeClassAttribute()
    {
        return match ($this->type) {
            'pdf' => 'materi-type-pdf',
            'video' => 'materi-type-video',
            'modul' => 'materi-type-modul',
            'link' => 'materi-type-link',
            default => 'materi-type-pdf',
        };
    }
}
