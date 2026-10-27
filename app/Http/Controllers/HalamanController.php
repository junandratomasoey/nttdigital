<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Layanan;
use App\Models\PaketHarga;
use App\Models\Testimoni;
use App\Support\Seo;
use Illuminate\Http\Request;

class HalamanController extends Controller
{
    public function tentang()
    {
        $testimonis = Testimoni::aktif()->take(3)->get();

        $seo = Seo::make(
            'Tentang Kami',
            'NTT Digital adalah jasa pembuatan website berbasis di Kupang, NTT. Developer lokal yang memahami kebutuhan desa, sekolah, dan UMKM di NTT.'
        )->breadcrumbs([['Tentang Kami', null]]);

        return view('halaman.tentang', compact('testimonis', 'seo'));
    }

    public function harga()
    {
        $pakets   = PaketHarga::aktif()->get();
        $layanans = Layanan::aktif()->get();
        $faqs     = Faq::aktif()->where('kategori', 'Harga & Pembayaran')->get();

        $seo = Seo::make(
            'Harga Pembuatan Website di NTT',
            'Daftar harga paket pembuatan website di Kupang & NTT. Harga transparan tanpa biaya tersembunyi, mulai dari Rp 150.000 untuk undangan digital.'
        )->breadcrumbs([['Harga', null]]);

        return view('halaman.harga', compact('pakets', 'layanans', 'faqs', 'seo'));
    }

    public function faq()
    {
        $faqs = Faq::aktif()->get()->groupBy('kategori');

        $seo = Seo::make(
            'Pertanyaan yang Sering Diajukan (FAQ)',
            'Jawaban atas pertanyaan umum seputar pembuatan website, harga, domain, hosting, dan proses kerja NTT Digital.'
        )
            ->breadcrumbs([['FAQ', null]])
            ->schema([
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => $faqs->flatten()->map(fn (Faq $f) => [
                    '@type'          => 'Question',
                    'name'           => $f->pertanyaan,
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f->jawaban)],
                ])->values()->all(),
            ]);

        return view('halaman.faq', compact('faqs', 'seo'));
    }

    public function kontak(Request $request)
    {
        $seo = Seo::make(
            'Hubungi Kami – Konsultasi Gratis',
            'Konsultasi gratis pembuatan website di Kupang & NTT. Hubungi NTT Digital via WhatsApp atau isi formulir, kami balas dalam 1×24 jam.'
        )->breadcrumbs([['Kontak', null]]);

        return view('halaman.kontak', [
            'seo'          => $seo,
            'pilihPaket'   => $request->query('paket'),
            'pilihLayanan' => $request->query('layanan'),
        ]);
    }
}
