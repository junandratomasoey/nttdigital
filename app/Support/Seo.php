<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Str;

/**
 * Data SEO per halaman. Dibuat di controller lalu dikirim ke view sebagai $seo.
 * Layout membaca objek ini untuk <title>, meta description, canonical,
 * Open Graph, Twitter Card, breadcrumb, dan JSON-LD.
 */
class Seo
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?string $image = null,
        public string $type = 'website',
        public ?string $canonical = null,
        public bool $noindex = false,
        /** @var array<int, array{0:string,1:?string}> [label, url] */
        public array $breadcrumbs = [],
        /** @var array<int, array> blok JSON-LD tambahan */
        public array $schema = [],
    ) {}

    public static function make(?string $title = null, ?string $description = null): static
    {
        return new static($title, $description);
    }

    public function image(?string $pathAtauUrl): static
    {
        if ($pathAtauUrl) {
            $this->image = Str::startsWith($pathAtauUrl, ['http://', 'https://'])
                ? $pathAtauUrl
                : asset('storage/' . ltrim($pathAtauUrl, '/'));
        }
        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function noindex(bool $noindex = true): static
    {
        $this->noindex = $noindex;
        return $this;
    }

    public function breadcrumbs(array $items): static
    {
        $this->breadcrumbs = $items;
        return $this;
    }

    public function schema(array $blok): static
    {
        $this->schema[] = $blok;
        return $this;
    }

    // ---------------------------------------------------------------- output

    public function siteName(): string
    {
        return SiteSetting::get('site_nama', 'NTT Digital');
    }

    public function fullTitle(): string
    {
        if (blank($this->title)) {
            return $this->siteName() . ' – ' . SiteSetting::get('site_tagline', 'Jasa Pembuatan Website Profesional di NTT');
        }

        return Str::limit($this->title, 60, '') . ' | ' . $this->siteName();
    }

    public function metaDescription(): string
    {
        $teks = $this->description ?: SiteSetting::get('site_deskripsi', '');

        return Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($teks))), 158);
    }

    public function canonicalUrl(): string
    {
        return $this->canonical ?: url()->current();
    }

    public function imageUrl(): ?string
    {
        if ($this->image) {
            return $this->image;
        }
        $default = SiteSetting::get('seo_og_image');

        return $default ? asset('storage/' . $default) : asset('images/og-default.png');
    }

    /** Semua blok JSON-LD untuk halaman ini. */
    public function jsonLd(): array
    {
        $blok = [$this->organisasi()];

        if (count($this->breadcrumbs)) {
            $items = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => route('home')]];
            foreach (array_values($this->breadcrumbs) as $i => [$label, $url]) {
                $items[] = array_filter([
                    '@type'    => 'ListItem',
                    'position' => $i + 2,
                    'name'     => $label,
                    'item'     => $url ?: $this->canonicalUrl(),
                ]);
            }
            $blok[] = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
        }

        return array_merge($blok, $this->schema);
    }

    public function organisasi(): array
    {
        $sameAs = array_values(array_filter([
            SiteSetting::get('site_instagram'),
            SiteSetting::get('site_facebook'),
            SiteSetting::get('site_tiktok'),
        ]));

        return array_filter([
            '@context'    => 'https://schema.org',
            '@type'       => 'ProfessionalService',
            '@id'         => route('home') . '#organisasi',
            'name'        => $this->siteName(),
            'description' => SiteSetting::get('site_deskripsi'),
            'url'         => route('home'),
            'logo'        => asset('images/og-default.png'),
            'image'       => $this->imageUrl(),
            'email'       => SiteSetting::get('site_email'),
            'telephone'   => ($wa = SiteSetting::get('site_whatsapp')) ? '+' . ltrim($wa, '+') : null,
            'priceRange'  => 'Rp150.000 - Rp10.000.000',
            'address'     => [
                '@type'           => 'PostalAddress',
                'addressLocality' => 'Kupang',
                'addressRegion'   => 'Nusa Tenggara Timur',
                'addressCountry'  => 'ID',
            ],
            'areaServed'  => ['@type' => 'State', 'name' => 'Nusa Tenggara Timur'],
            'sameAs'      => $sameAs ?: null,
        ]);
    }
}
