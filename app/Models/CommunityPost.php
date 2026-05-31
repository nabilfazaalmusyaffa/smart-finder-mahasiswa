<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'topic',
        'title',
        'body',
        'attachment',
        'event_date',
        'group_schedule'
    ];

    protected $casts = ['event_date' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(CommunityPostLike::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(CommunityPostComment::class, 'post_id');
    }

    public function savedBy()
    {
        return $this->hasMany(SavedPost::class, 'post_id');
    }

    public function studyGroupMembers()
    {
        return $this->hasMany(StudyGroupMember::class, 'post_id');
    }

    public function groupConversation()
    {
        return $this->hasOne(GroupConversation::class, 'study_group_post_id');
    }

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class, 'post_id');
    }

    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function isSavedBy($userId)
    {
        return $this->savedBy()->where('user_id', $userId)->exists();
    }

    public function isJoinedBy($userId)
    {
        if ($this->category === 'study_group') {
            return $this->studyGroupMembers()->where('user_id', $userId)->exists();
        }
        if ($this->category === 'event') {
            return $this->eventParticipants()->where('user_id', $userId)->exists();
        }
        return false;
    }

    public function getCategoryLabelAttribute()
    {
        return match ($this->category) {
            'diskusi' => 'Diskusi',
            'qa' => 'Q&A',
            'materi' => 'Materi',
            'study_group' => 'Study Group',
            'event' => 'Event',
            default => ucfirst($this->category),
        };
    }
}
