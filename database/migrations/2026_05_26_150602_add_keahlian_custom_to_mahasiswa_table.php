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
        if (!Schema::hasColumn('mahasiswa', 'keahlian_custom')) {
            Schema::table('mahasiswa', function (Blueprint $table) {
                $table->text('keahlian_custom')->nullable()->after('topik_minat');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('mahasiswa', 'keahlian_custom')) {
            Schema::table('mahasiswa', function (Blueprint $table) {
                $table->dropColumn('keahlian_custom');
            });
        }
    }
};
