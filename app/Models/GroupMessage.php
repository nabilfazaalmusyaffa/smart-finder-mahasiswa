<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    protected $fillable = [
        'group_conversation_id',
        'sender_id',
        'type',
        'message',
        'attachment_path',
        'attachment_name',
        'attachment_type',
        'attachment_mime',
        'attachment_size',
    ];

    public function groupConversation()
    {
        return $this->belongsTo(GroupConversation::class, 'group_conversation_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
