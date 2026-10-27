<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\CarouselSlide;
use App\Models\Faq;
use App\Models\KontakPesan;
use App\Models\Layanan;
use App\Models\PaketHarga;
use App\Models\Portofolio;
use App\Models\Testimoni;
use App\Support\Seo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides      = CarouselSlide::aktif()->get();
        $layanans    = Layanan::aktif()->get();
        $portofolios = Portofolio::aktif()->take(6)->get();
        $pakets      = PaketHarga::aktif()->get();
        $testimonis  = Testimoni::aktif()->take(6)->get();
        $artikels    = Artikel::terbit()->take(3)->get();
        $faqs        = Faq::aktif()->where('tampil_di_beranda', true)->take(5)->get();

        $seo = Seo::make();

        return view('home.index', compact(
            'slides', 'layanans', 'portofolios', 'pakets', 'testimonis', 'artikels', 'faqs', 'seo'
        ));
    }

    public function kirimPesan(Request $request)
    {
        // Honeypot anti-spam: field "website" disembunyikan dari manusia.
        if (filled($request->input('website'))) {
            return redirect()->to(url()->previous() . '#form-kontak')
                ->with('sukses', 'Pesan Anda telah terkirim! Kami akan menghubungi Anda segera.');
        }

        $data = $request->validate([
            'nama'          => 'required|string|max:100',
            'whatsapp'      => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{8,20}$/'],
            'jenis_website' => 'nullable|string|max:100',
            'paket'         => 'nullable|string|max:100',
            'pesan'         => 'nullable|string|max:1000',
        ], [
            'whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka, contoh 081234567890.',
        ]);

        $utm = $request->session()->get('utm', []);

        KontakPesan::create([
            'nama'          => $data['nama'],
            'whatsapp'      => $this->normalisasiWa($data['whatsapp']),
            'jenis_website' => $data['jenis_website'] ?? null,
            'paket'         => $data['paket'] ?? null,
            'pesan'         => $data['pesan'] ?? null,
            'status'        => 'baru',
            'halaman_asal'  => mb_substr((string) url()->previous(), 0, 255),
            'utm_source'    => $utm['utm_source'] ?? null,
            'utm_medium'    => $utm['utm_medium'] ?? null,
            'utm_campaign'  => $utm['utm_campaign'] ?? null,
        ]);

        return redirect()->to(url()->previous() . '#form-kontak')
            ->with('sukses', 'Pesan Anda telah terkirim! Kami akan menghubungi Anda segera.')
            ->with('lead_terkirim', true);
    }

    /** 0812-3456-7890 -> 6281234567890 (siap dipakai di link wa.me). */
    private function normalisasiWa(string $nomor): string
    {
        $angka = preg_replace('/\D/', '', $nomor);

        return str_starts_with($angka, '0') ? '62' . substr($angka, 1) : $angka;
    }
}
