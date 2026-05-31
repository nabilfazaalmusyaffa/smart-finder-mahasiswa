@extends('layouts.dashboard')

@section('title', 'Pengaturan – Smart Finder')

@section('styles')
<style>
/* CSS Halaman Pengaturan */
.settings-header {
    border-bottom: 1px solid var(--gray-200);
    padding-bottom: 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.settings-header svg {
    width: 28px;
    height: 28px;
    stroke: var(--blue);
    stroke-width: 2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.settings-title-text h1 {
    font-size: 24px;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 4px;
}
.settings-title-text p {
    font-size: 14px;
    color: var(--gray-600);
}

.settings-container {
    display: flex;
    gap: 32px;
    align-items: flex-start;
}
@media(max-width: 850px) {
    .settings-container {
        flex-direction: column;
    }
}

/* Sidebar Tab Vertikal */
.settings-tabs {
    width: 260px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
@media(max-width: 850px) {
    .settings-tabs {
        width: 100%;
    }
}
.setting-tab-item {
    display: block;
    padding: 12px 16px;
    border-radius: var(--radius-md);
    background: transparent;
    color: var(--gray-600);
    text-decoration: none;
    transition: all .2s;
}
.setting-tab-item:hover {
    background: var(--gray-100);
    color: var(--blue);
}
.setting-tab-item.active {
    background: #E0F2FE; /* Cyan muda */
    color: var(--blue);
    font-weight: 600;
    box-shadow: var(--shadow-sm);
}
.setting-tab-item-title {
    font-size: 15px;
    margin-bottom: 2px;
}
.setting-tab-item-sub {
    font-size: 12px;
    color: var(--gray-500);
    font-weight: 400;
}
.setting-tab-item.active .setting-tab-item-sub {
    color: rgba(37, 99, 235, 0.7);
}

/* Content Area */
.settings-content {
    flex-grow: 1;
    min-width: 0;
    background: transparent;
}
.setting-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    padding: 24px;
    margin-bottom: 24px;
}
.setting-card-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 6px;
}
.setting-card-sub {
    font-size: 14px;
    color: var(--gray-600);
    margin-bottom: 24px;
}

/* Form Styles */
.setting-form-group {
    margin-bottom: 20px;
}
.setting-form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 8px;
}
.setting-form-group input, 
.setting-form-group select, 
.setting-form-group textarea {
    width: 100%;
    padding: 12px 16px;
    border-radius: var(--radius-md);
    border: 1px solid var(--gray-300);
    font-size: 14px;
    color: var(--dark);
    background: var(--white);
    transition: border-color .2s;
}
.setting-form-group input:focus, 
.setting-form-group select:focus, 
.setting-form-group textarea:focus {
    outline: none;
    border-color: var(--blue);
}
.setting-form-group textarea {
    resize: vertical;
    min-height: 80px;
}

/* Checkbox/Switch Style (simplified to checkbox) */
.toggle-switch-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid var(--gray-100);
}
.toggle-switch-wrapper:last-child {
    border-bottom: none;
}
.toggle-label {
    font-size: 15px;
    color: var(--dark);
    font-weight: 500;
}
.setting-checkbox {
    width: 18px;
    height: 18px;
    accent-color: var(--blue);
    cursor: pointer;
}

/* Topics / Level Buttons */
.topic-btn, .level-btn, .day-btn {
    display: inline-block;
    padding: 8px 16px;
    border: 1px solid var(--gray-300);
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    color: var(--gray-600);
    cursor: pointer;
    background: var(--white);
    margin-right: 8px;
    margin-bottom: 12px;
    transition: all .2s;
}
.topic-btn.active, .level-btn.active, .day-btn.active {
    background: #E0F2FE;
    color: var(--blue);
    border-color: var(--blue);
}

