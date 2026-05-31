<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('angkatan')->nullable();
            $table->text('bio')->nullable();
            $table->string('portfolio_link')->nullable();
            $table->boolean('is_profile_public')->default(true);
            $table->boolean('is_online_visible')->default(true);
            $table->string('message_permission')->default('Semua orang');
            $table->string('tingkat_kemampuan')->nullable();
            $table->text('waktu_belajar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn([
                'angkatan',
                'bio',
                'portfolio_link',
                'is_profile_public',
                'is_online_visible',
                'message_permission',
                'tingkat_kemampuan',
                'waktu_belajar'
            ]);
        });
    }
};
