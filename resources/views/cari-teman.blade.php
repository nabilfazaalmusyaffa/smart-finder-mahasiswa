<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Partner - Smart Finder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-gradient-to-b from-[#265f89] to-[#123b5a] text-white p-6 hidden lg:block">
            <div class="flex items-center gap-3 mb-10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain bg-white rounded-full p-1">
                <div>
                    <h1 class="font-extrabold text-lg">Smart Finder</h1>
                    <p class="text-xs text-blue-100">Mahasiswa</p>
                </div>
            </div>

            <nav class="space-y-3">
                <a href="/dashboard" class="block hover:bg-white/20 px-4 py-3 rounded-xl font-semibold">
                    Dashboard
                </a>

                <a href="/cari-teman" class="block bg-white/20 px-4 py-3 rounded-xl font-semibold">
                    Cari Partner
                </a>

                <a href="#" class="block hover:bg-white/20 px-4 py-3 rounded-xl font-semibold">
                    Diskusi
                </a>

                <a href="#" class="block hover:bg-white/20 px-4 py-3 rounded-xl font-semibold">
                    Jadwal
                </a>

                <a href="#" class="block hover:bg-white/20 px-4 py-3 rounded-xl font-semibold">
                    Profil
                </a>
            </nav>

            <a href="/login" class="block mt-12 text-red-200 hover:text-white font-semibold">
                Logout
            </a>
        </aside>

        <!-- KONTEN -->
        <main class="flex-1 p-6 lg:p-8 bg-gradient-to-br from-[#d7f7f5] via-[#e8fbf7] to-[#f7ffff]">

            <!-- HEADER -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-[#245f8d]">
                    Cari Partner Belajar
                </h2>
                <p class="text-gray-600">
                    Temukan teman belajar berdasarkan skill, jurusan, minat, dan jadwal.
                </p>
            </div>

            <!-- SEARCH -->
            <div class="bg-white p-5 rounded-2xl shadow mb-8">
                <input
                    type="text"
                    placeholder="Cari nama, skill, jurusan, atau minat..."
                    class="w-full border border-gray-300 px-5 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#7ec8d8]"
                >
            </div>

            <!-- FILTER -->
            <div class="flex flex-wrap gap-3 mb-8">
                <button class="bg-[#245f8d] text-white px-5 py-2 rounded-full font-semibold">
                    Semua
                </button>
                <button class="bg-white text-[#245f8d] px-5 py-2 rounded-full font-semibold shadow">
                    UI/UX
                </button>
                <button class="bg-white text-[#245f8d] px-5 py-2 rounded-full font-semibold shadow">
                    Laravel
                </button>
                <button class="bg-white text-[#245f8d] px-5 py-2 rounded-full font-semibold shadow">
                    Database
                </button>
                <button class="bg-white text-[#245f8d] px-5 py-2 rounded-full font-semibold shadow">
                    Desain
                </button>
            </div>

            <!-- CARD PARTNER -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-14 h-14 bg-blue-100 text-[#245f8d] rounded-full flex items-center justify-center font-extrabold text-xl">
                            A
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-gray-800">Ahmad Rizky</h3>
                            <p class="text-sm text-gray-500">Manajemen Informatika</p>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600 mb-5">
                        <p><span class="font-bold text-gray-800">Skill:</span> UI/UX Design</p>
                        <p><span class="font-bold text-gray-800">Minat:</span> Desain aplikasi kampus</p>
                        <p><span class="font-bold text-gray-800">Jadwal:</span> Senin & Rabu</p>
                    </div>

                    <button class="w-full bg-[#245f8d] text-white py-3 rounded-full font-bold hover:bg-[#1c4d73]">
                        Ajak Belajar
                    </button>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-14 h-14 bg-blue-100 text-[#245f8d] rounded-full flex items-center justify-center font-extrabold text-xl">
                            S
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-gray-800">Siti Aulia</h3>
                            <p class="text-sm text-gray-500">Sistem Informasi</p>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600 mb-5">
                        <p><span class="font-bold text-gray-800">Skill:</span> Backend Laravel</p>
                        <p><span class="font-bold text-gray-800">Minat:</span> Website dan database</p>
                        <p><span class="font-bold text-gray-800">Jadwal:</span> Selasa & Kamis</p>
                    </div>

                    <button class="w-full bg-[#245f8d] text-white py-3 rounded-full font-bold hover:bg-[#1c4d73]">
                        Ajak Belajar
                    </button>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-14 h-14 bg-blue-100 text-[#245f8d] rounded-full flex items-center justify-center font-extrabold text-xl">
                            B
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-gray-800">Bima Putra</h3>
                            <p class="text-sm text-gray-500">Teknik Informatika</p>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600 mb-5">
                        <p><span class="font-bold text-gray-800">Skill:</span> Desain Poster</p>
                        <p><span class="font-bold text-gray-800">Minat:</span> Konten kreatif</p>
                        <p><span class="font-bold text-gray-800">Jadwal:</span> Jumat</p>
                    </div>

                    <button class="w-full bg-[#245f8d] text-white py-3 rounded-full font-bold hover:bg-[#1c4d73]">
                        Ajak Belajar
                    </button>
                </div>

            </div>

        </main>
    </div>
</body>
</html>