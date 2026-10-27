<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portofolios', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('nama_proyek');
            $table->string('klien')->nullable()->after('kategori');
            $table->string('lokasi')->nullable()->after('klien');
            $table->string('tahun', 4)->nullable()->after('lokasi');
            $table->longText('konten')->nullable()->after('deskripsi');  // studi kasus (rich text)
            $table->json('fitur')->nullable()->after('konten');
            $table->json('teknologi')->nullable()->after('fitur');
            $table->json('galeri')->nullable()->after('gambar_thumbnail');
            $table->string('meta_description', 300)->nullable();
        });

        // Isi slug untuk data yang sudah ada
        $dipakai = [];
        foreach (DB::table('portofolios')->orderBy('id')->get() as $row) {
            $base = Str::slug($row->nama_proyek) ?: 'proyek';
            $slug = $base;
            $i = 2;
            while (in_array($slug, $dipakai, true)) {
                $slug = $base . '-' . $i++;
            }
            $dipakai[] = $slug;
            DB::table('portofolios')->where('id', $row->id)->update(['slug' => $slug]);
        }

        Schema::table('portofolios', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('portofolios', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'klien', 'lokasi', 'tahun', 'konten', 'fitur', 'teknologi', 'galeri', 'meta_description']);
        });
    }
};
