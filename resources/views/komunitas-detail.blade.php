@extends('layouts.dashboard')
@section('title', $post->title . ' – Komunitas Smart Finder')

@section('styles')
    <style>
        .detail-container {
            max-width: 800px;
        }

        .post-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            margin-bottom: 24px;
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }

        .post-avatar {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--teal-light), var(--blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 20px;
            flex-shrink: 0;
        }

        .post-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .badge-diskusi {
            background: #e0e7ff;
            color: #3730a3;
        }

        .badge-qa {
            background: #fce7f3;
            color: #9d174d;
        }

        .badge-materi {
            background: #dcfce7;
            color: #166534;
        }

        .badge-study_group {
            background: #fef08a;
            color: #854d0e;
        }

        .badge-event {
            background: #fee2e2;
            color: #991b1b;
        }

        .post-actions {
            display: flex;
            align-items: center;
            border-top: 1px solid var(--gray-100);
            padding-top: 16px;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 24px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--gray-500);
            border: none;
            background: transparent;
            font-size: 14px;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.2s;
            padding: 0;
            text-decoration: none;
        }

        .action-btn:hover {
            color: var(--blue);
        }

        .action-btn.liked {
            color: #ef4444;
        }

        .action-btn.saved {
            color: #3b82f6;
        }

        .action-btn.joined {
            color: #10b981;
        }

        .action-btn svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
        }

        .comments-section {
            background: white;
            border-radius: 20px;
            padding: 32px;
            border: 1px solid var(--gray-200);
        }

        .comment-item {
            padding: 16px 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        .comment-avatar {
            width: 36px;
            height: 36px;
            background: var(--blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .info-pill {
            padding: 8px 14px;
            border-radius: 8px;
            background: #f1f5f9;
            font-size: 13px;
            color: var(--gray-700);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 4px 0;
        }

        .info-pill svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
        }
    </style>
@endsection

@section('content')
    <div class="detail-container">
        {{-- Kembali --}}
        <a href="{{ route('community.index') }}"
            style="display:inline-flex; align-items:center; gap:8px; color:var(--gray-600); text-decoration:none; font-weight:600; margin-bottom:24px; font-size:14px;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Kembali ke Komunitas
        </a>

        @if(session('success'))
            <div
                style="background:#dcfce7; color:#166534; padding:12px 20px; border-radius:12px; margin-bottom:20px; font-weight:600;">
                ✅ {{ session('success') }}</div>
        @endif

        {{-- Post Detail --}}
        <div class="post-card">
            @php
                $initials = strtoupper(substr($post->user->name, 0, 1));
                if (str_contains($post->user->name, ' ')) {
                    $parts = explode(' ', $post->user->name);
                    $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
                }
                $isLiked = $post->isLikedBy($userId);
                $isSaved = $post->isSavedBy($userId);
                $isJoined = $post->isJoinedBy($userId);
                $prodi = optional($post->user->mahasiswa)->program_studi;
            @endphp

            <div class="post-header">
                <div class="post-avatar">{{ $initials }}</div>
                <div>
                    <div style="font-weight:700; font-size:16px; color:var(--dark);">{{ $post->user->name }}</div>
                    <div style="font-size:13px; color:var(--gray-500);">
                        {{ $prodi ? $prodi . ' · ' : '' }}{{ $post->created_at->diffForHumans() }}</div>
                </div>
                @if($post->user_id === $userId)
                <div style="margin-left: auto;">
                    <form action="{{ route('community.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" title="Hapus Postingan">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 6h18"></path>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2-2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <span class="post-badge badge-{{ $post->category }}">{{ $post->category_label }}</span>
            @if($post->topic)
                <span
                    style="display:inline-block; padding:3px 10px; border-radius:100px; background:#e0f2fe; color:#0369a1; font-size:12px; font-weight:600; margin-left:8px;">{{ $post->topic }}</span>
            @endif

            <h1 style="font-size:22px; font-weight:700; margin:12px 0; line-height:1.4; color:var(--dark);">
                {{ $post->title }}</h1>
            <div style="font-size:16px; color:var(--gray-700); line-height:1.7; white-space:pre-line;">{{ $post->body }}
            </div>

            @if($post->attachment)
                <div
                    style="margin-top:16px; padding:12px; border:1px solid var(--gray-200); border-radius:12px; display:inline-flex; align-items:center; gap:12px; color:var(--blue); background:var(--gray-100);">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <a href="{{ asset('storage/' . $post->attachment) }}" download
                        style="font-weight:600; font-size:14px; color:var(--blue); text-decoration:none;">{{ basename($post->attachment) }}</a>
                </div>
            @endif

            @if($post->category === 'study_group' && $post->group_schedule)
                <div style="margin-top:16px;">
                    <div class="info-pill"><svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg> Jadwal: {{ $post->group_schedule }}</div>
                    <div class="info-pill"><svg viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg> {{ $post->studyGroupMembers->count() }} anggota</div>
                </div>
            @endif

            @if($post->category === 'event' && $post->event_date)
                <div style="margin-top:16px;">
                    <div class="info-pill"><svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg> {{ $post->event_date->isoFormat('dddd, D MMMM Y · HH:mm') }} WIB</div>
                    <div class="info-pill"><svg viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                        </svg> {{ $post->eventParticipants->count() }} peserta</div>
                </div>
            @endif

            <div class="post-actions">
                <form action="{{ route('community.like', $post->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="action-btn {{ $isLiked ? 'liked' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                            </path>
                        </svg>
                        {{ $post->likes->count() }} Suka
                    </button>
                </form>

                @if($post->category === 'study_group' && !$isJoined && $post->user_id !== $userId)
                    <form action="{{ route('community.joinStudyGroup', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="action-btn" style="color:#10b981; font-weight:700;">Gabung Study
                            Group</button>
                    </form>
                @elseif($post->category === 'study_group' && ($isJoined || $post->user_id === $userId))
                    <span class="action-btn joined" style="margin-right: 8px;">✓ Sudah Gabung</span>
                    @if($post->groupConversation)
                        <a href="{{ route('group-chat.show', $post->groupConversation->id) }}" class="action-btn" style="color:var(--blue); font-weight:700;">
                            Buka Obrolan Grup &rarr;
                        </a>
                    @endif
                @endif

                @if($post->category === 'event' && !$isJoined)
                    <form action="{{ route('community.joinEvent', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="action-btn" style="color:#ef4444; font-weight:700;">Ikut Event</button>
                    </form>
                @elseif($post->category === 'event' && $isJoined)
                    <span class="action-btn joined">✓ Sudah Ikut</span>
                @endif

                <form action="{{ route('community.save', $post->id) }}" method="POST"
                    style="display:inline; margin-left:auto;">
                    @csrf
                    <button type="submit" class="action-btn {{ $isSaved ? 'saved' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                        {{ $isSaved ? 'Tersimpan' : 'Simpan' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Komentar --}}
        <div class="comments-section">
            <h3 style="font-size:18px; font-weight:700; margin-bottom:24px; color:var(--dark);">
                {{ $post->category === 'qa' ? 'Jawaban' : 'Komentar' }} ({{ $post->comments->count() }})
            </h3>

            {{-- Form Komentar --}}
            <form action="{{ route('community.comment', $post->id) }}" method="POST" style="margin-bottom:32px;">
                @csrf
                <div style="display:flex; gap:12px; align-items:flex-start;">
                    <div
                        style="width:40px; height:40px; background:var(--blue); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:14px; flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div style="flex:1;">
                        <textarea name="comment" class="sf-input-plain" rows="3"
                            placeholder="{{ $post->category === 'qa' ? 'Tulis jawaban kamu...' : 'Tulis komentar kamu...' }}"
                            required style="margin-bottom:12px; resize:vertical;"></textarea>
                        <button type="submit" class="btn-primary" style="width:auto; padding:10px 24px; font-size:14px;">
                            {{ $post->category === 'qa' ? 'Kirim Jawaban' : 'Kirim Komentar' }}
                        </button>
                    </div>
                </div>
            </form>

            {{-- Daftar Komentar --}}
            @forelse($post->comments as $comment)
                @php
                    $ci = strtoupper(substr($comment->user->name, 0, 1));
                    if (str_contains($comment->user->name, ' ')) {
                        $cp = explode(' ', $comment->user->name);
                        $ci = strtoupper(substr($cp[0], 0, 1) . substr($cp[1], 0, 1));
                    }
                @endphp
                <div class="comment-item">
                    <div style="display:flex; gap:12px; align-items:flex-start;">
                        <div class="comment-avatar">{{ $ci }}</div>
                        <div style="flex: 1;">
                            <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
                                <span
                                    style="font-weight:700; font-size:14px; color:var(--dark);">{{ $comment->user->name }}</span>
                                <span
                                    style="font-size:12px; color:var(--gray-500);">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <div style="font-size:15px; color:var(--gray-700); line-height:1.6;">{{ $comment->comment }}</div>
                        </div>
                        @if($comment->user_id === $userId || $post->user_id === $userId)
                        <div>
                            <form action="{{ route('community.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" title="Hapus Komentar" style="width: 28px; height: 28px;">
                                    <svg viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2-2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align:center; padding:32px; color:var(--gray-500);">
                    Belum ada {{ $post->category === 'qa' ? 'jawaban' : 'komentar' }}. Jadilah yang pertama!
                </div>
            @endforelse
        </div>
    </div>
@endsection