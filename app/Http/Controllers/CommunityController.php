<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'semua');
        $topic = $request->query('topic');

        $posts = CommunityPost::with(['user', 'user.mahasiswa', 'likes', 'comments', 'savedBy', 'studyGroupMembers', 'eventParticipants', 'groupConversation'])
            ->when($category && $category !== 'semua', fn($q) => $q->where('category', $category))
            ->when($topic, fn($q) => $q->where('topic', $topic))
            ->latest()
            ->get();

        $userId = auth()->id();
        return view('komunitas', compact('posts', 'category', 'topic', 'userId'));
    }

    public function store(Request $request)
    {
        $rules = [
            'category' => 'required|in:diskusi,qa,materi,study_group,event',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'topic' => 'nullable|string|max:100',
        ];

        if ($request->category === 'event') {
            $rules['event_date'] = 'required|date';
        }
        if ($request->category === 'study_group') {
            $rules['group_schedule'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('community', 'public');
        }

        $post = CommunityPost::create($validated);

        if ($post->category === 'study_group') {
            $groupConversation = \App\Models\GroupConversation::create([
                'study_group_post_id' => $post->id,
                'name' => $post->title,
                'description' => $post->body ? substr($post->body, 0, 255) : null,
                'created_by' => $post->user_id,
                'last_message_at' => now(),
            ]);

            \App\Models\GroupConversationMember::create([
                'group_conversation_id' => $groupConversation->id,
                'user_id' => $post->user_id,
                'role' => 'admin',
                'joined_at' => now(),
            ]);
        }

        return redirect()->route('community.index')->with('success', 'Postingan berhasil dibuat!');
    }

    public function show(CommunityPost $post)
    {
        $post->load(['user', 'user.mahasiswa', 'likes', 'comments.user', 'savedBy', 'studyGroupMembers', 'eventParticipants', 'groupConversation']);
        $userId = auth()->id();
        return view('komunitas-detail', compact('post', 'userId'));
    }

    public function destroy(CommunityPost $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        if ($post->attachment) {
            Storage::disk('public')->delete($post->attachment);
        }

        $post->delete();

        return redirect()->route('community.index')->with('success', 'Postingan berhasil dihapus.');
    }
}
