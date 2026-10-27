<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori')->default('Tips');
            $table->text('ringkasan')->nullable();
            $table->longText('konten');
            $table->string('gambar')->nullable();
            $table->json('tags')->nullable();
            $table->string('penulis')->default('Tim NTT Digital');
            $table->enum('status', ['draf', 'terbit'])->default('draf');
            $table->timestamp('dipublikasikan_pada')->nullable();
            $table->unsignedInteger('dilihat')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->timestamps();

            $table->index(['status', 'dipublikasikan_pada']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
