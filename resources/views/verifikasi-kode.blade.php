<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode – Smart Finder</title>
    <link rel="stylesheet" href="{{ asset('css/smartfinder.css') }}">
</head>

<body>
    <div class="sf-center-page">
        <div class="sf-center-card">

            <div class="sf-center-logo-wrap" style="justify-content:center;">
                <img src="{{ asset('images/logo.png') }}" alt="Smart Finder Logo" class="brand-logo large">
            </div>

            <h1 class="sf-center-title">Masukkan Kode OTP</h1>
            <p class="sf-center-desc">
                Masukkan 6 digit kode verifikasi yang telah dikirim ke emailmu.
            </p>

            @if($errors->any())
            <div class="sf-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('verify.process') }}" method="POST" id="otpForm">
                @csrf
                {{-- Hidden field to collect combined OTP --}}
                <input type="hidden" name="kode" id="otpHidden">

                <div class="otp-grid" id="otpGrid">
                    @for($i = 0; $i < 6; $i++) <input class="otp-box" type="text" maxlength="1" inputmode="numeric"
                        pattern="\d" id="otp{{ $i }}" data-index="{{ $i }}" autocomplete="off">
                        @endfor
                </div>

                <button type="submit" class="btn-primary" style="margin-bottom:16px;">Verifikasi</button>
            </form>

            <div style="text-align:center;">
                <a href="{{ route('password.forgot') }}" class="sf-link" style="font-size:13px;">
                    Kirim ulang kode
                </a>
            </div>

        </div>
    </div>

    <script>
        const boxes = document.querySelectorAll('.otp-box');

        boxes.forEach((box, i) => {
            box.addEventListener('input', () => {
                box.value = box.value.replace(/\D/, '');
                if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
                syncHidden();
            });
            box.addEventListener('keydown', e => {
                if (e.key === 'Backspace' && !box.value && i > 0) {
                    boxes[i - 1].focus();
                }
                if (e.key === 'ArrowRight' && i < boxes.length - 1) boxes[i + 1].focus();
                if (e.key === 'ArrowLeft' && i > 0) boxes[i - 1].focus();
            });
            box.addEventListener('paste', e => {
                e.preventDefault();
                const text = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
                text.split('').forEach((ch, j) => { if (boxes[j]) boxes[j].value = ch; });
                syncHidden();
                if (boxes[text.length]) boxes[text.length].focus();
            });
        });

        function syncHidden() {
            document.getElementById('otpHidden').value = [...boxes].map(b => b.value).join('');
        }

        document.getElementById('otpForm').addEventListener('submit', function (e) {
            syncHidden();
            const val = document.getElementById('otpHidden').value;
            if (val.length < 6) {
                e.preventDefault();
                alert('Masukkan seluruh 6 digit kode OTP.');
            }
        });
    </script>
</body>

</html>