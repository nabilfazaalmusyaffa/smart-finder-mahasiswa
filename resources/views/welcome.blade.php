<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Finder Mahasiswa</title>
    <!-- Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Animations */
        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
        .fade-up.in-view { opacity: 1; transform: translateY(0); }
        
        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
        .stagger-4 { transition-delay: 0.4s; }
        
        /* Custom UI Elements */
        .glass-nav { 
            background: rgba(255, 255, 255, 0.92); 
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px); 
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .blob-shape {
            animation: blob-bounce 20s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes blob-bounce {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        
        /* Clean Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="bg-[#f8fafc] text-gray-800 antialiased overflow-x-hidden selection:bg-blue-200 selection:text-blue-900">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav border-b border-gray-100/80 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="flex justify-between h-[84px] items-center">
                <!-- Logo: Diperbesar sesuai permintaan -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.png') }}" alt="Smart Finder Logo" class="h-12 md:h-16 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#fitur" class="text-slate-600 hover:text-blue-600 font-semibold text-sm tracking-wide transition-colors">Fitur</a>
                    <a href="#keunggulan" class="text-slate-600 hover:text-blue-600 font-semibold text-sm tracking-wide transition-colors">Keunggulan</a>
                    <a href="#statistik" class="text-slate-600 hover:text-blue-600 font-semibold text-sm tracking-wide transition-colors">Komunitas</a>
                    
                    <div class="flex items-center space-x-5 pl-6 border-l border-gray-200">
                        <a href="/login" class="text-slate-700 font-bold hover:text-blue-600 transition-colors">Masuk</a>
                        <a href="/daftar" class="bg-blue-600 text-white px-6 py-2.5 rounded-full font-bold hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/30 hover:-translate-y-0.5 transition-all duration-300">
                            Daftar Gratis
                        </a>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-slate-600 hover:text-blue-600 focus:outline-none p-2 rounded-lg hover:bg-blue-50 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-xl absolute w-full transition-all duration-300">
            <div class="px-6 pt-4 pb-8 space-y-4">
                <a href="#fitur" class="block text-slate-700 font-semibold text-lg hover:text-blue-600 transition-colors">Fitur</a>
                <a href="#keunggulan" class="block text-slate-700 font-semibold text-lg hover:text-blue-600 transition-colors">Keunggulan</a>
                <a href="#statistik" class="block text-slate-700 font-semibold text-lg hover:text-blue-600 transition-colors">Komunitas</a>
                <div class="pt-6 mt-4 border-t border-slate-100 flex flex-col gap-3">
                    <a href="/login" class="block text-center text-blue-600 font-bold py-3.5 border-2 border-blue-600 rounded-2xl hover:bg-blue-50 transition-colors">Masuk ke Akun</a>
                    <a href="/daftar" class="block text-center bg-blue-600 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition-colors">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-44 lg:pb-32 min-h-[90vh] flex items-center overflow-hidden bg-[#f8fafc]">
        <!-- Modern Abstract Background Decorations -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] rounded-full bg-blue-200/40 blur-[100px] blob-shape mix-blend-multiply"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[500px] h-[500px] rounded-full bg-cyan-200/40 blur-[100px] blob-shape mix-blend-multiply" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] rounded-[100%] bg-indigo-100/30 blur-[80px] rotate-45 -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-10 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Text Content (Left) -->
                <div class="lg:col-span-6 text-center lg:text-left fade-up">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white border border-blue-100 shadow-sm text-blue-700 font-semibold text-xs md:text-sm tracking-wide mb-8">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-600"></span>
                        </span>
                        Platform Kolaborasi Mahasiswa #1
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-[64px] font-extrabold text-slate-900 leading-[1.1] mb-6 tracking-tight">
                        Temukan Partner <br class="hidden md:block">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Belajar Terbaikmu</span>
                    </h1>
                    
                    <p class="text-lg md:text-xl text-slate-600 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                        Tingkatkan produktivitas belajarmu. Bergabung dengan mahasiswa berbakat lainnya untuk berdiskusi, berbagi ilmu, dan mencapai target akademik bersama.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="/daftar" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-600/20 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                            Mulai Sekarang
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="/login" class="bg-white text-slate-700 border border-slate-200 px-8 py-4 rounded-2xl font-bold text-lg hover:border-blue-600 hover:text-blue-600 hover:shadow-md transition-all duration-300 flex items-center justify-center">
                            Sudah Punya Akun
                        </a>
                    </div>
                    
                    <!-- Social Proof -->
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 text-sm text-slate-500 font-semibold">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-[#f8fafc] object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&h=100" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-[#f8fafc] object-cover" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=100&h=100" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-[#f8fafc] object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&h=100" alt="User">
                            <div class="w-10 h-10 rounded-full border-2 border-[#f8fafc] bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-700 z-10">+1k</div>
                        </div>
                        <p>Dipercaya oleh ribuan mahasiswa</p>
                    </div>
                </div>

                <!-- Hero Image/Illustration (Right) -->
                <div class="lg:col-span-6 relative fade-up stagger-2 hidden md:block">
                    <!-- Main composition wrapper -->
                    <div class="relative w-full aspect-square md:aspect-[4/3] lg:aspect-square flex items-center justify-center">
                        
                        <!-- Main image rounded mask -->
                        <div class="absolute inset-0 w-[85%] h-[85%] left-[10%] top-[5%] rounded-[3rem] overflow-hidden shadow-2xl border-4 border-white/50 bg-white rotate-3 transition-transform duration-700 hover:rotate-0">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Mahasiswa Belajar Bersama" class="w-full h-full object-cover">
                            <!-- Overlay gradient -->
                            <div class="absolute inset-0 bg-gradient-to-tr from-blue-900/40 via-transparent to-transparent"></div>
                        </div>

                        <!-- Floating Glassmorphism Badge 1 -->
                        <div class="absolute bottom-[10%] -left-[5%] glass-card p-5 rounded-3xl shadow-xl z-20 flex items-center gap-4 animate-bounce" style="animation-duration: 4s;">
                            <div class="bg-gradient-to-br from-green-400 to-green-600 p-3.5 rounded-2xl text-white shadow-lg shadow-green-500/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mb-0.5">Topik Diskusi</p>
                                <p class="text-base font-extrabold text-slate-900 leading-none">Manajemen Proyek</p>
                            </div>
                        </div>

                        <!-- Floating Glassmorphism Badge 2 -->
                        <div class="absolute top-[15%] -right-[5%] glass-card p-5 rounded-3xl shadow-xl z-20 flex items-center gap-4 animate-bounce" style="animation-duration: 5s; animation-delay: 1s;">
                            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-3.5 rounded-2xl text-white shadow-lg shadow-blue-500/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-lg font-extrabold text-slate-900 leading-none mb-1">500+ Partner</p>
                                <p class="text-xs text-slate-500 font-semibold">Siap berkolaborasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center max-w-3xl mx-auto mb-20 fade-up">
                <h2 class="text-blue-600 font-bold tracking-widest uppercase text-xs md:text-sm mb-3">Fitur Unggulan</h2>
                <h3 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">Semua yang kamu butuhkan <br class="hidden md:block">untuk belajar optimal</h3>
                <p class="text-slate-600 text-lg lg:text-xl font-medium">Smart Finder dilengkapi dengan berbagai fitur yang dirancang khusus untuk memenuhi kebutuhan kolaborasi akademismu secara efisien.</p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                
                <!-- Feature 1 -->
                <div class="group bg-[#f8fafc] border border-slate-100 rounded-[2rem] p-8 hover:bg-gradient-to-b hover:from-blue-600 hover:to-blue-700 transition-all duration-300 hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue-600/20 fade-up stagger-1">
                    <div class="w-16 h-16 bg-white border border-slate-100 rounded-2xl shadow-sm flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform duration-500 group-hover:border-transparent">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-cyan-500">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                    </div>
                    <h4 class="text-xl font-extrabold text-slate-900 mb-4 group-hover:text-white transition-colors">Cari Partner</h4>
                    <p class="text-slate-600 font-medium group-hover:text-blue-100 transition-colors leading-relaxed">
                        Temukan teman belajar dengan minat, jurusan, atau target studi yang sama denganmu secara instan.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-[#f8fafc] border border-slate-100 rounded-[2rem] p-8 hover:bg-gradient-to-b hover:from-blue-600 hover:to-blue-700 transition-all duration-300 hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue-600/20 fade-up stagger-2">
                    <div class="w-16 h-16 bg-white border border-slate-100 rounded-2xl shadow-sm flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform duration-500 group-hover:border-transparent">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-cyan-500">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </span>
                    </div>
                    <h4 class="text-xl font-extrabold text-slate-900 mb-4 group-hover:text-white transition-colors">Diskusi Bersama</h4>
                    <p class="text-slate-600 font-medium group-hover:text-blue-100 transition-colors leading-relaxed">
                        Fasilitas chat personal dan grup yang terintegrasi, memudahkan tanya jawab pelajaran kapan saja.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-[#f8fafc] border border-slate-100 rounded-[2rem] p-8 hover:bg-gradient-to-b hover:from-blue-600 hover:to-blue-700 transition-all duration-300 hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue-600/20 fade-up stagger-3">
                    <div class="w-16 h-16 bg-white border border-slate-100 rounded-2xl shadow-sm flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform duration-500 group-hover:border-transparent">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-cyan-500">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                    </div>
                    <h4 class="text-xl font-extrabold text-slate-900 mb-4 group-hover:text-white transition-colors">Jadwal Belajar</h4>
                    <p class="text-slate-600 font-medium group-hover:text-blue-100 transition-colors leading-relaxed">
                        Atur agenda sesi belajar bersama partnermu dengan sistem terstruktur yang mudah dipantau.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group bg-[#f8fafc] border border-slate-100 rounded-[2rem] p-8 hover:bg-gradient-to-b hover:from-blue-600 hover:to-blue-700 transition-all duration-300 hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue-600/20 fade-up stagger-4">
                    <div class="w-16 h-16 bg-white border border-slate-100 rounded-2xl shadow-sm flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform duration-500 group-hover:border-transparent">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-cyan-500">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </span>
                    </div>
                    <h4 class="text-xl font-extrabold text-slate-900 mb-4 group-hover:text-white transition-colors">Multi Jurusan</h4>
                    <p class="text-slate-600 font-medium group-hover:text-blue-100 transition-colors leading-relaxed">
                        Lintas fakultas dan universitas. Jelajahi berbagai topik diskusi dari bermacam latar belakang studi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section id="keunggulan" class="py-24 bg-[#f8fafc] border-y border-slate-100 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Image Side -->
                <div class="order-2 lg:order-1 fade-up relative">
                    <div class="absolute inset-0 bg-blue-600 rounded-3xl translate-x-4 translate-y-4 -z-10 opacity-10"></div>
                    <img src="https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Kolaborasi Mahasiswa" class="rounded-3xl shadow-xl object-cover w-full h-auto aspect-square md:aspect-[4/3] lg:aspect-square border border-white/50">
                    
                    <!-- Decorative element overlay -->
                    <div class="absolute -bottom-8 -right-8 glass-card p-6 rounded-2xl shadow-xl hidden md:flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                            <div>
                                <p class="text-slate-900 font-bold leading-tight">Partner Ditemukan</p>
                                <p class="text-slate-500 text-xs font-semibold">Tepat Sasaran</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Text Side -->
                <div class="order-1 lg:order-2 fade-up stagger-1">
                    <h2 class="text-blue-600 font-bold tracking-widest uppercase text-sm mb-3">Mengapa Smart Finder?</h2>
                    <h3 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6 leading-tight tracking-tight">Membangun ekosistem belajar yang lebih produktif</h3>
                    <p class="text-slate-600 text-lg mb-10 leading-relaxed font-medium">
                        Kami mengerti bahwa belajar sendiri terkadang membosankan dan kurang terarah. Smart Finder hadir menghubungkanmu dengan circle akademik yang tepat.
                    </p>

                    <div class="space-y-8">
                        <div class="flex gap-5 group">
                            <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-blue-100 group-hover:bg-blue-600 transition-colors flex items-center justify-center text-blue-600 group-hover:text-white shadow-sm mt-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-extrabold text-slate-900 mb-2">Mendukung Semua Jurusan</h4>
                                <p class="text-slate-600 font-medium">Terbuka untuk semua bidang studi. Algoritma kami mencocokkanmu dengan partner yang paling relevan dengan targetmu.</p>
                            </div>
                        </div>
                        <div class="flex gap-5 group">
                            <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-blue-100 group-hover:bg-blue-600 transition-colors flex items-center justify-center text-blue-600 group-hover:text-white shadow-sm mt-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-extrabold text-slate-900 mb-2">Komunitas Super Aktif</h4>
                                <p class="text-slate-600 font-medium">Bergabung dengan Study Group atau buat grup mandiri. Selalu ada diskusi menarik dan bantuan setiap harinya.</p>
                            </div>
                        </div>
                        <div class="flex gap-5 group">
                            <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-blue-100 group-hover:bg-blue-600 transition-colors flex items-center justify-center text-blue-600 group-hover:text-white shadow-sm mt-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-extrabold text-slate-900 mb-2">Aman & Terpercaya</h4>
                                <p class="text-slate-600 font-medium">Platform khusus ekosistem mahasiswa. Keamanan privasi dan kenyamanan ruang diskusi adalah prioritas utama kami.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="statistik" class="py-24 relative overflow-hidden bg-gradient-to-r from-blue-700 to-blue-600">
        <!-- Decor pattern -->
        <div class="absolute inset-0 opacity-[0.05]">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40L40 0H20L0 20M40 40V20L20 40" stroke="currentColor" stroke-width="2" fill="none"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)"/>
            </svg>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-10 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center divide-y md:divide-y-0 md:divide-x divide-blue-400/50">
                <div class="pt-6 md:pt-0 fade-up">
                    <div class="text-5xl md:text-6xl font-black text-white mb-3 tracking-tight drop-shadow-md">1000+</div>
                    <div class="text-blue-100 font-bold text-lg tracking-wide uppercase text-sm">Mahasiswa Bergabung</div>
                </div>
                <div class="pt-10 md:pt-0 fade-up stagger-1">
                    <div class="text-5xl md:text-6xl font-black text-white mb-3 tracking-tight drop-shadow-md">500+</div>
                    <div class="text-blue-100 font-bold text-lg tracking-wide uppercase text-sm">Partner Ditemukan</div>
                </div>
                <div class="pt-10 md:pt-0 fade-up stagger-2">
                    <div class="text-5xl md:text-6xl font-black text-white mb-3 tracking-tight drop-shadow-md">100+</div>
                    <div class="text-blue-100 font-bold text-lg tracking-wide uppercase text-sm">Topik Diskusi Aktif</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final Section -->
    <section class="py-32 bg-white text-center relative overflow-hidden">
        <!-- Abstract gradient spheres -->
        <div class="absolute -top-32 -left-32 w-64 h-64 rounded-full bg-cyan-100/50 blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-blue-100/50 blur-3xl"></div>

        <div class="max-w-4xl mx-auto px-6 relative z-10 fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight leading-tight">Siap untuk meraih target akademik impianmu?</h2>
            <p class="text-xl text-slate-600 mb-12 max-w-2xl mx-auto font-medium">Tingkatkan efisiensi belajarmu dengan berkolaborasi bersama mahasiswa berbakat dari berbagai universitas.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-5">
                <a href="/daftar" class="bg-blue-600 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-600/20 hover:-translate-y-1 transition-all duration-300">
                    Mulai Sekarang — Gratis
                </a>
                <a href="/login" class="bg-[#f8fafc] text-slate-700 border border-slate-200 px-10 py-5 rounded-2xl font-bold text-lg hover:border-blue-600 hover:text-blue-600 hover:bg-white hover:shadow-md transition-all duration-300">
                    Masuk ke Akun
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-4 mb-6 group">
                        <!-- Apply brightness to make the logo white/visible on dark bg if it's a dark logo by default -->
                        <div class="bg-white p-2 rounded-xl">
                            <img src="{{ asset('images/logo.png') }}" alt="Smart Finder Logo" class="h-10 w-auto object-contain">
                        </div>
                        <span class="font-black text-2xl text-white tracking-tight">Smart Finder</span>
                    </div>
                    <p class="text-slate-400 max-w-sm mb-6 leading-relaxed font-medium">Platform kolaborasi mahasiswa masa kini. Menghubungkanmu dengan partner ideal untuk belajar, berdiskusi, dan berkembang bersama.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Navigasi</h4>
                    <ul class="space-y-4">
                        <li><a href="/" class="text-slate-400 hover:text-blue-400 font-medium transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="text-slate-400 hover:text-blue-400 font-medium transition-colors">Fitur Unggulan</a></li>
                        <li><a href="#keunggulan" class="text-slate-400 hover:text-blue-400 font-medium transition-colors">Keunggulan</a></li>
                        <li><a href="#statistik" class="text-slate-400 hover:text-blue-400 font-medium transition-colors">Statistik Komunitas</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-lg mb-6">Bantuan</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 font-medium transition-colors">Pusat Bantuan</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 font-medium transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 font-medium transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-blue-400 font-medium transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-sm text-slate-500 font-medium">© {{ date('Y') }} Smart Finder Mahasiswa. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-5">
                    <!-- Social Icons -->
                    <a href="#" class="text-slate-500 hover:text-white transition-colors p-2 bg-slate-800 rounded-lg hover:bg-blue-600">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-white transition-colors p-2 bg-slate-800 rounded-lg hover:bg-blue-600">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile menu toggle
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');

            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                const isHidden = menu.classList.contains('hidden');
                btn.innerHTML = isHidden 
                    ? '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>'
                    : '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
            });

            // Close mobile menu on link click
            menu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    menu.classList.add('hidden');
                    btn.innerHTML = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>';
                });
            });

            // Scroll animations (Intersection Observer)
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        observer.unobserve(entry.target); // Run once
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-up').forEach((el) => {
                observer.observe(el);
            });

            // Trigger animations for elements already in view on load
            setTimeout(() => {
                document.querySelectorAll('.fade-up').forEach((el) => {
                    const rect = el.getBoundingClientRect();
                    if(rect.top < window.innerHeight) {
                        el.classList.add('in-view');
                    }
                });
            }, 100);

            // Navbar scrolled state (glass effect & shadow)
            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    navbar.classList.add('shadow-sm');
                    navbar.classList.remove('border-transparent');
                } else {
                    navbar.classList.remove('shadow-sm');
                }
            });
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>