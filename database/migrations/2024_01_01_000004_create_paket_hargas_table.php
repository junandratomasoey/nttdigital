<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_hargas', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Starter, Profesional, Enterprise
            $table->string('label_badge')->nullable(); // Populer, Terbaik, dll
            $table->string('harga'); // Rp 1.500.000
            $table->string('satuan')->default('/ proyek');
            $table->json('fitur'); // array of string fitur
            $table->boolean('unggulan')->default(false); // border hijau
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_hargas');
    }
};
