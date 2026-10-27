@php
    /** @var \App\Support\Seo $seo */
    $seo = $seo ?? \App\Support\Seo::make();
    $ga4   = \App\Models\SiteSetting::get('tracking_ga4_id');
    $pixel = \App\Models\SiteSetting::get('tracking_meta_pixel_id');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ===================== SEO ===================== --}}
    <title>{{ $seo->fullTitle() }}</title>
    <meta name="description" content="{{ $seo->metaDescription() }}">
    <link rel="canonical" href="{{ $seo->canonicalUrl() }}">
    <meta name="robots" content="{{ $seo->noindex ? 'noindex, follow' : 'index, follow, max-image-preview:large' }}">
    <meta name="theme-color" content="#0F6E56">
    @if($verif = \App\Models\SiteSetting::get('seo_google_verification'))
    <meta name="google-site-verification" content="{{ $verif }}">
    @endif

    {{-- Open Graph (Facebook, WhatsApp) & Twitter --}}
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="{{ $seo->type }}">
    <meta property="og:site_name" content="{{ $seo->siteName() }}">
    <meta property="og:title" content="{{ $seo->fullTitle() }}">
    <meta property="og:description" content="{{ $seo->metaDescription() }}">
    <meta property="og:url" content="{{ $seo->canonicalUrl() }}">
    <meta property="og:image" content="{{ $seo->imageUrl() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo->fullTitle() }}">
    <meta name="twitter:description" content="{{ $seo->metaDescription() }}">
    <meta name="twitter:image" content="{{ $seo->imageUrl() }}">

    {{-- Data terstruktur (JSON-LD) --}}
    @foreach($seo->jsonLd() as $blok)
    <script type="application/ld+json">{!! json_encode($blok, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endforeach

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind CSS via CDN (ganti dengan Vite di production) --}}
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        teal: {
                            50:  '#f0fdf9', 100: '#ccfbef', 200: '#99f6e0', 300: '#5eead4',
                            400: '#2dd4bf', 500: '#1D9E75', 600: '#0F6E56', 700: '#085041',
                            800: '#054535', 900: '#04342C',
                        }
                    }
                }
            }
        }
    </script>
    <style>[x-cloak]{display:none!important}</style>

    {{-- ===================== TRACKING ===================== --}}
    @if($ga4)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4 }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', @json($ga4));
    </script>
    @endif
    @if($pixel)
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', @json($pixel));
        fbq('track', 'PageView');
    </script>
    @endif

    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-800">

    <a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[60] bg-white text-teal-700 px-4 py-2 rounded">
        Langsung ke konten
    </a>

    @include('components.navbar')

    <main id="konten">
        @yield('content')
    </main>

    @include('components.footer')

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

    {{-- Lacak klik WhatsApp & konversi form sebagai event GA4 / Meta Pixel --}}
    <script>
        function nttTrack(nama, data) {
            if (window.gtag) gtag('event', nama, data || {});
            if (window.fbq) fbq('track', nama === 'generate_lead' ? 'Lead' : 'Contact', data || {});
        }
        document.addEventListener('click', function (e) {
            var a = e.target.closest('a[href*="wa.me/"]');
            if (a) nttTrack('klik_whatsapp', { lokasi: a.dataset.lokasi || 'lainnya', halaman: location.pathname });
        });
        @if(session('lead_terkirim'))
        nttTrack('generate_lead', { halaman: location.pathname });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
