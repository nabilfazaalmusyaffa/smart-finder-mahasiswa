<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Terkirim – Smart Finder</title>
    <link rel="stylesheet" href="{{ asset('css/smartfinder.css') }}">
</head>

<body>
    <div class="sf-center-page">
        <div class="sf-center-card">

            <div class="sf-center-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
            </div>

            <h1 class="sf-center-title">Kode Terkirim!</h1>
            <p class="sf-center-desc">
                Kode verifikasi telah dikirim ke<br>
                <strong style="color:var(--dark);">{{ $email }}</strong>
            </p>

            {{-- Development: tampilkan kode OTP di layar --}}
            <div
                style="background:var(--gray-100);border:2px dashed var(--teal-light);border-radius:var(--radius-md);padding:18px;text-align:center;margin:0 0 24px;">
                <div style="font-size:12px;color:var(--gray-400);margin-bottom:8px;font-weight:500;">Kode OTP (mode
                    development)</div>
                <div
                    style="font-size:40px;font-weight:800;letter-spacing:12px;color:var(--blue);font-family:'Poppins',sans-serif;">
                    {{ $kode }}</div>
            </div>

            <a href="{{ route('verify.code') }}" class="btn-primary"
                style="display:block;text-align:center;text-decoration:none;line-height:1;padding:14px;">
                Masukkan Kode Verifikasi →
            </a>

            <div style="text-align:center;margin-top:16px;">
                <a href="{{ route('password.forgot') }}" class="sf-link" style="font-size:13px;">
                    ← Ganti Email
                </a>
            </div>

        </div>
    </div>
</body>

</html>