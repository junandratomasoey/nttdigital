<footer class="bg-teal-900 text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

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
                    @if(\App\Models\SiteSetting::get('site_instagram'))
                    <a href="{{ \App\Models\SiteSetting::get('site_instagram') }}" target="_blank"
                       class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition text-sm">
                        📷
                    </a>
                    @endif
                    @if(\App\Models\SiteSetting::get('site_facebook'))
                    <a href="{{ \App\Models\SiteSetting::get('site_facebook') }}" target="_blank"
                       class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition text-sm">
                        👤
                    </a>
                    @endif
                    <a href="https://wa.me/{{ \App\Models\SiteSetting::get('site_whatsapp') }}" target="_blank"
                       class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition text-sm">
                        💬
                    </a>
                </div>
            </div>

            {{-- NAVIGASI --}}
            <div>
                <h4 class="text-white font-medium mb-4 text-sm uppercase tracking-wider">Navigasi</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="#layanan"    class="hover:text-white transition">Layanan</a></li>
                    <li><a href="#portofolio" class="hover:text-white transition">Portofolio</a></li>
                    <li><a href="#harga"      class="hover:text-white transition">Harga</a></li>
                    <li><a href="#tentang"    class="hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="#kontak"     class="hover:text-white transition">Kontak</a></li>
                </ul>
            </div>

            {{-- KONTAK --}}
            <div>
                <h4 class="text-white font-medium mb-4 text-sm uppercase tracking-wider">Kontak</h4>
                <ul class="space-y-3 text-sm text-white/60">
                    <li class="flex items-center gap-2">
                        <span>📍</span>
                        {{ \App\Models\SiteSetting::get('site_alamat', 'Kupang, NTT') }}
                    </li>
                    <li class="flex items-center gap-2">
                        <span>📧</span>
                        <a href="mailto:{{ \App\Models\SiteSetting::get('site_email') }}"
                           class="hover:text-white transition">
                            {{ \App\Models\SiteSetting::get('site_email') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span>💬</span>
                        <a href="https://wa.me/{{ \App\Models\SiteSetting::get('site_whatsapp') }}" target="_blank"
                           class="hover:text-white transition">
                            WhatsApp
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p class="text-white/40 text-xs">
                © {{ date('Y') }} NTT Digital · Kupang, Nusa Tenggara Timur
            </p>
            <p class="text-white/30 text-xs">
                Dibuat dengan ❤️ di NTT
            </p>
        </div>
    </div>
</footer>

{{-- FLOATING WA BUTTON --}}
<a href="https://wa.me/{{ \App\Models\SiteSetting::get('site_whatsapp') }}?text=Halo%20NTT%20Digital%2C%20saya%20ingin%20konsultasi%20pembuatan%20website"
   target="_blank"
   class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center text-2xl transition-transform hover:scale-110"
   title="Chat WhatsApp">
    💬
</a>
