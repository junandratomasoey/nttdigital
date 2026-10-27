{{-- Header halaman dalam: $judul, $sub (opsional), $label (opsional), breadcrumb dari $seo --}}
<section class="bg-gradient-to-br from-teal-900 via-teal-700 to-teal-600 text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14 md:py-16">
        @if(isset($seo) && count($seo->breadcrumbs))
        <nav aria-label="Breadcrumb" class="text-xs text-white/60 mb-4">
            <ol class="flex flex-wrap items-center gap-1.5">
                <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                @foreach($seo->breadcrumbs as [$bLabel, $bUrl])
                <li aria-hidden="true">/</li>
                <li>
                    @if($bUrl)
                        <a href="{{ $bUrl }}" class="hover:text-white">{{ $bLabel }}</a>
                    @else
                        <span class="text-white/90" aria-current="page">{{ \Illuminate\Support\Str::limit($bLabel, 50) }}</span>
                    @endif
                </li>
                @endforeach
            </ol>
        </nav>
        @endif
        @isset($label)
        <span class="text-xs font-medium text-teal-200 uppercase tracking-widest">{{ $label }}</span>
        @endisset
        <h1 class="text-3xl md:text-4xl font-semibold mt-1 leading-tight max-w-3xl">{{ $judul }}</h1>
        @isset($sub)
        <p class="text-white/70 text-sm md:text-base mt-3 max-w-2xl leading-relaxed">{{ $sub }}</p>
        @endisset
    </div>
</section>
