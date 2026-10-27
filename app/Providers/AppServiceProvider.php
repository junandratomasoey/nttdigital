<?php

namespace App\Providers;

use App\Models\Artikel;
use App\Models\Layanan;
use App\Models\Portofolio;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::defaultView('pagination::tailwind');

        // Sitemap di-cache 1 jam; hapus cache setiap konten publik berubah.
        foreach ([Layanan::class, Portofolio::class, Artikel::class] as $model) {
            $model::saved(fn () => Cache::forget('sitemap.xml'));
            $model::deleted(fn () => Cache::forget('sitemap.xml'));
        }

        // Daftar layanan untuk menu navbar & footer
        View::composer(['components.navbar', 'components.footer'], function ($view) {
            $view->with('menuLayanan', Cache::remember('menu_layanan', 600, fn () =>
                Layanan::aktif()->get(['nama', 'slug', 'emoji_icon'])
            ));
        });
        Layanan::saved(fn () => Cache::forget('menu_layanan'));
        Layanan::deleted(fn () => Cache::forget('menu_layanan'));
    }
}
