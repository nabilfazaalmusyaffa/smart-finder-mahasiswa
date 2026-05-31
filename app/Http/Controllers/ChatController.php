<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\GroupConversation;
use App\Models\GroupConversationMember;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index(Request $request, $conversationId = null)
    {
        $user = Auth::user();

        // Personal conversations
        $conversations = Conversation::where(function ($q) use ($user) {
            $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
        })->with([
                    'userOne',
                    'userTwo',
                    'messages' => fn($q) => $q->latest()->limit(1),
                ])->orderBy('last_message_at', 'desc')->get();

        foreach ($conversations as $conv) {
            $conv->unread_count = Message::where('conversation_id', $conv->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();
        }

        // Group conversations for sidebar
        $groupConversations = GroupConversation::whereHas('members', fn($q) => $q->where('user_id', $user->id))
            ->with(['groupMessages' => fn($q) => $q->latest()->limit(1)])
            ->orderBy('last_message_at', 'desc')
            ->get();

        $activeConversation = null;
        $messages = collect();
        $partner = null;

        if ($conversationId) {
            $activeConversation = Conversation::where('id', $conversationId)
                ->where(function ($q) use ($user) {
                    $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
                })->firstOrFail();

            Message::where('conversation_id', $activeConversation->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            $messages = Message::where('conversation_id', $activeConversation->id)
                ->orderBy('created_at', 'asc')
                ->get();

            $partner = $activeConversation->user_one_id == $user->id
                ? $activeConversation->userTwo
                : $activeConversation->userOne;
        }

        return view('obrolan', compact(
            'conversations',
            'groupConversations',
            'activeConversation',
            'messages',
            'partner',
            'user'
        ));
    }

    public function send(Request $request, $conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::where('id', $conversationId)
            ->where(function ($q) use ($user) {
                $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
            })->firstOrFail();

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

        $receiverId = $conversation->user_one_id == $user->id
            ? $conversation->user_two_id
            : $conversation->user_one_id;

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'message' => $request->message,
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_type' => $attachmentType,
            'attachment_mime' => $attachmentMime,
            'attachment_size' => $attachmentSize,
            'is_read' => false,
        ]);

        $conversation->update(['last_message_at' => now()]);

        // Notification to receiver
        if ($attachmentPath) {
            Notification::create([
                'user_id' => $receiverId,
                'sender_id' => $user->id,
                'type' => 'chat_file',
                'title' => $user->name . ' mengirim file di obrolan',
                'message' => $attachmentName ?? 'File',
                'target_url' => route('obrolan.show', $conversation->id),
            ]);
        }

        return redirect()->route('obrolan.show', $conversation->id);
    }

    public function startConversation(User $user)
    {
        $me = Auth::user();
        if ($me->id == $user->id) {
            return back()->withErrors(['message' => 'Anda tidak bisa memulai obrolan dengan diri sendiri.']);
        }

        $conversation = Conversation::where(function ($q) use ($me, $user) {
            $q->where('user_one_id', $me->id)->where('user_two_id', $user->id);
        })->orWhere(function ($q) use ($me, $user) {
            $q->where('user_one_id', $user->id)->where('user_two_id', $me->id);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $me->id,
                'user_two_id' => $user->id,
                'last_message_at' => now(),
            ]);
        }

        return redirect()->route('obrolan.show', $conversation->id);
    }

    public function destroyMessage(Message $message)
    {
        if ($message->sender_id !== auth()->id()) {
            abort(403);
        }

        if ($message->attachment_path) {
            Storage::disk('public')->delete($message->attachment_path);
        }

        $message->delete();

        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
