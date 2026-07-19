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
                'judul'              => 'Website Profesional untuk Desa & Instansi Pemerintah',
                'subjudul'           => '📍 Berbasis di Kupang, NTT',
                'deskripsi'          => 'Kami membantu desa dan instansi di NTT hadir secara digital — profil, berita, layanan surat, dan informasi publik dalam satu platform.',
                'warna_tema'         => 'teal',
                'emoji_icon'         => '🏘️',
                'teks_tombol_utama'  => 'Lihat Demo Desa',
                'link_tombol_utama'  => '#portofolio',
                'teks_tombol_kedua'  => 'Konsultasi Gratis',
                'link_tombol_kedua'  => '#kontak',
                'urutan'             => 1,
                'aktif'              => true,
            ],
            [
                'judul'              => 'Tingkatkan Kepercayaan dengan Tampilan Digital',
                'subjudul'           => '🎓 Untuk Sekolah & UMKM',
                'deskripsi'          => 'Sekolah, toko, dan usaha kecil di NTT kini bisa tampil profesional online — katalog produk, galeri, berita, dan formulir pendaftaran.',
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
