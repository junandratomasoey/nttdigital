@extends('layouts.app')

@section('content')
@include('partials.page-header', [
    'label' => 'FAQ',
    'judul' => 'Pertanyaan yang sering diajukan',
    'sub'   => 'Tidak menemukan jawaban yang Anda cari? Tanyakan langsung lewat WhatsApp.',
])

<section class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        @forelse($faqs as $kategori => $daftar)
        <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ $kategori }}</h2>
            @include('partials.faq-list', ['faqs' => $daftar])
        </div>
        @empty
        <p class="text-center text-gray-500">Belum ada FAQ.</p>
        @endforelse
    </div>
</section>

@include('partials.cta', ['judulCta' => 'Masih ada pertanyaan?'])
@endsection
