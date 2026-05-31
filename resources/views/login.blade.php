<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – Smart Finder</title>
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

                <h2 class="auth-left-title">Belajar lebih<br>seru bersama<br>teman baru</h2>
                <p class="auth-left-desc">
                    Temukan partner belajar yang cocok, diskusi bareng,
                    dan raih tujuanmu bersama.
                </p>

                <div class="auth-feature-list">
                    <div class="auth-feature-item">
                        <div class="auth-feature-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        Cari partner belajar sesuai bidang studimu
                    </div>
                    <div class="auth-feature-item">
                        <div class="auth-feature-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                            </svg>
                        </div>
                        Diskusi dan tanya jawab secara langsung
                    </div>
                    <div class="auth-feature-item">
                        <div class="auth-feature-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>
                        Jadwalkan sesi belajar bersama kapan saja
                    </div>
                </div>
            </div>
            <p class="auth-bottom-note">Smart Finder &copy; 2025 – Platform Partner Belajar Mahasiswa</p>
        </div>

        <!-- Right Form -->
        <div class="auth-right">
            <div class="form-card">
                <h1>Selamat Datang!</h1>
                <p class="form-subtitle">Masuk untuk melanjutkan belajar bersama</p>

                @if(session('success'))
                    <div class="sf-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="sf-error">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="sf-error">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf

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
                            <input class="sf-input" type="password" name="password" id="login-password"
                                placeholder="Masukkan password" required>
                            <button type="button" class="toggle-password" data-target="login-password" tabindex="-1">
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

                    <div class="sf-row-opt">
                        <label class="sf-checkbox">
                            <input type="checkbox" name="remember">
                            <span>Ingat saya</span>
                        </label>
                        <a href="{{ route('password.forgot') }}" class="sf-link">Lupa sandi?</a>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-bottom:16px;">Masuk</button>
                </form>

                <div class="sf-divider">atau</div>

                <a href="{{ route('google.redirect') }}" class="btn-secondary google-btn" style="margin-bottom:20px;">
                    <span class="google-logo-svg">
                        <svg width="20" height="20" viewBox="0 0 48 48" aria-hidden="true">
                            <path fill="#EA4335"
                                d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                            <path fill="#4285F4"
                                d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                            <path fill="#FBBC05"
                                d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24s.92 7.54 2.56 10.78l7.97-6.19z" />
                            <path fill="#34A853"
                                d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                        </svg>
                    </span>
                    <span>Masuk dengan Google</span>
                </a>

                <div class="sf-bottom-link">
                    Belum punya akun? <a href="{{ route('daftar') }}">Daftar gratis</a>
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