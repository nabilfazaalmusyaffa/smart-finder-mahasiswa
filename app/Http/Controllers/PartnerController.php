<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Notification;
use App\Models\Message;
use App\Models\StudyInvitation;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function show(User $user)
    {
        $viewer = Auth::user();
        if ($viewer->id == $user->id) {
            return redirect()->route('profil.saya');
        }

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        // Cek privasi
        $isPublic = true;
        if ($mahasiswa && !$mahasiswa->is_profile_public) {
            $isPublic = false;
        }

        return view('partner-profil', compact('user', 'mahasiswa', 'isPublic'));
    }

    public function invite(Request $request, User $user)
    {
        $me = Auth::user();

        if ($me->id == $user->id) {
            return back()->withErrors(['message' => 'Anda tidak bisa mengajak belajar diri sendiri.']);
        }

        // Cek atau buat conversation
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
        } else {
            $conversation->update(['last_message_at' => now()]);
        }

        // Buat Study Invitation record (Opsional, tapi untuk tracking system di kemudian hari)
        StudyInvitation::create([
            'sender_id' => $me->id,
            'receiver_id' => $user->id,
            'conversation_id' => $conversation->id,
            'status' => 'pending',
            'message' => 'Ajakan Belajar Bersama'
        ]);

        // Kirim pesan default
        $defaultMsg = "Halo, aku tertarik belajar bareng dengan kamu. Apakah kamu bersedia?";
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $me->id,
            'receiver_id' => $user->id,
            'message' => $defaultMsg,
        ]);

        // Buat Notifikasi ke Partner
        Notification::create([
            'user_id' => $user->id,
            'sender_id' => $me->id,
            'type' => 'study_invitation',
            'title' => $me->name . ' mengajak kamu belajar bersama',
            'message' => 'Belajar bareng yuk!',
            'target_url' => route('obrolan.show', $conversation->id)
        ]);

        return redirect()->route('obrolan.show', $conversation->id)
            ->with('success', 'Ajakan belajar berhasil dikirim.');
    }
}
