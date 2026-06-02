<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\GoogleAuthController;

// ── Homepage ─────────────────────────────────────────────────────────────────
Route::get('/', [MahasiswaController::class, 'index'])->name('home');

// ── Auth (publik, tidak perlu login) ─────────────────────────────────────────
Route::get('/login', [MahasiswaController::class, 'login'])->name('login');
Route::post('/login', [MahasiswaController::class, 'loginProcess'])->name('login.process');
Route::post('/logout', [MahasiswaController::class, 'logout'])->name('logout');

// ── Register ──────────────────────────────────────────────────────────────────
Route::get('/daftar', [MahasiswaController::class, 'daftar'])->name('daftar');
Route::post('/daftar', [MahasiswaController::class, 'store'])->name('daftar.store');

// ── Google OAuth (Socialite) ──────────────────────────────────────────────────
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

// ── Lupa Sandi / OTP / Ganti Sandi (publik) ──────────────────────────────────
Route::get('/lupa-sandi', [MahasiswaController::class, 'lupaSandi'])->name('password.forgot');
Route::post('/lupa-sandi', [MahasiswaController::class, 'kirimKode'])->name('password.send');
Route::get('/verifikasi-kode', [MahasiswaController::class, 'verifikasiKodeView'])->name('verify.code');
Route::post('/verifikasi-kode', [MahasiswaController::class, 'verifikasiKode'])->name('verify.process');
Route::get('/ganti-sandi', [MahasiswaController::class, 'gantiSandiView'])->name('password.change');
Route::post('/ganti-sandi', [MahasiswaController::class, 'gantiSandi'])->name('password.update');
Route::get('/reset-berhasil', [MahasiswaController::class, 'resetBerhasil'])->name('reset.success');

// ── Route yang butuh login (dilindungi middleware auth) ─────────────────
Route::middleware('auth')->group(function () {
    Route::post('/user/heartbeat', [MahasiswaController::class, 'heartbeat'])->name('user.heartbeat');

    // Profil Saya
    Route::get('/profil', [MahasiswaController::class, 'profil'])->name('profil.saya');

    // Lengkapi Profil (Signup step)
    Route::get('/lengkapi-profil', [MahasiswaController::class, 'lengkapiProfil'])->name('profil.lengkapi');
    Route::post('/lengkapi-profil', [MahasiswaController::class, 'simpanProfil'])->name('profil.simpan');

    // Pengaturan
    Route::get('/pengaturan', [App\Http\Controllers\SettingsController::class, 'index'])->name('pengaturan');
    Route::patch('/pengaturan/akun', [App\Http\Controllers\SettingsController::class, 'updateAccount'])->name('pengaturan.akun');
    Route::patch('/pengaturan/preferensi', [App\Http\Controllers\SettingsController::class, 'updatePreferences'])->name('pengaturan.preferensi');
    Route::patch('/pengaturan/privasi', [App\Http\Controllers\SettingsController::class, 'updatePrivacy'])->name('pengaturan.privasi');
    Route::patch('/pengaturan/sandi', [App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('pengaturan.sandi');

    // Notifikasi
    Route::get('/notifikasi', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifikasi');
    Route::patch('/notifikasi/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifikasi.read');
    Route::patch('/notifikasi/read-all', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifikasi.readAll');

    // Dashboard & Fitur Utama
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/cari-partner', [MahasiswaController::class, 'cariPartner'])->name('cari.partner');
    Route::get('/eksplor-topik', [MahasiswaController::class, 'eksplorTopik'])->name('eksplor.topik');
    Route::post('/materials', [App\Http\Controllers\MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [App\Http\Controllers\MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::get('/komunitas', [App\Http\Controllers\CommunityController::class, 'index'])->name('community.index');
    Route::get('/komunitas/create', [App\Http\Controllers\CommunityController::class, 'create'])->name('community.create');
    Route::post('/komunitas', [App\Http\Controllers\CommunityController::class, 'store'])->name('community.store');
    Route::get('/komunitas/{post}', [App\Http\Controllers\CommunityController::class, 'show'])->name('community.show');
    Route::delete('/komunitas/{post}', [App\Http\Controllers\CommunityController::class, 'destroy'])->name('community.destroy');
    Route::post('/komunitas/{post}/like', [App\Http\Controllers\CommunityInteractionController::class, 'like'])->name('community.like');
    Route::post('/komunitas/{post}/comment', [App\Http\Controllers\CommunityInteractionController::class, 'comment'])->name('community.comment');
    Route::delete('/komunitas/comments/{comment}', [App\Http\Controllers\CommunityInteractionController::class, 'destroyComment'])->name('community.comments.destroy');
    Route::post('/komunitas/{post}/save', [App\Http\Controllers\CommunityInteractionController::class, 'save'])->name('community.save');
    Route::post('/komunitas/{post}/join-study-group', [App\Http\Controllers\CommunityInteractionController::class, 'joinStudyGroup'])->name('community.joinStudyGroup');
    Route::post('/komunitas/{post}/join-event', [App\Http\Controllers\CommunityInteractionController::class, 'joinEvent'])->name('community.joinEvent');
    // Legacy route redirect
    Route::get('/komunitas-lama', fn() => redirect()->route('community.index'));
    // Public Partner Profile & Undangan
    Route::get('/partners/{user}', [App\Http\Controllers\PartnerController::class, 'show'])->name('partners.show');
    Route::post('/partners/{user}/invite', [App\Http\Controllers\PartnerController::class, 'invite'])->name('partners.invite');

    // Obrolan Chat (Personal)
    Route::get('/obrolan', [App\Http\Controllers\ChatController::class, 'index'])->name('obrolan');
    Route::get('/obrolan/statuses', [App\Http\Controllers\ChatController::class, 'getStatuses'])->name('obrolan.statuses');
    Route::get('/obrolan/{chatId}', [App\Http\Controllers\ChatController::class, 'index'])->name('obrolan.show');
    Route::post('/obrolan/{chatId}/send', [App\Http\Controllers\ChatController::class, 'send'])->name('obrolan.send');
    Route::delete('/obrolan/messages/{message}', [App\Http\Controllers\ChatController::class, 'destroyMessage'])->name('chat.messages.destroy');
    Route::post('/obrolan/start/{user}', [App\Http\Controllers\ChatController::class, 'startConversation'])->name('obrolan.start');

    // Obrolan Group Chat
    Route::get('/obrolan/group/{groupConversation}', [App\Http\Controllers\GroupChatController::class, 'show'])->name('group-chat.show');
    Route::post('/obrolan/group/{groupConversation}/send', [App\Http\Controllers\GroupChatController::class, 'send'])->name('group-chat.send');
    Route::post('/obrolan/group/{groupConversation}/leave', [App\Http\Controllers\GroupChatController::class, 'leave'])->name('group-chat.leave');
    Route::delete('/obrolan/group/messages/{message}', [App\Http\Controllers\GroupChatController::class, 'destroyMessage'])->name('group-chat.messages.destroy');
});