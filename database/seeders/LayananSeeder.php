<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            ['nama' => 'Website Sekolah',       'slug' => 'website-sekolah',       'emoji_icon' => '🏫', 'warna_bg' => '#E1F5EE', 'harga_mulai' => 'Rp 2.500.000', 'urutan' => 1],
            ['nama' => 'Website Desa',           'slug' => 'website-desa',           'emoji_icon' => '🏘️', 'warna_bg' => '#E6F1FB', 'harga_mulai' => 'Rp 3.000.000', 'urutan' => 2],
            ['nama' => 'Website UMKM',           'slug' => 'website-umkm',           'emoji_icon' => '🛍️', 'warna_bg' => '#FAEEDA', 'harga_mulai' => 'Rp 1.500.000', 'urutan' => 3],
            ['nama' => 'Undangan Digital',       'slug' => 'undangan-digital',       'emoji_icon' => '💍', 'warna_bg' => '#FBEAF0', 'harga_mulai' => 'Rp 150.000',   'urutan' => 4],
            ['nama' => 'Website Perusahaan',     'slug' => 'website-perusahaan',     'emoji_icon' => '🏢', 'warna_bg' => '#EEEDFE', 'harga_mulai' => 'Rp 3.500.000', 'urutan' => 5],
            ['nama' => 'Website Gereja / Masjid','slug' => 'website-gereja',         'emoji_icon' => '⛪', 'warna_bg' => '#E1F5EE', 'harga_mulai' => 'Rp 2.000.000', 'urutan' => 6],
            ['nama' => 'Website Hotel',          'slug' => 'website-hotel',          'emoji_icon' => '🏨', 'warna_bg' => '#FAEEDA', 'harga_mulai' => 'Rp 3.000.000', 'urutan' => 7],
            ['nama' => 'Lainnya',                'slug' => 'lainnya',                'emoji_icon' => '➕', 'warna_bg' => '#F1EFE8', 'harga_mulai' => 'Diskusikan',   'urutan' => 8],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create(array_merge($layanan, ['aktif' => true]));
        }
    }
}
