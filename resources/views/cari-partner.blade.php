@extends('layouts.dashboard')
@section('title', 'Cari Partner – Smart Finder')

@section('styles')
    <style>
        .filter-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(180px, 1fr)) auto;
            gap: 12px;
            align-items: center;
        }

        .filter-select {
            width: 100%;
            height: 46px;
            padding: 0 14px;
            border: 1px solid #dbe3ef;
            border-radius: 14px;
            background: #f8fbff;
            color: #0f172a;
            font-size: 14px;
            font-weight: 500;
            outline: none;
            transition: all 0.2s;
        }

        .filter-select:focus {
            border-color: #2563eb;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .advanced-filter-btn {
            height: 46px;
            padding: 0 18px;
            border: none;
            border-radius: 14px;
            background: #2563eb;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
            cursor: pointer;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.18);
            transition: all 0.2s;
        }

        .advanced-filter-btn:hover {
            background: #1d4ed8;
        }

        .reset-filter-btn {
            height: 40px;
            padding: 0 14px;
            border: 1px solid #dbe3ef;
            border-radius: 12px;
            background: #ffffff;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .reset-filter-btn:hover {
            background: #f1f5f9;
        }

        @media (max-width: 900px) {
            .filter-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 600px) {
            .filter-row {
                grid-template-columns: 1fr;
            }
        }

        .pagination-wrapper {
            margin-top: 32px;
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper nav {
            display: inline-block;
        }

        .partner-jadwal {
            font-size: 13px;
            color: var(--gray-500);
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .partner-jadwal svg {
            width: 16px;
            height: 16px;
        }

        .partner-actions {
            display: flex;
            gap: 8px;
            margin-top: 16px;
        }

        .partner-actions .btn-outline {
            flex: 1;
            text-align: center;
            padding: 8px;
            border: 1px solid var(--blue);
            color: var(--blue);
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
        }

        .partner-actions .btn-outline:hover {
            background-color: var(--blue-100);
        }

        .partner-actions .btn-primary {
            flex: 1;
            text-align: center;
            padding: 8px;
            border-radius: 8px;
            text-decoration: none;
        }

        .partner-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
@endsection

@section('content')

    <!-- Topbar -->
    <div class="dashboard-topbar" style="border-bottom:none; padding-bottom: 0;">
        <div class="dashboard-greeting" style="display:flex; align-items:center; gap:12px;">
            <div style="background:var(--blue-100); padding:12px; border-radius:12px; color:var(--blue);">
                <svg viewBox="0 0 24 24" width="28" height="28" stroke="currentColor" fill="none" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </div>
            <div>
                <h2 style="margin:0;">Cari Partner!</h2>
            </div>
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
        <div class="dashboard-avatar" style="overflow:hidden;">
            @if($fotoTop)
                <img src="{{ foto_profil_url($fotoTop) }}" style="width:100%; height:100%; object-fit:cover;">
            @else
                {{ $initials }}
            @endif
        </div>
    </div>

    <!-- Page Content -->
    <div style="margin-top:24px;">
        <form method="GET" action="{{ route('cari.partner') }}" style="margin-bottom: 24px;">
            <div style="margin-bottom: 12px;">
                <input type="text" name="search" class="sf-input-plain"
                    style="width: 100%; height:46px; border-radius:14px; font-size:14px; padding:0 16px;"
                    placeholder="Ketik nama, keahlian, topik..." value="{{ request('search') }}">
            </div>

            <div class="filter-row">
                <select name="topik" class="filter-select">
                    <option value="">Semua Topik</option>
                    <option value="Teknologi & IT" {{ request('topik') == 'Teknologi & IT' ? 'selected' : '' }}>Teknologi & IT</option>
                    <option value="Desain & Seni" {{ request('topik') == 'Desain & Seni' ? 'selected' : '' }}>Desain & Seni</option>
                    <option value="Bisnis & Ekonomi" {{ request('topik') == 'Bisnis & Ekonomi' ? 'selected' : '' }}>Bisnis & Ekonomi</option>
                    <option value="Sains & Teknik" {{ request('topik') == 'Sains & Teknik' ? 'selected' : '' }}>Sains & Teknik</option>
                    <option value="Sastra & Bahasa" {{ request('topik') == 'Sastra & Bahasa' ? 'selected' : '' }}>Sastra & Bahasa</option>
                    <option value="Kesehatan & Medis" {{ request('topik') == 'Kesehatan & Medis' ? 'selected' : '' }}>Kesehatan & Medis</option>
                    <option value="Hukum & Sosial" {{ request('topik') == 'Hukum & Sosial' ? 'selected' : '' }}>Hukum & Sosial</option>
                </select>

                <select name="keahlian" class="filter-select">
                    <option value="">Semua Keahlian</option>
                    <option value="Programming" {{ request('keahlian') == 'Programming' ? 'selected' : '' }}>Programming</option>
                    <option value="Desain Grafis" {{ request('keahlian') == 'Desain Grafis' ? 'selected' : '' }}>Desain Grafis</option>
                    <option value="Digital Marketing" {{ request('keahlian') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                    <option value="Copywriting" {{ request('keahlian') == 'Copywriting' ? 'selected' : '' }}>Copywriting</option>
                    <option value="Data Analysis" {{ request('keahlian') == 'Data Analysis' ? 'selected' : '' }}>Data Analysis</option>
                    <option value="Video Editing" {{ request('keahlian') == 'Video Editing' ? 'selected' : '' }}>Video Editing</option>
                    <option value="Public Speaking" {{ request('keahlian') == 'Public Speaking' ? 'selected' : '' }}>Public Speaking</option>
                    <option value="Riset & Penulisan" {{ request('keahlian') == 'Riset & Penulisan' ? 'selected' : '' }}>Riset & Penulisan</option>
                </select>

                <select name="jadwal" class="filter-select">
                    <option value="">Jadwal</option>
                    <option value="Senin" {{ request('jadwal') == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ request('jadwal') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ request('jadwal') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ request('jadwal') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ request('jadwal') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    <option value="Sabtu" {{ request('jadwal') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                    <option value="Minggu" {{ request('jadwal') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                </select>

                <button type="submit" class="advanced-filter-btn">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    Filter
                </button>
            </div>
        </form>

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div style="color:var(--gray-600); font-size:14px;"><strong>{{ $partners->total() }} partner ditemukan</strong>
            </div>
            <a href="{{ route('cari.partner') }}" class="reset-filter-btn" title="Reset Filter">
                ↻ Reset
            </a>
        </div>

        <div class="partner-grid">
            @forelse($partners as $partner)
                @php
                    $p = $partner->mahasiswa;
                    $p_initials = strtoupper(substr($partner->name, 0, 1));
                    if (str_contains($partner->name, ' ')) {
                        $p_parts = explode(' ', $partner->name);
                        $p_initials = strtoupper(substr($p_parts[0], 0, 1) . substr($p_parts[1], 0, 1));
                    }

                    $all_skills = [];
                    if ($p && $p->skill) {
                        $all_skills = array_merge($all_skills, explode(',', $p->skill));
                    }
                    if ($p && $p->keahlian_custom) {
                        $all_skills = array_merge($all_skills, explode(',', $p->keahlian_custom));
                    }
                    $all_skills = array_unique(array_filter(array_map('trim', $all_skills)));
                @endphp
                <div class="partner-card">
                    <div>
                        <div class="partner-initials" style="background:#2563EB;">
                            @if($p && $p->foto_profil)
                                <img src="{{ foto_profil_url($p->foto_profil) }}"
                                    style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                            @else
                                {{ $p_initials }}
                            @endif
                        </div>
                        <div class="partner-name" style="margin-top:12px;">{{ $partner->name }}</div>
                        <div class="partner-prodi"
                            style="color:var(--gray-500); font-size:14px; margin-bottom: 12px; margin-top:4px;">
                            {{ optional($p)->program_studi ?? 'Mahasiswa' }} · {{ optional($p)->universitas ?? 'Belum diisi' }}
                        </div>

                        <div style="font-size:12px; font-weight:600; color:var(--gray-700); margin-bottom:8px;">
                            Keahlian:</div>
                        <div class="partner-tags">
                            @forelse(array_slice($all_skills, 0, 4) as $s)
                                <span class="partner-tag">{{ $s }}</span>
                            @empty
                                <span class="partner-tag" style="background:var(--gray-200); color:var(--gray-600);">Belum
                                    diisi</span>
                            @endforelse
                            @if(count($all_skills) > 4)
                                <span class="partner-tag">+{{ count($all_skills) - 4 }}</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        @php
                            $waktus = optional($p)->waktu_belajar;
                            $jadwal = is_array($waktus) && count($waktus) > 0 ? implode(', ', $waktus) : null;
                        @endphp
                        <div style="margin-top:16px;">
                            <div style="font-size:12px; font-weight:600; color:var(--gray-700);">Jadwal Kosong:</div>
                            <div class="partner-jadwal">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                {{ $jadwal ?? 'Fleksibel' }}
                            </div>
                        </div>

                        <div class="partner-actions">
                            <a href="{{ route('partners.show', ['user' => $partner->id]) }}" class="btn-outline">Lihat
                                profil</a>

                            <form action="{{ route('partners.invite', ['user' => $partner->id]) }}" method="POST"
                                style="flex:1;">
                                @csrf
                                <button type="submit" class="btn-primary" style="width:100%; border:none;">Ajak Belajar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    style="grid-column: 1 / -1; text-align: center; padding: 48px; background: white; border-radius: 12px; border: 1px dashed var(--gray-300);">
                    <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="var(--gray-400)" stroke-width="2"
                        style="margin-bottom:16px;">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <h3 style="margin-bottom: 8px;">Partner tidak ditemukan</h3>
                    <p style="color:var(--gray-500);">Coba ubah keyword pencarian atau filter.</p>
                </div>
            @endforelse
        </div>

        <!-- Fix Pagination default layout override -->
        <style>
            svg.w-5.h-5 {
                height: 20px;
                width: 20px;
            }
        </style>
        <div class="pagination-wrapper">
            {{ $partners->links() }}
        </div>
@endsection