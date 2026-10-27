@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'label' => 'Layanan',
    'judul' => 'Jasa Pembuatan Website untuk Semua Kebutuhan di NTT',
    'sub'   => 'Dari website desa dan sekolah hingga toko online UMKM dan undangan digital — dikerjakan oleh developer lokal Kupang yang paham kebutuhan Anda.',
])

<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($layanans as $layanan)
            <a href="{{ route('layanan.show', $layanan) }}"
               class="group border border-gray-100 rounded-2xl p-6 hover:shadow-lg hover:-translate-y-1 hover:border-teal-200 transition-all duration-200 flex flex-col">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl mb-4" style="background-color: {{ $layanan->warna_bg }}">
                    {{ $layanan->emoji_icon }}
                </div>
                <h2 class="font-semibold text-gray-900 text-lg group-hover:text-teal-700">{{ $layanan->nama }}</h2>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed flex-1">{{ $layanan->deskripsi ?: $layanan->tagline }}</p>
                <div class="flex items-center justify-between mt-5">
                    @if($layanan->harga_mulai)
                    <span class="text-xs text-gray-400">mulai <span class="text-teal-700 font-semibold text-sm">{{ $layanan->harga_mulai }}</span></span>
                    @endif
                    <span class="text-teal-600 text-sm font-medium">Detail →</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-xs font-medium text-teal-600 uppercase tracking-widest">Proses Kerja</span>
            <h2 class="text-gray-900 text-3xl font-semibold mt-2">Dari konsultasi sampai website online</h2>
        </div>
        <ol class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                ['Konsultasi', 'Ceritakan kebutuhan Anda lewat WhatsApp atau formulir. Gratis dan tanpa kewajiban.'],
                ['Penawaran & DP', 'Kami kirim rincian fitur, harga, dan jadwal. Pengerjaan dimulai setelah DP.'],
                ['Desain & Pengembangan', 'Anda bisa memantau progres dan memberi masukan selama pengerjaan.'],
                ['Online & Pelatihan', 'Website ditayangkan, Anda dilatih mengelola konten secara mandiri.'],
            ] as $i => [$judulLangkah, $isiLangkah])
            <li class="bg-white rounded-2xl p-6 border border-gray-100">
                <span class="w-9 h-9 rounded-full bg-teal-600 text-white flex items-center justify-center text-sm font-semibold">{{ $i + 1 }}</span>
                <h3 class="font-semibold text-gray-900 mt-4">{{ $judulLangkah }}</h3>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">{{ $isiLangkah }}</p>
            </li>
            @endforeach
        </ol>
    </div>
</section>

@include('partials.cta')
@endsection
