<?php

namespace App\Http\Controllers;

use App\Models\CarouselSlide;
use App\Models\KontakPesan;
use App\Models\Layanan;
use App\Models\PaketHarga;
use App\Models\Portofolio;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides     = CarouselSlide::aktif()->get();
        $layanans   = Layanan::aktif()->get();
        $portofolios = Portofolio::aktif()->get();
        $pakets     = PaketHarga::aktif()->get();

        return view('home.index', compact('slides', 'layanans', 'portofolios', 'pakets'));
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'whatsapp'      => 'required|string|max:20',
            'jenis_website' => 'nullable|string|max:100',
            'pesan'         => 'nullable|string|max:1000',
        ]);

        KontakPesan::create([
            'nama'          => $request->nama,
            'whatsapp'      => $request->whatsapp,
            'jenis_website' => $request->jenis_website,
            'pesan'         => $request->pesan,
            'status'        => 'baru',
        ]);

        return back()->with('sukses', 'Pesan Anda telah terkirim! Kami akan menghubungi Anda segera.');
    }
}
