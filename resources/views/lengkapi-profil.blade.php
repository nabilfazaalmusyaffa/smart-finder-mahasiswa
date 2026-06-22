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

                <div class="profil-form-grid" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom:24px;">
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
                            <label class="sf-label">Provinsi Kampus</label>
                            <select class="sf-input-plain" id="provinsi" name="provinsi" required style="width:100%; height:46px; border-radius:14px; background:#f8fbff; border:1px solid #dbe3ef;">
                                <option value="">Pilih Provinsi</option>
                                <!-- Populated by JS -->
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="sf-form-group">
                            <label class="sf-label">Universitas</label>
                            <select class="sf-input-plain" id="universitas" name="universitas" required style="width:100%; height:46px; border-radius:14px; background:#f8fbff; border:1px solid #dbe3ef;">
                                <option value="">Pilih Universitas</option>
                                @if($mahasiswa->universitas)
                                    <option value="{{ $mahasiswa->universitas }}" selected>{{ $mahasiswa->universitas }}</option>
                                @endif
                                <!-- Populated by JS -->
                            </select>
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
                        $topics = [
                            'Programming', 'Web Dev', 'Mobile Dev', 'Data Science', 'Machine Learning', 
                            'UI/UX Design', 'Digital Marketing', 'Copywriting', 'Bisnis & Manajemen', 
                            'Akuntansi', 'Bahasa Asing', 'Matematika', 'Sains', 'Hukum', 'Public Speaking'
                        ];
                        $selected = $mahasiswa->topik_minat ? explode(',', $mahasiswa->topik_minat) : [];
                        $allSelected = array_filter(array_map('trim', $selected));
                    @endphp

                    <div class="topic-grid" id="topicGrid" style="margin-top:16px;">
                        @foreach($topics as $topic)
                            @php $isSelected = in_array($topic, $allSelected); @endphp
                            <label class="topic-chip {{ $isSelected ? 'selected' : '' }}">
                                <input type="checkbox" name="topik_minat[]" value="{{ $topic }}" {{ $isSelected ? 'checked' : '' }} onchange="updateTopicCount(this)">
                                {{ $topic }}
                            </label>
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
        // Load data universitas
        let dataUniversitas = [];
        const savedProvinsi = "{{ $mahasiswa->provinsi ?? '' }}";
        const savedUniversitas = "{{ $mahasiswa->universitas ?? '' }}";

        fetch('/data/universitas.json')
            .then(res => res.json())
            .then(data => {
                dataUniversitas = data;
                const provSelect = document.getElementById('provinsi');
                
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.provinsi;
                    option.textContent = item.provinsi;
                    if (item.provinsi === savedProvinsi) {
                        option.selected = true;
                    }
                    provSelect.appendChild(option);
                });

                if (savedProvinsi) {
                    populateUniversitas(savedProvinsi, savedUniversitas);
                }
            })
            .catch(err => console.error("Gagal memuat data universitas", err));

        document.getElementById('provinsi').addEventListener('change', function() {
            populateUniversitas(this.value);
        });

        function populateUniversitas(provinsi, selectedUniv = '') {
            const univSelect = document.getElementById('universitas');
            univSelect.innerHTML = '<option value="">Pilih Universitas</option>';
            
            if (!provinsi) return;

            const provData = dataUniversitas.find(p => p.provinsi === provinsi);
            if (provData) {
                provData.universitas.forEach(univ => {
                    const option = document.createElement('option');
                    option.value = univ;
                    option.textContent = univ;
                    if (univ === selectedUniv) option.selected = true;
                    univSelect.appendChild(option);
                });
            }
        }

        function previewFoto(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var container = document.getElementById('avatarPreview');
                    container.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updateTopicCount(checkbox) {
            var checked = document.querySelectorAll('input[name="topik_minat[]"]:checked');
            if (checked.length > 6) {
                checkbox.checked = false;
                alert('Maksimal 6 topik minat!');
                return;
            }
            document.getElementById('topicCounter').innerText = checked.length + '/6';
            
            if(checkbox.checked) {
                checkbox.parentElement.classList.add('selected');
            } else {
                checkbox.parentElement.classList.remove('selected');
            }
        }

        // Init counter
        window.onload = function() {
            var checked = document.querySelectorAll('input[name="topik_minat[]"]:checked');
            document.getElementById('topicCounter').innerText = checked.length + '/6';
        };
    </script>
</body>

</html>