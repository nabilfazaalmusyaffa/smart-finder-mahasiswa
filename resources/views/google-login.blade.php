<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login dengan Google – Smart Finder</title>
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

                <h2 class="auth-left-title">Masuk dengan<br>akun<br>Google-mu</h2>
                <p class="auth-left-desc">
                    Login cepat menggunakan akun Google. Data akunmu aman bersama kami.
                </p>
            </div>
            <p class="auth-bottom-note">Simulasi UI – OAuth tidak aktif di lingkungan ini.</p>
        </div>

        <!-- Right: Account Picker -->
        <div class="auth-right">
            <div class="form-card">

                <div class="google-header" style="display:flex;align-items:center;gap:12px;margin-bottom:6px;">
                    <span class="google-logo-svg">
                        <svg width="24" height="24" viewBox="0 0 48 48" aria-hidden="true"
                            style="width:24px;height:24px;">
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
                    <div>
                        <h2 style="font-size:16px;font-weight:700;color:var(--dark);margin-bottom:0;">Login dengan
                            Google</h2>
                        <p style="font-size:12px;color:var(--gray-400);margin-bottom:0;">Pilih akun untuk lanjut ke
                            Smart Finder</p>
                    </div>
                </div>

                <div style="height:1px;background:var(--gray-200);margin:16px 0 20px;"></div>

                <div class="google-accounts">
                    @php
                    $accounts = [
                    ['nama' => 'Budi Santoso', 'email' => 'budi.santoso@gmail.com', 'initials' => 'BS'],
                    ['nama' => 'Siti Aminah', 'email' => 'siti.aminah@gmail.com', 'initials' => 'SA'],
                    ['nama' => 'Rizky Pratama', 'email' => 'rizky.pratama@gmail.com', 'initials' => 'RP'],
                    ];
                    @endphp

                    @foreach($accounts as $acc)
                    <form action="{{ route('google.choose') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $acc['email'] }}">
                        <input type="hidden" name="nama" value="{{ $acc['nama'] }}">
                        <button type="submit" class="google-account-btn">
                            <div class="google-avatar">{{ $acc['initials'] }}</div>
                            <div class="google-info">
                                <div class="google-name">{{ $acc['nama'] }}</div>
                                <div class="google-email">{{ $acc['email'] }}</div>
                            </div>
                            <div class="google-arrow">›</div>
                        </button>
                    </form>
                    @endforeach
                </div>

                <div style="height:1px;background:var(--gray-200);margin:20px 0 16px;"></div>

                <!-- Gunakan akun lain -->
                <div style="margin-bottom:4px;">
                    <button onclick="toggleCustom()" class="btn-secondary" style="margin-bottom:0;">
                        <svg viewBox="0 0 24 24"
                            style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Gunakan Akun Lain
                    </button>
                </div>

                <div id="customForm" style="display:none;margin-top:16px;">
                    <form action="{{ route('google.choose') }}" method="POST" id="customGoogleForm">
                        @csrf
                        <input type="hidden" name="email" id="customEmail">
                        <input type="hidden" name="nama" id="customNama">

                        <div class="sf-form-group">
                            <label class="sf-label">Nama</label>
                            <input class="sf-input-plain" type="text" id="inputNama" placeholder="Nama lengkap">
                        </div>
                        <div class="sf-form-group">
                            <label class="sf-label">Email Gmail</label>
                            <input class="sf-input-plain" type="email" id="inputEmail" placeholder="email@gmail.com">
                        </div>
                        <button type="button" onclick="submitCustom()" class="btn-primary">
                            Lanjut
                        </button>
                    </form>
                </div>

                <div style="text-align:center;margin-top:20px;">
                    <a href="{{ route('login') }}" class="sf-link" style="font-size:13px;">
                        ← Kembali ke Login
                    </a>
                </div>
            </div>
        </div>

    </div>

    <script>
        func             toggleCustom() {
            const el = document.            lementById('customForm');
            el.style.display = el.style.d        isp        lay === 'none' ? 'block' :            ne';
       }

        function submitCustom() {
            con            ama = document.getElementById('inputNama').value.trim();
                     onst email = document.getElementById('inputEmail').value.trim();
                    if (!nama || !email) { alert('Nama dan em l harus             i.'); return; }
            document.getElementById('c            mNama').value = nama;
            document.getElementB        yId('mail').value = email;
            document.getElementById('customGoogleForm').submit();
        }
    </script>
</body>

</html>