.settings-input {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #dbe3ef;
    border-radius: 16px;
    background: #f8fbff;
    font-size: 15px;
    color: #0f172a;
    outline: none;
    transition: all 0.2s ease;
}
.settings-input:focus {
    border-color: #2563eb;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
}
.settings-textarea {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #dbe3ef;
    border-radius: 16px;
    background: #f8fbff;
    font-size: 15px;
    color: #0f172a;
    outline: none;
    transition: all 0.2s ease;
    min-height: 120px;
    resize: vertical;
}
.settings-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 22px;
}
.preference-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 18px;
    border-radius: 999px;
    border: 1px solid #dbe3ef;
    background: #ffffff;
    cursor: pointer;
    font-weight: 600;
    transition: all .2s;
    user-select: none;
}
.preference-chip.active {
    background: #E0F2FE;
    border-color: #2563eb;
    color: #2563eb;
}
.level-card {
    padding: 18px;
    border-radius: 18px;
    border: 1px solid #dbe3ef;
    background: #ffffff;
    cursor: pointer;
    transition: all .2s;
}
.level-card.active {
    background: #E0F2FE;
    border-color: #2563eb;
}
.error-text {
    font-size: 12px;
    color: #dc2626;
    margin-top: 6px;
    display: block;
}
@media (max-width: 768px) {
    .settings-grid {
        grid-template-columns: 1fr;
    }
}
.hidden-checkbox {
    display: none;
}

