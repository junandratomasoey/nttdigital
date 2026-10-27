<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Support\Seo;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, ?string $kategori = null)
    {
        $cari = trim((string) $request->query('q'));

        $kategoriNama = null;
        if ($kategori) {
            $kategoriNama = collect(Artikel::KATEGORI)->keys()
                ->first(fn ($k) => str($k)->slug()->value() === $kategori);
            abort_unless($kategoriNama, 404);
        }

        $artikels = Artikel::terbit()
            ->when($kategoriNama, fn ($q) => $q->where('kategori', $kategoriNama))
            ->when($cari !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('judul', 'like', "%{$cari}%")
                ->orWhere('ringkasan', 'like', "%{$cari}%")))
            ->paginate(9)
            ->withQueryString();

        $kategoris = Artikel::terbit()->reorder()->select('kategori')
            ->selectRaw('count(*) as jumlah')->groupBy('kategori')->pluck('jumlah', 'kategori');

        $seo = Seo::make(
            $kategoriNama ? "Artikel {$kategoriNama}" : 'Blog: Tips Website & Digitalisasi di NTT',
            'Artikel, panduan, dan tips seputar website desa, sekolah, UMKM, dan transformasi digital di Nusa Tenggara Timur.'
        )->breadcrumbs($kategoriNama
            ? [['Blog', route('blog.index')], [$kategoriNama, null]]
            : [['Blog', null]]);

        if ($cari !== '' || $artikels->currentPage() > 1) {
            $seo->noindex();
        }

        return view('blog.index', compact('artikels', 'kategoris', 'kategoriNama', 'cari', 'seo'));
    }

    public function show(Artikel $artikel)
    {
        $bolehLihat = $artikel->status === 'terbit'
            && $artikel->dipublikasikan_pada
            && $artikel->dipublikasikan_pada->isPast();

        // Admin yang login boleh melihat pratinjau draf
        abort_unless($bolehLihat || auth()->check(), 404);

        if ($bolehLihat) {
            Artikel::whereKey($artikel->id)->increment('dilihat');
        }

        $terkait = Artikel::terbit()
            ->where('id', '!=', $artikel->id)
            ->orderByRaw('kategori = ? desc', [$artikel->kategori])
            ->take(3)->get();

        $seo = Seo::make($artikel->meta_title ?: $artikel->judul, $artikel->meta_description ?: $artikel->ringkasan_otomatis)
            ->type('article')
            ->image($artikel->gambar)
            ->noindex(! $bolehLihat)
            ->breadcrumbs([
                ['Blog', route('blog.index')],
                [$artikel->kategori, route('blog.kategori', str($artikel->kategori)->slug())],
                [$artikel->judul, null],
            ])
            ->schema(array_filter([
                '@context'         => 'https://schema.org',
                '@type'            => 'BlogPosting',
                'headline'         => $artikel->judul,
                'description'      => $artikel->ringkasan_otomatis,
                'image'            => $artikel->gambar ? asset('storage/' . $artikel->gambar) : null,
                'datePublished'    => $artikel->dipublikasikan_pada?->toIso8601String(),
                'dateModified'     => $artikel->updated_at?->toIso8601String(),
                'author'           => ['@type' => 'Organization', 'name' => $artikel->penulis],
                'publisher'        => ['@id' => route('home') . '#organisasi'],
                'mainEntityOfPage' => route('blog.show', $artikel),
                'keywords'         => $artikel->tags ? implode(', ', $artikel->tags) : null,
            ]));

        return view('blog.show', compact('artikel', 'terkait', 'seo'));
    }
}
