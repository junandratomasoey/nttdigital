<section class="bg-teal-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <h2 class="text-gray-900 text-2xl font-semibold">{{ $judulCta ?? 'Siap punya website sendiri?' }}</h2>
            <p class="text-gray-500 text-sm mt-2">{{ $subCta ?? 'Konsultasi gratis, tanpa kewajiban. Kami balas dalam 1×24 jam.' }}</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 shrink-0">
            <a href="{{ \App\Support\Wa::link($pesanWa ?? null) }}" data-lokasi="cta" target="_blank" rel="noopener"
               class="inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-full text-sm transition">
                💬 Chat WhatsApp
            </a>
            <a href="{{ route('kontak') }}"
               class="inline-flex items-center justify-center border border-teal-500 text-teal-700 font-medium px-6 py-3 rounded-full text-sm hover:bg-white transition">
                Isi Formulir
            </a>
        </div>
    </div>
</section>
