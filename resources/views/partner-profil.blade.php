@extends('layouts.dashboard')

@section('title', 'Profil Partner – ' . $user->name)

@section('styles')
    <style>
        .public-profile-container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }

        .public-profile-header {
            background: linear-gradient(135deg, #1e3a8a, #0d9488);
            height: 160px;
            position: relative;
        }

        .public-profile-avatar-wrap {
            position: absolute;
            bottom: -50px;
            left: 40px;
            border: 4px solid var(--white);
            border-radius: 50%;
            width: 120px;
            height: 120px;
            background: var(--white);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: 700;
            color: var(--blue);
        }

        .public-profile-actions {
            position: absolute;
            bottom: 20px;
            right: 40px;
            display: flex;
            gap: 12px;
        }

        .public-profile-body {
            padding: 70px 40px 40px;
        }

        .partner-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .partner-info-row {
            display: flex;
            align-items: center;
            gap: 16px;
            color: var(--gray-600);
            margin-bottom: 24px;
            font-size: 15px;
        }

        .partner-info-row svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
        }

        .partner-section {
            margin-bottom: 32px;
        }

        .partner-section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .partner-bio {
            font-size: 15px;
            line-height: 1.6;
            color: var(--gray-600);
        }

        .partner-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .skill-chip {
            padding: 6px 16px;
            border-radius: 20px;
            background: #E0F2FE;
            color: var(--blue);
            font-size: 13px;
            font-weight: 600;
        }

        /* Empty State Privasi */
        .private-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray-500);
        }

        .private-state svg {
            width: 64px;
            height: 64px;
            stroke: var(--gray-300);
            fill: none;
            margin-bottom: 16px;
        }
    </style>
@endsection

@section('content')

    @if(!$isPublic)
        <div class="public-profile-container">
            <div class="private-state">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <h2 style="font-size:20px; font-weight:700; color:var(--dark); margin-bottom:8px;">Profil Privat</h2>
                <p style="font-size:15px; max-width:400px; margin:0 auto;">Pengguna mengatur profil ini menjadi privat dan tidak
                    tersedia untuk publik.</p>
            </div>
        </div>
    @else
        <div class="public-profile-container">
            <!-- Header -->
            <div class="public-profile-header">
                <div class="public-profile-avatar-wrap">
                    @if($mahasiswa && $mahasiswa->foto_profil)
                        <img src="{{ foto_profil_url($mahasiswa->foto_profil) }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>

                <div class="public-profile-actions">
                    <form action="{{ route('obrolan.start', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-secondary"
                            style="background:rgba(255,255,255,0.2) !important; color:var(--white) !important; border-color:rgba(255,255,255,0.4) !important;">
                            <svg viewBox="0 0 24 24"
                                style="width:18px;height:18px;stroke:currentColor;fill:none;margin-right:6px;">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                            </svg>
                            Kirim Pesan
                        </button>
                    </form>

                    <form action="{{ route('partners.invite', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary" style="background:var(--white); color:var(--blue);">
                            Ajak Belajar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Body -->
            <div class="public-profile-body">

                <h1 class="partner-name">{{ $mahasiswa->nama ?? $user->name }}</h1>

                <div class="partner-info-row">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                            <path d="M6 12v5c3 3 9 3 12 0v-5" />
                        </svg>
                        <span>{{ $mahasiswa->program_studi ?? 'Belum ada jurusan' }},
                            {{ $mahasiswa->universitas ?? 'Universitas' }}</span>
                    </div>
                    <div>•</div>
                    <div style="display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        <span>Angkatan {{ $mahasiswa->angkatan ?? 'N/A' }}</span>
                    </div>
                </div>

                @if($mahasiswa && $mahasiswa->bio)
                    <div class="partner-section">
                        <div class="partner-section-title">Tentang Saya</div>
                        <div class="partner-bio">
                            {!! nl2br(e($mahasiswa->bio)) !!}
                        </div>
                    </div>
                @endif

                <div style="display:flex; gap:40px; flex-wrap:wrap;">

                    @if($mahasiswa && $mahasiswa->topik_minat)
                        <div class="partner-section" style="flex:1; min-width:300px;">
                            <div class="partner-section-title">Topik Minat & Keahlian</div>
                            <div class="partner-skills">
                                @php 
                                    $topics = explode(',', $mahasiswa->topik_minat);
                                @endphp
                                @foreach($topics as $topic)
                                    <div class="skill-chip">{{ trim($topic) }}</div>
                                @endforeach


                                                       @if($mahasiswa->tingkat_kemampuan)
                                                        <div class="skill-chip" style="background:var(--gray-200); color:var(--dark);">Level: {{ $mahasiswa->tingkat_kemampuan }}</div>
                                                    @endif
                            </div>
                            </div>
                    @endif
                    <div class="partner-section" style="flex:1; min-width:300px;">
                        <div class="partner-section-title">Jadwal Belajar Bersedia</div>
                        <div class="partner-skills">
                            @if($mahasiswa && is_array($mahasiswa->waktu_belajar) && count($mahasiswa->waktu_belajar) > 0)
                                @foreach($mahasiswa->waktu_belajar as $waktu)
                                    <div class="skill-chip" style="background:#fef3c7; color:#d97706;">{{ $waktu }}</div>
                                @endforeach
                            @else
                                <div class="skill-chip" style="background:#fef3c7; color:#d97706;">Fleksibel</div>
                            @endif
                        </div>
                    </div>

                </div>
                </div>
            </div>
    @endif

@endsection
