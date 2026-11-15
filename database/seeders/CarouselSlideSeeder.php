<?php

namespace Database\Seeders;

use App\Models\CarouselSlide;
use Illuminate\Database\Seeder;

class CarouselSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'judul'              => 'Website Profesional untuk Usaha di NTT',
                'subjudul'           => '📍 Berbasis di Kupang, NTT',
                'deskripsi'          => 'Kafe, toko, hotel, dan usaha lokal di NTT tampil profesional online — katalog produk, tombol WhatsApp, dan mudah ditemukan di Google.',
                'warna_tema'         => 'teal',
                'emoji_icon'         => '🛍️',
                'teks_tombol_utama'  => 'Lihat Contoh Website',
                'link_tombol_utama'  => '#portofolio',
                'teks_tombol_kedua'  => 'Konsultasi Gratis',
                'link_tombol_kedua'  => '#kontak',
                'urutan'             => 1,
                'aktif'              => true,
            ],
            [
                'judul'              => 'Tingkatkan Kepercayaan dengan Tampilan Digital',
                'subjudul'           => '🎓 Untuk Sekolah, Gereja & Komunitas',
                'deskripsi'          => 'Sekolah, gereja, dan komunitas di NTT kini bisa tampil profesional online — profil, jadwal, galeri, berita, dan formulir pendaftaran.',
                'warna_tema'         => 'biru',
                'emoji_icon'         => '🏫',
                'teks_tombol_utama'  => 'Lihat Portofolio',
                'link_tombol_utama'  => '#portofolio',
                'teks_tombol_kedua'  => 'Pilih Paket',
                'link_tombol_kedua'  => '#harga',
                'urutan'             => 2,
                'aktif'              => true,
            ],
            [
                'judul'              => 'Undangan Pernikahan Digital yang Elegan & Modern',
                'subjudul'           => '💍 Undangan & Acara Spesial',
                'deskripsi'          => 'Bagikan momen istimewa Anda lewat undangan digital — lengkap dengan RSVP, countdown, galeri foto, dan amplop digital.',
                'warna_tema'         => 'ungu',
                'emoji_icon'         => '💍',
                'teks_tombol_utama'  => 'Lihat Contoh',
                'link_tombol_utama'  => '#portofolio',
                'teks_tombol_kedua'  => 'Pesan Sekarang',
                'link_tombol_kedua'  => '#kontak',
                'urutan'             => 3,
                'aktif'              => true,
            ],
        ];

        foreach ($slides as $slide) {
            CarouselSlide::create($slide);
        }
    }
}
