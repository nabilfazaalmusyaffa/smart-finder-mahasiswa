<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswa', 'program_studi')) {
                $table->string('program_studi')->nullable()->after('jadwal_kosong');
            }
            if (!Schema::hasColumn('mahasiswa', 'universitas')) {
                $table->string('universitas')->nullable()->after('program_studi');
            }
            if (!Schema::hasColumn('mahasiswa', 'foto_profil')) {
                $table->string('foto_profil')->nullable()->after('universitas');
            }
            if (!Schema::hasColumn('mahasiswa', 'topik_minat')) {
                $table->string('topik_minat')->nullable()->after('foto_profil');
            }
            if (!Schema::hasColumn('mahasiswa', 'profile_completed')) {
                $table->boolean('profile_completed')->default(false)->after('topik_minat');
            }
            if (!Schema::hasColumn('mahasiswa', 'reset_code')) {
                $table->string('reset_code', 6)->nullable()->after('profile_completed');
            }
            if (!Schema::hasColumn('mahasiswa', 'reset_code_expires_at')) {
                $table->timestamp('reset_code_expires_at')->nullable()->after('reset_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn([
                'program_studi', 'universitas', 'foto_profil', 'topik_minat',
                'profile_completed', 'reset_code', 'reset_code_expires_at',
            ]);
        });
    }
};