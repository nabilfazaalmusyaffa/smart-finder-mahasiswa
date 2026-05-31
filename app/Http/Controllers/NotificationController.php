<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('filter', 'all');

        $query = Notification::where('user_id', $user->id)->with('sender')->orderBy('created_at', 'desc');

        if ($filter == 'unread') {
            $query->where('is_read', false);
        }

        $notifications = $query->get();

        // Group by today and earlier
        $todayNotifications = $notifications->filter(function ($item) {
            return $item->created_at->isToday();
        });

        $earlierNotifications = $notifications->filter(function ($item) {
            return !$item->created_at->isToday();
        });

        return view('notifikasi', compact('todayNotifications', 'earlierNotifications', 'filter'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if (!$notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }

        if ($notification->target_url) {
            return redirect($notification->target_url);
        }

        return back();
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return back()->with('success', 'Semua notifikasi ditandai dibaca.');
    }
}
