<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:fix-plain-text-passwords')]
#[Description('Command description')]
class FixPlainTextPasswords extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = \App\Models\User::all();
        $count = 0;
        foreach ($users as $user) {
            if ($user->password && !str_starts_with($user->password, '$2y$')) {
                $user->password = \Illuminate\Support\Facades\Hash::make($user->password);
                $user->save();
                $count++;
            }
        }
        $this->info("Menghash $count password plaintext di tabel users.");

        $mahasiswas = \App\Models\Mahasiswa::all();
        $countM = 0;
        foreach ($mahasiswas as $mahasiswa) {
            if ($mahasiswa->password && !str_starts_with($mahasiswa->password, '$2y$')) {
                $mahasiswa->password = \Illuminate\Support\Facades\Hash::make($mahasiswa->password);
                $mahasiswa->save();
                $countM++;
            }
        }
        $this->info("Menghash $countM password plaintext di tabel mahasiswa.");
    }
}
