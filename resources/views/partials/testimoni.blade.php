{{-- $testimonis: koleksi Testimoni. Tidak tampil apa pun jika kosong. --}}
@if($testimonis->isNotEmpty())
<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    @foreach($testimonis as $t)
    <figure class="bg-white border border-gray-100 rounded-2xl p-6 flex flex-col">
        <div class="text-amber-400 text-sm mb-3" aria-label="Rating {{ $t->rating }} dari 5">
            {{ str_repeat('★', $t->rating) }}<span class="text-gray-200">{{ str_repeat('★', 5 - $t->rating) }}</span>
        </div>
        <blockquote class="text-gray-600 text-sm leading-relaxed flex-1">“{{ $t->isi }}”</blockquote>
        <figcaption class="flex items-center gap-3 mt-5">
            @if($t->foto)
                <img src="{{ asset('storage/' . $t->foto) }}" alt="{{ $t->nama }}" class="w-10 h-10 rounded-full object-cover" loading="lazy">
            @else
                <span class="w-10 h-10 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-semibold">{{ $t->inisial }}</span>
            @endif
            <div>
                <div class="text-sm font-medium text-gray-800">{{ $t->nama }}</div>
                <div class="text-xs text-gray-400">{{ collect([$t->jabatan, $t->instansi])->filter()->implode(', ') }}</div>
            </div>
        </figcaption>
    </figure>
    @endforeach
</div>
@endif
