{{--
    Form kontak (dipakai di beranda & halaman Kontak).
    Variabel opsional: $pilihPaket, $pilihLayanan
--}}
@php
    $opsiLayanan = \App\Models\Layanan::aktif()->pluck('nama');
    $pilihPaket  = old('paket', $pilihPaket ?? null);
    $pilihJenis  = old('jenis_website', $pilihLayanan ?? null);
    $kelasInput  = 'w-full bg-white border border-white/15 text-gray-900 placeholder:text-gray-400 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400 transition';
@endphp
<div class="bg-white/5 border border-white/10 rounded-2xl p-6" id="form-kontak">

    @if(session('sukses'))
    <div class="bg-teal-500/20 border border-teal-400/30 text-teal-100 rounded-xl p-4 mb-5 text-sm" role="status">
        ✅ {{ session('sukses') }}
    </div>
    @endif

    <form action="{{ route('kontak.kirim') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Honeypot anti-spam (jangan dihapus) --}}
        <div class="hidden" aria-hidden="true">
            <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        </div>

        <div>
            <label for="f-nama" class="block text-white/70 text-xs mb-1.5">Nama Lengkap *</label>
            <input id="f-nama" type="text" name="nama" value="{{ old('nama') }}" required maxlength="100"
                   placeholder="Nama Anda" autocomplete="name" class="{{ $kelasInput }}">
            @error('nama') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="f-wa" class="block text-white/70 text-xs mb-1.5">Nomor WhatsApp *</label>
            <input id="f-wa" type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required maxlength="20"
                   placeholder="08xxxxxxxxxx" autocomplete="tel" inputmode="tel" class="{{ $kelasInput }}">
            @error('whatsapp') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="f-jenis" class="block text-white/70 text-xs mb-1.5">Jenis Website</label>
                <select id="f-jenis" name="jenis_website" class="{{ $kelasInput }}">
                    <option value="">-- Pilih Jenis --</option>
                    @foreach($opsiLayanan as $nama)
                    <option value="{{ $nama }}" @selected($pilihJenis === $nama)>{{ $nama }}</option>
                    @endforeach
                    @if($pilihJenis && ! $opsiLayanan->contains($pilihJenis))
                    <option value="{{ $pilihJenis }}" selected>{{ $pilihJenis }}</option>
                    @endif
                </select>
            </div>
            <div>
                <label for="f-paket" class="block text-white/70 text-xs mb-1.5">Paket</label>
                <select id="f-paket" name="paket" class="{{ $kelasInput }}">
                    <option value="">Belum tahu / konsultasi</option>
                    @foreach(\App\Models\PaketHarga::aktif()->pluck('nama') as $nama)
                    <option value="{{ $nama }}" @selected($pilihPaket === $nama)>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="f-pesan" class="block text-white/70 text-xs mb-1.5">Pesan (opsional)</label>
            <textarea id="f-pesan" name="pesan" rows="3" maxlength="1000"
                      placeholder="Ceritakan kebutuhan website Anda..."
                      class="{{ $kelasInput }} resize-none">{{ old('pesan') }}</textarea>
        </div>

        <button type="submit" class="w-full bg-teal-500 hover:bg-teal-400 text-white font-medium py-3 rounded-xl text-sm transition">
            Kirim Pesan
        </button>
        <p class="text-white/40 text-xs text-center">Data Anda hanya dipakai untuk menghubungi Anda kembali.</p>
    </form>
</div>
