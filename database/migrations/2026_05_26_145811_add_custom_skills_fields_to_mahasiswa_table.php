<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswa', 'keahlian_custom')) {
                $table->text('keahlian_custom')->nullable();
            }
            if (!Schema::hasColumn('mahasiswa', 'skill')) {
                $table->text('skill')->nullable();
            }
            if (!Schema::hasColumn('mahasiswa', 'minat_belajar')) {
                $table->string('minat_belajar')->nullable();
            }
            if (!Schema::hasColumn('mahasiswa', 'jadwal_kosong')) {
                $table->string('jadwal_kosong')->nullable();
            }
            if (!Schema::hasColumn('mahasiswa', 'jurusan')) {
                $table->string('jurusan')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswa', 'keahlian_custom')) {
                $table->dropColumn('keahlian_custom');
            }
        });
    }
};