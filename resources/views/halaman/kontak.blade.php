@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'label' => 'Kontak',
    'judul' => 'Konsultasi gratis untuk website Anda',
    'sub'   => 'Ceritakan kebutuhan Anda — kami balas dalam 1×24 jam.',
])

<section class="py-16 bg-teal-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
        <div class="space-y-6">
            <a href="{{ \App\Support\Wa::link() }}" data-lokasi="halaman-kontak" target="_blank" rel="noopener"
               class="flex items-center gap-4 bg-green-500 hover:bg-green-600 rounded-2xl p-5 text-white transition">
                <span class="text-3xl">💬</span>
                <span>
                    <span class="block font-semibold">Chat WhatsApp</span>
                    <span class="block text-sm text-white/80">+{{ \App\Support\Wa::nomor() }} · respon tercepat</span>
                </span>
            </a>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 space-y-4 text-sm text-white/70">
                <div class="flex items-start gap-3"><span>📍</span><span>{{ \App\Models\SiteSetting::get('site_alamat', 'Kupang, NTT') }}</span></div>
                @if($email = \App\Models\SiteSetting::get('site_email'))
                <div class="flex items-start gap-3"><span>📧</span><a href="mailto:{{ $email }}" class="hover:text-white">{{ $email }}</a></div>
                @endif
                <div class="flex items-start gap-3"><span>🕘</span><span>{{ \App\Models\SiteSetting::get('jam_operasional', 'Senin – Sabtu, 08.00 – 20.00 WITA') }}</span></div>
            </div>
            @if($peta = \App\Models\SiteSetting::get('site_gmaps_embed'))
            <div class="rounded-2xl overflow-hidden aspect-video">
                <iframe src="{{ $peta }}" class="w-full h-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi NTT Digital"></iframe>
            </div>
            @endif
        </div>

        @include('partials.form-kontak', ['pilihPaket' => $pilihPaket, 'pilihLayanan' => $pilihLayanan])
    </div>
</section>
@endsection
