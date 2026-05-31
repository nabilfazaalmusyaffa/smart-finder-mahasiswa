@extends('layouts.dashboard')

@section('title', 'Profil Saya – Smart Finder')

@section('styles')
    <style>
        /* CSS Spesifik untuk Halaman Profil */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .profile-header svg {
            width: 28px;
            height: 28px;
            stroke: var(--blue);
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .profile-title-text h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 2px;
        }

        .profile-title-text p {
            font-size: 14px;
            color: var(--gray-600);
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 24px;
            align-items: start;
        }

        @media(max-width: 900px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Card Kiri (Utama) */
        .profile-card-main {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 32px 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
            text-align: center;
        }

        .avatar-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
        }

        .avatar-circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal-light), var(--blue));
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: 700;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-edit-btn {
            position: absolute;
            bottom: 0px;
            right: 0px;
            width: 36px;
            height: 36px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            cursor: pointer;
            color: var(--blue);
        }

        .avatar-edit-btn svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .profile-card-main h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .profile-card-main .prodi-text {
            font-size: 15px;
            color: var(--blue);
            font-weight: 600;
            margin-bottom: 16px;
        }

        .profile-card-main .bio-text {
            font-size: 14px;
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .btn-edit-profile {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--blue);
            color: var(--white);
            padding: 12px 24px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 14px;
            box-shadow: var(--shadow-sm);
            transition: all .2s;
        }

        .btn-edit-profile:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-edit-profile svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }


        /* Kanan (Stat & Detail) */
        .profile-right {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        @media(max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #E0F2FE;
            /* Cyan muda / Light Sky */
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg {
            width: 24px;
            height: 24px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .stat-info h3 {
            font-size: 13px;
            color: var(--gray-600);
            font-weight: 500;
            margin-bottom: 4px;
        }

        .stat-info p {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
        }

        /* Informasi Pribadi */
        .info-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        .info-card h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
        }

        .info-row {
            display: flex;
            padding: 16px 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            width: 35%;
            font-size: 14px;
            color: var(--gray-600);
            font-weight: 500;
        }

        .info-value {
            width: 65%;
            font-size: 15px;
            color: var(--dark);
            font-weight: 600;
        }

        .empty-data {
            color: var(--gray-400);
            font-weight: 400;
            font-style: italic;
        }
    </style>
@endsection

@section('content')
    <div style="max-width: 1100px; margin: 0 auto;">

        <!-- Header -->
        <div class="profile-header">
            <svg viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
            <div class="profile-title-text">
                <h1>Profil Saya</h1>
                <p>Kelola informasi profil dan preferensi belajar kamu.</p>
            </div>
        </div>

        <!-- Grid -->
        <div class="profile-grid">

            <!-- Main Left -->
            <div class="profile-card-main">
                <div class="avatar-wrapper">
                    <div class="avatar-circle">
                        @if($mahasiswa && $mahasiswa->foto_profil)
                            <img src="{{ asset($mahasiswa->foto_profil) }}" alt="Avatar" class="avatar-img">
                        @else
                            @php
                                $nama = $mahasiswa ? $mahasiswa->nama : Auth::user()->name;
                                $ini = strtoupper(substr($nama, 0, 1));
                                if (str_contains($nama, ' ')) {
                                    $parts = explode(' ', $nama);
                                    $ini = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
                                }
                            @endphp
                            {{ $ini }}
                        @endif
                    </div>
                    <div class="avatar-edit-btn" title="Ubah Foto">
                        <svg viewBox="0 0 24 24">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                            <circle cx="12" cy="13" r="4" />
                        </svg>
                    </div>
                </div>

                <h2>{{ $mahasiswa ? $mahasiswa->nama : Auth::user()->name }}</h2>
                <div class="prodi-text">
                    {{ $mahasiswa->program_studi ?? 'Belum ada jurusan' }}
                    @if($mahasiswa && $mahasiswa->angkatan)
                        • {{ $mahasiswa->angkatan }}
                    @endif
                </div>

                <div class="bio-text">
                    @if($mahasiswa && $mahasiswa->bio)
                        "{{ $mahasiswa->bio }}"
                    @else
                        <span class="empty-data">Belum menambahkan bio singkat.</span>
                    @endif
                </div>

                <a href="{{ route('pengaturan') }}" class="btn-edit-profile">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                    Edit profil
                </a>
            </div>

            <!-- Detail Right -->
            <div class="profile-right">

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Sesi belajar</h3>
                            <p>{{ $stats['sesi_belajar'] }}</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Partner</h3>
                            <p>{{ $stats['partner'] }}</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Total hari aktif</h3>
                            <p>{{ $stats['hari_aktif'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pribadi Info Card -->
                <div class="info-card">
                    <h2>Informasi Pribadi</h2>

                    <div class="info-table">
                        <div class="info-row">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">{{ $mahasiswa ? $mahasiswa->nama : Auth::user()->name }}</div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Program Studi</div>
                            <div class="info-value">
                                {{ $mahasiswa->program_studi ?? '-' }}
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Universitas</div>
                            <div class="info-value">
                                {{ $mahasiswa->universitas ?? '-' }}
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Angkatan</div>
                            <div class="info-value">
                                {{ $mahasiswa->angkatan ?? '-' }}
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Nomor HP</div>
                            <div class="info-value">
                                @if($mahasiswa && $mahasiswa->phone)
                                    {{ substr_replace($mahasiswa->phone, '******', -6) }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        @if($mahasiswa && $mahasiswa->portfolio_link)
                            <div class="info-row">
                                <div class="info-label">Portofolio</div>
                                <div class="info-value">
                                    <a href="{{ $mahasiswa->portfolio_link }}" target="_blank"
                                        style="color:var(--blue);text-decoration:underline;">Kunjungi link</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div> <!-- end profile right -->

                <!-- Preferensi Card -->
                <div class="info-card" style="margin-top:24px;">
                    <h2>Preferensi Belajar</h2>
                    <div class="info-table">
                        <div class="info-row">
                            <div class="info-label">Tingkat Kemampuan</div>
                            <div class="info-value">
                                @if($mahasiswa && $mahasiswa->tingkat_kemampuan)
                                    <span style="display:inline-block; padding:4px 12px; background:var(--blue); color:var(--white); border-radius:99px; font-size:12px; font-weight:600;">{{ $mahasiswa->tingkat_kemampuan }}</span>
                                @else
                                    <span class="empty-data">Belum diatur</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Topik Minat</div>
                            <div class="info-value" style="display:flex; flex-wrap:wrap; gap:8px;">
                                @if($mahasiswa && $mahasiswa->topik_minat)
                                    @php $topiks = explode(',', $mahasiswa->topik_minat); @endphp
                                    @foreach($topiks as $t)
                                        <span style="display:inline-block; padding:4px 12px; background:var(--sky-light, #e0f2fe); color:var(--blue); border-radius:99px; font-size:12px; font-weight:600; border:1px solid #bae6fd;">{{ trim($t) }}</span>
                                    @endforeach
                                @else
                                    <span class="empty-data">Belum ada topik yang dipilih</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Waktu Belajar</div>
                            <div class="info-value" style="display:flex; flex-wrap:wrap; gap:8px;">
                                @if($mahasiswa && is_array($mahasiswa->waktu_belajar) && count($mahasiswa->waktu_belajar) > 0)
                                    @foreach($mahasiswa->waktu_belajar as $wb)
                                        <span style="display:inline-block; padding:4px 12px; background:#fef3c7; color:#d97706; border-radius:99px; font-size:12px; font-weight:600;">{{ $wb }}</span>
                                    @endforeach
                                @else
                                    <span style="display:inline-block; padding:4px 12px; background:#f3f4f6; color:#4b5563; border-radius:99px; font-size:12px; font-weight:600;">Fleksibel</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
@endsection