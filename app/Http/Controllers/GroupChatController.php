<?php

namespace App\Http\Controllers;

use App\Models\GroupConversation;
use App\Models\GroupConversationMember;
use App\Models\GroupMessage;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GroupChatController extends Controller
{
    public function show(GroupConversation $groupConversation)
    {
        $user = Auth::user();

        // Only members can view this group chat
        if (!$groupConversation->isMember($user->id)) {
            abort(403, 'Kamu bukan anggota grup ini.');
        }

        $messages = GroupMessage::where('group_conversation_id', $groupConversation->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $members = GroupConversationMember::where('group_conversation_id', $groupConversation->id)
            ->with('user')
            ->get();

        // Load the user's personal conversations for sidebar
        $personalConversations = \App\Models\Conversation::where(function ($q) use ($user) {
            $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
        })->with(['userOne', 'userTwo', 'messages' => fn($q) => $q->latest()->limit(1)])
            ->orderBy('last_message_at', 'desc')
            ->get();

        foreach ($personalConversations as $conv) {
            $conv->unread_count = \App\Models\Message::where('conversation_id', $conv->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();
        }

        // Load group conversations for sidebar
        $groupConversations = GroupConversation::whereHas('members', fn($q) => $q->where('user_id', $user->id))
            ->with(['groupMessages' => fn($q) => $q->latest()->limit(1)])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('group-chat', compact(
            'groupConversation',
            'messages',
            'members',
            'personalConversations',
            'groupConversations',
            'user'
        ));
    }

    public function send(Request $request, GroupConversation $groupConversation)
    {
        $user = Auth::user();

        if (!$groupConversation->isMember($user->id)) {
            abort(403, 'Kamu bukan anggota grup ini.');
        }

        $request->validate([
            'message' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,jpg,jpeg,png,webp,mp4,mov,avi,mkv|max:51200',
        ]);

        if (!$request->filled('message') && !$request->hasFile('attachment')) {
            return back()->withErrors(['message' => 'Tulis pesan atau pilih file terlebih dahulu.']);
        }

        $attachmentPath = null;
        $attachmentName = null;
        $attachmentMime = null;
        $attachmentSize = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentName = $file->getClientOriginalName();
            $attachmentMime = $file->getMimeType();
            $attachmentSize = $file->getSize();
            $attachmentPath = $file->store('chat-attachments', 'public');

            if (str_starts_with($attachmentMime, 'video/')) {
                $attachmentType = 'video';
            } elseif (str_starts_with($attachmentMime, 'image/')) {
                $attachmentType = 'image';
            } else {
                $attachmentType = 'document';
            }
        }

        GroupMessage::create([
            'group_conversation_id' => $groupConversation->id,
            'sender_id' => $user->id,
            'message' => $request->message,
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_type' => $attachmentType,
            'attachment_mime' => $attachmentMime,
            'attachment_size' => $attachmentSize,
        ]);

        $groupConversation->update(['last_message_at' => now()]);

        // Notify other members
        $otherMembers = GroupConversationMember::where('group_conversation_id', $groupConversation->id)
            ->where('user_id', '!=', $user->id)
            ->pluck('user_id');

        foreach ($otherMembers as $memberId) {
            $title = $attachmentPath
                ? $user->name . ' mengirim file di ' . $groupConversation->name
                : $user->name . ' mengirim pesan di ' . $groupConversation->name;

            Notification::create([
                'user_id' => $memberId,
                'sender_id' => $user->id,
                'type' => 'group_message',
                'title' => $title,
                'message' => $request->message ? substr($request->message, 0, 100) : ($attachmentName ?? ''),
                'target_url' => route('group-chat.show', $groupConversation->id),
            ]);
        }

        return redirect()->route('group-chat.show', $groupConversation->id);
    }

    public function destroyMessage(GroupMessage $message)
    {
        $user = Auth::user();

        $isSender = $message->sender_id === $user->id;

        $isAdmin = $message->conversation
            ->members()
            ->where('user_id', $user->id)
            ->where('role', 'admin')
            ->exists();

        if (!$isSender && !$isAdmin) {
            abort(403);
        }

        if ($message->attachment_path) {
            Storage::disk('public')->delete($message->attachment_path);
        }

        $message->delete();

        return back()->with('success', 'Pesan grup berhasil dihapus.');
    }

    public function leave(GroupConversation $groupConversation)
    {
        $user = Auth::user();

        if (!$groupConversation->isMember($user->id)) {
            abort(403);
        }

        // Create system message
        GroupMessage::create([
            'group_conversation_id' => $groupConversation->id,
            'type' => 'system_left',
            'message' => $user->name . ' baru saja keluar',
        ]);

        $groupConversation->update(['last_message_at' => now()]);

        // Remove from group conversation members
        GroupConversationMember::where('group_conversation_id', $groupConversation->id)
            ->where('user_id', $user->id)
            ->delete();

        // If it's a study group, also remove from study group members
        if ($groupConversation->study_group_post_id) {
            \App\Models\StudyGroupMember::where('post_id', $groupConversation->study_group_post_id)
                ->where('user_id', $user->id)
                ->delete();
        }

        return redirect()->route('obrolan.index')->with('success', 'Berhasil keluar dari grup.');
    }
}
