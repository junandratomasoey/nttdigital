@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'label' => 'Layanan',
    'judul' => $layanan->nama,
    'sub'   => $layanan->tagline ?: $layanan->deskripsi,
])

<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-10">

        {{-- KONTEN UTAMA --}}
        <div class="lg:col-span-2">
            @if($layanan->gambar)
            <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="{{ $layanan->nama }}" class="w-full rounded-2xl mb-8">
            @endif

            @if($layanan->konten)
            <div class="prose prose-teal max-w-none prose-headings:font-semibold prose-a:text-teal-700">
                {!! $layanan->konten !!}
            </div>
            @else
            <p class="text-gray-600 leading-relaxed">{{ $layanan->deskripsi }}</p>
            @endif

            @if(! empty($layanan->fitur))
            <h2 class="text-xl font-semibold text-gray-900 mt-10 mb-4">Yang Anda dapatkan</h2>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($layanan->fitur as $fitur)
                <li class="flex items-start gap-2 text-sm text-gray-600 bg-gray-50 rounded-xl px-4 py-3">
                    <span class="text-teal-500 mt-0.5">✓</span> {{ $fitur }}
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        {{-- SIDEBAR --}}
        <aside class="space-y-5">
            <div class="rounded-2xl border border-teal-100 bg-teal-50/50 p-6 lg:sticky lg:top-24">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl mb-4" style="background-color: {{ $layanan->warna_bg }}">
                    {{ $layanan->emoji_icon }}
                </div>
                @if($layanan->harga_mulai)
                <div class="text-xs text-gray-500">Harga mulai</div>
                <div class="text-2xl font-semibold text-teal-700">{{ $layanan->harga_mulai }}</div>
                @endif
                <p class="text-xs text-gray-500 mt-2">Harga final menyesuaikan fitur yang Anda butuhkan.</p>

                <a href="{{ \App\Support\Wa::link('Halo NTT Digital, saya tertarik dengan layanan ' . $layanan->nama . '. Boleh minta info lebih lanjut?') }}"
                   data-lokasi="layanan-{{ $layanan->slug }}" target="_blank" rel="noopener"
                   class="mt-5 flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium py-3 rounded-full text-sm transition">
                    💬 Tanya via WhatsApp
                </a>
                <a href="{{ route('kontak', ['layanan' => $layanan->nama]) }}"
                   class="mt-2 block text-center border border-teal-500 text-teal-700 font-medium py-3 rounded-full text-sm hover:bg-white transition">
                    Minta Penawaran
                </a>
            </div>
        </aside>
    </div>
</section>

@if($portofolios->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-8">Contoh {{ $layanan->nama }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            @foreach($portofolios as $porto)
                @include('partials.kartu-portofolio', ['porto' => $porto])
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-8 text-center">Pilihan paket</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            @foreach($pakets as $paket)
                @include('partials.kartu-paket', ['paket' => $paket])
            @endforeach
        </div>
    </div>
</section>

@if($faqs->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6 text-center">Pertanyaan seputar {{ $layanan->nama }}</h2>
        @include('partials.faq-list', ['faqs' => $faqs])
    </div>
</section>
@endif

<section class="py-14 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-5">Layanan lainnya</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($lainnya as $l)
            <a href="{{ route('layanan.show', $l) }}" class="border border-gray-100 rounded-2xl p-4 text-center hover:shadow-md hover:border-teal-200 transition">
                <div class="text-2xl">{{ $l->emoji_icon }}</div>
                <div class="text-sm font-medium text-gray-800 mt-2">{{ $l->nama }}</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta', ['pesanWa' => 'Halo NTT Digital, saya tertarik dengan layanan ' . $layanan->nama . '.'])
@endsection
