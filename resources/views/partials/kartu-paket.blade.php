<div class="rounded-2xl p-6 border transition-all duration-200 bg-white flex flex-col
            {{ $paket->unggulan ? 'border-teal-500 shadow-lg shadow-teal-100 relative' : 'border-gray-100 hover:border-gray-200 hover:shadow-md' }}">
    @if($paket->unggulan && $paket->label_badge)
    <div class="absolute -top-3 left-1/2 -translate-x-1/2">
        <span class="bg-teal-600 text-white text-xs px-3 py-1 rounded-full whitespace-nowrap">{{ $paket->label_badge }}</span>
    </div>
    @elseif($paket->label_badge)
    <div class="self-start bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full mb-3">{{ $paket->label_badge }}</div>
    @endif

    <h3 class="text-gray-900 font-semibold text-lg {{ $paket->unggulan ? 'mt-2' : '' }}">{{ $paket->nama }}</h3>
    <div class="text-teal-600 font-semibold text-2xl mt-2">
        {{ $paket->harga }} <span class="text-gray-400 text-sm font-normal">{{ $paket->satuan }}</span>
    </div>

    <ul class="mt-5 space-y-2.5 flex-1">
        @foreach((array) $paket->fitur as $fitur)
        <li class="flex items-start gap-2 text-sm text-gray-600">
            <span class="text-teal-500 mt-0.5 flex-shrink-0">✓</span>
            {{ is_array($fitur) ? ($fitur['item'] ?? '') : $fitur }}
        </li>
        @endforeach
    </ul>

    <a href="{{ route('kontak', ['paket' => $paket->nama]) }}"
       class="block text-center mt-6 py-2.5 rounded-full text-sm font-medium transition
              {{ $paket->unggulan ? 'bg-teal-600 text-white hover:bg-teal-700' : 'border border-teal-500 text-teal-600 hover:bg-teal-50' }}">
        Pilih Paket Ini
    </a>
</div>
