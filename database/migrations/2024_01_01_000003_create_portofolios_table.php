<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id();
            $table->string('nama_proyek');
            $table->string('kategori'); // Desa, Sekolah, UMKM, dll
            $table->string('emoji_icon')->default('🌐');
            $table->string('warna_thumb')->default('#E1F5EE');
            $table->text('deskripsi')->nullable();
            $table->string('gambar_thumbnail')->nullable();
            $table->string('link_demo')->nullable();
            $table->boolean('tampilkan_demo')->default(true);
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portofolios');
    }
};
