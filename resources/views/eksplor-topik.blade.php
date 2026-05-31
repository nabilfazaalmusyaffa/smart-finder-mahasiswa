@extends('layouts.dashboard')
@section('title', 'Eksplor Topik – Smart Finder')

@section('styles')
    <style>
        .eksplor-header {
            background: linear-gradient(135deg, var(--blue-dark), var(--blue));
            padding: 48px;
            border-radius: 24px;
            color: white;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }

        .eksplor-header::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: url('data:image/svg+xml;utf8,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" stroke="rgba(255,255,255,0.1)" stroke-width="2" fill="none"/></svg>') repeat;
            opacity: 0.5;
            pointer-events: none;
        }

        .search-large {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 100px;
            padding: 6px 6px 6px 24px;
            max-width: 600px;
            margin-top: 24px;
            position: relative;
            z-index: 10;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .search-large input {
            flex: 1;
            border: none;
            outline: none;
            font-family: inherit;
            font-size: 16px;
            color: var(--dark);
        }

        .search-large button {
            background: var(--blue);
            color: white;
            border: none;
            border-radius: 100px;
            padding: 12px 24px;
            font-weight: 600;
            cursor: pointer;
        }

        .topik-populer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 48px;
        }

        .topik-card2 {
            background: white;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--gray-200);
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
        }

        .topik-card2:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .t-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .t-icon svg {
            width: 28px;
            height: 28px;
        }

        .materi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .materi-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .materi-type {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .materi-type-pdf {
            background: #fee2e2;
            color: #b91c1c;
        }

        .materi-type-video {
            background: #e0e7ff;
            color: #4338ca;
        }

        .materi-type-modul {
            background: #dcfce7;
            color: #15803d;
        }

        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: white;
            border-radius: 24px;
            padding: 32px;
            width: 100%;
            max-width: 500px;
            box-shadow: var(--shadow-lg);
        }
    </style>
@endsection

