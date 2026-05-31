@extends('layouts.dashboard')
@section('title', 'Komunitas – Smart Finder')

@section('styles')
    <style>
        .komunitas-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .k-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--blue-dark);
        }

        .k-subtitle {
            font-size: 15px;
            color: var(--gray-600);
        }

        .tab-filter {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            overflow-x: auto;
            padding-bottom: 8px;
            flex-wrap: wrap;
        }

        .tab-pill {
            padding: 8px 20px;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 100px;
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-600);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
            display: inline-block;
        }

        .tab-pill:hover {
            background: var(--gray-100);
        }

        .tab-pill.active {
            background: var(--blue);
            color: white;
            border-color: var(--blue);
        }

        .feed-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 800px;
        }

        .post-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }

        .post-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--teal-light), var(--blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
            flex-shrink: 0;
        }

        .post-meta {
            flex: 1;
        }

        .post-user {
            font-weight: 700;
            font-size: 15px;
            color: var(--dark);
            margin-bottom: 2px;
        }

        .post-time {
            font-size: 13px;
            color: var(--gray-500);
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

        .post-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            line-height: 1.4;
            color: var(--dark);
        }

        .post-body {
            font-size: 15px;
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .post-actions {
            display: flex;
            align-items: center;
            border-top: 1px solid var(--gray-100);
            padding-top: 16px;
            gap: 16px;
            flex-wrap: wrap;
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

        .topic-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 100px;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 12px;
            margin-left: 8px;
        }

        .info-pill {
            padding: 6px 14px;
            border-radius: 8px;
            background: #f1f5f9;
            font-size: 13px;
            color: var(--gray-700);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 8px 0;
        }

        .info-pill svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: white;
            border-radius: 24px;
            padding: 32px;
            width: 100%;
            max-width: 580px;
            box-shadow: var(--shadow-lg);
            max-height: 90vh;
            overflow-y: auto;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray-500);
        }

        .empty-state svg {
            width: 64px;
            height: 64px;
            stroke: var(--gray-300);
            fill: none;
            margin-bottom: 16px;
        }
    </style>
@endsection

@section('content')
@php
    $topic    = $topic ?? request('topic');
    $category = $category ?? request('category', 'semua');
    $posts    = $posts ?? collect();
    $userId   = $userId ?? auth()->id();
