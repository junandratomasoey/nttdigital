<?php

namespace Database\Seeders;

use App\Models\PaketHarga;
use Illuminate\Database\Seeder;

class PaketHargaSeeder extends Seeder
{
    public function run(): void
    {
        $pakets = [
            [
                'nama'        => 'Starter',
                'label_badge' => 'Mulai dari sini',
                'harga'       => 'Rp 1.500.000',
                'satuan'      => '/ proyek',
                'fitur'       => [
                    '5 halaman website',
                    'Desain responsif (mobile friendly)',
                    'Formulir kontak',
                    'Integrasi WhatsApp',
                    'Revisi 1 bulan',
                ],
                'unggulan' => false,
                'urutan'   => 1,
                'aktif'    => true,
            ],
            [
                'nama'        => 'Profesional',
                'label_badge' => '⭐ Paling Populer',
                'harga'       => 'Rp 3.000.000',
                'satuan'      => '/ proyek',
                'fitur'       => [
                    '10 halaman website',
                    'Admin panel (kelola konten sendiri)',
                    'Desain responsif (mobile friendly)',
                    'Formulir kontak & WhatsApp',
                    'Galeri foto & video',
                    'SEO dasar',
                    'Revisi 3 bulan',
                ],
                'unggulan' => true,
                'urutan'   => 2,
                'aktif'    => true,
            ],
            [
                'nama'        => 'Enterprise',
                'label_badge' => 'Solusi Lengkap',
                'harga'       => 'Rp 6.000.000+',
                'satuan'      => '/ proyek',
                'fitur'       => [
                    'Fitur & halaman custom (tak terbatas)',
                    'Admin panel lengkap',
                    'Integrasi sistem pihak ketiga',
                    'Pelatihan penggunaan admin',
                    'Laporan & statistik pengunjung',
                    'Support & maintenance 1 tahun',
                ],
                'unggulan' => false,
                'urutan'   => 3,
                'aktif'    => true,
            ],
        ];

        foreach ($pakets as $paket) {
            PaketHarga::create($paket);
        }
    }
}
