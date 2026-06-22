<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart Finder')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/smartfinder.css') }}">
    @yield('styles')
    <style>
        .user-avatar-link,
        .mobile-avatar-link,
        .sidebar-user-profile {
            text-decoration: none;
            cursor: pointer;
            display: block;
        }

        .user-avatar-link:hover .dashboard-avatar,
        .user-avatar-link:hover .user-avatar,
        .mobile-avatar-link:hover .mobile-avatar,
        .sidebar-user-profile:hover .sidebar-user-avatar {
            transform: scale(1.05);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.25);
        }

        .dashboard-avatar,
        .user-avatar,
        .mobile-avatar,
        .sidebar-user-avatar {
            transition: all 0.2s ease;
        }

        .sidebar-user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            color: inherit;
            border-radius: 14px;
        }

        .sidebar-user-profile:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        @media (max-width: 768px) {
            .mobile-avatar-link {
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 44px;
                min-height: 44px;
            }

            .mobile-avatar {
                border-radius: 50%;
            }
        }
    </style>

<body>
    <!-- Mobile Overlay -->
    <div class="mobile-overlay"></div>

    <div class="dashboard-layout">

        <!-- Mobile Header (Hidden on Desktop) -->
        <header class="mobile-header">
            <button class="mobile-menu-btn" title="Toggle Menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" style="width:24px; height:24px;">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            <div class="mobile-brand">Smart Finder</div>
            <a href="{{ route('profil.saya') }}" class="mobile-avatar-link" title="Profil Saya">
                <div class="mobile-avatar">
                    @php
                        $userMobile = \Illuminate\Support\Facades\Auth::user();
                        $mahasiswaMobile = $userMobile ? \App\Models\Mahasiswa::where('email', $userMobile->email)->orWhere('user_id', $userMobile->id)->first() : null;
                        $namaMobile = $mahasiswaMobile ? $mahasiswaMobile->nama : session('mahasiswa_nama', 'User');
                        $iniMobile = strtoupper(substr($namaMobile, 0, 1));
                        if (str_contains($namaMobile, ' ')) {
                            $parts = explode(' ', $namaMobile);
                            $iniMobile = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
                        }
                        $fotoMobile = $mahasiswaMobile ? $mahasiswaMobile->foto_profil : null;
                    @endphp
                    @if($fotoMobile)
                        <img src="{{ foto_profil_url($fotoMobile) }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        {{ $iniMobile }}
                    @endif
                </div>
            </a>
        </header>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand-wrapper sidebar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Smart Finder" class="sidebar-logo">
                <span>Smart Finder</span>
            </div>

            <div class="sidebar-section-label">Menu Utama</div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}"
                    class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('cari.partner') }}"
                    class="sidebar-item {{ request()->routeIs('cari.partner') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <circle cx="19" cy="11" r="3"></circle>
                        <line x1="21" y1="13" x2="23" y2="15"></line>
                    </svg>
                    Cari Partner
                </a>
                <a href="{{ route('eksplor.topik') ?? '#' }}"
                    class="sidebar-item {{ request()->routeIs('eksplor.topik') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                    </svg>
                    Eksplor Topik
                </a>
                <a href="{{ route('community.index') }}"
                    class="sidebar-item {{ request()->routeIs('community.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M9 21v-2a4 4 0 0 1 4-4h.5"></path>
                        <circle cx="13" cy="7" r="4"></circle>
                        <circle cx="6" cy="10" r="3"></circle>
                        <path d="M3 21v-2a4 4 0 0 1 2-3.8"></path>
                    </svg>
                    Komunitas
                </a>
                <a href="{{ route('obrolan') ?? '#' }}"
                    class="sidebar-item {{ request()->routeIs('obrolan') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        <path d="M8 10h.01"></path>
                        <path d="M12 10h.01"></path>
                        <path d="M16 10h.01"></path>
                    </svg>
                    Obrolan
                </a>
            </nav>

            <div class="sidebar-section-label">Akun</div>

            <nav class="sidebar-nav">
                <a href="{{ route('profil.saya') }}"
                    class="sidebar-item {{ request()->routeIs('profil.saya') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Profil Saya
                </a>
            </nav>

            <div class="sidebar-section-label">Lainnya</div>

            <nav class="sidebar-nav">
                <a href="{{ route('pengaturan') ?? '#' }}"
                    class="sidebar-item {{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    Pengaturan
                </a>
                <a href="{{ route('notifikasi') }}"
                    class="sidebar-item {{ request()->routeIs('notifikasi') ? 'active' : '' }}"
                    style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <svg viewBox="0 0 24 24" style="width:22px;height:22px;stroke:currentColor;stroke-width:2.2;fill:none;stroke-linecap:round;stroke-linejoin:round;transition:transform .2s ease;">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        Notifikasi
                    </div>
                    @php
                        $unreadNotifs = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                    @endphp
                    @if($unreadNotifs > 0)
                        <span
                            style="background:var(--red); color:var(--white); font-size:12px; font-weight:700; padding:2px 8px; border-radius:12px;">
                            {{ $unreadNotifs }}
                        </span>
                    @endif
                </a>
            </nav>

            <div class="sidebar-bottom">
                <a href="{{ route('profil.saya') }}" class="sidebar-user-profile" style="margin-bottom:16px; padding:8px 10px;">
                    @php
                        $userSidebar = \Illuminate\Support\Facades\Auth::user();
                        $mahasiswaSidebar = $userSidebar ? \App\Models\Mahasiswa::where('email', $userSidebar->email)->orWhere('user_id', $userSidebar->id)->first() : null;
                        $namaSidebar = $mahasiswaSidebar ? $mahasiswaSidebar->nama : session('mahasiswa_nama', 'User');
                        $iniSidebar = strtoupper(substr($namaSidebar, 0, 1));
                        if (str_contains($namaSidebar, ' ')) {
                            $partsSidebar = explode(' ', $namaSidebar);
                            $iniSidebar = strtoupper(substr($partsSidebar[0], 0, 1) . substr($partsSidebar[1], 0, 1));
                        }
                        $fotoSidebar = $mahasiswaSidebar ? $mahasiswaSidebar->foto_profil : null;
                    @endphp
                    <div class="sidebar-user-avatar"
                        style="width:36px; height:36px; border-radius:50%; background:var(--white); color:var(--blue); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; flex-shrink:0; overflow:hidden;">
                        @if($fotoSidebar)
                            <img src="{{ foto_profil_url($fotoSidebar) }}" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            {{ $iniSidebar }}
                        @endif
                    </div>
                    <div class="sidebar-user-info" style="overflow:hidden;">
                        <div
                            style="color:var(--white); font-weight:600; font-size:14px; white-space:nowrap; text-overflow:ellipsis; overflow:hidden;">
                            {{ $namaSidebar }}
                        </div>
                        <div style="color:rgba(255,255,255,0.6); font-size:11px;">Mahasiswa</div>
                    </div>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-logout-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-main">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuBtn = document.querySelector('.mobile-menu-btn');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.mobile-overlay');

            if (menuBtn && sidebar && overlay) {
                menuBtn.addEventListener('click', () => {
                    sidebar.classList.add('mobile-open');
                    overlay.classList.add('active');
                });

                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('active');
                });

                // Auto close when a link is clicked
                document.querySelectorAll('.sidebar-item').forEach(link => {
                    link.addEventListener('click', () => {
                        sidebar.classList.remove('mobile-open');
                        overlay.classList.remove('active');
                    });
                });
            }

            // Heartbeat
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (csrfTokenMeta) {
                const token = csrfTokenMeta.getAttribute('content');
                setInterval(() => {
                    fetch('/user/heartbeat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        }
                    }).catch(err => console.error('Heartbeat failed', err));
                }, 15000); // 15 seconds as requested by user to be safe (15-30s)
            }
        });
    </script>
    @yield('scripts')
</body>

</html>