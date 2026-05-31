<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('skill')->nullable();
            $table->string('minat_belajar')->nullable();
            $table->string('jadwal_kosong')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};