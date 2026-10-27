@extends('layouts.app')

@section('content')

{{-- ============================================================ --}}
{{-- SECTION 1: HERO CAROUSEL                                      --}}
{{-- ============================================================ --}}
<section id="hero" x-data="carousel()" x-init="init()">

    {{-- SLIDES WRAPPER --}}
    <div class="relative overflow-hidden" style="height: 520px;">
        <div class="flex h-full transition-transform duration-500 ease-in-out"
             :style="`transform: translateX(-${current * 100}%)`">

            @forelse($slides as $slide)
            <div class="min-w-full h-full relative flex items-center justify-center
                        @if($slide->warna_tema === 'biru') bg-gradient-to-br from-[#042C53] via-[#185FA5] to-[#378ADD]
                        @elseif($slide->warna_tema === 'ungu') bg-gradient-to-br from-[#3C3489] via-[#534AB7] to-[#7F77DD]
                        @else bg-gradient-to-br from-teal-900 via-teal-700 to-teal-500
                        @endif">

                {{-- OVERLAY EMOJI --}}
                @if($slide->emoji_icon)
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none">
                    <span class="text-[160px] opacity-[0.06]">{{ $slide->emoji_icon }}</span>
                </div>
                @endif

                {{-- GAMBAR BACKGROUND (jika ada upload) --}}
                @if($slide->gambar)
                <div class="absolute inset-0 bg-cover bg-center"
                     style="background-image: url('{{ asset('storage/' . $slide->gambar) }}')">
                    <div class="absolute inset-0 bg-teal-900/70"></div>
                </div>
                @endif

                {{-- KONTEN SLIDE --}}
                <div class="relative z-10 text-center px-6 max-w-3xl mx-auto">

                    {{-- BADGE --}}
                    @if($slide->subjudul)
                    <div class="inline-block bg-white/15 border border-white/25 text-white/90
                                text-xs px-4 py-1.5 rounded-full mb-4">
                        {{ $slide->subjudul }}
                    </div>
                    @endif

                    {{-- JUDUL --}}
                    <{{ $loop->first ? 'h1' : 'h2' }} class="text-white text-3xl md:text-4xl lg:text-5xl font-semibold leading-tight mb-4">
                        {!! nl2br(e($slide->judul)) !!}
                    </{{ $loop->first ? 'h1' : 'h2' }}>

                    {{-- DESKRIPSI --}}
                    @if($slide->deskripsi)
                    <p class="text-white/70 text-sm md:text-base leading-relaxed mb-8 max-w-xl mx-auto">
                        {{ $slide->deskripsi }}
                    </p>
                    @endif

                    {{-- TOMBOL --}}
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ $slide->link_tombol_utama }}"
                           class="bg-white text-teal-700 font-medium px-6 py-3 rounded-full text-sm
                                  hover:bg-teal-50 transition shadow-md">
                            {{ $slide->teks_tombol_utama }}
                        </a>
                        @if($slide->teks_tombol_kedua)
                        <a href="{{ $slide->link_tombol_kedua ?? '#kontak' }}"
                           class="border border-white/50 text-white font-medium px-6 py-3 rounded-full text-sm
                                  hover:bg-white/10 transition">
                            {{ $slide->teks_tombol_kedua }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            {{-- FALLBACK jika belum ada slide --}}
            <div class="min-w-full h-full bg-gradient-to-br from-teal-900 via-teal-700 to-teal-500
                        flex items-center justify-center text-center px-6">
                <div>
                    <h1 class="text-white text-4xl font-semibold mb-4">
                        Solusi Website Profesional<br>untuk Bisnis & Instansi di NTT
                    </h1>
                    <a href="#kontak"
                       class="bg-white text-teal-700 font-medium px-6 py-3 rounded-full text-sm hover:bg-teal-50 transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        {{-- PANAH KIRI --}}
        @if($slides->count() > 1)
        <button @click="prev()" aria-label="Slide sebelumnya"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-20
                       w-10 h-10 rounded-full bg-white/15 border border-white/30 text-white
                       hover:bg-white/25 transition flex items-center justify-center text-lg">
            ‹
        </button>

        {{-- PANAH KANAN --}}
        <button @click="next()" aria-label="Slide berikutnya"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-20
                       w-10 h-10 rounded-full bg-white/15 border border-white/30 text-white
                       hover:bg-white/25 transition flex items-center justify-center text-lg">
            ›
        </button>

        {{-- DOT INDIKATOR --}}
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-20 flex gap-2">
            @foreach($slides as $i => $slide)
            <button @click="goTo({{ $i }})" aria-label="Ke slide {{ $i + 1 }}"
                    :class="current === {{ $i }}
                        ? 'w-6 bg-white'
                        : 'w-2 bg-white/40'"
                    class="h-2 rounded-full transition-all duration-300">
            </button>
            @endforeach
        </div>
        @endif
    </div>

    {{-- STATS BAR --}}
    <div class="bg-teal-900 py-3">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-around md:justify-center md:gap-16">
                <div class="text-center">
                    <div class="text-teal-300 font-semibold text-lg">
                        {{ \App\Models\SiteSetting::get('jumlah_proyek', '15+') }}
                    </div>
                    <div class="text-white/45 text-xs">Proyek selesai</div>
                </div>
                <div class="text-center">
                    <div class="text-teal-300 font-semibold text-lg">
                        {{ \App\Models\SiteSetting::get('jumlah_kategori', '7+') }}
                    </div>
                    <div class="text-white/45 text-xs">Kategori website</div>
                </div>
                <div class="text-center">
                    <div class="text-teal-300 font-semibold text-lg">NTT</div>
                    <div class="text-white/45 text-xs">Berbasis lokal</div>
                </div>
                <div class="text-center">
                    <div class="text-teal-300 font-semibold text-lg">
                        {{ \App\Models\SiteSetting::get('respon_jam', '24 jam') }}
                    </div>
                    <div class="text-white/45 text-xs">Respon cepat</div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ============================================================ --}}
{{-- SECTION 2: LAYANAN                                            --}}
{{-- ============================================================ --}}
<section id="layanan" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="text-xs font-medium text-teal-600 uppercase tracking-widest">Layanan</span>
            <h2 class="text-gray-900 text-3xl font-semibold mt-2">Apa yang kami kerjakan</h2>
            <p class="text-gray-500 text-sm mt-3 max-w-lg mx-auto">
                Berbagai jenis website profesional siap dikustomisasi sesuai kebutuhan Anda
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($layanans as $layanan)
            <a href="{{ route('layanan.show', $layanan) }}"
               class="group border border-gray-100 rounded-2xl p-5 text-center hover:shadow-md hover:-translate-y-1 hover:border-teal-200 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3 text-2xl"
                     style="background-color: {{ $layanan->warna_bg }}">
                    {{ $layanan->emoji_icon }}
                </div>
                <div class="font-medium text-gray-800 text-sm group-hover:text-teal-700">{{ $layanan->nama }}</div>
                @if($layanan->harga_mulai)
                <div class="text-xs text-gray-400 mt-1">mulai {{ $layanan->harga_mulai }}</div>
                @endif
            </a>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('layanan.index') }}" class="text-teal-600 text-sm font-medium hover:text-teal-800">Pelajari semua layanan →</a>
        </div>
    </div>
