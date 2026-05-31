@extends('layouts.dashboard')

@section('title', 'Obrolan – Smart Finder')

@section('styles')
<style>
.chat-container {
    display: flex;
    height: calc(100vh - 48px);
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    overflow: hidden;
    margin: -12px;
}
/* Sidebar */
.chat-sidebar {
    width: 320px;
    border-right: 1px solid var(--gray-200);
    display: flex;
    flex-direction: column;
    background: #FAFAFA;
}
.chat-sidebar-header {
    padding: 20px;
    border-bottom: 1px solid var(--gray-200);
    background: var(--white);
}
.chat-sidebar-header h2 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
.chat-sidebar-header p { font-size: 12px; color: var(--gray-500); }
.chat-search { margin-top: 12px; position: relative; }
.chat-search input { width: 100%; padding: 8px 12px 8px 36px; border: 1px solid var(--gray-300); border-radius: 20px; font-size: 13px; outline: none; }
.chat-search svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; stroke: var(--gray-400); fill: none; }
.chat-section-label { padding: 10px 20px 4px; font-size: 10px; font-weight: 700; color: var(--gray-400); text-transform: uppercase; letter-spacing: 1px; }
.chat-list { flex-grow: 1; overflow-y: auto; }
.chat-item {
    display: flex; padding: 14px 20px; border-bottom: 1px solid var(--gray-100);
    cursor: pointer; transition: background .2s; text-decoration: none; color: inherit;
}
.chat-item:hover { background: var(--gray-100); }
.chat-item.active { background: #E0F2FE; border-left: 4px solid var(--blue); padding-left: 16px; }
.chat-item-avatar {
    width: 44px; height: 44px; border-radius: 50%; background: var(--blue);
    color: var(--white); display: flex; align-items: center; justify-content: center;
    font-weight: 700; margin-right: 12px; position: relative; flex-shrink: 0; font-size: 14px;
}
.chat-item-avatar.group-avatar { background: linear-gradient(135deg, #7c3aed, #2563eb); font-size: 12px; border-radius: 12px; }
.chat-online-badge { position: absolute; bottom: 2px; right: 2px; width: 11px; height: 11px; border: 2px solid var(--white); border-radius: 50%; }
.chat-online-badge.online { background: #10B981; }
.chat-online-badge.offline { background: #9ca3af; }
.chat-item-body { flex-grow: 1; min-width: 0; }
.chat-item-name { font-size: 14px; font-weight: 700; margin-bottom: 3px; display: flex; justify-content: space-between; align-items: center; }
.chat-item-time { font-size: 11px; color: var(--gray-500); font-weight: 400; }
.chat-item-preview { font-size: 12px; color: var(--gray-500); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.chat-unread-badge { background: var(--blue); color: var(--white); font-size: 11px; padding: 2px 6px; border-radius: 10px; font-weight: 700; margin-left: auto; display: inline-block; margin-top: 4px; }
.group-badge { background: #7c3aed; color: #fff; font-size: 9px; font-weight: 700; padding: 2px 7px; border-radius: 99px; margin-left: 6px; letter-spacing: 0.5px; }

/* Main */
.chat-main { flex-grow: 1; display: flex; flex-direction: column; background: #F8FAFC; }
.chat-main-header { padding: 16px 24px; background: var(--white); border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; }
.chat-main-user { display: flex; align-items: center; gap: 12px; }
.chat-main-header .back-btn { display: none; align-items: center; gap: 6px; font-size: 13px; color: var(--blue); font-weight: 600; text-decoration: none; padding: 6px 14px; background: #E0F2FE; border-radius: 8px; margin-right: 4px; }
.chat-main-user-info h3 { font-size: 16px; font-weight: 700; margin-bottom: 2px; }
.chat-main-user-info p { font-size: 12px; color: #10B981; font-weight: 500; }
.status-dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; margin-right: 6px; }
.status-dot.online { background: #22c55e; }
.status-dot.offline { background: #9ca3af; }
.chat-user-status { display: flex; align-items: center; font-size: 13px; color: var(--gray-600); margin-top: 3px; }
.chat-messages { flex-grow: 1; padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; }
.chat-date-separator { text-align: center; margin: 8px 0; }
.chat-date-separator span { background: var(--gray-200); color: var(--gray-600); font-size: 11px; padding: 4px 12px; border-radius: 12px; }
.chat-bubble-row { display: flex; width: 100%; }
.chat-bubble-row.me { justify-content: flex-end; }
.chat-bubble { max-width: 60%; padding: 12px 16px; border-radius: 16px; font-size: 14px; line-height: 1.5; position: relative; }
.chat-bubble-row.them .chat-bubble { background: var(--white); color: var(--dark); border: 1px solid var(--gray-200); border-bottom-left-radius: 4px; }
.chat-bubble-row.me .chat-bubble { background: var(--blue); color: var(--white); border-bottom-right-radius: 4px; }
.chat-bubble-time { font-size: 10px; margin-top: 4px; text-align: right; display: block; opacity: 0.7; }
.message-meta { margin-top: 6px; font-size: 11px; opacity: 0.8; display: flex; gap: 8px; justify-content: flex-end; align-items: center; }
.message-status.sent { color: #dbeafe; }
.message-status.read { color: #bbf7d0; font-weight: 600; }

/* Attachment display */
.chat-image-preview { max-width: 220px; max-height: 180px; border-radius: 12px; display: block; object-fit: cover; cursor: pointer; margin-bottom: 6px; }
.chat-video-preview { max-width: 280px; border-radius: 12px; display: block; margin-bottom: 6px; }
.chat-file-card { display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: rgba(255,255,255,0.15); border-radius: 10px; text-decoration: none; color: inherit; margin-bottom: 6px; }
.chat-bubble-row.them .chat-file-card { background: var(--gray-100); color: var(--dark); }
.chat-file-icon { width: 36px; height: 36px; background: rgba(255,255,255,0.25); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.chat-bubble-row.them .chat-file-icon { background: var(--blue); }
.chat-file-icon svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; }
.chat-file-info { min-width: 0; }
.chat-file-name { font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 160px; }
.chat-file-size { font-size: 11px; opacity: 0.7; }

/* Input area */
.chat-input-area { padding: 14px 24px; background: var(--white); border-top: 1px solid var(--gray-200); }
.chat-input-area form { display: flex; width: 100%; align-items: flex-end; gap: 10px; }
.chat-input-inner { flex-grow: 1; background: #F1F5F9; border: 1px solid var(--gray-200); border-radius: 20px; padding: 10px 16px; display: flex; flex-direction: column; gap: 6px; }
.chat-input-field { background: transparent; border: none; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; width: 100%; resize: none; }
.chat-file-preview-bar { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--blue); font-weight: 600; padding: 4px 0; border-top: 1px solid var(--gray-200); }
.chat-file-preview-bar button { background: none; border: none; cursor: pointer; color: var(--gray-400); font-size: 16px; line-height: 1; padding: 0; display: flex; align-items: center; }
.chat-file-preview-bar button:hover { color: var(--red); }

.chat-attach-btn {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    border: 1px solid #dbe3ef;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2563eb;
    cursor: pointer;
    transition: 0.2s ease;
    flex-shrink: 0;
}
.chat-attach-btn:hover {
    background: #eaf4ff;
    border-color: #2563eb;
}
.chat-attach-btn svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 2; }

.chat-send-btn { width: 44px; height: 44px; border-radius: 50%; background: var(--blue); color: var(--white); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .2s; flex-shrink: 0; }
.chat-send-btn:hover { background: #1d4ed8; }
.chat-send-btn svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; }
.chat-empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: var(--gray-500); text-align: center; }
.chat-empty-state svg { width: 64px; height: 64px; stroke: var(--gray-300); fill: none; margin-bottom: 16px; }
.chat-back-icon { display: none; border: none; background: transparent; color: var(--blue); cursor: pointer; }

/* MOBILE CHAT STYLES */
@media (max-width: 768px) {
    html, body {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    .main-content, .content, .page-content {
        width: 100% !important;
        max-width: 100% !important;
        margin-left: 0 !important;
        padding: 0 !important;
        overflow-x: hidden !important;
    }

    .chat-layout {
        grid-template-columns: 1fr !important;
        display: block !important;
    }

    .chat-container, .chat-layout, .chat-wrapper {
        width: 100% !important;
        max-width: 100% !important;
        height: calc(100vh - 76px) !important;
        margin: 0 !important;
        border-radius: 0 !important;
        display: block !important;
        overflow: hidden !important;
        background: #f8fbff;
    }
    
    .chat-mobile-wrapper {
        position: relative;
        width: 100% !important;
        max-width: 100% !important;
        height: calc(100vh - 76px) !important;
        overflow: hidden !important;
    }

    .chat-sidebar, .chat-main,
    .chat-list-panel, .chat-room-panel,
    .chat-list, .conversation-list,
    .chat-room, .conversation-room {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 100% !important;
        height: 100% !important;
    }

    .chat-list-panel {
        position: absolute !important;
        inset: 0 !important;
        transform: translateX(0);
        transition: transform 0.28s ease;
        z-index: 2;
        border-right: none !important;
        background: #ffffff;
        overflow-y: auto;
    }

    .chat-room-panel {
        position: absolute !important;
        inset: 0 !important;
        transform: translateX(100%);
        transition: transform 0.28s ease;
        z-index: 3;
        background: #f8fbff;
    }

    .chat-mobile-wrapper.chat-open .chat-list-panel {
        transform: translateX(-100%);
    }

    .chat-mobile-wrapper.chat-open .chat-room-panel {
        transform: translateX(0);
    }
    
    .chat-main-header, .chat-header {
        width: 100%;
        height: 72px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        box-sizing: border-box;
    }

    .chat-back-icon, .mobile-back-btn, .chat-back-btn {
        width: 38px;
        height: 38px;
        border: none;
        background: transparent;
        color: #2563eb;
        display: flex !important;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 4px;
        padding: 0;
    }
    
    .chat-main-header .back-btn {
         display: none !important; 
    }

    .chat-main-user {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
    }

    .chat-item-avatar {
        width: 44px !important;
        height: 44px !important;
        font-size: 16px !important;
        flex-shrink: 0;
    }

    .chat-main-user-info, .group-header-info {
        min-width: 0;
        flex: 1;
    }

    .chat-main-user-info h3, .group-header-info h3,
    .chat-header h3, .chat-header-name {
        font-size: 17px !important;
        line-height: 1.2;
        margin: 0;
        white-space: normal;
        word-break: break-word;
    }

    .chat-user-status, .chat-status, .group-header-info p {
        font-size: 13px !important;
        color: #64748b !important;
    }

    .chat-messages {
        height: calc(100vh - 76px - 72px - 76px) !important;
        overflow-y: auto !important;
        padding: 16px 14px 90px !important;
        box-sizing: border-box;
        background: #f8fbff;
        display: flex;
        flex-direction: column;
    }

    .chat-bubble {
        max-width: 78% !important;
        font-size: 15px !important;
        line-height: 1.45;
        padding: 14px 16px !important;
        border-radius: 18px !important;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .chat-bubble-row.me {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 12px;
    }

    .chat-bubble-row.them {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 12px;
    }

    .message-meta, .chat-bubble-time {
        font-size: 11px !important;
        margin-top: 6px;
    }

    .chat-input-area {
        position: fixed !important;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100% !important;
        background: #ffffff;
        padding: 10px 12px calc(10px + env(safe-area-inset-bottom)) !important;
        border-top: 1px solid #e5e7eb;
        box-sizing: border-box;
        z-index: 950;
    }

    .chat-input-area form, .chat-input-form {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        box-sizing: border-box;
    }

    .chat-attach-btn {
        width: 48px !important;
        height: 48px !important;
        min-width: 48px !important;
        border-radius: 16px;
        flex-shrink: 0;
    }

    .chat-input-inner, .chat-input-field,
    .chat-input-form input[type="text"],
    .chat-input-form textarea {
        flex: 1;
        min-width: 0;
        height: 48px;
        border-radius: 999px;
        padding: 0 16px !important;
        font-size: 15px;
        box-sizing: border-box;
        justify-content: center;
    }
    
    .chat-file-preview-bar {
        position: absolute;
        bottom: 60px;
        left: 10px;
        background: white;
        padding: 8px 12px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
    }

    .chat-send-btn {
        width: 48px !important;
        height: 48px !important;
        min-width: 48px !important;
        border-radius: 16px !important;
        flex-shrink: 0;
    }
}

@media (max-width: 380px) {
    .chat-bubble {
        max-width: 84% !important;
        font-size: 14px !important;
    }
}
</style>
@endsection

@section('content')
<div class="chat-container chat-mobile-wrapper {{ $activeConversation ? 'chat-open' : '' }}">

    <!-- Sidebar / Kiri -->
    <div class="chat-sidebar chat-list-panel">
        <div class="chat-sidebar-header">
            <h2>Obrolan</h2>
            <p>Percakapan dengan partner & study group.</p>
            <div class="chat-search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" placeholder="Cari pesan atau partner..." id="chatSearch">
            </div>
        </div>

        <div class="chat-list">
            {{-- Personal Conversations --}}
            @if($conversations->count() > 0)
                <div class="chat-section-label">Pesan Personal</div>
                @foreach($conversations as $conv)
                    @php
                        $partnerItem = $conv->user_one_id == $user->id ? $conv->userTwo : $conv->userOne;
                        $lastMsg = $conv->messages->first();
                        $isActive = $activeConversation && $activeConversation->id == $conv->id;
                    @endphp
                    <a href="{{ route('obrolan.show', $conv->id) }}" class="chat-item {{ $isActive ? 'active' : '' }}">
                        <div class="chat-item-avatar">
                            @if($partnerItem->avatar)
                                <img src="{{ asset($partnerItem->avatar) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                            @else
                                {{ strtoupper(substr($partnerItem->name, 0, 1)) }}
                            @endif
                            <div class="chat-online-badge {{ $partnerItem->is_currently_online ? 'online' : 'offline' }}"></div>
                        </div>
                        <div class="chat-item-body">
                            <div class="chat-item-name">
                                {{ $partnerItem->name }}
                                <span class="chat-item-time">{{ $conv->last_message_at ? $conv->last_message_at->format('H:i') : '' }}</span>
                            </div>
                            <div class="chat-item-preview">
                                @if($lastMsg)
                                    @if($lastMsg->attachment_name) 📎 {{ $lastMsg->attachment_name }}
                                    @else {{ $lastMsg->message }}
                                    @endif
                                @else Belum ada pesan
                                @endif
                            </div>
                            @if($conv->unread_count > 0)
                                <div class="chat-unread-badge">{{ $conv->unread_count }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            @endif

            {{-- Group Conversations --}}
            @if(isset($groupConversations) && $groupConversations->count() > 0)
                <div class="chat-section-label">Obrolan Grup</div>
                @foreach($groupConversations as $gc)
                    @php
                        $lastGMsg = $gc->groupMessages->first();
                        $initials = collect(explode(' ', $gc->name))->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->join('');
                    @endphp
                    <a href="{{ route('group-chat.show', $gc->id) }}" class="chat-item">
                        <div class="chat-item-avatar group-avatar">{{ substr($initials,0,2) ?: 'GR' }}</div>
                        <div class="chat-item-body">
                            <div class="chat-item-name">
                                <span>{{ Str::limit($gc->name, 22) }}<span class="group-badge">Grup</span></span>
                                <span class="chat-item-time">{{ $gc->last_message_at ? $gc->last_message_at->format('H:i') : '' }}</span>
                            </div>
                            <div class="chat-item-preview">
                                @if($lastGMsg)
                                    @if($lastGMsg->attachment_name) 📎 {{ $lastGMsg->attachment_name }}
                                    @else {{ $lastGMsg->message ?? '' }}
                                    @endif
                                @else Belum ada pesan
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif

            @if($conversations->count() == 0 && (!isset($groupConversations) || $groupConversations->count() == 0))
                <div style="padding: 32px 20px; text-align: center; color: var(--gray-500); font-size: 13px;">
                    Belum ada percakapan. Mulai cari partner dan kirim pesan!
                </div>
            @endif
        </div>
    </div>

    <!-- Area Kanan -->
    <div class="chat-main chat-room-panel">
        @if($activeConversation && $partner)

            <div class="chat-main-header">
                <div class="chat-main-user">
                    <button class="chat-back-icon" type="button" id="mobileBackButton">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <div class="chat-item-avatar" style="width:40px;height:40px;">
                        @if($partner->avatar)
                            <img src="{{ asset($partner->avatar) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                        @else
                            {{ strtoupper(substr($partner->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="chat-main-user-info">
                        <h3>{{ $partner->name }}</h3>
                        <div class="chat-user-status">
                            <span class="status-dot {{ $partner->is_currently_online ? 'online' : 'offline' }}"></span>
                            <span>{{ $partner->is_currently_online ? 'Online' : 'Offline' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chat-messages" id="chat-messages-container">
                @if($messages->count() == 0)
                    <div class="chat-date-separator"><span>Mulai ngobrol sekarang</span></div>
                @else
                    @php $lastDate = ''; @endphp
                    @foreach($messages as $msg)
                        @php
                            $msgDate = $msg->created_at->format('Y-m-d');
                            if($msgDate != $lastDate) {
                                $displayDate = $msg->created_at->isToday() ? 'Hari ini' : ($msg->created_at->isYesterday() ? 'Kemarin' : $msg->created_at->format('d M Y'));
                                echo '<div class="chat-date-separator"><span>'.$displayDate.'</span></div>';
                                $lastDate = $msgDate;
                            }
                        @endphp

                        @if($msg->sender_id == $user->id)
                            <div class="chat-bubble-row me">
                                <div class="chat-bubble">
                                    @if($msg->attachment_path)
                                        @if($msg->attachment_type === 'image')
                                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $msg->attachment_path) }}" class="chat-image-preview" alt="{{ $msg->attachment_name }}">
                                            </a>
                                        @elseif($msg->attachment_type === 'video')
                                            <video controls class="chat-video-preview">
                                                <source src="{{ asset('storage/' . $msg->attachment_path) }}" type="{{ $msg->attachment_mime }}">
                                            </video>
                                        @else
                                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" class="chat-file-card">
                                                <div class="chat-file-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                                                <div class="chat-file-info">
                                                    <div class="chat-file-name">{{ $msg->attachment_name }}</div>
                                                    <div class="chat-file-size">{{ $msg->attachment_size ? number_format($msg->attachment_size/1024, 1) . ' KB' : '' }}</div>
                                                </div>
                                            </a>
                                        @endif
                                    @endif
                                    @if($msg->message)<div>{{ $msg->message }}</div>@endif
                                    <div class="message-meta">
                                        <span class="chat-bubble-time">{{ $msg->created_at->format('H:i') }}</span>
                                        @if($msg->is_read)
                                            <span class="message-status read">Dibaca</span>
                                        @else
                                            <span class="message-status sent">Terkirim</span>
                                        @endif
                                        <form action="{{ route('chat.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')" style="margin-left:8px; display:inline-flex; align-items:center;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus pesan" style="background:transparent; border:none; color:rgba(255,255,255,0.8); cursor:pointer; padding:0; display:flex; align-items:center;">
                                                <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2;">
                                                    <path d="M3 6h18"></path>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2-2v2"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="chat-bubble-row them">
                                <div class="chat-bubble">
                                    @if($msg->attachment_path)
                                        @if($msg->attachment_type === 'image')
                                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $msg->attachment_path) }}" class="chat-image-preview" alt="{{ $msg->attachment_name }}">
                                            </a>
                                        @elseif($msg->attachment_type === 'video')
                                            <video controls class="chat-video-preview">
                                                <source src="{{ asset('storage/' . $msg->attachment_path) }}" type="{{ $msg->attachment_mime }}">
                                            </video>
                                        @else
                                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" class="chat-file-card">
                                                <div class="chat-file-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                                                <div class="chat-file-info">
                                                    <div class="chat-file-name">{{ $msg->attachment_name }}</div>
                                                    <div class="chat-file-size">{{ $msg->attachment_size ? number_format($msg->attachment_size/1024, 1) . ' KB' : '' }}</div>
                                                </div>
                                            </a>
                                        @endif
                                    @endif
                                    @if($msg->message)<div>{{ $msg->message }}</div>@endif
                                    <span class="chat-bubble-time">{{ $msg->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>

            <div class="chat-input-area">
                <form action="{{ route('obrolan.send', $activeConversation->id) }}" method="POST" enctype="multipart/form-data" id="chat-form">
                    @csrf
                    <input type="file" name="attachment" id="chat-file-input" style="display:none"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.jpg,.jpeg,.png,.webp,.mp4,.mov,.avi,.mkv">
                    <label for="chat-file-input" class="chat-attach-btn" title="Kirim file">
                        <svg viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    </label>
                    <div class="chat-input-inner">
                        <input type="text" name="message" class="chat-input-field" placeholder="Tulis pesan..." id="chat-msg-input" autocomplete="off">
                        <div class="chat-file-preview-bar" id="file-preview-bar" style="display:none">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                            <span id="file-preview-name">file.pdf</span>
                            <button type="button" onclick="clearFileInput()" title="Hapus file">✕</button>
                        </div>
                    </div>
                    <button type="submit" class="chat-send-btn" id="chat-send-btn">
                        <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </form>
            </div>

        @else
            <div class="chat-empty-state">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <div style="font-size:18px; font-weight:700; color:var(--dark); margin-bottom:8px;">Belum Memilih Pesan</div>
                <div style="font-size:14px; max-width:300px;">Pilih percakapan dari daftar di sebelah kiri atau buka Obrolan Grup dari Study Group.</div>
            </div>
        @endif
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Auto scroll
    document.addEventListener("DOMContentLoaded", function() {
        const c = document.getElementById("chat-messages-container");
        if(c) c.scrollTop = c.scrollHeight;
    });

    // File input preview
    const fileInput = document.getElementById('chat-file-input');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const previewBar = document.getElementById('file-preview-bar');
            const previewName = document.getElementById('file-preview-name');
            if (this.files.length > 0) {
                const file = this.files[0];
                const maxSize = 51200 * 1024;
                if (file.size > maxSize) {
                    alert('Ukuran file melebihi batas 50MB.');
                    this.value = '';
                    return;
                }
                previewName.textContent = file.name;
                previewBar.style.display = 'flex';
            } else {
                previewBar.style.display = 'none';
            }
        });
    }

    function clearFileInput() {
        const fi = document.getElementById('chat-file-input');
        if(fi) fi.value = '';
        const pb = document.getElementById('file-preview-bar');
        if(pb) pb.style.display = 'none';
    }

    // Toggle password (pengaturan halaman sudah ada inline, tapi paste di sini juga)
    document.querySelectorAll('.toggle-password').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = document.getElementById(this.dataset.target);
            if (!input) return;
            if (input.type === 'password') { input.type = 'text'; this.classList.add('showing'); }
            else { input.type = 'password'; this.classList.remove('showing'); }
        });
    });
    // Mobile UI Logics
    const chatWrapper = document.querySelector('.chat-mobile-wrapper');
    const backBtn = document.getElementById('mobileBackButton');
    
    if (backBtn && chatWrapper) {
        backBtn.addEventListener('click', () => {
            chatWrapper.classList.remove('chat-open');
        });
    }

    // Touch Swipe Logic
    let touchStartX = 0;
    let touchEndX = 0;
    
    if (chatWrapper) {
        chatWrapper.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, {passive: true});

        chatWrapper.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            const swipeDistance = touchEndX - touchStartX;
            
            // Swipe right to go back
            if (swipeDistance > 80 && chatWrapper.classList.contains('chat-open')) {
                chatWrapper.classList.remove('chat-open');
            }
        }, {passive: true});
    }

    // Visual Viewport Keyboard Logic
    if (window.visualViewport) {
        const chatInputArea = document.querySelector('.chat-input-area');
        
        function updateChatInputPosition() {
            if (!chatInputArea) return;
            const viewportHeight = window.visualViewport.height;
            const windowHeight = window.innerHeight;
            const keyboardHeight = windowHeight - viewportHeight;
            
            if (keyboardHeight > 80) {
                chatInputArea.style.transform = `translateY(-${keyboardHeight}px)`;
                document.body.classList.add('keyboard-open');
            } else {
                chatInputArea.style.transform = 'translateY(0)';
                document.body.classList.remove('keyboard-open');
            }
        }
        
        window.visualViewport.addEventListener('resize', updateChatInputPosition);
        window.visualViewport.addEventListener('scroll', updateChatInputPosition);
    }
</script>
@endsection