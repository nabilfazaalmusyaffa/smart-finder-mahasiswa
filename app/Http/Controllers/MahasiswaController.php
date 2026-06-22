<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MahasiswaController extends Controller
{
    // ─── Helpers ──────────────────────────────────────────────────────────────
    private function authGuard(Request $request = null)
    {
        if (!session('mahasiswa_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        return null;
    }

    private function getDynamicTopics($limit = 6)
    {
        $topicsData = \App\Models\CommunityPost::select('topic', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->whereNotNull('topic')
            ->groupBy('topic')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
            
        if ($topicsData->isEmpty()) {
            return [
                ['nama' => 'Desain Grafis', 'icon' => 'layout', 'color' => '#db2777', 'bg' => '#fce7f3', 'member' => 201, 'materi' => 52, 'count' => 52],
                ['nama' => 'Digital Marketing', 'icon' => 'trending-up', 'color' => '#059669', 'bg' => '#d1fae5', 'member' => 156, 'materi' => 67, 'count' => 67],
                ['nama' => 'Web Development', 'icon' => 'code', 'color' => '#0891b2', 'bg' => '#cffafe', 'member' => 312, 'materi' => 89, 'count' => 89],
                ['nama' => 'Bahasa Inggris', 'icon' => 'book', 'color' => '#7c3aed', 'bg' => '#ede9fe', 'member' => 198, 'materi' => 45, 'count' => 45],
            ];
        }

        $topiks = [];
        foreach ($topicsData as $t) {
            $name = $t->topic;
            $count = $t->count;
            
            $icon = 'book';
            $color = '#7c3aed';
            $bg = '#ede9fe';
            
            $nm = strtolower($name);
            if (str_contains($nm, 'machine learning') || str_contains($nm, 'ai')) { $icon = 'cpu'; $color = '#2563EB'; $bg = '#dbeafe'; }
            elseif (str_contains($nm, 'web dev') || str_contains($nm, 'website')) { $icon = 'code'; $color = '#0891b2'; $bg = '#cffafe'; }
            elseif (str_contains($nm, 'desain') || str_contains($nm, 'ui/ux')) { $icon = 'layout'; $color = '#db2777'; $bg = '#fce7f3'; }
            elseif (str_contains($nm, 'marketing') || str_contains($nm, 'bisnis')) { $icon = 'trending-up'; $color = '#059669'; $bg = '#d1fae5'; }
            elseif (str_contains($nm, 'basis data') || str_contains($nm, 'database')) { $icon = 'database'; $color = '#8b5cf6'; $bg = '#ede9fe'; }
            elseif (str_contains($nm, 'cyber') || str_contains($nm, 'security')) { $icon = 'shield-check'; $color = '#dc2626'; $bg = '#fee2e2'; }
            elseif (str_contains($nm, 'manajemen')) { $icon = 'briefcase'; $color = '#ea580c'; $bg = '#ffedd5'; }
            
            $topiks[] = [
                'nama' => $name,
                'icon' => $icon,
                'color' => $color,
                'bg' => $bg,
                'member' => $count * 3 + rand(10, 50),
                'materi' => $count,
                'count' => $count
            ];
        }
        
        return $topiks;
    }

    // ─── Homepage ─────────────────────────────────────────────────────────────
    public function index()
    {
        return view('home');
    }

    // ─── Auth Views ───────────────────────────────────────────────────────────
    public function login()
    {
        if (session('mahasiswa_id')) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function daftar()
    {
        return view('daftar');
    }

    // ─── Register ─────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:mahasiswa,username',
            'email' => 'required|email|unique:mahasiswa,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $mahasiswa = Mahasiswa::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Dipertahankan sementara mencegah data error logic lama
            'phone' => $request->phone,
            'profile_completed' => false,
        ]);

        Auth::login($user);

        return redirect()->route('profil.lengkapi')
            ->with('success', 'Akun berhasil dibuat! Lengkapi profilmu.');
    }

    // ─── Login ────────────────────────────────────────────────────────────────
    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            auth()->user()->update([
                'is_online' => true,
                'last_seen' => now(),
            ]);

            // Set backward compatibility session setup for legacy views
            $mahasiswa = Mahasiswa::where('email', $request->email)->first();
            if ($mahasiswa) {
                session([
                    'mahasiswa_id' => $mahasiswa->id,
                    'mahasiswa_nama' => $mahasiswa->nama,
                    'mahasiswa_email' => $mahasiswa->email,
                ]);

                if (!$mahasiswa->profile_completed) {
                    return redirect()->route('profil.lengkapi');
                }
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ─── Logout ───────────────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        if (auth()->check()) {
            auth()->user()->update([
                'is_online' => false,
                'last_seen' => now(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil keluar.');
    }

    // ─── Profil Saya ──────────────────────────────────────────────────────────
    public function profil()
    {
        $mahasiswa = Mahasiswa::where('email', Auth::user()->email)->first();

        // Dummy statistik profil untuk visual sementara
        $stats = [
            'sesi_belajar' => 15,
            'partner' => 4,
            'hari_aktif' => 10
        ];

        return view('profil', compact('mahasiswa', 'stats'));
    }

    // ─── Lengkapi Profil ──────────────────────────────────────────────────────
    public function lengkapiProfil()
    {
        $guard = $this->authGuard();
        if ($guard)
            return $guard;

        $mahasiswa = Mahasiswa::find(session('mahasiswa_id'));
        return view('lengkapi-profil', compact('mahasiswa'));
    }

    public function simpanProfil(Request $request)
    {
        $guard = $this->authGuard();
        if ($guard)
            return $guard;

        $request->validate([
            'program_studi' => 'required|string|max:255',
            'universitas' => 'required|string|max:255',
            'topik_minat' => 'nullable|array|max:6',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        $mahasiswa = Mahasiswa::find(session('mahasiswa_id'));

        $fotoProfil = $mahasiswa->foto_profil;
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $filename = 'profil_' . $mahasiswa->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Check if Supabase Storage is configured
            if (config('filesystems.disks.supabase.key') && config('filesystems.disks.supabase.secret')) {
                try {
                    // Upload to Supabase Storage
                    \Illuminate\Support\Facades\Storage::disk('supabase')->put('images/profil/' . $filename, file_get_contents($file));
                    // Get public URL
                    $fotoProfil = \Illuminate\Support\Facades\Storage::disk('supabase')->url('images/profil/' . $filename);
                } catch (\Exception $e) {
                    return back()->withErrors(['foto_profil' => 'Gagal mengunggah foto ke Supabase. Pastikan variabel SUPABASE di Railway sudah diisi.']);
                }
            } else {
                // Fallback to local public disk storage
                try {
                    $path = $file->storeAs('images/profil', $filename, 'public');
                    $fotoProfil = '/storage/' . $path;
                } catch (\Exception $e) {
                    return back()->withErrors(['foto_profil' => 'Gagal menyimpan foto secara lokal: ' . $e->getMessage()]);
                }
            }
        }

        $topics_input = $request->topik_minat ?? [];
        $predefined = ['Machine Learning', 'Web Dev', 'Basis Data', 'Algoritma', 'Cyber Sec', 'Lainnya'];
        $customs = array_diff($topics_input, $predefined);

        $topik_string = empty($topics_input) ? null : implode(',', $topics_input);
        $keahlian_custom_string = empty($customs) ? null : implode(',', $customs);

        $mahasiswa->update([
            'program_studi' => $request->program_studi,
            'universitas' => $request->universitas,
            'foto_profil' => $fotoProfil,
            'topik_minat' => $topik_string,
            'keahlian_custom' => $keahlian_custom_string,
            'jurusan' => $request->program_studi,
            'minat_belajar' => $topik_string,
            'skill' => $topik_string,
            'profile_completed' => true,
        ]);

        return redirect()->route('dashboard')
            ->with('welcome', 'Halo, ' . $mahasiswa->nama . '! Selamat datang di Smart Finder!');
    }

    // ─── Dashboard ────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $guard = $this->authGuard();
        if ($guard)
            return $guard;

        $mahasiswa = Mahasiswa::find(session('mahasiswa_id'));

        $partners = User::where('id', '!=', auth()->id())
            ->whereHas('mahasiswa', function ($q) {
                $q->where('profile_completed', true);
            })
            ->with('mahasiswa')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $topiks = $this->getDynamicTopics(4);

        return view('dashboard', compact('mahasiswa', 'partners', 'topiks'));
    }

    // ─── Cari Partner ─────────────────────────────────────────────────────────
    public function cariPartner(Request $request)
    {
        $guard = $this->authGuard();
        if ($guard)
            return $guard;

        $mahasiswa = Mahasiswa::find(session('mahasiswa_id'));

        $query = User::where('id', '!=', auth()->id())->with('mahasiswa');

        if ($request->filled('search')) {
            $search = strtolower(trim($request->search));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"])
                    ->orWhereHas('mahasiswa', function ($sub) use ($search) {
                        $sub->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(username) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(program_studi) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(universitas) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(jurusan) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(skill) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(minat_belajar) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(topik_minat) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(keahlian_custom) LIKE ?', ["%{$search}%"]);
                    });
            });
        }

        if ($request->filled('topik') && $request->topik !== 'all') {
            $query->whereHas('mahasiswa', function ($sub) use ($request) {
                $sub->where('topik_minat', 'like', '%' . $request->topik . '%');
            });
        }

        if ($request->filled('keahlian') && $request->keahlian !== 'all') {
            $query->whereHas('mahasiswa', function ($sub) use ($request) {
                $sub->where(function ($q2) use ($request) {
                    $q2->where('skill', 'like', '%' . $request->keahlian . '%')
                        ->orWhere('keahlian_custom', 'like', '%' . $request->keahlian . '%');
                });
            });
        }

        if ($request->filled('jadwal') && $request->jadwal !== 'all') {
            $query->whereHas('mahasiswa', function ($sub) use ($request) {
                $sub->where('jadwal_kosong', 'like', '%' . $request->jadwal . '%');
            });
        }

        $partners = $query->paginate(9)->withQueryString();

        return view('cari-partner', compact('mahasiswa', 'partners'));
    }

    // ─── Lupa Sandi ───────────────────────────────────────────────────────────
    public function lupaSandi()
    {
        return view('lupa-sandi');
    }

    public function kirimKode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:mahasiswa,email',
        ], [
            'email.exists' => 'Email tidak ditemukan di sistem kami.',
        ]);

        $kode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = now()->addMinutes(15);

        // Simpan ke database
        Mahasiswa::where('email', $request->email)->update([
            'reset_code' => $kode,
            'reset_code_expires_at' => $expires,
        ]);

        // Simpan ke session
        session([
            'reset_email' => $request->email,
            'reset_kode' => $kode,
        ]);

        return view('reset-terkirim', ['email' => $request->email, 'kode' => $kode]);
    }

    // ─── Verifikasi OTP ───────────────────────────────────────────────────────
    public function verifikasiKodeView()
    {
        return view('verifikasi-kode');
    }

    public function verifikasiKode(Request $request)
    {
        $request->validate([
            'kode' => 'required|digits:6',
        ]);

        $email = session('reset_email');
        $mahasiswa = Mahasiswa::where('email', $email)
            ->where('reset_code', $request->kode)
            ->whereNotNull('reset_code_expires_at')
            ->first();

        if (!$mahasiswa || now()->isAfter($mahasiswa->reset_code_expires_at)) {
            return back()->withErrors(['kode' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        // Tandai OTP sudah diverifikasi (simpan ke session)
        session(['reset_verified' => true]);

        return redirect()->route('password.change');
    }

    // ─── Ganti Sandi ─────────────────────────────────────────────────────────
    public function gantiSandiView()
    {
        if (!session('reset_verified') || !session('reset_email')) {
            return redirect()->route('password.forgot')
                ->with('error', 'Silakan mulai dari awal proses lupa sandi.');
        }
        return view('ganti-sandi');
    }

    public function gantiSandi(Request $request)
    {
        if (!session('reset_verified') || !session('reset_email')) {
            return redirect()->route('password.forgot');
        }

        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $mahasiswa = Mahasiswa::where('email', session('reset_email'))->first();
        $user = User::where('email', session('reset_email'))->first();

        if (!$mahasiswa && !$user) {
            return redirect()->route('password.forgot')
                ->with('error', 'Akun tidak ditemukan.');
        }

        if ($mahasiswa) {
            $mahasiswa->update([
                'password' => Hash::make($request->password),
                'reset_code' => null,
                'reset_code_expires_at' => null,
            ]);
        }

        if ($user) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        session()->forget(['reset_email', 'reset_kode', 'reset_verified']);

        return redirect()->route('reset.success');
    }

    // ─── Reset Berhasil ───────────────────────────────────────────────────────
    public function resetBerhasil()
    {
        return view('reset-berhasil');
    }

    // ─── Google Login (UI Simulasi) ───────────────────────────────────────────
    public function googleLogin()
    {
        return view('google-login');
    }

    public function googlePilihAkun(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nama' => 'required|string',
        ]);

        $mahasiswa = Mahasiswa::where('email', $request->email)->first();

        if (!$mahasiswa) {
            $base = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->nama));
            $username = $base . rand(100, 999);
            // Ensure unique username
            while (Mahasiswa::where('username', $username)->exists()) {
                $username = $base . rand(1000, 9999);
            }
            $mahasiswa = Mahasiswa::create([
                'nama' => $request->nama,
                'username' => $username,
                'email' => $request->email,
                'password' => Hash::make(uniqid()),
                'profile_completed' => false,
            ]);
        }

        session([
            'mahasiswa_id' => $mahasiswa->id,
            'mahasiswa_nama' => $mahasiswa->nama,
            'mahasiswa_email' => $mahasiswa->email,
        ]);

        if (!$mahasiswa->profile_completed) {
            return redirect()->route('profil.lengkapi');
        }

        return redirect()->route('dashboard');
    }

    public function eksplorTopik(Request $request)
    {
        $popularTopics = $this->getDynamicTopics(6);

        $materials = \App\Models\Material::with('user')
            ->when($request->filled('topic'), fn($q) => $q->where('topic', $request->topic))
            ->latest()
            ->get();
        return view('eksplor-topik', compact('materials', 'popularTopics'));
    }

    public function komunitas()
    {
        return view('komunitas');
    }

    public function obrolan()
    {
        return view('obrolan');
    }

    public function heartbeat()
    {
        if (auth()->check()) {
            auth()->user()->update([
                'is_online' => true,
                'last_seen' => now(),
            ]);
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'unauthenticated'], 401);
    }
}