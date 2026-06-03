@extends('layouts.dashboard')
@section('title', 'Dashboard – Smart Finder')

@section('content')

    <!-- Topbar -->
    <div class="dashboard-topbar">
        <div class="dashboard-greeting">
            <h2>Halo, {{ session('mahasiswa_nama', 'Partner') }}!</h2>
            <p>Ayo temukan partner belajar untukmu hari ini.</p>
        </div>
        @php
            $userTop = \Illuminate\Support\Facades\Auth::user();
            $mahasiswaTop = $userTop ? \App\Models\Mahasiswa::where('email', $userTop->email)->orWhere('user_id', $userTop->id)->first() : null;
            $nama = $mahasiswaTop ? $mahasiswaTop->nama : session('mahasiswa_nama', 'U');
            $initials = strtoupper(substr($nama, 0, 1));
            if (str_contains($nama, ' ')) {
                $parts = explode(' ', $nama);
                $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
            }
            $fotoTop = $mahasiswaTop ? $mahasiswaTop->foto_profil : null;
        @endphp
        <a href="{{ route('profil.saya') }}" class="user-avatar-link" title="Buka Profil Saya">
            <div class="dashboard-avatar" style="overflow:hidden;">
                @if($fotoTop)
                    <img src="{{ asset($fotoTop) }}" style="width:100%; height:100%; object-fit:cover;">
                @else
                    {{ $initials }}
                @endif
            </div>
        </a>
    </div>

    @if(session('welcome'))
        <div class="welcome-banner">
            <div class="welcome-banner-text">
                <h3>{{ session('welcome') }}</h3>
                <p>Profilmu sudah lengkap. Mulai temukan partner belajar sekarang!</p>
            </div>
            <div class="welcome-banner-icon">🎉</div>
        </div>
    @endif

    <!-- Partner Rekomendasi -->
    <div class="section-heading">
        <svg viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </svg>
        Rekomendasi Partner Belajar
    </div>

    <div class="partner-grid">
        @foreach($partners as $partner)
            @php
                $p = $partner->mahasiswa;
                $p_initials = strtoupper(substr($partner->name, 0, 1));
                if (str_contains($partner->name, ' ')) {
                    $p_parts = explode(' ', $partner->name);
                    $p_initials = strtoupper(substr($p_parts[0], 0, 1) . substr($p_parts[1], 0, 1));
                }

                $all_skills = [];
                if ($p && $p->skill)
                    $all_skills = array_merge($all_skills, explode(',', $p->skill));
                if ($p && $p->keahlian_custom)
                    $all_skills = array_merge($all_skills, explode(',', $p->keahlian_custom));
                $all_skills = array_unique(array_filter(array_map('trim', $all_skills)));
            @endphp
            <div class="partner-card" style="display:flex; flex-direction:column; justify-content:space-between;">
                <div>
                    <div class="partner-initials" style="background:var(--blue);">
                        @if($p && $p->foto_profil)
                            <img src="{{ asset($p->foto_profil) }}"
                                style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                        @else
                            {{ $p_initials }}
                        @endif
                    </div>
                    <div class="partner-name" style="margin-top:12px;">{{ $partner->name }}</div>
                    <div class="partner-prodi" style="color:var(--gray-500); font-size:14px; margin-bottom:12px;">
                        {{ $p->program_studi ?? '-' }} · {{ $p->universitas ?? '-' }}
                    </div>
                    <div class="partner-tags">
                        @forelse(array_slice($all_skills, 0, 3) as $tag)
                            <span class="partner-tag">{{ trim($tag) }}</span>
                        @empty
                            <span class="partner-tag" style="background:var(--gray-200); color:var(--gray-600);">Belum diisi</span>
                        @endforelse
                    </div>
                </div>

                <div class="partner-actions" style="display:flex; gap:8px; margin-top:20px;">
                    <div class="partner-actions" style="display:flex; gap:8px; margin-top:20px;">
                        <a href="{{ route('partners.show', ['user' => $partner->id]) }}" class="btn-outline"
                            style="flex:1; text-align:center; padding:8px; font-size:13px; font-weight:500; border:1px solid var(--blue); color:var(--blue); border-radius:8px; text-decoration:none;">Lihat
                            profil</a>
                        <form action="{{ route('partners.invite', ['user' => $partner->id]) }}" method="POST"
                            style="flex:1; display:flex;">
                            @csrf
                            <button type="submit" class="btn-primary"
                                style="flex:1; padding:8px; font-size:13px; border:none; background:var(--blue); color:var(--white); border-radius:8px;">Ajak
                                Belajar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Topik Populer -->
    <div class="section-heading" style="margin-top:8px;">
        <svg viewBox="0 0 24 24">
            <polygon
                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
        </svg>
        Topik Populer Minggu Ini
    </div>

    <div class="topik-grid">
        @foreach($topiks as $t)
            <a href="{{ route('community.index', ['topic' => $t['nama']]) }}" class="topik-card"
                style="text-decoration:none; display:flex; align-items:center; gap:16px;">
                <div class="topik-icon" style="background:{{ $t['color'] }};">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        @if($t['icon'] === 'cpu')
                            <rect x="4" y="4" width="16" height="16" rx="2" ry="2" />
                            <rect x="9" y="9" width="6" height="6" />
                            <line x1="9" y1="1" x2="9" y2="4" />
                            <line x1="15" y1="1" x2="15" y2="4" />
                            <line x1="9" y1="20" x2="9" y2="23" />
                            <line x1="15" y1="20" x2="15" y2="23" />
                            <line x1="20" y1="9" x2="23" y2="9" />
                            <line x1="20" y1="14" x2="23" y2="14" />
                            <line x1="1" y1="9" x2="4" y2="9" />
                            <line x1="1" y1="14" x2="4" y2="14" />
                        @elseif($t['icon'] === 'code')
                            <polyline points="16 18 22 12 16 6"></polyline>
                            <polyline points="8 6 2 12 8 18"></polyline>
                        @elseif($t['icon'] === 'database')
                            <ellipse cx="12" cy="5" rx="9" ry="3" />
                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                        @elseif($t['icon'] === 'layout')
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                            <line x1="3" y1="9" x2="21" y2="9" />
                            <line x1="9" y1="21" x2="9" y2="9" />
                        @elseif($t['icon'] === 'trending-up')
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                            <polyline points="17 6 23 6 23 12" />
                        @elseif($t['icon'] === 'briefcase')
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                        @elseif($t['icon'] === 'shield-check')
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            <path d="M9 12l2 2 4-4" />
                        @else
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                        @endif
                    </svg>
                </div>
                <div>
                    <div class="topik-name">{{ $t['nama'] }}</div>
                    <div class="topik-count">{{ $t['member'] ?? $t['count'] }} member aktif</div>
                </div>
            </a>
        @endforeach
@endsection