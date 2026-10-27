@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'label' => 'Blog',
    'judul' => $kategoriNama ? "Artikel: {$kategoriNama}" : 'Tips & Wawasan Digital untuk NTT',
    'sub'   => 'Panduan praktis seputar website desa, sekolah, UMKM, dan transformasi digital di Nusa Tenggara Timur.',
])

<section class="py-14 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('blog.index') }}"
                   class="px-4 py-1.5 rounded-full text-sm transition {{ ! $kategoriNama ? 'bg-teal-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:border-teal-300' }}">Semua</a>
                @foreach($kategoris as $kat => $jumlah)
                <a href="{{ route('blog.kategori', str($kat)->slug()) }}"
                   class="px-4 py-1.5 rounded-full text-sm transition {{ $kategoriNama === $kat ? 'bg-teal-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:border-teal-300' }}">
                    {{ $kat }} <span class="opacity-60">({{ $jumlah }})</span>
                </a>
                @endforeach
            </div>
            <form action="{{ route('blog.index') }}" method="GET" role="search" class="flex">
                <label for="cari-artikel" class="sr-only">Cari artikel</label>
                <input id="cari-artikel" type="search" name="q" value="{{ $cari }}" placeholder="Cari artikel..."
                       class="w-full md:w-60 border border-gray-200 rounded-l-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                <button class="bg-teal-600 text-white text-sm px-4 rounded-r-full hover:bg-teal-700">Cari</button>
            </form>
        </div>

        @if($cari !== '')
        <p class="text-sm text-gray-500 mb-6">Hasil pencarian untuk “{{ $cari }}”: {{ $artikels->total() }} artikel</p>
        @endif

        @if($artikels->isEmpty())
            <p class="text-center text-gray-500 py-16">Belum ada artikel.</p>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($artikels as $artikel)
                @include('partials.kartu-artikel', ['artikel' => $artikel])
            @endforeach
        </div>
        <div class="mt-10">{{ $artikels->links() }}</div>
        @endif
    </div>
</section>

@include('partials.cta')
@endsection
