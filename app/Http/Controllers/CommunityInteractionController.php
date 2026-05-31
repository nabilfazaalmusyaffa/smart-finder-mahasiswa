<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\CommunityPostLike;
use App\Models\CommunityPostComment;
use App\Models\SavedPost;
use App\Models\StudyGroupMember;
use App\Models\EventParticipant;
use App\Models\Notification;
use App\Models\GroupConversation;
use App\Models\GroupConversationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityInteractionController extends Controller
{
    public function like(CommunityPost $post)
    {
        $userId = auth()->id();
        $existing = CommunityPostLike::where('post_id', $post->id)->where('user_id', $userId)->first();

        if ($existing) {
            $existing->delete();
        } else {
            CommunityPostLike::create(['post_id' => $post->id, 'user_id' => $userId]);
            // Notifikasi ke pemilik (jika bukan diri sendiri)
            if ($post->user_id !== $userId) {
                Notification::create([
                    'user_id' => $post->user_id,
                    'sender_id' => $userId,
                    'type' => 'community_like',
                    'title' => auth()->user()->name . ' menyukai postingan kamu',
                    'message' => $post->title,
                    'target_url' => route('community.show', $post->id),
                ]);
            }
        }
        return back();
    }

    public function comment(Request $request, CommunityPost $post)
    {
        $request->validate(['comment' => 'required|string|max:2000']);
        $userId = auth()->id();

        CommunityPostComment::create([
            'post_id' => $post->id,
            'user_id' => $userId,
            'comment' => $request->comment,
        ]);

        if ($post->user_id !== $userId) {
            $type = $post->category === 'qa' ? 'community_answer' : 'community_comment';
            $title = $post->category === 'qa'
                ? auth()->user()->name . ' menjawab pertanyaan kamu'
                : auth()->user()->name . ' mengomentari postingan kamu';

            Notification::create([
                'user_id' => $post->user_id,
                'sender_id' => $userId,
                'type' => $type,
                'title' => $title,
                'message' => substr($request->comment, 0, 100),
                'target_url' => route('community.show', $post->id),
            ]);
        }

        return redirect()->route('community.show', $post->id)->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function save(CommunityPost $post)
    {
        $userId = auth()->id();
        $existing = SavedPost::where('post_id', $post->id)->where('user_id', $userId)->first();

        if ($existing) {
            $existing->delete();
            return back()->with('info', 'Postingan dihapus dari tersimpan.');
        } else {
            SavedPost::create(['post_id' => $post->id, 'user_id' => $userId]);
            return back()->with('success', 'Postingan berhasil disimpan!');
        }
    }

    public function joinStudyGroup(CommunityPost $post)
    {
        $userId = auth()->id();

        // Cari atau buat group conversation untuk study group ini
        $groupConversation = GroupConversation::where('study_group_post_id', $post->id)->first();

        // Jika user sudah adalah anggota study group
        $alreadyMember = StudyGroupMember::where('post_id', $post->id)->where('user_id', $userId)->exists();

        if ($alreadyMember) {
            // Pastikan juga sudah masuk group conversation
            if ($groupConversation) {
                GroupConversationMember::firstOrCreate([
                    'group_conversation_id' => $groupConversation->id,
                    'user_id' => $userId,
                ], [
                    'role' => 'member',
                    'joined_at' => now(),
                ]);
                return redirect()->route('group-chat.show', $groupConversation->id)
                    ->with('info', 'Kamu sudah bergabung. Membuka obrolan grup...');
            }
            return back()->with('info', 'Kamu sudah bergabung di study group ini.');
        }

        // Tambahkan ke study group members
        StudyGroupMember::create(['post_id' => $post->id, 'user_id' => $userId, 'status' => 'joined']);

        // Buat group conversation jika belum ada
        if (!$groupConversation) {
            $groupConversation = GroupConversation::create([
                'study_group_post_id' => $post->id,
                'name' => $post->title,
                'description' => $post->body ? substr($post->body, 0, 255) : null,
                'created_by' => $post->user_id,
                'last_message_at' => now(),
            ]);

            // Tambahkan pembuat study group sebagai admin
            GroupConversationMember::firstOrCreate([
                'group_conversation_id' => $groupConversation->id,
                'user_id' => $post->user_id,
            ], [
                'role' => 'admin',
                'joined_at' => now(),
            ]);

            // Tambahkan semua member yang sudah ada sebelumnya
            $existingMembers = StudyGroupMember::where('post_id', $post->id)
                ->where('user_id', '!=', $post->user_id)
                ->pluck('user_id');

            foreach ($existingMembers as $memberId) {
                GroupConversationMember::firstOrCreate([
                    'group_conversation_id' => $groupConversation->id,
                    'user_id' => $memberId,
                ], [
                    'role' => 'member',
                    'joined_at' => now(),
                ]);
            }
        }

        // Tambahkan user ini ke group conversation
        $member = GroupConversationMember::firstOrCreate([
            'group_conversation_id' => $groupConversation->id,
            'user_id' => $userId,
        ], [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        if ($member->wasRecentlyCreated) {
            \App\Models\GroupMessage::create([
                'group_conversation_id' => $groupConversation->id,
                'type' => 'system_joined',
                'message' => auth()->user()->name . ' baru saja bergabung',
            ]);
        }

        // Notifikasi ke pembuat grup
        if ($post->user_id !== $userId) {
            Notification::create([
                'user_id' => $post->user_id,
                'sender_id' => $userId,
                'type' => 'study_group_join',
                'title' => auth()->user()->name . ' bergabung ke study group kamu',
                'message' => $post->title,
                'target_url' => route('group-chat.show', $groupConversation->id),
            ]);
        }

        return redirect()
            ->route('group-chat.show', $groupConversation->id)
            ->with('success', 'Berhasil bergabung ke study group!');
    }

    public function joinEvent(CommunityPost $post)
    {
        $userId = auth()->id();
        $existing = EventParticipant::where('post_id', $post->id)->where('user_id', $userId)->first();

        if ($existing) {
            return back()->with('info', 'Kamu sudah terdaftar di event ini.');
        }

        EventParticipant::create(['post_id' => $post->id, 'user_id' => $userId, 'status' => 'joined']);

        if ($post->user_id !== $userId) {
            Notification::create([
                'user_id' => $post->user_id,
                'sender_id' => $userId,
                'type' => 'event_join',
                'title' => auth()->user()->name . ' mengikuti event kamu',
                'message' => $post->title,
                'target_url' => route('community.show', $post->id),
            ]);
        }

        return back()->with('success', 'Berhasil mendaftar ke event!');
    }

    public function destroyComment(CommunityPostComment $comment)
    {
        $user = auth()->user();

        if (
            $comment->user_id !== $user->id &&
            $comment->post->user_id !== $user->id
        ) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