@endphp

    {{-- Flash Messages --}}
    @if(session('success'))
        <div
            style="background:#dcfce7; color:#166534; padding:12px 20px; border-radius:12px; margin-bottom:20px; font-weight:600;">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div
            style="background:#dbeafe; color:#1e40af; padding:12px 20px; border-radius:12px; margin-bottom:20px; font-weight:600;">
            ℹ️ {{ session('info') }}
        </div>
    @endif

    <div class="komunitas-header">
        <div>
            <h1 class="k-title">Komunitas</h1>
            <p class="k-subtitle">Tempat berdiskusi, bertanya, berbagi materi, dan belajar bersama.</p>
            @if($topic)
                <div style="margin-top:8px; color:var(--blue); font-weight:600; font-size:14px;">
                    Menampilkan topik: <strong>{{ $topic }}</strong>
                    &nbsp;<a href="{{ route('community.index', ['category' => $category]) }}"
                        style="color:var(--gray-500); font-size:13px;">(Hapus filter)</a>
                </div>
            @endif
        </div>
        <button class="btn-primary" style="width:auto; padding:12px 24px;"
            onclick="document.getElementById('modalPost').style.display='flex'">
            + Buat Postingan
        </button>
    </div>

    {{-- Tabs --}}
    <div class="tab-filter">
        @php $tabs = ['semua' => 'Semua', 'diskusi' => 'Diskusi', 'qa' => 'Q&A', 'materi' => 'Materi', 'study_group' => 'Study Group', 'event' => 'Event']; @endphp
        @foreach($tabs as $key => $label)
            <a href="{{ route('community.index', ['category' => $key, 'topic' => $topic]) }}"
                class="tab-pill {{ $category === $key ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    {{-- Feed --}}
    <div class="feed-container">
        @forelse($posts as $post)
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
            <div class="post-card">
                <div class="post-header">
                    <div class="post-avatar">{{ $initials }}</div>
                    <div class="post-meta">
                        <div class="post-user">{{ $post->user->name }}</div>
                        <div class="post-time">{{ $prodi ? $prodi . ' · ' : '' }}{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                    @if($post->user_id === $userId)
                    <div style="margin-left: auto;">
                        <form action="{{ route('community.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" title="Hapus Postingan">
                                <svg viewBox="0 0 24 24">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
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
                    <span class="topic-badge">{{ $post->topic }}</span>
                @endif

                <h2 class="post-title">
                    <a href="{{ route('community.show', $post->id) }}"
                        style="text-decoration:none; color:inherit;">{{ $post->title }}</a>
                </h2>
                <p class="post-body">{{ Str::limit($post->body, 200) }}</p>

                {{-- Info khusus kategori --}}
                @if($post->category === 'study_group' && $post->group_schedule)
                    <div class="info-pill">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Jadwal: {{ $post->group_schedule }}
                        &nbsp;·&nbsp; {{ $post->studyGroupMembers->count() }} anggota
                    </div>
                @endif
                @if($post->category === 'event' && $post->event_date)
                    <div class="info-pill">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        {{ $post->event_date->isoFormat('dddd, D MMMM Y · HH:mm') }} WIB
                        &nbsp;·&nbsp; {{ $post->eventParticipants->count() }} peserta
                    </div>
                @endif

                {{-- Aksi --}}
                <div class="post-actions">
                    <form action="{{ route('community.like', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="action-btn {{ $isLiked ? 'liked' : '' }}">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                                </path>
                            </svg>
                            {{ $post->likes->count() }} {{ $post->category === 'qa' ? 'Berguna' : 'Suka' }}
                        </button>
                    </form>

                    <a href="{{ route('community.show', $post->id) }}" class="action-btn">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        {{ $post->comments->count() }} {{ $post->category === 'qa' ? 'Jawaban' : 'Komentar' }}
                    </a>

                    @if($post->category === 'study_group')
                        @if(!$isJoined && $post->user_id !== $userId)
                            <form action="{{ route('community.joinStudyGroup', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="action-btn" style="color:#10b981; font-weight:700;">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    Gabung
                                </button>
                            </form>
                        @else
                            <span class="action-btn joined" style="margin-right: 8px;">
                                <svg viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Sudah Gabung
                            </span>
                            @if($post->groupConversation)
                                <a href="{{ route('group-chat.show', $post->groupConversation->id) }}" class="action-btn" style="color:var(--blue); font-weight:700;">
                                    Buka Obrolan &rarr;
                                </a>
                            @endif
                        @endif
                    @elseif($post->category === 'event')
                        @if(!$isJoined)
                            <form action="{{ route('community.joinEvent', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="action-btn" style="color:#ef4444; font-weight:700;">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                    Ikut Event
                                </button>
                            </form>
                        @else
                            <span class="action-btn joined">
                                <svg viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Sudah Ikut
                            </span>
                        @endif
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
        @empty
            <div class="empty-state">
                <svg viewBox="0 0 24 24">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <h3 style="font-size:20px; font-weight:700; color:var(--dark); margin-bottom:8px;">Belum ada postingan</h3>
                <p>Jadilah yang pertama memulai diskusi!</p>
            </div>
        @endforelse
    </div>

    {{-- Modal Buat Postingan --}}
    <div class="modal-overlay" id="modalPost" onclick="if(event.target===this)this.style.display='none'">
        <div class="modal-content">
            <h2 style="font-size:22px; font-weight:700; margin-bottom:24px;">Buat Postingan</h2>
            <form action="{{ route('community.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="sf-form-group">
                    <label class="sf-label">Kategori *</label>
                    <select name="category" class="sf-input-plain" id="categorySelect" onchange="toggleFields(this.value)"
                        required>
                        <option value="">Pilih Kategori</option>
                        <option value="diskusi">Diskusi</option>
                        <option value="qa">Q&A</option>
                        <option value="materi">Materi</option>
                        <option value="study_group">Study Group</option>
                        <option value="event">Event</option>
                    </select>
                </div>
                <div class="sf-form-group">
                    <label class="sf-label">Topik</label>
                    <select name="topic" class="sf-input-plain">
                        <option value="">Pilih Topik (Opsional)</option>
                        @foreach(['Machine Learning', 'Web Development', 'Basis Data', 'Algoritma', 'UI/UX Design', 'Cyber Security', 'Lainnya'] as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sf-form-group">
                    <label class="sf-label">Judul *</label>
                    <input type="text" name="title" class="sf-input-plain" placeholder="Judul postingan..." required
                        maxlength="255">
                </div>
                <div class="sf-form-group">
                    <label class="sf-label">Isi Postingan *</label>
                    <textarea name="body" class="sf-input-plain" rows="5" placeholder="Tuliskan isi postingan kamu..."
                        required></textarea>
                </div>
                <div class="sf-form-group" id="fieldAttachment" style="display:none;">
                    <label class="sf-label">Lampiran (Opsional)</label>
                    <input type="file" name="attachment" class="sf-input-plain" style="padding:10px;">
                </div>
                <div class="sf-form-group" id="fieldSchedule" style="display:none;">
                    <label class="sf-label">Jadwal Belajar *</label>
                    <input type="text" name="group_schedule" class="sf-input-plain" placeholder="Contoh: Sabtu 19.00 WIB">
                </div>
                <div class="sf-form-group" id="fieldEventDate" style="display:none;">
                    <label class="sf-label">Tanggal & Waktu Event *</label>
                    <input type="datetime-local" name="event_date" class="sf-input-plain">
                </div>
                <div style="display:flex; gap:12px; margin-top:32px;">
                    <button type="button" class="btn-secondary" style="flex:1;"
                        onclick="document.getElementById('modalPost').style.display='none'">Batal</button>
                    <button type="submit" class="btn-primary" style="flex:1;">Posting</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function toggleFields(cat) {
            document.getElementById('fieldAttachment').style.display = (cat === 'materi') ? 'block' : 'none';
            document.getElementById('fieldSchedule').style.display = (cat === 'study_group') ? 'block' : 'none';
            document.getElementById('fieldEventDate').style.display = (cat === 'event') ? 'block' : 'none';
        }
    </script>
@endsection