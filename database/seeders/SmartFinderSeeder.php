<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Notification;

class SmartFinderSeeder extends Seeder
{
    public function run()
    {
        $dummyUsers = [
            [
                'name' => 'Rina Wulandari',
                'email' => 'rina@example.com',
                'prodi' => 'Teknik Informatika',
                'univ' => 'Universitas Gadjah Mada',
                'topik' => 'Web Dev, UI/UX',
                'bio' => 'Saya Frontend Developer dengan minat besar di bidang interaktif dan web design modern. Senang belajar bareng soal framework JS.'
            ],
            [
                'name' => 'Dimas Firmansyah',
                'email' => 'dimas@example.com',
                'prodi' => 'Sistem Informasi',
                'univ' => 'Institut Teknologi Sepuluh Nopember',
                'topik' => 'Machine Learning, Data',
                'bio' => 'Data Science enthusiast. Sedang fokus menyelesaikan project akhir seputar prediksi machine learning dan analisis data besar.'
            ],
            [
                'name' => 'Salsa Nabila',
                'email' => 'salsa@example.com',
                'prodi' => 'Ilmu Komputer',
                'univ' => 'Universitas Indonesia',
                'topik' => 'Algoritma, Cyber Sec',
                'bio' => 'Fokus di cyber security dan competitive programming (Algoritma). Sering ikut CTF atau lomba sejenis. Mari belajar!'
            ],
            [
                'name' => 'Aldi Kurniawan',
                'email' => 'aldi@example.com',
                'prodi' => 'Teknik Komputer',
                'univ' => 'Universitas Padjadjaran',
                'topik' => 'Basis Data, Backend',
                'bio' => 'Backend developer (Laravel & Node.js). Tersedot ke dalam dunia API creation, mikroservis, dan relasional database.'
            ]
        ];

        $users = collect();
        foreach ($dummyUsers as $index => $u) {
            $user = User::firstOrCreate(['email' => $u['email']], [
                'name' => $u['name'],
                'password' => Hash::make('password123'),
            ]);

            $username = 'dummy' . ($index + 1) . '_' . rand(100, 999);
            Mahasiswa::firstOrCreate(['email' => $u['email']], [
                'user_id' => $user->id,
                'nama' => $u['name'],
                'username' => $username,
                'password' => Hash::make('password123'),
                'program_studi' => $u['prodi'],
                'universitas' => $u['univ'],
                'topik_minat' => $u['topik'],
                'skill' => $u['topik'],
                'bio' => $u['bio'],
                'angkatan' => '2021',
                'jadwal_kosong' => 'Fleksibel',
                'is_profile_public' => true,
                'profile_completed' => true,
            ]);

            $users->push($user);
        }

        // Ciptakan satu percakapan antara user(1) Rina dan user(2) Dimas untuk ditunjukkan sebagai riwayat
        if ($users->count() >= 2) {
            $u1 = $users[0];
            $u2 = $users[1];

            $conv = Conversation::firstOrCreate([
                'user_one_id' => $u1->id,
                'user_two_id' => $u2->id
            ], [
                'last_message_at' => now(),
            ]);

            Message::firstOrCreate([
                'conversation_id' => $conv->id,
                'sender_id' => $u1->id,
                'receiver_id' => $u2->id,
                'message' => 'Halo Dimas! Saya Rina. Apakah kamu mau join tim saya untuk lomba web dev?'
            ]);

            Message::firstOrCreate([
                'conversation_id' => $conv->id,
                'sender_id' => $u2->id,
                'receiver_id' => $u1->id,
                'message' => 'Halo Rina! Wow tawaran menarik. Saya sih biasanya pegang Data Science, tapi saya juga tertarik fullstack.'
            ]);

            // Notifikasi contoh
            Notification::firstOrCreate([
                'user_id' => $u2->id,
                'sender_id' => $u1->id,
                'type' => 'informasi',
                'title' => 'Rina mengirim pesan pertama',
                'message' => 'Klik untuk membalas di menu Obrolan.',
                'target_url' => '/obrolan/' . $conv->id
            ]);
        }
    }
}
