@php
    $actionUrl = route('notifikasi.read', $notif->id);
    if ($notif->is_read && $notif->target_url) {
        $actionUrl = $notif->target_url;
    }
@endphp
<a href="{{ $notif->target_url ? '#' : 'javascript:void(0)' }}"
    onclick="event.preventDefault(); document.getElementById('notif-form-{{ $notif->id }}').submit();"
    class="notif-card {{ $notif->is_read ? 'read' : '' }}">

    <div class="notif-avatar">
        @if($notif->sender && $notif->sender->avatar)
            <img src="{{ asset($notif->sender->avatar) }}" style="width:100%; height:100%; object-fit:cover;">
        @else
            {{ $notif->sender ? strtoupper(substr($notif->sender->name, 0, 1)) : '!' }}
        @endif
    </div>

    <div class="notif-body">
        <div class="notif-title">{{ $notif->title }}</div>
        <div class="notif-msg">{{ Str::limit($notif->message, 80) }}</div>
    </div>

    <div class="notif-meta">
        <div>{{ $notif->created_at->diffForHumans() }}</div>
        @if(!$notif->is_read)
            <div class="notif-unread-dot"></div>
        @endif
    </div>

    <form id="notif-form-{{ $notif->id }}" action="{{ route('notifikasi.read', $notif->id) }}" method="POST"
        style="display: none;">
        @csrf
        @method('PATCH')
    </form>
</a>