<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar – Smart Finder</title>
    <link rel="stylesheet" href="{{ asset('css/smartfinder.css') }}">
</head>

<body>
    <div class="auth-page">

        <!-- Left Branding -->
        <div class="auth-left">
            <div>
                <div class="brand-wrapper">
                    <img src="{{ asset('images/logo.png') }}" alt="Smart Finder Logo" class="brand-logo">
                    <h1>Smart Finder</h1>
                </div>

                <h2 class="auth-left-title">Bergabung dan<br>mulai belajar<br>bersama hari ini</h2>
                <p class="auth-left-desc">
                    Ribuan mahasiswa sudah menemukan partner belajar mereka di Smart Finder.
                </p>

                <div class="auth-feature-list">
                    <div class="auth-feature-item">
                        <div class="auth-feature-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                                <path d="M6 12v5c3 3 9 3 12 0v-5" />
                            </svg>
                        </div>
                        Berbagai bidang studi tersedia untuk semua
                    </div>
                    <div class="auth-feature-item">
                        <div class="auth-feature-icon">
                            <svg viewBox="0 0 24 24">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                        Tantangan belajar mingguan bersama komunitas
                    </div>
                    <div class="auth-feature-item">
                        <div class="auth-feature-icon">
                            <svg viewBox="0 0 24 24">
                                <line x1="18" y1="20" x2="18" y2="10" />
                                <line x1="12" y1="20" x2="12" y2="4" />
                                <line x1="6" y1="20" x2="6" y2="14" />
                            </svg>
                        </div>
                        Pantau perkembangan belajarmu setiap hari
                    </div>
                </div>
            </div>
            <p class="auth-bottom-note">Smart Finder &copy; 2025 – Platform Partner Belajar Mahasiswa</p>
        </div>

        <!-- Right Form -->
        <div class="auth-right">
            <div class="form-card">
                <h1>Buat Akun Baru</h1>
                <p class="form-subtitle">Isi informasi dasar untuk membuat akunmu</p>

                @if($errors->any())
                    <div class="sf-error">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('daftar.store') }}" method="POST">
                    @csrf

                    <div class="sf-form-group">
                        <label class="sf-label">Nama Lengkap</label>
                        <div class="sf-input-wrap">
                            <span class="sf-input-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <input class="sf-input" type="text" name="nama" placeholder="Nama lengkapmu"
                                value="{{ old('nama') }}" required>
                        </div>
                    </div>

                    <div class="sf-form-group">
                        <label class="sf-label">Username</label>
                        <div class="sf-input-wrap">
                            <span class="sf-input-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <input class="sf-input" type="text" name="username" placeholder="username_unik"
                                value="{{ old('username') }}" required>
                        </div>
                    </div>

                    <div class="sf-form-group">
                        <label class="sf-label">Email</label>
                        <div class="sf-input-wrap">
                            <span class="sf-input-icon">
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </span>
                            <input class="sf-input" type="email" name="email" placeholder="email@contoh.com"
                                value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="sf-form-group">
                        <label class="sf-label">Password</label>
                        <div class="sf-input-wrap password-wrapper">
                            <span class="sf-input-icon">
                                <svg viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input class="sf-input" type="password" name="password" id="daftar-password"
                                placeholder="Minimal 6 karakter" required>
                            <button type="button" class="toggle-password" data-target="daftar-password" tabindex="-1">
                                <svg class="icon-eye" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg class="icon-eye-off" viewBox="0 0 24 24">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="sf-form-group">
                        <label class="sf-label">Nomor Telepon <span
                                style="color:var(--gray-400);font-weight:400;">(opsional)</span></label>
                        <div class="sf-input-wrap">
                            <span class="sf-input-icon">
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13 19.79 19.79 0 0 1 1.61 4.37 2 2 0 0 1 3.58 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.07 6.07l1.47-1.47a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                            </span>
                            <input class="sf-input" type="text" name="phone" placeholder="08xx-xxxx-xxxx"
                                value="{{ old('phone') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-bottom:16px;">Buat Akun</button>
                </form>

                <div class="sf-bottom-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
                </div>
            </div>
        </div>

    </div>
</body>

<script>
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(this.dataset.target);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.add('showing');
            } else {
                input.type = 'password';
                this.classList.remove('showing');
            }
        });
    });
</script>

</html>