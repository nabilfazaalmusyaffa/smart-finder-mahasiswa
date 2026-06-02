<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect ke halaman login Google.
     */
    public function redirect()
    {
        try {
            if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Login Google belum dikonfigurasi. Isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di file .env.',
                ]);
            }

            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            Log::error('Google Redirect Error: ' . $e->getMessage());

            return redirect()->route('login')->with('error', 'Login Google gagal. Pastikan konfigurasi Google sudah benar.');
        }
    }

    /**
     * Handle callback dari Google setelah user mengizinkan akses.
     */
    public function callback()
    {
        try {
            $provider = Socialite::driver('google')->stateless();
            if (app()->environment('local')) {
                $provider->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
            }
            $googleUser = $provider->user();
        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->with('error', 'Login Google gagal. Cek konfigurasi Client ID, Client Secret, Redirect URI, dan database.');
        }

        $name = $googleUser->getName() ?? 'User';

        // Cari atau buat User berdasarkan email Google
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $name,
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'provider' => 'google',
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(32)),
            ]
        );

        // Cari atau buat Mahasiswa untuk backward compatibility profil
        $mahasiswa = Mahasiswa::where('email', $googleUser->getEmail())
            ->orWhere('google_id', $googleUser->getId())
            ->first();

        if ($mahasiswa) {
            $mahasiswa->update([
                'user_id' => $user->id,
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'provider' => 'google',
            ]);
        } else {
            $mahasiswa = Mahasiswa::create([
                'user_id' => $user->id,
                'nama' => $name,
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'provider' => 'google',
                'password' => Hash::make(Str::random(32)),
                'username' => 'google_' . Str::slug($name) . '_' . Str::random(5),
                'profile_completed' => false,
            ]);
        }

        Auth::login($user);

        // Set session manual seperti login biasa (backward compatibility views)
        session([
            'mahasiswa_id' => $mahasiswa->id,
            'mahasiswa_nama' => $mahasiswa->nama,
            'mahasiswa_email' => $mahasiswa->email,
        ]);

        if (!$mahasiswa->profile_completed) {
            return redirect()->route('profil.lengkapi')
                ->with('success', 'Login Google berhasil! Lengkapi profilmu dulu ya.');
        }

        return redirect()->route('dashboard');
    }
}
