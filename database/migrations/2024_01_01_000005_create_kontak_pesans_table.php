<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontak_pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('whatsapp');
            $table->string('jenis_website')->nullable();
            $table->text('pesan')->nullable();
            $table->enum('status', ['baru', 'dibaca', 'diproses', 'selesai'])->default('baru');
            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak_pesans');
    }
};
