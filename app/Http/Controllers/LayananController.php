<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\PaketHarga;
use App\Models\Portofolio;
use App\Models\Faq;
use App\Support\Seo;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::aktif()->get();
        $pakets   = PaketHarga::aktif()->get();

        $seo = Seo::make(
            'Layanan Pembuatan Website di NTT',
            'Jasa pembuatan website desa, sekolah, UMKM, gereja, hotel, perusahaan, dan undangan digital di Kupang & seluruh NTT. Konsultasi gratis.'
        )->breadcrumbs([['Layanan', null]]);

        return view('layanan.index', compact('layanans', 'pakets', 'seo'));
    }

    public function show(Layanan $layanan)
    {
        abort_unless($layanan->aktif, 404);

        $portofolios = Portofolio::aktif()
            ->where('kategori', $layanan->kata_kunci_kategori)
            ->take(3)->get();
        $lainnya = Layanan::aktif()->where('id', '!=', $layanan->id)->take(4)->get();
        $pakets  = PaketHarga::aktif()->get();
        $faqs    = Faq::aktif()->whereIn('kategori', ['Umum', $layanan->kata_kunci_kategori])->take(5)->get();

        $seo = Seo::make(
            $layanan->meta_title ?: $layanan->nama . ' di Kupang & NTT',
            $layanan->meta_description ?: ($layanan->deskripsi ?: $layanan->tagline)
        )
            ->image($layanan->gambar)
            ->breadcrumbs([['Layanan', route('layanan.index')], [$layanan->nama, null]])
            ->schema(array_filter([
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'name'        => $layanan->nama,
                'description' => $layanan->deskripsi,
                'provider'    => ['@id' => route('home') . '#organisasi'],
                'areaServed'  => ['@type' => 'State', 'name' => 'Nusa Tenggara Timur'],
                'url'         => route('layanan.show', $layanan),
            ]));

        return view('layanan.show', compact('layanan', 'portofolios', 'lainnya', 'pakets', 'faqs', 'seo'));
    }
}
