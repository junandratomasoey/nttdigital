<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kontak_pesans', function (Blueprint $table) {
            $table->string('paket')->nullable()->after('jenis_website');
            $table->string('halaman_asal')->nullable()->after('pesan');  // URL tempat form dikirim
            $table->string('utm_source')->nullable()->after('halaman_asal');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');
        });
    }

    public function down(): void
    {
        Schema::table('kontak_pesans', function (Blueprint $table) {
            $table->dropColumn(['paket', 'halaman_asal', 'utm_source', 'utm_medium', 'utm_campaign']);
        });
    }
};
