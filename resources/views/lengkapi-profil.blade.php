<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil – Smart Finder</title>
    <link rel="stylesheet" href="{{ asset('css/smartfinder.css') }}">
</head>

<body>
    <div class="profil-page">
        <div class="profil-card">

            <!-- Logo -->
            <div class="brand-wrapper"
                style="margin-bottom:28px; justify-content:center; display:flex; align-items:center; gap:12px;">
                <img src="{{ asset('images/logo.png') }}" alt="Smart Finder Logo" class="brand-logo"
                    style="width:48px;height:48px;">
                <span style="font-size:28px;font-weight:800;color:var(--blue-dark);letter-spacing:-0.5px;">Smart
                    Finder</span>
            </div>

            <!-- Header -->
            <div class="profil-header">
                @php
                    $nama = $mahasiswa->nama ?? session('mahasiswa_nama', 'User');
                    $initials = strtoupper(substr($nama, 0, 1));
                    if (str_contains($nama, ' ')) {
                        $parts = explode(' ', $nama);
                        $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
                    }
                @endphp

                <label for="foto_upload" style="cursor:pointer;">
                    <div class="profil-avatar" id="avatarPreview">
                        @if($mahasiswa->foto_profil)
                            <img src="{{ foto_profil_url($mahasiswa->foto_profil) }}"
                                style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                        @else
                            {{ $initials }}
                        @endif
                        <div class="profil-avatar-edit">
                            <svg viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </div>
                    </div>
                </label>

                <div class="profil-card-title">Lengkapi Profil</div>
                <div class="profil-card-subtitle">Isi profil anda dan segera temukan partner belajar</div>
            </div>

            @if(session('success'))
                <div class="sf-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="sf-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('profil.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="file" id="foto_upload" name="foto_profil" accept="image/*" style="display:none;"
                    onchange="previewFoto(this)">

                <div class="profil-form-grid">
                    <div>
                        <div class="sf-form-group">
                            <label class="sf-label">Program Studi</label>
                            <input class="sf-input-plain" type="text" name="program_studi"
                                placeholder="Contoh: Teknik Informatika"
                                value="{{ old('program_studi', $mahasiswa->program_studi) }}" required>
                        </div>
                    </div>
                    <div>
                        <div class="sf-form-group">
                            <label class="sf-label">Universitas</label>
                            <input class="sf-input-plain" type="text" name="universitas"
                                placeholder="Contoh: Universitas Gadjah Mada"
                                value="{{ old('universitas', $mahasiswa->universitas) }}" required>
                        </div>
                    </div>
                </div>

                <!-- Topic Selection -->
                <div style="margin-bottom:24px;">
                    <div class="topic-label">
                        Topik yang Diminati
                        <span class="topic-count" id="topicCounter">0/6</span>
                    </div>

                    @php
                        $topics = ['Machine Learning', 'Web Dev', 'Basis Data', 'Algoritma', 'Cyber Sec', 'Lainnya'];
                        $selected = $mahasiswa->topik_minat ? explode(',', $mahasiswa->topik_minat) : [];
                        $keahlian_custom = $mahasiswa->keahlian_custom ? explode(',', $mahasiswa->keahlian_custom) : [];
                        $allSelected = array_merge($selected, $keahlian_custom);
                        $allSelected = array_filter(array_map('trim', $allSelected));
                    @endphp

                    <div style="display:flex; gap:12px; margin-bottom:18px;">
                        <input class="sf-input-plain" type="text" id="customTopicInput"
                            placeholder="Tambah topik minat... (contoh: Laravel, Figma, MySQL)" style="flex:1;">
                        <button type="button" class="btn-primary"
                            style="width:150px; flex:none; display:flex; align-items:center; justify-content:center; gap:8px;"
                            onclick="addCustomTopic()">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Tambah
                        </button>
                    </div>

                    <div class="topic-grid" id="topicGrid">
                        @foreach($topics as $topic)
                                            @php $isSelected = in_array($topic, $allSelected); @endphp
                                            <label class="topic-chip {{ $isSelected ? 'selected' : '' }}">
                                                <input type="checkbox" name="topik_minat[]" value="{{ $topic }}" {{ $isSelected ? 'checked'
                            : '' }} onchange="updateTopicCount(this)">
                                                <svg viewBox="0 0 24 24">
                                                    @if($topic === 'Machine Learning')
                                                        <rect x="2" y="2" width="20" height="8" rx="2" />
                                                        <rect x="2" y="14" width="20" height="8" rx="2" />
                                                        <line x1="6" y1="6" x2="6.01" y2="6" />
                                                        <line x1="6" y1="18" x2="6.01" y2="18" />
                                                    @elseif($topic === 'Web Dev')
                                                        <polyline points="16 18 22 12 16 6" />
                                                        <polyline points="8 6 2 12 8 18" />
                                                    @elseif($topic === 'Basis Data')
                                                        <ellipse cx="12" cy="5" rx="9" ry="3" />
                                                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                                                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                                                    @elseif($topic === 'Algoritma')
                                                        <line x1="18" y1="20" x2="18" y2="10" />
                                                        <line x1="12" y1="20" x2="12" y2="4" />
                                                        <line x1="6" y1="20" x2="6" y2="14" />
                                                    @elseif($topic === 'Cyber Sec')
                                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                                    @else
                                                        <circle cx="12" cy="12" r="10" />
                                                        <line x1="12" y1="8" x2="12" y2="12" />
                                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                                    @endif
                                                </svg>
                                                {{ $topic }}
                                            </label>
                        @endforeach

                        @foreach($keahlian_custom as $custom)
                            @if(!in_array(trim($custom), $topics) && !empty(trim($custom)))
                                <label class="topic-chip selected">
                                    <input type="checkbox" name="topik_minat[]" value="{{ trim($custom) }}" checked
                                        onchange="updateTopicCount(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                                    </svg>
                                    {{ trim($custom) }}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    Simpan &amp; Lanjutkan
                </button>
            </form>

        </div>
    </div>

    <script>
        function previewFoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const el = document.getElementById('avatarPreview');
                    el.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            <div class="profil-avatar-edit">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" width="14" height="14"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updateTopicCount(changedEl = null) {
            const checkboxes = document.querySelectorAll('#topicGrid input[type="checkbox"]');
            const checked = document.querySelectorAll('#topicGrid input[type="checkbox"]:checked');
            const counter = document.getElementById('topicCounter');
            counter.textContent = checked.length + '/6';
            counter.style.color = checked.length >= 6 ? 'var(--blue)' : 'var(--gray-400)';

            if (changedEl) {
                if (changedEl.checked) {
                    changedEl.parentElement.classList.add('selected');
                } else {
                    changedEl.parentElement.classList.remove('selected');
                }
            }

            // Disable unchecked if max reached
            checkboxes.forEach(cb => {
                if (!cb.checked && checked.length >= 6) {
                    cb.parentElement.style.opacity = '0.4';
                    cb.parentElement.style.pointerEvents = 'none';
                } else {
                    cb.parentElement.style.opacity = '';
                    cb.parentElement.style.pointerEvents = '';
                }
            });
        }

        function addCustomTopic() {
            const input = document.getElementById('customTopicInput');
            let val = input.value.trim();
            if (!val) return;

            // Check max limit
            const checkedCount = document.querySelectorAll('#topicGrid input[type="checkbox"]:checked').length;
            if (checkedCount >= 6) {
                alert('Maksimal 6 topik/keahlian telah dipilih.');
                return;
            }

            // Prevent duplicate UI
            const exists = Array.from(document.querySelectorAll('#topicGrid input[type="checkbox"]')).some(cb => cb.value.toLowerCase() === val.toLowerCase());
            if (exists) {
                input.value = '';
                return;
            }

            const grid = document.getElementById('topicGrid');
            const label = document.createElement('label');
            label.className = 'topic-chip selected';
            label.innerHTML = `
                <input type="checkbox" name="topik_minat[]" value="${val}" checked onchange="updateTopicCount(this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                ${val}
            `;
            grid.appendChild(label);
            input.value = '';

            // Re-bind click event is not needed because we use onchange attribute
            updateTopicCount();
        }

        // Init on load
        window.addEventListener('DOMContentLoaded', updateTopicCount);
    </script>
</body>

</html>