</section>


{{-- ============================================================ --}}
{{-- SECTION 3: PORTOFOLIO                                         --}}
{{-- ============================================================ --}}
<section id="portofolio" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="text-xs font-medium text-teal-600 uppercase tracking-widest">Portofolio</span>
            <h2 class="text-gray-900 text-3xl font-semibold mt-2">Demo website kami</h2>
            <p class="text-gray-500 text-sm mt-3 max-w-lg mx-auto">
                Klik untuk melihat detail dan demo langsung — semua bisa dikustomisasi sesuai kebutuhan Anda
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            @foreach($portofolios as $porto)
                @include('partials.kartu-portofolio', ['porto' => $porto])
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('portofolio.index') }}"
               class="inline-block border border-teal-500 text-teal-700 text-sm font-medium px-6 py-2.5 rounded-full hover:bg-white transition">
                Lihat semua portofolio
            </a>
        </div>
    </div>
</section>


{{-- ============================================================ --}}
{{-- SECTION 4: PAKET HARGA                                        --}}
{{-- ============================================================ --}}
<section id="harga" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="text-xs font-medium text-teal-600 uppercase tracking-widest">Harga</span>
            <h2 class="text-gray-900 text-3xl font-semibold mt-2">Paket yang transparan</h2>
            <p class="text-gray-500 text-sm mt-3 max-w-lg mx-auto">Harga tetap, tanpa biaya tersembunyi</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            @foreach($pakets as $paket)
                @include('partials.kartu-paket', ['paket' => $paket])
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('harga') }}" class="text-teal-600 text-sm font-medium hover:text-teal-800">Bandingkan paket & harga per layanan →</a>
        </div>
    </div>
</section>


{{-- ============================================================ --}}
{{-- SECTION 5: TESTIMONI (tampil jika sudah ada testimoni aktif)  --}}
{{-- ============================================================ --}}
@if($testimonis->isNotEmpty())
<section id="testimoni" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-xs font-medium text-teal-600 uppercase tracking-widest">Testimoni</span>
            <h2 class="text-gray-900 text-3xl font-semibold mt-2">Kata klien kami</h2>
        </div>
        @include('partials.testimoni', ['testimonis' => $testimonis])
    </div>
</section>
@endif


