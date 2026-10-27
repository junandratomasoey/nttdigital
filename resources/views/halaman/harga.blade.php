@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'label' => 'Harga',
    'judul' => 'Harga pembuatan website yang transparan',
    'sub'   => 'Pilih paket sesuai kebutuhan. Harga tetap, tanpa biaya tersembunyi. Belum yakin? Konsultasikan gratis.',
])

<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            @foreach($pakets as $paket)
                @include('partials.kartu-paket', ['paket' => $paket])
            @endforeach
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Harga mulai per jenis website</h2>
        <p class="text-sm text-gray-500 mb-6">Estimasi awal. Harga akhir menyesuaikan jumlah halaman dan fitur.</p>
        <div class="overflow-x-auto border border-gray-100 rounded-2xl">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-500">
                    <tr><th class="px-5 py-3 font-medium">Jenis website</th><th class="px-5 py-3 font-medium text-right">Mulai dari</th><th class="px-5 py-3"></th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($layanans as $l)
                    <tr>
                        <td class="px-5 py-3 text-gray-800">{{ $l->emoji_icon }} {{ $l->nama }}</td>
                        <td class="px-5 py-3 text-right font-semibold text-teal-700 whitespace-nowrap">{{ $l->harga_mulai ?? '-' }}</td>
                        <td class="px-5 py-3 text-right"><a href="{{ route('layanan.show', $l) }}" class="text-teal-600 hover:text-teal-800 whitespace-nowrap">Detail →</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@if($faqs->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6 text-center">Seputar harga & pembayaran</h2>
        @include('partials.faq-list', ['faqs' => $faqs])
    </div>
</section>
@endif

@include('partials.cta', ['judulCta' => 'Butuh penawaran khusus?', 'subCta' => 'Untuk proyek pemerintah, sistem informasi, atau kebutuhan khusus — kami siapkan penawaran sesuai anggaran.'])
@endsection
