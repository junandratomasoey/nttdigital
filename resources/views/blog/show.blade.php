@extends('layouts.app')

@section('content')
<article>
    <header class="bg-gradient-to-br from-teal-900 via-teal-700 to-teal-600 text-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <nav aria-label="Breadcrumb" class="text-xs text-white/60 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white">Beranda</a> /
                <a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a> /
                <a href="{{ route('blog.kategori', str($artikel->kategori)->slug()) }}" class="hover:text-white">{{ $artikel->kategori }}</a>
            </nav>
            @if($artikel->status !== 'terbit')
            <span class="inline-block bg-amber-400 text-amber-950 text-xs font-semibold px-3 py-1 rounded-full mb-3">PRATINJAU DRAF</span>
            @endif
            <h1 class="text-3xl md:text-4xl font-semibold leading-tight">{{ $artikel->judul }}</h1>
            <div class="flex flex-wrap items-center gap-2 text-sm text-white/70 mt-4">
                <span>{{ $artikel->penulis }}</span><span>·</span>
                <time datetime="{{ $artikel->dipublikasikan_pada?->toDateString() }}">{{ $artikel->dipublikasikan_pada?->translatedFormat('d F Y') ?? 'Belum terbit' }}</time><span>·</span>
                <span>{{ $artikel->menit_baca }} menit baca</span>
            </div>
        </div>
    </header>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($artikel->gambar)
        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-full rounded-2xl mb-10">
        @endif

        <div class="prose prose-teal max-w-none prose-headings:font-semibold prose-a:text-teal-700 prose-img:rounded-xl">
            {!! $artikel->konten !!}
        </div>

        @if(! empty($artikel->tags))
        <div class="flex flex-wrap gap-2 mt-10">
            @foreach($artikel->tags as $tag)
            <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full">#{{ $tag }}</span>
            @endforeach
        </div>
        @endif

        {{-- BAGIKAN --}}
        @php $urlArtikel = urlencode(route('blog.show', $artikel)); $judulEnc = urlencode($artikel->judul); @endphp
        <div class="flex flex-wrap items-center gap-3 mt-8 pt-6 border-t border-gray-100 text-sm">
            <span class="text-gray-500">Bagikan:</span>
            <a href="https://wa.me/?text={{ $judulEnc }}%20{{ $urlArtikel }}" data-lokasi="bagikan-artikel" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-full bg-green-50 text-green-700 hover:bg-green-100">WhatsApp</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $urlArtikel }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 hover:bg-blue-100">Facebook</a>
            <a href="https://x.com/intent/post?text={{ $judulEnc }}&url={{ $urlArtikel }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">X</a>
        </div>

        {{-- CTA DALAM ARTIKEL --}}
        <div class="mt-10 rounded-2xl bg-teal-900 text-white p-6 md:p-8">
            <h2 class="text-xl font-semibold">Butuh website untuk instansi atau usaha Anda?</h2>
            <p class="text-white/70 text-sm mt-2">NTT Digital membantu desa, sekolah, dan UMKM di NTT go digital. Konsultasi gratis.</p>
            <div class="flex flex-col sm:flex-row gap-3 mt-5">
                <a href="{{ \App\Support\Wa::link('Halo NTT Digital, saya baca artikel "' . $artikel->judul . '" dan ingin konsultasi.') }}"
                   data-lokasi="artikel-cta" target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-full text-sm">💬 Chat WhatsApp</a>
                <a href="{{ route('layanan.index') }}" class="inline-flex items-center justify-center border border-white/40 text-white font-medium px-6 py-3 rounded-full text-sm hover:bg-white/10">Lihat Layanan</a>
            </div>
        </div>
    </div>
</article>

@if($terkait->isNotEmpty())
<section class="py-14 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Artikel terkait</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($terkait as $a)
                @include('partials.kartu-artikel', ['artikel' => $a])
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