/* FAQ Accordion */
.faq-item {
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-md);
    margin-bottom: 12px;
    overflow: hidden;
}
.faq-question {
    padding: 16px;
    background: #f9fafb;
    font-weight: 600;
    color: var(--dark);
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.faq-question svg {
    width: 20px;
    height: 20px;
    stroke: var(--gray-500);
    fill: none;
    transition: transform .3s;
}
.faq-answer {
    padding: 0 16px;
    max-height: 0;
    overflow: hidden;
    transition: max-height .3s, padding .3s;
    background: var(--white);
    color: var(--gray-600);
    font-size: 14px;
    line-height: 1.6;
}
.faq-item.open .faq-answer {
    padding: 16px;
    max-height: 500px;
}
.faq-item.open .faq-question svg {
    transform: rotate(180deg);
}
</style>
@endsection

@section('content')
<div style="max-width: 1100px; margin: 0 auto;">

    <!-- Header -->
    <div class="settings-header">
        <svg viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="3"/>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
        </svg>
        <div class="settings-title-text">
            <h1>Pengaturan</h1>
            <p>Kelola akun sesuai yang kamu mau</p>
        </div>
    </div>

    @if(session('success'))
        <div class="sf-success" style="margin-bottom:20px;">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="sf-error" style="margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="settings-container">
        
        <!-- Tab Nav -->
        <div class="settings-tabs">
            <a href="?tab=akun" class="setting-tab-item {{ $tab == 'akun' ? 'active' : '' }}">
                <div class="setting-tab-item-title">Akun</div>
                <div class="setting-tab-item-sub">Informasi profil dan akun</div>
            </a>
            <a href="?tab=preferensi" class="setting-tab-item {{ $tab == 'preferensi' ? 'active' : '' }}">
                <div class="setting-tab-item-title">Preferensi</div>
                <div class="setting-tab-item-sub">Topik, level, dan waktu</div>
            </a>
            <a href="?tab=privasi" class="setting-tab-item {{ $tab == 'privasi' ? 'active' : '' }}">
                <div class="setting-tab-item-title">Privasi dan Keamanan</div>
                <div class="setting-tab-item-sub">Password dan Keamanan</div>
            </a>
            <a href="?tab=bantuan" class="setting-tab-item {{ $tab == 'bantuan' ? 'active' : '' }}">
                <div class="setting-tab-item-title">Bantuan</div>
                <div class="setting-tab-item-sub">FAQ dan Pusat Bantuan</div>
            </a>
            <a href="?tab=tentang" class="setting-tab-item {{ $tab == 'tentang' ? 'active' : '' }}">
                <div class="setting-tab-item-title">Tentang Aplikasi</div>
                <div class="setting-tab-item-sub">Informasi Tentang Aplikasi</div>
            </a>
        </div>

        <!-- Content Pane -->
        <div class="settings-content">
            
            <!-- AKUN TAB -->
            @if($tab == 'akun')
            <div class="setting-card">
                <div class="setting-card-title">Informasi Akun</div>
                <div class="setting-card-sub">Perbarui detail profil publikmu.</div>

                <form action="{{ route('pengaturan.akun') }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PATCH')

                    <!-- Avatar Upload -->
                    <div style="display:flex; align-items:center; gap:20px; margin-bottom:32px;">
                        <div style="width:96px; height:96px; border-radius:50%; background:var(--blue); color:var(--white); display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:bold; overflow:hidden;">
                            @if($mahasiswa && $mahasiswa->foto_profil)
                                <img src="{{ asset($mahasiswa->foto_profil) }}" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <label class="btn-secondary" style="cursor:pointer; display:inline-block; margin-bottom:8px;">
                                Ganti Foto
                                <input type="file" name="foto_profil" accept="image/*" style="display:none;">
                            </label>
                            <div style="font-size:12px; color:var(--gray-500);">JPG, PNG, WEBP Maks 2MB</div>
                            @error('foto_profil')
                                <small class="error-text">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="settings-grid" style="margin-bottom:20px;">
                        <div class="setting-form-group">
                            <label><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px; margin-right:4px;"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Nama Lengkap</label>
                            <input type="text" class="settings-input" name="nama" value="{{ old('nama', $mahasiswa->nama ?? $user->name) }}" required>
                            @error('nama') <small class="error-text">{{ $message }}</small> @enderror
                        </div>
                        <div class="setting-form-group">
                            <label><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px; margin-right:4px;"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg> Email</label>
                            <input type="email" class="settings-input" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email') <small class="error-text">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="settings-grid" style="margin-bottom:20px;">
                        <div class="setting-form-group">
                            <label><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px; margin-right:4px;"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg> Program Studi</label>
                            <input type="text" class="settings-input" name="program_studi" value="{{ old('program_studi', $mahasiswa->program_studi ?? '') }}" required>
                            @error('program_studi') <small class="error-text">{{ $message }}</small> @enderror
                        </div>
                        <div class="setting-form-group">
                            <label><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px; margin-right:4px;"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg> Universitas</label>
                            <input type="text" class="settings-input" name="universitas" value="{{ old('universitas', $mahasiswa->universitas ?? '') }}" required>
                            @error('universitas') <small class="error-text">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="settings-grid" style="margin-bottom:20px;">
                        <div class="setting-form-group">
                            <label><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px; margin-right:4px;"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg> Angkatan (Tahun)</label>
                            <input type="number" class="settings-input" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan ?? '') }}" required>
                            @error('angkatan') <small class="error-text">{{ $message }}</small> @enderror
                        </div>
                        <div class="setting-form-group">
                            <label><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px; margin-right:4px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg> Nomor HP (Opsional)</label>
                            <input type="text" class="settings-input" name="phone" value="{{ old('phone', $mahasiswa->phone ?? '') }}" placeholder="+628...">
                            @error('phone') <small class="error-text">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="setting-form-group" style="margin-bottom:20px;">
                        <label><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px; margin-right:4px;"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg> Link Portofolio / LinkedIn (Opsional)</label>
                        <input type="url" class="settings-input" name="portfolio_link" value="{{ old('portfolio_link', $mahasiswa->portfolio_link ?? '') }}" placeholder="https://...">
                        @error('portfolio_link') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <div class="setting-form-group" style="margin-bottom:32px;">
                        <label><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-3px; margin-right:4px;"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg> Bio Singkat (Opsional)</label>
                        <textarea class="settings-textarea" name="bio" placeholder="Deskripsikan dirimu secara singkat...">{{ old('bio', $mahasiswa->bio ?? '') }}</textarea>
                        @error('bio') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </form>

                <!-- Mobile Logout (Hidden on Desktop) -->
                <div class="mobile-account-logout">
                    <div class="account-action-card">
                        <div class="account-action-title">Aksi Akun</div>
                        <div class="logout-row">
                            <div class="logout-info">
                                <div class="logout-icon">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                </div>
                                <div>
                                    <div style="font-size:14px; font-weight:700; color:var(--dark);">Keluar</div>
                                    <div style="font-size:12px; color:var(--gray-500);">Keluar dari akun Smart Finder</div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="mobile-logout-btn">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            @endif

            <!-- PREFERENSI TAB -->
            @if($tab == 'preferensi')
            <form action="{{ route('pengaturan.preferensi') }}" method="POST" id="pref-form">
                @csrf 
                @method('PATCH')

                <!-- TOPIK -->
                <div class="setting-card">
                    <div class="setting-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--blue);"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        Topik Yang Diminati
                    </div>
                    <div class="setting-card-sub">Pilih topik yang kamu minati, maksimal 6. Ketik di kolom di bawah untuk menambahkan topik sendiri.</div>
                    
                    @php 
                        $topics = [
                            'Machine Learning', 'Web Dev', 'Basis Data', 'Algoritma',
                            'Cyber Sec', 'UI/UX', 'Mobile Dev', 'Laravel', 'Python',
                            'Data Science', 'Git & GitHub'
                        ]; 
                        $savedTopics = [];
                        if ($mahasiswa && $mahasiswa->topik_minat) {
                            $savedTopics = array_map('trim', explode(',', $mahasiswa->topik_minat));
                            $savedTopics = array_filter($savedTopics);
                        }
                        $customTopics = array_filter($savedTopics, fn($t) => !in_array($t, $topics));
                    @endphp

                    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:12px;" id="topic-container">
                        @foreach($topics as $t)
                            <label class="preference-chip {{ in_array($t, $savedTopics) ? 'active' : '' }}" id="chip-{{ Str::slug($t) }}">
                                <input type="checkbox" name="topik_minat[]" value="{{ $t }}" class="hidden-checkbox topic-checkbox" {{ in_array($t, $savedTopics) ? 'checked' : '' }}>
                                {{ $t }}
                            </label>
                        @endforeach

                        @foreach($customTopics as $ct)
                            <label class="preference-chip active custom-topic-chip">
                                <input type="checkbox" name="topik_minat[]" value="{{ $ct }}" class="hidden-checkbox topic-checkbox" checked>
                                {{ $ct }}
                                <span class="chip-remove" onclick="removeCustomChip(this)" style="margin-left:6px; cursor:pointer; font-weight:700; color:var(--blue);">✕</span>
                            </label>
                        @endforeach

                        <div style="display:inline-flex; align-items:center; gap:8px;" id="custom-input-wrapper">
                            <input type="text" id="custom-topic-input" class="settings-input" 
                                style="width:190px; height:40px; padding:0 14px; border-radius:999px; font-size:13px;" 
                                placeholder="Tambahkan topik lain...">
                        </div>
                    </div>
                    <small id="topic-warning" class="error-text" style="display:none; margin-bottom:16px; display:block;">Maksimal 6 topik yang dapat dipilih.</small>
                    <small id="topic-duplicate-warning" class="error-text" style="display:none; margin-bottom:16px; display:block;">Topik tersebut sudah ada.</small>
                </div>

                <!-- TINGKAT KEMAMPUAN -->
                <div class="setting-card">
                    <div class="setting-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--blue);"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Tingkat Kemampuan
                    </div>
                    <div class="setting-card-sub">Pilih tingkat kemampuan kamu saat ini.</div>

                    @php 
                        $levels = [
                            ['Pemula', 'Baru mulai belajar', 'M1 1 12 8 3 5 3 19l9-4 9 4V5z'],
                            ['Menengah', 'Sudah paham dasar', 'M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20'],
                            ['Lanjutan', 'Sudah cukup mahir', 'M23 6l-9.5 9.5-5-5L1 18;M17 6h6v6'],
                            ['Atas', 'Profesional / Spesialis', 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z']
                        ]; 
                        $savedLevel = $mahasiswa ? $mahasiswa->tingkat_kemampuan : '';
                    @endphp

                    <div class="settings-grid" style="margin-bottom:24px;">
                        @foreach($levels as $l)
                            <label class="level-card {{ $savedLevel == $l[0] ? 'active' : '' }}" id="level-{{ strtolower($l[0]) }}" onclick="selectLevel(this)">
                                <input type="radio" name="tingkat_kemampuan" value="{{ $l[0] }}" class="hidden-checkbox" {{ $savedLevel == $l[0] ? 'checked' : '' }}>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div style="width:36px; height:36px; flex-shrink:0; border-radius:8px; background:var(--blue-light, #eff6ff); display:flex; align-items:center; justify-content:center;">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--blue)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="{{ $l[2] }}"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div style="font-weight:700; font-size:15px; margin-bottom:2px; color:var(--dark);">{{ $l[0] }}</div>
                                        <div style="font-size:13px; color:var(--gray-600);">{{ $l[1] }}</div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- WAKTU BELAJAR -->
                <div class="setting-card">
                    <div class="setting-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--blue);"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Waktu Belajar
                    </div>
                    <div class="setting-card-sub">Kapan kamu biasanya bersedia untuk belajar? Pilih "Fleksibel" jika tidak ada hari tetap.</div>

                    @php 
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        $savedDays = $mahasiswa && is_array($mahasiswa->waktu_belajar) ? $mahasiswa->waktu_belajar : [];
                        $isFleksibel = empty($savedDays) || in_array('Fleksibel', $savedDays);
                    @endphp

                    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:24px;" id="day-container">
                        {{-- Fleksibel chip --}}
                        <label class="preference-chip day-chip {{ $isFleksibel ? 'active' : '' }}" id="chip-fleksibel" onclick="toggleFleksibel(this)">
                            <input type="checkbox" name="waktu_belajar[]" value="Fleksibel" class="hidden-checkbox day-checkbox" id="cb-fleksibel" {{ $isFleksibel ? 'checked' : '' }}>
                            Fleksibel
                        </label>

                        <div style="width:1px; height:36px; background:var(--gray-200); margin:0 4px;"></div>

                        @foreach($days as $d)
                            <label class="preference-chip day-chip {{ in_array($d, $savedDays) ? 'active' : '' }}" id="chip-{{ strtolower($d) }}" onclick="toggleDay(this)">
                                <input type="checkbox" name="waktu_belajar[]" value="{{ $d }}" class="hidden-checkbox day-checkbox" id="cb-{{ strtolower($d) }}" {{ in_array($d, $savedDays) ? 'checked' : '' }}>
                                {{ $d }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn-primary" id="save-pref-btn">Simpan Preferensi</button>
            </form>
            @endif

            <!-- PRIVASI TAB -->
            @if($tab == 'privasi')
            
            <form action="{{ route('pengaturan.privasi') }}" method="POST">
                @csrf 
                @method('PATCH')
                <div class="setting-card">
                    <div class="setting-card-title">Privasi Akun</div>
                    <div class="setting-card-sub">Atur siapa saja yang dapat melihat profilmu.</div>

                    <div class="toggle-switch-wrapper" style="align-items:flex-start; margin-bottom:12px;">
                        <div style="display:flex; gap:16px;">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="var(--blue)" stroke-width="2" style="margin-top:2px;"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                            <div>
                                <div class="toggle-label" style="margin-bottom:4px;">Tampilkan informasi ke publik</div>
                                <div style="font-size:13px; color:var(--gray-500);">Izinkan pengguna lain melihat profil kamu.</div>
                            </div>
                        </div>
                        <input type="checkbox" name="is_profile_public" class="setting-checkbox" {{ ($mahasiswa && $mahasiswa->is_profile_public) || !$mahasiswa ? 'checked' : '' }}>
                    </div>

                    <div class="toggle-switch-wrapper" style="align-items:flex-start; margin-bottom:12px;">
                        <div style="display:flex; gap:16px;">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="var(--blue)" stroke-width="2" style="margin-top:2px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <div>
                                <div class="toggle-label" style="margin-bottom:4px;">Tampilkan status online</div>
                                <div style="font-size:13px; color:var(--gray-500);">Izinkan partner melihat status online kamu.</div>
                            </div>
                        </div>
                        <input type="checkbox" name="is_online_visible" class="setting-checkbox" {{ ($mahasiswa && $mahasiswa->is_online_visible) || !$mahasiswa ? 'checked' : '' }}>
                    </div>

                    <div class="toggle-switch-wrapper" style="align-items:flex-start; border:none; padding-bottom:0;">
                        <div style="display:flex; gap:16px;">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="var(--blue)" stroke-width="2" style="margin-top:2px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <div style="padding-right:20px;">
                                <div class="toggle-label" style="margin-bottom:4px;">Siapa yang bisa mengirim pesan?</div>
                                <div style="font-size:13px; color:var(--gray-500);">Atur siapa yang dapat menghubungi kamu.</div>
                            </div>
                        </div>
                        <select name="message_permission" style="padding:12px 16px; border-radius:12px; border:1px solid #dbe3ef; background:#f8fbff; outline:none; font-size:14px;">
                            @php $perm = $mahasiswa ? $mahasiswa->message_permission : 'Semua orang'; @endphp
                            <option value="Semua orang" {{ $perm == 'Semua orang' ? 'selected' : '' }}>Semua orang</option>
                            <option value="Hanya partner saya" {{ $perm == 'Hanya partner saya' ? 'selected' : '' }}>Hanya partner saya</option>
                            <option value="Tidak ada" {{ $perm == 'Tidak ada' ? 'selected' : '' }}>Tidak ada</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-top:32px;">Simpan Privasi</button>
                </div>
            </form>

            <form action="{{ route('pengaturan.sandi') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="setting-card">
                    <div class="setting-card-title">Keamanan Akun</div>
                    <div class="setting-card-sub">Ubah password secara berkala agar tetap aman.</div>

                    <div class="setting-form-group" style="margin-bottom:20px;">
                        <label>Password Saat Ini</label>
                        <div class="password-wrapper">
                            <input type="password" class="settings-input" name="current_password" id="pwd-current" placeholder="Masukkan password saat ini" required>
                            <button type="button" class="toggle-password" data-target="pwd-current" tabindex="-1">
                                <svg class="icon-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="icon-eye-off" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        @error('current_password') <small class="error-text">{{ $message }}</small> @enderror
                    </div>
                    
                    <div class="setting-form-group" style="margin-bottom:20px;">
                        <label>Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" class="settings-input" name="password" id="pwd-new" minlength="8" placeholder="Masukkan password baru" required>
                            <button type="button" class="toggle-password" data-target="pwd-new" tabindex="-1">
                                <svg class="icon-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="icon-eye-off" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        @error('password') <small class="error-text">{{ $message }}</small> @enderror
                    </div>

                    <div class="setting-form-group" style="margin-bottom:24px;">
                        <label>Konfirmasi Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" class="settings-input" name="password_confirmation" id="pwd-confirm" placeholder="Ulangi password baru" required>
                            <button type="button" class="toggle-password" data-target="pwd-confirm" tabindex="-1">
                                <svg class="icon-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="icon-eye-off" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="background:#0f172a; border-color:#0f172a;">Simpan Password</button>
                </div>
            </form>

            @endif

            <!-- BANTUAN TAB -->
            @if($tab == 'bantuan')
            <div class="setting-card">
                <div class="setting-card-title">Pertanyaan yang Sering Diajukan (FAQ)</div>
                <div class="setting-card-sub">Temukan jawaban atas masalah yang sering terjadi.</div>

                <div class="faq-item">
                    <div class="faq-question">Bagaimana cara mencari partner belajar?
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">Buka halaman Cari Partner di sebelah kiri, dan gunakan fitur pencarian atau filter menggunakan topik untuk menemukan rekan yang pas dengan kriteria Anda.</div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">Apa sesi belajar dilakukan di luar aplikasi?
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">Saat ini Smart Finder ditujukan untuk perjodohan *partner finding*. Anda dapat melanjutkan sesi di platform Zoom, Discord, atau bertemu langsung.</div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">Bagaimana cara membatalkan sesi yang sudah dijadwalkan?
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">Silakan kirim pesan langsung kepada partner belajar Anda melalui fitur Obrolan dan atur jadwal ulang yang disetujui bersama.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">Apakah aplikasi ini gratis?
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">Ya, Smart Finder sepenuhnya gratis bagi mahasiswa di Indonesia.</div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">Bagaimana cara menghapus akun saya?
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">Untuk menghapus akun beserta datanya, mohon email kami di support@smartfinder.id melalui alamat email yang terdaftar.</div>
                </div>

                <!-- Hidden Extra FAQs -->
                <div id="more-faqs" style="display: none;">
                    <div class="faq-item">
                        <div class="faq-question">Apa itu Study Group?
                            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="faq-answer">Study group adalah fitur diskusi grup di mana pengguna dapat belajar bersama dalam satu obrolan mengenai topik spesifik.</div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">Bagaimana cara mengganti topik yang saya minati?
                            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="faq-answer">Pergi ke menu Pengaturan, lalu pilih tab Preferensi, dan Anda bisa mencentang, menambah, atau menghapus centang topik yang Anda minati.</div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">Apakah ada batas jumlah post di Komunitas?
                            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="faq-answer">Tidak ada batasan pasti. Anda bebas membuat postingan di komunitas, baik itu Pertanyaan (Q&A), Diskusi Umum, atau berbagi Materi.</div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">Saya lupa password, apa yang harus saya lakukan?
                            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="faq-answer">Anda dapat mengklik 'Lupa Sandi' pada halaman login dan mengikuti langkah untuk menerima kode OTP melalui email untuk menyetel ulang password.</div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">Bagaimana jika saya ingin melaporkan user yang mengganggu?
                            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="faq-answer">Saat ini Anda dapat menghubungi tim dukungan kami melalui email hello@smartfinder.id untuk melakukan pelaporan. Fitur report dalam aplikasi sedang dalam tahap pengembangan.</div>
                    </div>
                </div>

                <a href="javascript:void(0)" onclick="document.getElementById('more-faqs').style.display='block'; this.style.display='none';" style="color:var(--blue); font-size:14px; display:inline-block; margin-top:16px; font-weight:600;">Lihat semua FAQ →</a>
            </div>
            @endif

            <!-- TENTANG TAB -->
            @if($tab == 'tentang')
            <div class="setting-card" style="text-align:center; padding:40px 24px;">
                <img src="{{ asset('images/logo.png') }}" style="width:72px; margin-bottom:16px;">
                <h2 style="font-size:24px; font-weight:700; color:var(--dark); margin-bottom:4px;">Smart Finder</h2>
                <div style="font-size:14px; color:var(--gray-500); margin-bottom:20px;">Versi 1.0.0</div>

                <p style="color:var(--gray-600); line-height:1.6; max-width:500px; margin:0 auto 24px;">
                    Aplikasi untuk menemukan partner belajar sesuai dengan minat, tujuan, dan jadwalmu. Belajar jadi mudah, seru, dan terarah!
                </p>

                <button class="btn-primary" style="margin-bottom:40px;">Cek Pembaruan</button>

                <div style="text-align:left; max-width:400px; margin:0 auto; border-top:1px solid var(--gray-200); padding-top:24px;">
                    <div style="font-weight:700; font-size:16px; margin-bottom:16px;">Informasi Aplikasi</div>
                    
                    <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px;">
                        <span style="color:var(--gray-600);">Nama Aplikasi</span>
                        <span style="font-weight:600; color:var(--dark);">Smart Finder</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px;">
                        <span style="color:var(--gray-600);">Platform</span>
                        <span style="font-weight:600; color:var(--dark);">Web App</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px;">
                        <span style="color:var(--gray-600);">Dikembangkan Oleh</span>
                        <span style="font-weight:600; color:var(--dark);">Smart Finder Team</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px;">
                        <span style="color:var(--gray-600);">Kontak Pengembang</span>
                        <span style="font-weight:600; color:var(--blue);">hello@smartfinder.id</span>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // ─── FAQ Accordion ──────────────────────────────────────────────
    document.querySelectorAll('.faq-question').forEach(item => {
        item.addEventListener('click', () => {
            const parent = item.parentElement;
            const isOpen = parent.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(el => el.classList.remove('open'));
            if(!isOpen) parent.classList.add('open');
        });
    });

    // ─── Level Kemampuan ────────────────────────────────────────────
    function selectLevel(el) {
        document.querySelectorAll('.level-card').forEach(c => {
            c.classList.remove('active');
            c.querySelector('input[type="radio"]').checked = false;
        });
        el.classList.add('active');
        el.querySelector('input[type="radio"]').checked = true;
    }

    // ─── Topik Chips ────────────────────────────────────────────────
    function getCheckedTopicCount() {
        return document.querySelectorAll('.topic-checkbox:checked').length;
    }

    function showTopicWarning(type) {
        document.getElementById('topic-warning').style.display = type === 'max' ? 'block' : 'none';
        document.getElementById('topic-duplicate-warning').style.display = type === 'dup' ? 'block' : 'none';
    }

    // Attach click handlers to all default topic chips
    document.querySelectorAll('#topic-container .preference-chip:not(.custom-topic-chip)').forEach(label => {
        label.addEventListener('click', function() {
            const cb = this.querySelector('.topic-checkbox');
            const willCheck = !cb.checked;
            if (willCheck && getCheckedTopicCount() >= 6) {
                showTopicWarning('max');
                return;
            }
            cb.checked = willCheck;
            this.classList.toggle('active', willCheck);
            showTopicWarning('none');
        });
    });

    function removeCustomChip(spanEl) {
        spanEl.closest('label').remove();
        showTopicWarning('none');
    }

    // Custom topic input
    const customInput = document.getElementById('custom-topic-input');
    if (customInput) {
        customInput.addEventListener('keydown', function(e) {
            if(e.key === 'Enter') {
                e.preventDefault();
                addCustomTopic(this.value);
            }
        });
    }

    function addCustomTopic(val) {
        val = val.trim();
        if (!val) return;

        // Check duplicate
        const existing = Array.from(document.querySelectorAll('.topic-checkbox')).map(cb => cb.value.toLowerCase());
        if (existing.includes(val.toLowerCase())) {
            showTopicWarning('dup');
            return;
        }

        // Check max
        if (getCheckedTopicCount() >= 6) {
            showTopicWarning('max');
            return;
        }

        showTopicWarning('none');

        const container = document.getElementById('topic-container');
        const wrapper = document.getElementById('custom-input-wrapper');

        const label = document.createElement('label');
        label.className = 'preference-chip active custom-topic-chip';

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'topik_minat[]';
        checkbox.value = val;
        checkbox.className = 'hidden-checkbox topic-checkbox';
        checkbox.checked = true;

        const text = document.createTextNode(' ' + val + ' ');
        
        const removeBtn = document.createElement('span');
        removeBtn.className = 'chip-remove';
        removeBtn.style.cssText = 'margin-left:4px; cursor:pointer; font-weight:700; color:var(--blue);';
        removeBtn.textContent = '✕';
        removeBtn.onclick = function() { removeCustomChip(this); };

        label.appendChild(checkbox);
        label.appendChild(text);
        label.appendChild(removeBtn);

        container.insertBefore(label, wrapper);
        document.getElementById('custom-topic-input').value = '';
    }

    // ─── Waktu Belajar Fleksibel Logic ──────────────────────────────
    function toggleFleksibel(el) {
        const cb = el.querySelector('#cb-fleksibel');
        const willCheck = !cb.checked;
        cb.checked = willCheck;
        el.classList.toggle('active', willCheck);

        if (willCheck) {
            // Deactivate all day chips
            document.querySelectorAll('.day-chip:not(#chip-fleksibel)').forEach(chip => {
                chip.classList.remove('active');
                chip.querySelector('.day-checkbox').checked = false;
            });
        }
    }

    function toggleDay(el) {
        const cb = el.querySelector('.day-checkbox');
        const willCheck = !cb.checked;
        cb.checked = willCheck;
        el.classList.toggle('active', willCheck);

        // Deactivate Fleksibel if any specific day is selected
        if (willCheck) {
            const fleksibelCb = document.getElementById('cb-fleksibel');
            const fleksibelChip = document.getElementById('chip-fleksibel');
            if (fleksibelCb && fleksibelCb.checked) {
                fleksibelCb.checked = false;
                fleksibelChip.classList.remove('active');
            }
        }
    }

</script>
@endsection
