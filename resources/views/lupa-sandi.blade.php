<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi – Smart Finder</title>
    <link rel="stylesheet" href="{{ asset('css/smartfinder.css') }}">
</head>

<body>
    <div class="sf-center-page">
        <div class="sf-center-card">

            <div class="sf-center-logo-wrap" style="justify-content:center;">
                <img src="{{ asset('images/logo.png') }}" alt="Smart Finder Logo" class="brand-logo large">
            </div>

            <h1 class="sf-center-title">Lupa Kata Sandi?</h1>
            <p class="sf-center-desc">
                Masukkan email yang terdaftar. Kami akan mengirimkan kode verifikasi 6 digit ke email tersebut.
            </p>

            @if($errors->any())
            <div class="sf-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('password.send') }}" method="POST">
                @csrf

                <div class="sf-form-group">
                    <label class="sf-label">Alamat Email</label>
                    <div class="sf-input-wrap">
                        <span class="sf-input-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </span>
                        <input class="sf-input" type="email" name="email" placeholder="email@contoh.com"
                            value="{{ old('email') }}" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="margin-bottom:16px;">
                    Kirim Kode Verifikasi
                </button>
            </form>

            <div style="text-align:center;">
                <a href="{{ route('login') }}" class="sf-link" style="font-size:13px;">
                    ← Kembali ke Login
                </a>
            </div>

        </div>
    </div>
</body>

</html>