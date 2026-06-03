<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)
            ->orWhere('user_id', $user->id)
            ->first();

        $tab = $request->query('tab', 'akun');
        return view('pengaturan', compact('user', 'mahasiswa', 'tab'));
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->orWhere('user_id', $user->id)->first();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'program_studi' => 'required|string',
            'universitas' => 'required|string',
            'angkatan' => 'required|numeric',
            'phone' => 'nullable|string',
            'portfolio_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'github_link' => 'nullable|url',
            'bio' => 'nullable|string|max:500',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoProfilPath = $mahasiswa ? $mahasiswa->foto_profil : null;
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            // Upload to Supabase Storage
            \Illuminate\Support\Facades\Storage::disk('supabase')->put('images/profil/' . $filename, file_get_contents($file));
            // Get public URL
            $fotoProfilPath = \Illuminate\Support\Facades\Storage::disk('supabase')->url('images/profil/' . $filename);
        }

        // Update User
        User::where('id', $user->id)->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        if ($mahasiswa) {
            $mahasiswa->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'program_studi' => $request->program_studi,
                'universitas' => $request->universitas,
                'angkatan' => $request->angkatan,
                'phone' => $request->phone,
                'portfolio_link' => $request->portfolio_link,
                'linkedin_link' => $request->linkedin_link,
                'github_link' => $request->github_link,
                'bio' => $request->bio,
            ]);
            if ($fotoProfilPath) {
                $mahasiswa->update(['foto_profil' => $fotoProfilPath]);
            }
        }

        return redirect()->route('pengaturan', ['tab' => 'akun'])
            ->with('success', 'Informasi akun berhasil disimpan.');
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->orWhere('user_id', $user->id)->first();

        if ($mahasiswa) {
            $request->validate([
                'topik_minat' => 'nullable|array|max:6',
                'tingkat_kemampuan' => 'nullable|string',
                'waktu_belajar' => 'nullable|array',
            ]);

            $mahasiswa->update([
                'topik_minat' => $request->topik_minat ? implode(',', $request->topik_minat) : null,
                'tingkat_kemampuan' => $request->tingkat_kemampuan,
                'waktu_belajar' => $request->waktu_belajar,
            ]);
        }

        return redirect()->route('pengaturan', ['tab' => 'preferensi'])
            ->with('success', 'Preferensi belajar berhasil disimpan.');
    }

    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->orWhere('user_id', $user->id)->first();

        if ($mahasiswa) {
            $mahasiswa->update([
                'is_profile_public' => $request->has('is_profile_public'),
                'is_online_visible' => $request->has('is_online_visible'),
                'message_permission' => $request->message_permission ?? 'Semua orang',
            ]);
        }

        return redirect()->route('pengaturan', ['tab' => 'privasi'])
            ->with('success', 'Pengaturan privasi berhasil disimpan.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password),
        ]);

        // Sync to Mahasiswa for backward compatibility
        $mahasiswa = Mahasiswa::where('email', $user->email)->orWhere('user_id', $user->id)->first();
        if ($mahasiswa) {
            $mahasiswa->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('pengaturan', ['tab' => 'privasi'])
            ->with('success', 'Kata sandi berhasil diubah.');
    }
}
