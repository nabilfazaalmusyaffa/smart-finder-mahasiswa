<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
        'read_at',
        'attachment_path',
        'attachment_name',
        'attachment_type',
        'attachment_mime',
        'attachment_size',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
