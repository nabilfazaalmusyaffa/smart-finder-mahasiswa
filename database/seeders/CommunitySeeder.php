<?php

namespace Database\Seeders;

use App\Models\CommunityPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommunitySeeder extends Seeder
{
    public function run(): void
    {
        // Ambil 2 user pertama untuk dibuat sebagai penulis
        $users = User::take(3)->get();
        if ($users->isEmpty())
            return;

        $u1 = $users->first();
        $u2 = $users->count() > 1 ? $users->get(1) : $u1;
        $u3 = $users->count() > 2 ? $users->get(2) : $u1;

        $posts = [
            // Diskusi
            [
                'user_id' => $u1->id,
                'category' => 'diskusi',
                'topic' => 'Machine Learning',
                'title' => 'Ada yang punya rekomendasi roadmap belajar machine learning untuk pemula?',
                'body' => 'Aku lagi mulai belajar ML tapi bingung mulai dari mana. Ada yang bisa share roadmap atau sumber belajar yang bagus dari nol dan pakai Python?',
            ],
            [
                'user_id' => $u2->id,
                'category' => 'diskusi',
                'topic' => 'Web Development',
                'title' => 'Pilih Laravel atau Next.js untuk project akhir?',
                'body' => 'Saya lagi bimbang mau pakai Laravel monolith atau Next.js + REST API untuk project akhir semester. Ada masukan dari teman-teman yang sudah pernah pakai keduanya?',
            ],
            [
                'user_id' => $u3->id,
                'category' => 'diskusi',
                'topic' => 'Basis Data',
                'title' => 'Tips optimasi query SQL untuk jutaan data',
                'body' => 'Database saya sudah punya 5 juta baris data dan query mulai lambat. Apa saja teknik indexing dan optimasi yang sering kalian pakai?',
            ],
            // Q&A
            [
                'user_id' => $u2->id,
                'category' => 'qa',
                'topic' => 'Web Development',
                'title' => 'Kenapa useEffect saya berjalan dua kali di React?',
                'body' => 'Saya menggunakan useEffect tanpa dependency array tapi fungsinya berjalan dua kali saat component mount. Itu normal atau ada bug?',
            ],
            [
                'user_id' => $u1->id,
                'category' => 'qa',
                'topic' => 'Machine Learning',
                'title' => 'Bagaimana cara menangani imbalanced dataset?',
                'body' => 'Dataset saya sangat tidak seimbang: 95% class 0 dan 5% class 1. Bagaimana cara terbaik untuk menanganinya?',
            ],
            // Materi
            [
                'user_id' => $u3->id,
                'category' => 'materi',
                'topic' => 'Web Development',
                'title' => 'Cheatsheet Git yang sering aku pakai',
                'body' => 'Aku bikin ringkasan perintah Git yang paling sering digunakan saat ngoding bareng tim. Semoga bermanfaat buat kalian yang baru belajar cara push, pull, sama conflict resolve!',
            ],
            [
                'user_id' => $u2->id,
                'category' => 'materi',
                'topic' => 'Machine Learning',
                'title' => 'Panduan lengkap scikit-learn untuk pemula',
                'body' => 'Kumpulan contoh kode scikit-learn dari preprocessing sampai evaluasi model. Cocok buat yang baru mulai belajar machine learning dengan Python.',
            ],
            // Study Group
            [
                'user_id' => $u1->id,
                'category' => 'study_group',
                'topic' => 'Web Development',
                'title' => 'Study Group Laravel Bareng – Mulai dari Dasar',
                'body' => 'Aku ingin bikin study group kecil (maks 5 orang) untuk belajar Laravel 11 dari dasar sampai bikin CRUD. Diutamakan yang aktif dan mau belajar serius.',
                'group_schedule' => 'Sabtu 19.00 WIB',
            ],
            [
                'user_id' => $u2->id,
                'category' => 'study_group',
                'topic' => 'Machine Learning',
                'title' => 'Study Group Machine Learning – Python & scikit-learn',
                'body' => 'Belajar bareng machine learning dari regresi, klasifikasi, clustering sampai deep learning. Cocok untuk pemula yang ingin serius masuk ke dunia AI.',
                'group_schedule' => 'Minggu 10.00 WIB',
            ],
            [
                'user_id' => $u3->id,
                'category' => 'study_group',
                'topic' => 'Cyber Security',
                'title' => 'Belajar Ethical Hacking Bersama',
                'body' => 'Study group untuk belajar dasar-dasar keamanan siber, CTF, dan ethical hacking. Sudah ada 3 anggota, butuh 2 lagi!',
                'group_schedule' => 'Jumat 20.00 WIB',
            ],
            // Event
            [
                'user_id' => $u1->id,
                'category' => 'event',
                'topic' => 'Machine Learning',
                'title' => 'Webinar Dasar Machine Learning – Mulai dari Nol',
                'body' => 'Webinar gratis untuk memperkenalkan konsep dasar machine learning kepada mahasiswa. Dibawakan oleh praktisi industri.',
                'event_date' => Carbon::now()->addDays(7),
            ],
            [
                'user_id' => $u2->id,
                'category' => 'event',
                'topic' => 'Web Development',
                'title' => 'Hackathon 24 Jam – Build a Social App',
                'body' => 'Kompetisi hackathon 24 jam dengan tema Social Application. Hadiah total Rp 10 juta. Daftar sekarang dan bentuk timmu!',
                'event_date' => Carbon::now()->addDays(14),
            ],
        ];

        foreach ($posts as $postData) {
            CommunityPost::firstOrCreate(
                ['title' => $postData['title'], 'user_id' => $postData['user_id']],
                $postData
            );
        }
    }
}
