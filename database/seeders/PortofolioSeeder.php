<?php

namespace Database\Seeders;

use App\Models\Portofolio;
use Illuminate\Database\Seeder;

class PortofolioSeeder extends Seeder
{
    public function run(): void
    {
        $portofolios = [
            [
                'nama_proyek'    => 'Desa Oesao',
                'kategori'       => 'Desa',
                'emoji_icon'     => '🏘️',
                'warna_thumb'    => '#E1F5EE',
                'deskripsi'      => 'Profil, berita, layanan surat, produk desa',
                'link_demo'      => 'https://demo-desa.nttdigital.site',
                'tampilkan_demo' => true,
                'urutan'         => 1,
            ],
            [
                'nama_proyek'    => 'SMA Negeri 1 Kupang',
                'kategori'       => 'Sekolah',
                'emoji_icon'     => '🏫',
                'warna_thumb'    => '#E6F1FB',
                'deskripsi'      => 'Profil, berita, galeri, PPDB online',
                'link_demo'      => 'https://demo-sekolah.nttdigital.site',
                'tampilkan_demo' => true,
                'urutan'         => 2,
            ],
            [
                'nama_proyek'    => 'Tenun Alor Shop',
                'kategori'       => 'UMKM',
                'emoji_icon'     => '🛍️',
                'warna_thumb'    => '#FAEEDA',
                'deskripsi'      => 'Katalog produk, WhatsApp checkout',
                'link_demo'      => 'https://demo-umkm.nttdigital.site',
                'tampilkan_demo' => true,
                'urutan'         => 3,
            ],
            [
                'nama_proyek'    => 'Yohannes & Maria',
                'kategori'       => 'Undangan',
                'emoji_icon'     => '💍',
                'warna_thumb'    => '#FBEAF0',
                'deskripsi'      => 'Countdown, RSVP, galeri, ucapan',
                'link_demo'      => 'https://demo-undangan.nttdigital.site',
                'tampilkan_demo' => true,
                'urutan'         => 4,
            ],
            [
                'nama_proyek'    => 'GMIT Kota Kupang',
                'kategori'       => 'Gereja',
                'emoji_icon'     => '⛪',
                'warna_thumb'    => '#EEEDFE',
                'deskripsi'      => 'Jadwal ibadah, warta jemaat, donasi',
                'link_demo'      => 'https://demo-gereja.nttdigital.site',
                'tampilkan_demo' => true,
                'urutan'         => 5,
            ],
            [
                'nama_proyek'    => 'Hotel Timor Indah',
                'kategori'       => 'Hotel',
                'emoji_icon'     => '🏨',
                'warna_thumb'    => '#EAF3DE',
                'deskripsi'      => 'Kamar, tarif, galeri, booking inquiry',
                'link_demo'      => 'https://demo-hotel.nttdigital.site',
                'tampilkan_demo' => true,
                'urutan'         => 6,
            ],
        ];

        foreach ($portofolios as $item) {
            Portofolio::create(array_merge($item, ['aktif' => true]));
        }
    }
}