{{-- ============================================================ --}}
{{-- SECTION 6: TENTANG                                            --}}
{{-- ============================================================ --}}
<section id="tentang" class="py-20 {{ $testimonis->isNotEmpty() ? 'bg-white' : 'bg-gray-50' }}">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center gap-12">

            <div class="flex-shrink-0 text-center">
                <div class="w-32 h-32 rounded-full bg-teal-100 border-4 border-teal-200 flex items-center justify-center text-6xl mx-auto">👨‍💻</div>
                <div class="flex gap-2 justify-center mt-4 flex-wrap">
                    <span class="bg-white border border-gray-200 text-gray-500 text-xs px-3 py-1 rounded-full">Laravel</span>
                    <span class="bg-white border border-gray-200 text-gray-500 text-xs px-3 py-1 rounded-full">Tailwind CSS</span>
                    <span class="bg-white border border-gray-200 text-gray-500 text-xs px-3 py-1 rounded-full">Filament</span>
                </div>
            </div>

            <div>
                <span class="text-xs font-medium text-teal-600 uppercase tracking-widest">Tentang Kami</span>
                <h2 class="text-gray-900 text-3xl font-semibold mt-2">{{ \App\Models\SiteSetting::get('site_nama', 'NTT Digital') }}</h2>
                <p class="text-teal-600 text-sm mt-1">Jasa pembuatan website berbasis di Kupang, NTT</p>
                <p class="text-gray-500 text-sm leading-relaxed mt-4">
                    Kami adalah developer lokal yang berkomitmen membantu organisasi dan bisnis di
                    Nusa Tenggara Timur bertransformasi digital. Dengan pengalaman membangun sistem
                    untuk berbagai instansi, kami memahami kebutuhan unik klien di NTT.
                </p>
                <div class="flex flex-wrap gap-3 mt-6">
                    <div class="bg-teal-50 text-teal-700 text-sm px-4 py-2 rounded-full">📍 Berbasis di Kupang, NTT</div>
                    <div class="bg-teal-50 text-teal-700 text-sm px-4 py-2 rounded-full">💻 Spesialis Laravel & Tailwind</div>
                    <div class="bg-teal-50 text-teal-700 text-sm px-4 py-2 rounded-full">🤝 Konsultasi gratis</div>
                </div>
                <a href="{{ route('tentang') }}" class="inline-block text-teal-600 text-sm font-medium hover:text-teal-800 mt-6">Kenali kami lebih jauh →</a>
            </div>
        </div>
    </div>
</section>


{{-- ============================================================ --}}
{{-- SECTION 7: ARTIKEL TERBARU                                    --}}
{{-- ============================================================ --}}
@if($artikels->isNotEmpty())
<section id="blog" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-medium text-teal-600 uppercase tracking-widest">Blog</span>
                <h2 class="text-gray-900 text-3xl font-semibold mt-2">Tips & wawasan digital</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="text-teal-600 text-sm font-medium hover:text-teal-800">Semua artikel →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($artikels as $artikel)
                @include('partials.kartu-artikel', ['artikel' => $artikel])
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ============================================================ --}}
{{-- SECTION 8: FAQ                                                --}}
{{-- ============================================================ --}}
@if($faqs->isNotEmpty())
<section id="faq" class="py-20 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="text-xs font-medium text-teal-600 uppercase tracking-widest">FAQ</span>
            <h2 class="text-gray-900 text-3xl font-semibold mt-2">Pertanyaan yang sering diajukan</h2>
        </div>
        @include('partials.faq-list', ['faqs' => $faqs])
        <div class="text-center mt-6">
            <a href="{{ route('faq') }}" class="text-teal-600 text-sm font-medium hover:text-teal-800">Lihat semua pertanyaan →</a>
        </div>
    </div>
</section>
@endif


{{-- ============================================================ --}}
{{-- SECTION 9: KONTAK                                             --}}
{{-- ============================================================ --}}
<section id="kontak" class="py-20 bg-teal-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-xs font-medium text-teal-300 uppercase tracking-widest">Kontak</span>
                <h2 class="text-white text-3xl font-semibold mt-2">Siap mulai proyek Anda?</h2>
                <p class="text-white/60 text-sm leading-relaxed mt-3">
                    Konsultasi gratis, kami akan balas dalam 1×24 jam. Ceritakan kebutuhan website Anda
                    dan kami akan siapkan solusi terbaik.
                </p>
                <div class="mt-8 space-y-4">
                    <div class="flex items-center gap-3 text-white/70 text-sm">
                        <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">📍</span>
                        {{ \App\Models\SiteSetting::get('site_alamat', 'Kupang, NTT') }}
                    </div>
                    <div class="flex items-center gap-3 text-white/70 text-sm">
                        <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">📧</span>
                        {{ \App\Models\SiteSetting::get('site_email', 'info@nttdigital.com') }}
                    </div>
                    <div class="flex items-center gap-3 text-white/70 text-sm">
                        <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">💬</span>
                        WhatsApp: +{{ \App\Support\Wa::nomor() }}
                    </div>
                </div>
                <a href="{{ \App\Support\Wa::link() }}" data-lokasi="beranda-kontak" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-full mt-6 transition text-sm">
                    💬 Chat via WhatsApp
                </a>
            </div>

            @include('partials.form-kontak')
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function carousel() {
    return {
        current: 0,
        total: {{ $slides->count() ?: 1 }},
        timer: null,

        init() {
            if (this.total > 1) {
                this.timer = setInterval(() => this.next(), 4000);
            }
        },

        next() {
            this.current = (this.current + 1) % this.total;
        },

        prev() {
            this.current = (this.current - 1 + this.total) % this.total;
        },

        goTo(idx) {
            this.current = idx;
            clearInterval(this.timer);
            this.timer = setInterval(() => this.next(), 4000);
        }
    }
}
</script>
@endpush
