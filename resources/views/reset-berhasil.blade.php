<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Berhasil – Smart Finder</title>
    <link rel="stylesheet" href="{{ asset('css/smartfinder.css') }}">
</head>

<body>
    <div class="sf-center-page">
        <div class="sf-center-card" style="text-align:center;">

            <div class="sf-center-icon" style="background:linear-gradient(135deg,#dcfce7,#bbf7d0);">
                <svg viewBox="0 0 24 24" style="stroke:#059669;">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>

            <h1 class="sf-center-title">Kata Sandi Berhasil Diubah!</h1>
            <p class="sf-center-desc">
                Kata sandimu sudah berhasil diperbarui.<br>
                Silakan login menggunakan kata sandi barumu.
            </p>

            <div
                style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:var(--radius-sm);padding:14px 18px;color:#166534;font-size:13px;font-weight:500;margin-bottom:24px;">
                Akunmu sudah aman kembali.
            </div>

            <a href="{{ route('login') }}" class="btn-primary"
                style="display:block;text-align:center;text-decoration:none;line-height:1;padding:14px;">
                Masuk Sekarang
            </a>

        </div>
    </div>
</body>

</html>