<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Kata Sandi – Smart Finder</title>
    <link rel="stylesheet" href="{{ asset('css/smartfinder.css') }}">
</head>

<body>
    <div class="sf-center-page">
        <div class="sf-center-card">

            <div class="sf-center-logo-wrap" style="justify-content:center;">
                <img src="{{ asset('images/logo.png') }}" alt="Smart Finder Logo" class="brand-logo large">
            </div>

            <h1 class="sf-center-title">Ganti Kata Sandi</h1>
            <p class="sf-center-desc">
                Masukkan kata sandi baru untuk akunmu.
            </p>

            @if($errors->any())
            <div class="sf-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                <div class="sf-form-group">
                    <label class="sf-label">Kata Sandi Baru</label>
                    <div class="sf-input-wrap">
                        <span class="sf-input-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                        <input class="sf-input" type="password" name="password" id="newPwd"
                            placeholder="Minimal 6 karakter" required>
                    </div>
                </div>

                <div class="sf-form-group">
                    <label class="sf-label">Konfirmasi Kata Sandi</label>
                    <div class="sf-input-wrap">
                        <span class="sf-input-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                        <input class="sf-input" type="password" name="password_confirmation" id="confPwd"
                            placeholder="Ulangi kata sandi baru" required>
                    </div>
                </div>

                <div style="font-size:12px;color:var(--gray-400);margin:-8px 0 16px;padding-left:4px;" id="matchMsg">
                </div>

                <button type="submit" class="btn-primary">Simpan Kata Sandi</button>
            </form>

        </div>
    </div>

    <script>
        const newPwd = document.getElementById('newPwd');
        const confPwd = document.getElementById('confPwd');
        const msg = document.getElementById('matchMsg');

        function checkMatch() {
            if (!confPwd.value) { msg.textContent = ''; return; }
            if (newPwd.value === confPwd.value) {
                msg.textContent = '✓ Kata sandi cocok';
                msg.style.color = 'var(--green)';
            } else {
                msg.textContent = '✗ Kata sandi tidak cocok';
                msg.style.color = 'var(--red)';
            }
        }

        newPwd.addEventListener('input', checkMatch);
        confPwd.addEventListener('input', checkMatch);
    </script>
</body>

</html>