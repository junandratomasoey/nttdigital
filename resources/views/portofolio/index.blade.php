@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'label' => 'Portofolio',
    'judul' => $kategoriAktif ? "Portofolio Website {$kategoriAktif}" : 'Portofolio & Demo Website',
    'sub'   => 'Lihat hasil kerja dan demo langsung. Semua desain bisa disesuaikan dengan identitas instansi atau usaha Anda.',
])

<section class="py-14 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- FILTER KATEGORI --}}
        <div class="flex flex-wrap gap-2 mb-8" role="navigation" aria-label="Filter kategori">
            <a href="{{ route('portofolio.index') }}"
               class="px-4 py-1.5 rounded-full text-sm transition {{ ! $kategoriAktif ? 'bg-teal-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:border-teal-300' }}">
                Semua
            </a>
            @foreach($kategoris as $kat)
            <a href="{{ route('portofolio.index', ['kategori' => $kat]) }}"
               class="px-4 py-1.5 rounded-full text-sm transition {{ $kategoriAktif === $kat ? 'bg-teal-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:border-teal-300' }}">
                {{ $kat }}
            </a>
            @endforeach
        </div>

        @if($portofolios->isEmpty())
            <p class="text-center text-gray-500 py-16">Belum ada portofolio untuk kategori ini.</p>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            @foreach($portofolios as $porto)
                @include('partials.kartu-portofolio', ['porto' => $porto])
            @endforeach
        </div>
        @endif
    </div>
</section>

@include('partials.cta', ['judulCta' => 'Mau website seperti ini untuk instansi Anda?'])
@endsection
