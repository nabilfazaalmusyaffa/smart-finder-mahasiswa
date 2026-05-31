<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswa', 'google_id')) {
                $table->string('google_id')->nullable()->after('email');
            }
            if (!Schema::hasColumn('mahasiswa', 'avatar')) {
                $table->string('avatar')->nullable()->after('google_id');
            }
            if (!Schema::hasColumn('mahasiswa', 'provider')) {
                $table->string('provider')->nullable()->default('manual')->after('avatar');
            }
            // Buat username nullable karena user Google tidak punya username
            if (Schema::hasColumn('mahasiswa', 'username')) {
                $table->string('username')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar', 'provider']);
        });
    }
};
