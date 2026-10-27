@php
    $menu = [
        ['Portofolio', route('portofolio.index'), 'portofolio.*'],
        ['Harga',      route('harga'),            'harga'],
        ['Blog',       route('blog.index'),       'blog.*'],
        ['Tentang',    route('tentang'),          'tentang'],
        ['FAQ',        route('faq'),              'faq'],
    ];
@endphp
<nav class="bg-teal-600 sticky top-0 z-50 shadow-md" x-data="{ open: false, layanan: false }" @keydown.escape.window="open=false; layanan=false">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2" aria-label="Beranda NTT Digital">
                <span class="text-teal-200 font-semibold text-xl tracking-tight">
                    <span class="text-white">NTT</span>Digital
                </span>
            </a>

            {{-- DESKTOP MENU --}}
            <div class="hidden md:flex items-center gap-6">
                {{-- Dropdown Layanan --}}
                <div class="relative" @mouseenter="layanan = true" @mouseleave="layanan = false">
                    <a href="{{ route('layanan.index') }}"
                       @focus="layanan = true"
                       class="text-sm transition inline-flex items-center gap-1
                              {{ request()->routeIs('layanan.*') ? 'text-white font-medium' : 'text-white/80 hover:text-white' }}">
                        Layanan
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div x-cloak x-show="layanan" x-transition.opacity
                         class="absolute left-1/2 -translate-x-1/2 top-full pt-3 w-72">
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-2">
                            @foreach($menuLayanan as $item)
                            <a href="{{ route('layanan.show', $item->slug) }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700">
                                <span class="text-lg">{{ $item->emoji_icon }}</span> {{ $item->nama }}
                            </a>
                            @endforeach
                            <a href="{{ route('layanan.index') }}"
                               class="block text-center text-xs font-medium text-teal-600 border-t border-gray-100 mt-1 pt-2 pb-1 hover:text-teal-800">
                                Lihat semua layanan →
                            </a>
                        </div>
                    </div>
                </div>

                @foreach($menu as [$label, $url, $pola])
                <a href="{{ $url }}"
                   class="text-sm transition {{ request()->routeIs($pola) ? 'text-white font-medium' : 'text-white/80 hover:text-white' }}"
                   @if(request()->routeIs($pola)) aria-current="page" @endif>
                    {{ $label }}
                </a>
                @endforeach

                <a href="{{ route('kontak') }}"
                   class="bg-white text-teal-700 text-sm font-medium px-4 py-2 rounded-full hover:bg-teal-50 transition">
                    Konsultasi Gratis
                </a>
            </div>

            {{-- HAMBURGER MOBILE --}}
            <button @click="open = !open" class="md:hidden text-white focus:outline-none"
                    :aria-expanded="open" aria-label="Buka menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-cloak x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div x-cloak x-show="open" x-transition class="md:hidden bg-teal-700 px-4 pb-4 space-y-1">
        <a href="{{ route('layanan.index') }}" class="block text-white/90 hover:text-white py-2 text-sm font-medium">Layanan</a>
        <div class="grid grid-cols-2 gap-1 pb-2">
            @foreach($menuLayanan as $item)
            <a href="{{ route('layanan.show', $item->slug) }}" class="text-white/70 hover:text-white text-xs py-1.5">
                {{ $item->emoji_icon }} {{ $item->nama }}
            </a>
            @endforeach
        </div>
        @foreach($menu as [$label, $url, $pola])
        <a href="{{ $url }}" class="block py-2 text-sm {{ request()->routeIs($pola) ? 'text-white font-medium' : 'text-white/80 hover:text-white' }}">{{ $label }}</a>
        @endforeach
        <a href="{{ route('kontak') }}"
           class="block bg-white text-teal-700 text-sm font-medium px-4 py-2 rounded-full text-center mt-2">
            Konsultasi Gratis
        </a>
    </div>
</nav>
