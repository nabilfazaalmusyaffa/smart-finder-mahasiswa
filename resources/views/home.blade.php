<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Finder – Platform Belajar Mahasiswa</title>
    <link rel="stylesheet" href="{{ asset('css/smartfinder.css') }}">
</head>

<body>

    <div class="home-page">
        <!-- Decorative circles -->
        <div class="home-bg-circle" style="width:500px;height:500px;background:#ffffff;top:-200px;left:-150px;"></div>
        <div class="home-bg-circle" style="width:400px;height:400px;background:#2563EB;top:-100px;right:-80px;"></div>
        <div class="home-bg-circle" style="width:600px;height:600px;background:#A7FFE8;bottom:-280px;left:200px;"></div>

        <!-- Navbar -->
        <nav class="home-nav">
            <div class="brand-wrapper nav-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Smart Finder Logo" class="brand-logo">
                <span class="nav-logo-name">Smart Finder</span>
            </div>
            <div class="home-nav-btns">
                <a href="{{ route('login') }}" class="home-btn-ghost">Masuk</a>
                <a href="{{ route('daftar') }}" class="home-btn-solid">Daftar Gratis</a>
            </div>
        </nav>

        <!-- Hero -->
        <section class="home-hero">
            <div class="home-hero-left">
                <h1 class="home-hero-title">
                    Temukan Partner<br>Belajar Terbaikmu
                </h1>
                <p class="home-hero-desc">
                    Bergabung bersama ribuan mahasiswa, temukan teman belajar yang cocok
                    sesuai jurusan dan minatmu, dan raih prestasi bersama di Smart Finder.
                </p>
                <div style="display:flex;gap:14px;flex-wrap:wrap;">
                    <a href="{{ route('daftar') }}" class="home-btn-solid" style="padding:14px 32px;font-size:15px;">
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="home-btn-ghost" style="padding:14px 32px;font-size:15px;">
                        Sudah Punya Akun
                    </a>
                </div>

                <div class="home-feature-grid" style="margin-top:40px;">
                    <div class="home-feature-card">
                        <div class="home-feature-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div class="home-feature-title">Cari Partner</div>
                        <div class="home-feature-desc">Temukan teman belajar sesuai bidang studimu</div>
                    </div>
                    <div class="home-feature-card">
                        <div class="home-feature-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                            </svg>
                        </div>
                        <div class="home-feature-title">Diskusi Bersama</div>
                        <div class="home-feature-desc">Chat dan tanya jawab topik pelajaran</div>
                    </div>
                    <div class="home-feature-card">
                        <div class="home-feature-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </div>
                        <div class="home-feature-title">Jadwal Belajar</div>
                        <div class="home-feature-desc">Atur sesi belajar bersama kapan saja</div>
                    </div>
                    <div class="home-feature-card">
                        <div class="home-feature-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                            </svg>
                        </div>
                        <div class="home-feature-title">Multi Jurusan</div>
                        <div class="home-feature-desc">Tersedia untuk semua program studi</div>
                    </div>
                </div>
            </div>

            <div class="home-hero-logo-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="Smart Finder Logo" class="home-logo">
            </div>
        </section>
    </div>

</body>

</html>