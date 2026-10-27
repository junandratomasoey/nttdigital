@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'label' => 'Portofolio · ' . $portofolio->kategori,
    'judul' => $portofolio->nama_proyek,
    'sub'   => $portofolio->deskripsi,
])

<section class="py-14 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-10">

        <div class="lg:col-span-2">
            {{-- GAMBAR UTAMA --}}
            <div class="rounded-2xl overflow-hidden h-64 md:h-96 flex items-center justify-center text-8xl" style="background-color: {{ $portofolio->warna_thumb }}">
                @if($portofolio->gambar_thumbnail)
                    <img src="{{ asset('storage/' . $portofolio->gambar_thumbnail) }}" alt="{{ $portofolio->nama_proyek }}" class="w-full h-full object-cover">
                @else
                    <span aria-hidden="true">{{ $portofolio->emoji_icon }}</span>
                @endif
            </div>

            {{-- GALERI --}}
            @if(! empty($portofolio->galeri))
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-3" x-data="{ lihat: null }">
                @foreach($portofolio->galeri as $g)
                <button type="button" @click="lihat = '{{ asset('storage/' . $g) }}'" class="rounded-xl overflow-hidden aspect-video bg-gray-100">
                    <img src="{{ asset('storage/' . $g) }}" alt="Tangkapan layar {{ $portofolio->nama_proyek }} {{ $loop->iteration }}" loading="lazy" class="w-full h-full object-cover hover:opacity-90">
                </button>
                @endforeach
                <div x-cloak x-show="lihat" @click="lihat = null" class="fixed inset-0 z-[70] bg-black/80 flex items-center justify-center p-4">
                    <img :src="lihat" alt="" class="max-h-full max-w-full rounded-xl">
                </div>
            </div>
            @endif

            @if($portofolio->konten)
            <div class="prose prose-teal max-w-none mt-10 prose-headings:font-semibold prose-a:text-teal-700">
                {!! $portofolio->konten !!}
            </div>
            @endif

            @if(! empty($portofolio->fitur))
            <h2 class="text-xl font-semibold text-gray-900 mt-10 mb-4">Fitur utama</h2>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($portofolio->fitur as $fitur)
                <li class="flex items-start gap-2 text-sm text-gray-600 bg-gray-50 rounded-xl px-4 py-3"><span class="text-teal-500">✓</span> {{ $fitur }}</li>
                @endforeach
            </ul>
            @endif

            @foreach($portofolio->testimonis as $t)
            <figure class="mt-10 border-l-4 border-teal-500 bg-teal-50/50 rounded-r-2xl p-6">
                <blockquote class="text-gray-700 italic">“{{ $t->isi }}”</blockquote>
                <figcaption class="text-sm text-gray-500 mt-3">— {{ $t->nama }}{{ $t->jabatan ? ', ' . $t->jabatan : '' }}</figcaption>
            </figure>
            @endforeach
        </div>

        {{-- INFO PROYEK --}}
        <aside>
            <div class="rounded-2xl border border-gray-100 p-6 lg:sticky lg:top-24">
                <h2 class="font-semibold text-gray-900 mb-4">Info proyek</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4"><dt class="text-gray-400">Kategori</dt><dd class="text-gray-800 text-right">{{ $portofolio->kategori }}</dd></div>
                    @if($portofolio->klien)<div class="flex justify-between gap-4"><dt class="text-gray-400">Klien</dt><dd class="text-gray-800 text-right">{{ $portofolio->klien }}</dd></div>@endif
                    @if($portofolio->lokasi)<div class="flex justify-between gap-4"><dt class="text-gray-400">Lokasi</dt><dd class="text-gray-800 text-right">{{ $portofolio->lokasi }}</dd></div>@endif
                    @if($portofolio->tahun)<div class="flex justify-between gap-4"><dt class="text-gray-400">Tahun</dt><dd class="text-gray-800 text-right">{{ $portofolio->tahun }}</dd></div>@endif
                </dl>
                @if(! empty($portofolio->teknologi))
                <div class="flex flex-wrap gap-1.5 mt-5">
                    @foreach($portofolio->teknologi as $tek)
                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full">{{ $tek }}</span>
                    @endforeach
                </div>
                @endif

                @if($portofolio->tampilkan_demo && $portofolio->link_demo)
                <a href="{{ $portofolio->link_demo }}" target="_blank" rel="noopener"
                   class="mt-6 block text-center bg-teal-600 hover:bg-teal-700 text-white font-medium py-3 rounded-full text-sm transition">
                    Lihat Demo Langsung ↗
                </a>
                @endif
                <a href="{{ \App\Support\Wa::link('Halo NTT Digital, saya tertarik dibuatkan website seperti ' . $portofolio->nama_proyek . '.') }}"
                   data-lokasi="portofolio-{{ $portofolio->slug }}" target="_blank" rel="noopener"
                   class="mt-2 flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium py-3 rounded-full text-sm transition">
                    💬 Mau yang seperti ini
                </a>
            </div>
        </aside>
    </div>
</section>

@if($lainnya->isNotEmpty())
<section class="py-14 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Portofolio lainnya</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            @foreach($lainnya as $porto)
                @include('partials.kartu-portofolio', ['porto' => $porto])
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
