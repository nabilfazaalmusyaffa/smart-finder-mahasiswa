<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupConversationMember extends Model
{
    protected $fillable = [
        'group_conversation_id',
        'user_id',
        'role',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function groupConversation()
    {
        return $this->belongsTo(GroupConversation::class, 'group_conversation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
