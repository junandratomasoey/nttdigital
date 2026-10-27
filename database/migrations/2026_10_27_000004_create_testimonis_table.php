<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan')->nullable();   // contoh: Kepala Desa
            $table->string('instansi')->nullable();  // contoh: Desa Oesao
            $table->string('foto')->nullable();
            $table->text('isi');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->foreignId('portofolio_id')->nullable()->constrained('portofolios')->nullOnDelete();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
