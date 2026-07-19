<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carousel_slides', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('subjudul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('warna_tema')->default('teal'); // teal, biru, ungu
            $table->string('emoji_icon')->nullable();
            $table->string('gambar')->nullable(); // path gambar upload
            $table->string('teks_tombol_utama')->default('Lihat Portofolio');
            $table->string('link_tombol_utama')->default('#portofolio');
            $table->string('teks_tombol_kedua')->nullable();
            $table->string('link_tombol_kedua')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carousel_slides');
    }
};
