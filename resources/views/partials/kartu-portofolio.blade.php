<article class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-200 group flex flex-col">
    <a href="{{ route('portofolio.show', $porto) }}" class="block h-40 flex items-center justify-center text-5xl overflow-hidden"
       style="background-color: {{ $porto->warna_thumb }}">
        @if($porto->gambar_thumbnail)
            <img src="{{ asset('storage/' . $porto->gambar_thumbnail) }}" alt="{{ $porto->nama_proyek }}"
                 loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <span aria-hidden="true">{{ $porto->emoji_icon }}</span>
        @endif
    </a>
    <div class="p-4 flex-1 flex flex-col">
        <span class="self-start bg-teal-50 text-teal-700 text-xs px-2.5 py-0.5 rounded-full mb-2">{{ $porto->kategori }}</span>
        <h3 class="font-medium text-gray-800 text-sm">
            <a href="{{ route('portofolio.show', $porto) }}" class="hover:text-teal-700">{{ $porto->nama_proyek }}</a>
        </h3>
        <p class="text-gray-400 text-xs mt-1 flex-1">{{ $porto->deskripsi }}</p>
        <div class="flex items-center gap-4 mt-3">
            <a href="{{ route('portofolio.show', $porto) }}" class="text-teal-600 text-xs font-medium hover:text-teal-800">Detail proyek →</a>
            @if($porto->tampilkan_demo && $porto->link_demo)
            <a href="{{ $porto->link_demo }}" target="_blank" rel="noopener" class="text-gray-400 text-xs hover:text-teal-700">Lihat demo ↗</a>
            @endif
        </div>
    </div>
</article>
