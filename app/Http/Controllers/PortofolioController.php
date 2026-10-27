<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use App\Support\Seo;
use Illuminate\Http\Request;

class PortofolioController extends Controller
{
    public function index(Request $request)
    {
        $kategoriAktif = $request->query('kategori');
        $kategoris     = Portofolio::aktif()->pluck('kategori')->unique()->values();

        $portofolios = Portofolio::aktif()
            ->when($kategoriAktif, fn ($q) => $q->where('kategori', $kategoriAktif))
            ->get();

        $seo = Seo::make(
            $kategoriAktif ? "Portofolio Website {$kategoriAktif}" : 'Portofolio & Demo Website',
            'Lihat contoh dan demo website buatan NTT Digital untuk desa, sekolah, UMKM, gereja, hotel, dan undangan digital di NTT.'
        )->breadcrumbs([['Portofolio', null]]);

        // Halaman filter tidak perlu diindeks terpisah
        if ($kategoriAktif) {
            $seo->canonical = route('portofolio.index');
        }

        return view('portofolio.index', compact('portofolios', 'kategoris', 'kategoriAktif', 'seo'));
    }

    public function show(Portofolio $portofolio)
    {
        abort_unless($portofolio->aktif, 404);

        $portofolio->load(['testimonis' => fn ($q) => $q->where('aktif', true)]);

        $lainnya = Portofolio::aktif()
            ->where('id', '!=', $portofolio->id)
            ->orderByRaw('kategori = ? desc', [$portofolio->kategori])
            ->take(3)->get();

        $seo = Seo::make(
            $portofolio->nama_proyek . ' – Website ' . $portofolio->kategori,
            $portofolio->meta_description ?: $portofolio->deskripsi
        )
            ->image($portofolio->gambar_thumbnail)
            ->breadcrumbs([['Portofolio', route('portofolio.index')], [$portofolio->nama_proyek, null]])
            ->schema(array_filter([
                '@context'    => 'https://schema.org',
                '@type'       => 'CreativeWork',
                'name'        => $portofolio->nama_proyek,
                'description' => $portofolio->deskripsi,
                'genre'       => 'Website ' . $portofolio->kategori,
                'creator'     => ['@id' => route('home') . '#organisasi'],
                'url'         => route('portofolio.show', $portofolio),
                'dateCreated' => $portofolio->tahun,
            ]));

        return view('portofolio.show', compact('portofolio', 'lainnya', 'seo'));
    }
}
