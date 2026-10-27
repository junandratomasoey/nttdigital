@php $S = fn ($k, $d = null) => \App\Models\SiteSetting::get($k, $d); @endphp
<footer class="bg-teal-900 text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

            {{-- BRAND --}}
            <div>
                <div class="text-teal-300 font-semibold text-xl mb-3">
                    <span class="text-white">NTT</span>Digital
                </div>
                <p class="text-white/60 text-sm leading-relaxed">
                    Jasa pembuatan website profesional berbasis di Kupang, Nusa Tenggara Timur.
                    Melayani seluruh wilayah NTT.
                </p>
                <div class="flex gap-3 mt-4">
                    @if($S('site_instagram'))
                    <a href="{{ $S('site_instagram') }}" target="_blank" rel="noopener" aria-label="Instagram"
                       class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition text-sm">📷</a>
                    @endif
                    @if($S('site_facebook'))
                    <a href="{{ $S('site_facebook') }}" target="_blank" rel="noopener" aria-label="Facebook"
                       class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition text-sm">👤</a>
                    @endif
                    @if($S('site_tiktok'))
                    <a href="{{ $S('site_tiktok') }}" target="_blank" rel="noopener" aria-label="TikTok"
                       class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition text-sm">🎵</a>
                    @endif
                    <a href="{{ \App\Support\Wa::link() }}" data-lokasi="footer-ikon" target="_blank" rel="noopener" aria-label="WhatsApp"
                       class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition text-sm">💬</a>
                </div>
            </div>

            {{-- LAYANAN --}}
            <div>
                <h4 class="text-white font-medium mb-4 text-sm uppercase tracking-wider">Layanan</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    @foreach($menuLayanan->take(7) as $item)
                    <li><a href="{{ route('layanan.show', $item->slug) }}" class="hover:text-white transition">{{ $item->nama }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- NAVIGASI --}}
            <div>
                <h4 class="text-white font-medium mb-4 text-sm uppercase tracking-wider">Perusahaan</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="{{ route('portofolio.index') }}" class="hover:text-white transition">Portofolio</a></li>
                    <li><a href="{{ route('harga') }}"            class="hover:text-white transition">Harga</a></li>
                    <li><a href="{{ route('blog.index') }}"       class="hover:text-white transition">Blog</a></li>
                    <li><a href="{{ route('tentang') }}"          class="hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="{{ route('faq') }}"              class="hover:text-white transition">FAQ</a></li>
                    <li><a href="{{ route('kontak') }}"           class="hover:text-white transition">Kontak</a></li>
                </ul>
            </div>

            {{-- KONTAK --}}
            <div>
                <h4 class="text-white font-medium mb-4 text-sm uppercase tracking-wider">Kontak</h4>
                <ul class="space-y-3 text-sm text-white/60">
                    <li class="flex items-start gap-2"><span>📍</span>{{ $S('site_alamat', 'Kupang, NTT') }}</li>
                    @if($S('site_email'))
                    <li class="flex items-center gap-2"><span>📧</span>
                        <a href="mailto:{{ $S('site_email') }}" class="hover:text-white transition break-all">{{ $S('site_email') }}</a>
                    </li>
                    @endif
                    <li class="flex items-center gap-2"><span>💬</span>
                        <a href="{{ \App\Support\Wa::link() }}" data-lokasi="footer" target="_blank" rel="noopener" class="hover:text-white transition">
                            +{{ \App\Support\Wa::nomor() }}
                        </a>
                    </li>
                    @if($S('jam_operasional'))
                    <li class="flex items-start gap-2"><span>🕘</span>{{ $S('jam_operasional') }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p class="text-white/40 text-xs">© {{ date('Y') }} NTT Digital · Kupang, Nusa Tenggara Timur</p>
            <p class="text-white/30 text-xs">Dibuat dengan ❤️ di NTT</p>
        </div>
    </div>
</footer>

{{-- FLOATING WA BUTTON --}}
<a href="{{ \App\Support\Wa::link() }}" data-lokasi="tombol-melayang"
   target="_blank" rel="noopener"
   class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center text-2xl transition-transform hover:scale-110"
   title="Chat WhatsApp" aria-label="Chat WhatsApp">
    💬
</a>
