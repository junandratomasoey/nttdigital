<article class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-200 group flex flex-col">
    <a href="{{ route('blog.show', $artikel) }}" class="block aspect-[16/9] bg-teal-50 overflow-hidden">
        @if($artikel->gambar)
            <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-teal-50 to-teal-100">
                <span class="text-teal-700/30 text-5xl font-semibold">{{ mb_substr($artikel->kategori, 0, 1) }}</span>
            </div>
        @endif
    </a>
    <div class="p-5 flex-1 flex flex-col">
        <div class="flex items-center gap-2 text-xs text-gray-400 mb-2">
            <a href="{{ route('blog.kategori', str($artikel->kategori)->slug()) }}" class="text-teal-600 font-medium hover:text-teal-800">{{ $artikel->kategori }}</a>
            <span>·</span>
            <time datetime="{{ $artikel->dipublikasikan_pada?->toDateString() }}">{{ $artikel->dipublikasikan_pada?->translatedFormat('d M Y') }}</time>
        </div>
        <h3 class="font-semibold text-gray-900 leading-snug">
            <a href="{{ route('blog.show', $artikel) }}" class="hover:text-teal-700">{{ $artikel->judul }}</a>
        </h3>
        <p class="text-gray-500 text-sm mt-2 line-clamp-3 flex-1">{{ $artikel->ringkasan_otomatis }}</p>
        <span class="text-xs text-gray-400 mt-3">{{ $artikel->menit_baca }} menit baca</span>
    </div>
</article>
