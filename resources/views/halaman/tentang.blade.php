@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'label' => 'Tentang Kami',
    'judul' => 'Developer lokal NTT, untuk kemajuan digital NTT',
    'sub'   => \App\Models\SiteSetting::get('site_deskripsi'),
])

<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-12 items-start">
        <div class="text-center">
            <div class="w-40 h-40 rounded-full bg-teal-100 border-4 border-teal-200 flex items-center justify-center text-7xl mx-auto">👨‍💻</div>
            <div class="flex gap-2 justify-center mt-5 flex-wrap">
                @foreach(['Laravel', 'Tailwind CSS', 'Filament', 'Alpine.js', 'MySQL'] as $tek)
                <span class="bg-gray-50 border border-gray-200 text-gray-500 text-xs px-3 py-1 rounded-full">{{ $tek }}</span>
                @endforeach
            </div>
        </div>
        <div class="md:col-span-2 text-gray-600 leading-relaxed space-y-4">
            <h2 class="text-2xl font-semibold text-gray-900">Kenapa NTT Digital?</h2>
            <p>
                {{ \App\Models\SiteSetting::get('site_nama', 'NTT Digital') }} lahir di Kupang dengan satu tujuan sederhana:
                membuat website berkualitas terjangkau bagi desa, sekolah, gereja, UMKM, dan instansi di Nusa Tenggara Timur.
            </p>
            <p>
                Kami berpengalaman membangun sistem informasi untuk instansi pemerintah — mulai dari arsip digital,
                sistem pelayanan publik, hingga aplikasi peta (WebGIS). Pengalaman itu kami bawa ke setiap website yang kami buat:
                rapi, aman, cepat, dan mudah dikelola sendiri.
            </p>
            <p>
                Karena berbasis lokal, Anda bisa bertemu langsung, berdiskusi dalam bahasa yang sama,
                dan mendapat dukungan cepat ketika dibutuhkan.
            </p>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-900 text-center mb-10">Nilai yang kami pegang</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                ['📍', 'Lokal & dekat', 'Berbasis di Kupang, bisa tatap muka dan paham konteks NTT.'],
                ['💰', 'Harga transparan', 'Rincian jelas di awal, tanpa biaya tersembunyi.'],
                ['🛠️', 'Kelola mandiri', 'Setiap website dilengkapi panel admin dan pelatihan.'],
                ['🤝', 'Dukungan berkelanjutan', 'Kami tetap mendampingi setelah website online.'],
            ] as [$ikon, $judulNilai, $isiNilai])
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <div class="text-3xl">{{ $ikon }}</div>
                <h3 class="font-semibold text-gray-900 mt-3">{{ $judulNilai }}</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">{{ $isiNilai }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@if($testimonis->isNotEmpty())
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-900 text-center mb-10">Kata klien kami</h2>
        @include('partials.testimoni', ['testimonis' => $testimonis])
    </div>
</section>
@endif

@include('partials.cta')
@endsection