@section('content')
    <div class="eksplor-header">
        <h1 style="font-size: 36px; font-weight: 800; margin-bottom: 12px;">Eksplor Topik</h1>
        <p style="font-size: 16px; opacity: 0.9; max-width: 600px; line-height: 1.6;">
            Temukan topik populer, materi belajar, video pembelajaran, dan modul dari mentor atau mahasiswa yang
            berpengalaman.
        </p>

        <div class="search-large">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--gray-400)" stroke-width="2"
                style="margin-right: 12px;">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="exploreSearchInput" placeholder="Cari topik, modul, video, atau mentor...">
            <button type="button" id="exploreSearchBtn">Cari</button>
        </div>
    </div>

    <div id="searchIndicator" style="display: none; margin-bottom: 24px; padding: 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; align-items: center; justify-content: space-between;">
        <div>
            <span style="color: var(--gray-600); font-size: 14px;">Menampilkan hasil untuk: </span>
            <span id="searchTextDisplay" style="font-weight: 700; color: var(--blue);"></span>
        </div>
        <button id="resetSearchBtn" style="background: none; border: none; color: var(--red); font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: underline;">Hapus Pencarian</button>
    </div>

    <!-- Empty State -->
    <div id="emptySearchState" style="display: none; text-align: center; padding: 60px 20px; background: white; border-radius: 20px; border: 1px solid var(--gray-200); margin-bottom: 30px;">
        <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="var(--gray-300)" stroke-width="2" style="margin-bottom:16px; display:inline-block;">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 8px;">Topik atau materi tidak ditemukan.</h3>
        <p style="color: var(--gray-500);">Coba gunakan kata kunci lain.</p>
    </div>

    <!-- Topik Populer -->
    <div id="topikHeader" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 700;">Topik Populer</h2>
    </div>

    <div class="topik-populer-grid" id="topikGrid">
        @foreach($popularTopics as $t)
            <div class="topik-card2" data-search="{{ strtolower($t['nama']) }}">
                <div class="t-icon" style="background: {{ $t['bg'] }}; color: {{ $t['color'] }};">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        @if($t['icon'] == 'cpu')
                            <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                            <rect x="9" y="9" width="6" height="6"></rect>
                            <line x1="9" y1="1" x2="9" y2="4"></line>
                            <line x1="15" y1="1" x2="15" y2="4"></line>
                            <line x1="9" y1="20" x2="9" y2="23"></line>
                            <line x1="15" y1="20" x2="15" y2="23"></line>
                            <line x1="20" y1="9" x2="23" y2="9"></line>
                            <line x1="20" y1="14" x2="23" y2="14"></line>
                            <line x1="1" y1="9" x2="4" y2="9"></line>
                        <line x1="1" y1="14" x2="4" y2="14"></line> @endif
                        @if($t['icon'] == 'code')
                            <polyline points="16 18 22 12 16 6"></polyline>
                        <polyline points="8 6 2 12 8 18"></polyline> @endif
                        @if($t['icon'] == 'book')
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path> @endif
                        @if($t['icon'] == 'trending-up')
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline> @endif
                        @if($t['icon'] == 'layout')
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                        <line x1="9" y1="21" x2="9" y2="9"></line> @endif
                        @if($t['icon'] == 'briefcase')
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path> @endif
                    </svg>
                </div>
                <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 8px;">{{ $t['nama'] }}</h3>
                <p style="font-size: 13px; color: var(--gray-500); font-weight: 500; margin-bottom: 12px;">
                    {{ $t['member'] }} member • {{ $t['materi'] }} materi
                </p>
                <a href="{{ route('community.index', ['topic' => $t['nama']]) }}"
                    style="font-size: 13px; font-weight: 600; color: var(--blue);">Lihat Topik &rarr;</a>
            </div>
        @endforeach
    </div>

    <!-- Materi Rekomendasi -->
    <div id="materiHeader" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 700;">Materi Rekomendasi</h2>
        <button type="button" class="btn-primary" style="padding: 10px 20px; width: auto; font-size: 14px;"
            onclick="document.getElementById('modalUpload').style.display='flex'">
            + Upload Materi
        </button>
    </div>

    @if(session('success'))
        <div
            style="background:#dcfce7; color:#166534; padding:12px 20px; border-radius:12px; margin-bottom:20px; font-weight:600;">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if($errors->has('file'))
        <div
            style="background:#fee2e2; color:#b91c1c; padding:12px 20px; border-radius:12px; margin-bottom:20px; font-weight:600;">
            ⚠️ {{ $errors->first('file') }}
        </div>
    @endif

    <div class="materi-grid" id="materiGrid">
        @forelse($materials as $material)
            <div class="materi-card" data-search="{{ strtolower($material->title . ' ' . $material->topic . ' ' . $material->type_label . ' ' . ($material->user->name ?? '') . ' ' . $material->description) }}">
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <span class="materi-type {{ $material->type_badge_class }}">{{ $material->type_label }}</span>
                        @if($material->user_id === auth()->id() || auth()->user()->role === 'admin')
                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" title="Hapus Materi" style="width:28px; height:28px;">
                                    <svg viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2-2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 12px; line-height: 1.4;">{{ $material->title }}
                    </h3>
                    <div style="font-size: 13px; color: var(--gray-600); margin-bottom: 6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                            style="vertical-align:-2px; margin-right:4px;">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        {{ $material->user->name ?? 'User' }}
                    </div>
                    @if($material->topic)
                        <div style="font-size: 13px; color: var(--gray-600); margin-bottom:6px;">
                            🏷️ {{ $material->topic }}
                        </div>
                    @endif
                    @if($material->description)
                        <div style="font-size: 13px; color: var(--gray-500); line-height:1.5; margin-top:8px;">
                            {{ Str::limit($material->description, 100) }}</div>
                    @endif
                </div>
                @if($material->file_path)
                    <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                        style="display:block; text-align:center; padding: 10px; background: var(--blue); color: white; font-weight: 600; border-radius: 12px; margin-top: 20px; font-size: 14px; text-decoration:none;">
                        Buka Materi
                    </a>
                @elseif($material->url)
                    <a href="{{ $material->url }}" target="_blank" rel="noopener"
                        style="display:block; text-align:center; padding: 10px; background: var(--blue); color: white; font-weight: 600; border-radius: 12px; margin-top: 20px; font-size: 14px; text-decoration:none;">
                        Buka Link Materi
                    </a>
                @else
                    <button disabled
                        style="display:block; width:100%; padding: 10px; background: var(--gray-200); color: var(--gray-500); font-weight: 600; border-radius: 12px; margin-top: 20px; font-size: 14px; border:none; cursor:not-allowed;">
                        File belum tersedia
                    </button>
                @endif
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align:center; padding:48px; color:var(--gray-500);">
                <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="var(--gray-300)" stroke-width="2"
                    style="margin-bottom:16px;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                <h3 style="font-size:18px; font-weight:700; margin-bottom:8px;">Belum ada materi</h3>
                <p>Jadilah yang pertama mengupload materi belajar!</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Form Upload Materi -->
    <div class="modal-overlay" id="modalUpload" onclick="if(event.target===this)this.style.display='none'">
        <div class="modal-content" style="max-height:90vh; overflow-y:auto;">
            <h2 style="font-size: 22px; font-weight: 700; margin-bottom: 24px;">Upload Materi Baru</h2>
            <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="sf-form-group">
                    <label class="sf-label">Judul Materi *</label>
                    <input type="text" name="title" class="sf-input-plain" placeholder="Cth: Dasar Laravel 10" required
                        value="{{ old('title') }}">
                </div>
                <div class="sf-form-group">
                    <label class="sf-label">Topik *</label>
                    <input type="text" name="topic" list="topic-datalist" class="sf-input-plain"
                        placeholder="Pilih atau ketik topik sendiri" required value="{{ old('topic') }}">
                    <datalist id="topic-datalist">
                        @foreach(['Teknologi & IT', 'Bisnis & Manajemen', 'Desain Grafis', 'Public Speaking', 'Digital Marketing', 'Sastra & Bahasa', 'Hukum', 'Akuntansi', 'Kesehatan', 'Kedokteran', 'Teknik Mesin', 'Penulisan Artikel', 'Fotografi & Videografi', 'Web Development', 'Machine Learning', 'Data Analysis', 'Keuangan', 'Psikologi', 'Lainnya'] as $t)
                            <option value="{{ $t }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="sf-form-group">
                    <label class="sf-label">Tipe Materi *</label>
                    <select name="type" class="sf-input-plain" required>
                        <option value="pdf" {{ old('type') === 'pdf' ? 'selected' : '' }}>PDF Modul</option>
                        <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video Rekaman</option>
                        <option value="modul" {{ old('type') === 'modul' ? 'selected' : '' }}>Modul Belajar</option>
                        <option value="link" {{ old('type') === 'link' ? 'selected' : '' }}>Link Materi</option>
                    </select>
                </div>
                <div class="sf-form-group">
                    <label class="sf-label">Deskripsi</label>
                    <textarea name="description" class="sf-input-plain" rows="3"
                        placeholder="Jelaskan sedikit tentang materi ini...">{{ old('description') }}</textarea>
                </div>
                <div class="sf-form-group">
                    <label class="sf-label">Upload File (maks. 20MB)</label>
                    <input type="file" name="file" class="sf-input-plain" style="padding: 10px;"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.png,.jpg,.jpeg">
                    <small style="color:var(--gray-500); font-size:12px;">Format: PDF, Word, PowerPoint, ZIP, gambar</small>
                </div>
                <div class="sf-form-group">
                    <label class="sf-label">Atau Masukkan Link URL Materi</label>
                    <input type="url" name="url" class="sf-input-plain" placeholder="https://..." value="{{ old('url') }}">
                </div>
                <small style="color:var(--gray-500); font-size:12px; display:block; margin-bottom:16px;">⚠️ Minimal salah
                    satu dari file atau URL harus diisi</small>
                <div style="display: flex; gap: 12px; margin-top: 32px;">
                    <button type="button" class="btn-secondary" style="flex: 1;"
                        onclick="document.getElementById('modalUpload').style.display='none'">Batal</button>
                    <button type="submit" class="btn-primary" style="flex: 1;">Simpan Materi</button>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('exploreSearchInput');
            const searchBtn = document.getElementById('exploreSearchBtn');
            const resetBtn = document.getElementById('resetSearchBtn');
            const searchIndicator = document.getElementById('searchIndicator');
            const searchTextDisplay = document.getElementById('searchTextDisplay');
            const emptyState = document.getElementById('emptySearchState');
            
            const topicCards = document.querySelectorAll('.topik-card2');
            const materialCards = document.querySelectorAll('.materi-card');

            const topikHeader = document.getElementById('topikHeader');
            const topikGrid = document.getElementById('topikGrid');
            const materiHeader = document.getElementById('materiHeader');
            const materiGrid = document.getElementById('materiGrid');

            function filterContent() {
                const keyword = searchInput.value.toLowerCase().trim();
                let visibleTopics = 0;
                let visibleMaterials = 0;

                topicCards.forEach(card => {
                    const searchableText = card.dataset.search || card.innerText.toLowerCase();
                    if (keyword === '' || searchableText.includes(keyword)) {
                        card.style.display = '';
                        visibleTopics++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                materialCards.forEach(card => {
                    const searchableText = card.dataset.search || card.innerText.toLowerCase();
                    if (keyword === '' || searchableText.includes(keyword)) {
                        card.style.display = 'flex';
                        visibleMaterials++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update UI
                if (keyword !== '') {
                    searchIndicator.style.display = 'flex';
                    searchTextDisplay.textContent = searchInput.value;
                    
                    if (topikHeader) topikHeader.style.display = visibleTopics > 0 ? 'flex' : 'none';
                    if (topikGrid) topikGrid.style.display = visibleTopics > 0 ? 'grid' : 'none';
                    
                    if (materiHeader) materiHeader.style.display = visibleMaterials > 0 ? 'flex' : 'none';
                    if (materiGrid) materiGrid.style.display = visibleMaterials > 0 ? 'grid' : 'none';
                    
                    if (emptyState) emptyState.style.display = (visibleTopics === 0 && visibleMaterials === 0) ? 'block' : 'none';
                } else {
                    if (searchIndicator) searchIndicator.style.display = 'none';
                    if (topikHeader) topikHeader.style.display = 'flex';
                    if (topikGrid) topikGrid.style.display = 'grid';
                    if (materiHeader) materiHeader.style.display = 'flex';
                    if (materiGrid) materiGrid.style.display = 'grid';
                    if (emptyState) emptyState.style.display = 'none';
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterContent);
                if (searchBtn) searchBtn.addEventListener('click', filterContent);
                if (resetBtn) {
                    resetBtn.addEventListener('click', () => {
                        searchInput.value = '';
                        filterContent();
                    });
                }
            }
        });
    </script>
    @endsection
@endsection