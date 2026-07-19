<nav class="bg-teal-600 sticky top-0 z-50 shadow-md" x-data="{ open: false }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-teal-200 font-semibold text-xl tracking-tight">
                    <span class="text-white">NTT</span>Digital
                </span>
            </a>

            {{-- DESKTOP MENU --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="#layanan"    class="text-white/80 hover:text-white text-sm transition">Layanan</a>
                <a href="#portofolio" class="text-white/80 hover:text-white text-sm transition">Portofolio</a>
                <a href="#harga"      class="text-white/80 hover:text-white text-sm transition">Harga</a>
                <a href="#tentang"    class="text-white/80 hover:text-white text-sm transition">Tentang</a>
                <a href="#kontak"
                   class="bg-white text-teal-700 text-sm font-medium px-4 py-2 rounded-full hover:bg-teal-50 transition">
                    Hubungi Kami
                </a>
            </div>

            {{-- HAMBURGER MOBILE --}}
            <button @click="open = !open" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div x-show="open" x-transition class="md:hidden bg-teal-700 px-4 pb-4 space-y-2">
        <a href="#layanan"    @click="open=false" class="block text-white/80 hover:text-white py-2 text-sm">Layanan</a>
        <a href="#portofolio" @click="open=false" class="block text-white/80 hover:text-white py-2 text-sm">Portofolio</a>
        <a href="#harga"      @click="open=false" class="block text-white/80 hover:text-white py-2 text-sm">Harga</a>
        <a href="#tentang"    @click="open=false" class="block text-white/80 hover:text-white py-2 text-sm">Tentang</a>
        <a href="#kontak"     @click="open=false"
           class="block bg-white text-teal-700 text-sm font-medium px-4 py-2 rounded-full text-center mt-2">
            Hubungi Kami
        </a>
    </div>
</nav>
