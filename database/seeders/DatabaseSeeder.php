<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CarouselSlideSeeder::class,
            LayananSeeder::class,
            PortofolioSeeder::class,
            PaketHargaSeeder::class,
            SiteSettingSeeder::class,
        ]);
    }
}
