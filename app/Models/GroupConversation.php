<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupConversation extends Model
{
    protected $fillable = [
        'study_group_post_id',
        'name',
        'description',
        'created_by',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function studyGroupPost()
    {
        return $this->belongsTo(CommunityPost::class, 'study_group_post_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->hasMany(GroupConversationMember::class, 'group_conversation_id');
    }

    public function groupMessages()
    {
        return $this->hasMany(GroupMessage::class, 'group_conversation_id');
    }

    public function isMember($userId): bool
    {
        return $this->members()->where('user_id', $userId)->exists();
    }
}
