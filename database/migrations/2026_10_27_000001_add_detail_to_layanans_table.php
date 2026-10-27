<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->string('tagline')->nullable()->after('nama');
            $table->longText('konten')->nullable()->after('deskripsi');   // isi halaman detail (rich text)
            $table->json('fitur')->nullable()->after('konten');            // daftar fitur yang didapat
            $table->string('gambar')->nullable()->after('fitur');
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 300)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn(['tagline', 'konten', 'fitur', 'gambar', 'meta_title', 'meta_description']);
        });
    }
};
