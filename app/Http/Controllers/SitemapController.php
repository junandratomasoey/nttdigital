<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Layanan;
use App\Models\Portofolio;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $xml = Cache::remember('sitemap.xml', 3600, function () {
            $urls = collect([
                ['loc' => route('home'),            'priority' => '1.0', 'changefreq' => 'weekly'],
                ['loc' => route('layanan.index'),   'priority' => '0.9', 'changefreq' => 'monthly'],
                ['loc' => route('portofolio.index'),'priority' => '0.8', 'changefreq' => 'weekly'],
                ['loc' => route('harga'),           'priority' => '0.8', 'changefreq' => 'monthly'],
                ['loc' => route('blog.index'),      'priority' => '0.7', 'changefreq' => 'daily'],
                ['loc' => route('tentang'),         'priority' => '0.5', 'changefreq' => 'yearly'],
                ['loc' => route('faq'),             'priority' => '0.5', 'changefreq' => 'monthly'],
                ['loc' => route('kontak'),          'priority' => '0.6', 'changefreq' => 'yearly'],
            ]);

            Layanan::aktif()->get()->each(fn ($l) => $urls->push([
                'loc' => route('layanan.show', $l), 'lastmod' => $l->updated_at, 'priority' => '0.8', 'changefreq' => 'monthly',
            ]));
            Portofolio::aktif()->get()->each(fn ($p) => $urls->push([
                'loc' => route('portofolio.show', $p), 'lastmod' => $p->updated_at, 'priority' => '0.6', 'changefreq' => 'monthly',
            ]));
            Artikel::terbit()->get()->each(fn ($a) => $urls->push([
                'loc' => route('blog.show', $a), 'lastmod' => $a->updated_at, 'priority' => '0.6', 'changefreq' => 'monthly',
            ]));

            return view('sitemap', ['urls' => $urls])->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
