<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_nama'         => 'NTT Digital',
            'site_tagline'      => 'Solusi Website Profesional untuk Bisnis & Instansi di NTT',
            'site_deskripsi'    => 'Jasa pembuatan website profesional berbasis di Kupang, Nusa Tenggara Timur. Melayani sekolah, desa, UMKM, gereja, hotel, dan perusahaan.',
            'site_email'        => 'nttdigital@gmail.com',
            'site_whatsapp'     => '6282247290150',
            'site_alamat'       => 'Kupang, Nusa Tenggara Timur',
            'site_instagram'    => 'https://instagram.com/nttdigital',
            'site_facebook'     => 'https://facebook.com/nttdigital',
            'jumlah_proyek'     => '15+',
            'jumlah_kategori'   => '7+',
            'respon_jam'        => '24 jam',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::set($key, $value);
        }
    }
}
