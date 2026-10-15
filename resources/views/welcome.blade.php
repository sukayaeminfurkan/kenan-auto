<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kenan Auto – Güvenilir araç alım satım platformu. En iyi fiyatlarla araç al veya sat.">
    <title>Kenan Auto – Premium Araç Alım Satım</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet"/>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body { font-family: 'Instrument Sans', sans-serif; overflow-x: clip; }
        html { overflow-x: clip; }

        #site-header.scrolled {
            background: rgba(10,10,10,.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding-top: .6rem; padding-bottom: .6rem;
            border-bottom-color: rgba(204,0,0,.2);
            box-shadow: 0 2px 24px rgba(0,0,0,.5);
        }

        #mobile-menu { max-height: 0; overflow: hidden; transition: max-height .35s ease, padding .35s ease; }
        #mobile-menu.open { max-height: 18rem; padding-top: 1rem; padding-bottom: 1rem; border-top: 1px solid rgba(255,255,255,.1); margin-top: .75rem; }

        .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; }
        .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        @keyframes scrollBounce {
            0%, 100% { transform: scaleY(1); opacity: 1; }
            50%       { transform: scaleY(.6); opacity: .4; }
        }
        @keyframes floatCard {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-7px); }
        }

        /* ── Panel genişleme efekti ── */
        .panel-item {
            transition: flex 0.6s cubic-bezier(0.4,0,0.2,1);
            flex: 1;
        }
        .panel-item.active {
            flex: 3.5;
        }
        .panel-item .panel-bg {
            transition: filter 0.5s ease, transform 0.6s ease;
            filter: brightness(0.4);
            transform: scale(1.08);
        }
        .panel-item.active .panel-bg {
            filter: brightness(0.85);
            transform: scale(1);
        }
        .panel-item .panel-side-label {
            transition: opacity 0.3s ease;
        }
        .panel-item.active .panel-side-label {
            opacity: 0;
            pointer-events: none;
        }
        .panel-item .panel-content {
            transition: opacity 0.4s ease 0.25s, transform 0.4s ease 0.25s;
        }
        .panel-item.active .panel-content {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        /* ── Öne çıkan araçlar — cam kart ── */
        .arac-card-glass {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 0.5px solid rgba(255,255,255,0.8);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        /* ── Araç kartı hover efektleri ── */
        .arac-card {
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1),
                        box-shadow 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .arac-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(204,0,0,0.18),
                        0 0 0 1px rgba(204,0,0,0.2);
        }

        .shine {
            position: absolute; top: 0; left: -100%;
            width: 60%; height: 100%;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.55) 50%, transparent 60%);
            transition: left 0.55s ease;
            pointer-events: none; z-index: 2;
        }
        .card:hover .shine { left: 150%; }

        .card-body { position: relative; z-index: 1; overflow: hidden; }
        .card-body > * { position: relative; z-index: 1; }
        .card-body::before {
            content: '';
            position: absolute;
            bottom: -60%; left: -60%;
            width: 200%; height: 200%;
            background: radial-gradient(ellipse at bottom left,
                #CC0000 0%, #CC0000 25%, rgba(204,0,0,0.55) 50%, transparent 72%);
            opacity: 0;
            transition: opacity 0.45s cubic-bezier(0.4,0,0.2,1);
            pointer-events: none; z-index: 0;
        }
        .card:hover .card-body::before { opacity: 1; }

        .card-brand-model { transition: color 0.35s ease; }
        .card:hover .card-brand-model { color: rgba(255,255,255,0.95) !important; }

        .card-package { transition: color 0.35s ease; }
        .card:hover .card-package { color: rgba(255,255,255,0.7) !important; }

        .card-divider { transition: border-color 0.35s ease, background 0.35s ease; }
        .card:hover .card-divider {
            background: rgba(255,255,255,0.2) !important;
            border-color: rgba(255,255,255,0.2) !important;
        }

        .spec-tag { border: 1px solid transparent; border-radius: 4px; transition: background 0.35s ease, border-color 0.35s ease, color 0.35s ease; }
        .card:hover .spec-tag {
            background: rgba(255,255,255,0.15) !important;
            border-color: rgba(255,255,255,0.2) !important;
            color: rgba(255,255,255,0.9) !important;
        }
        .card:hover .spec-tag svg { stroke: rgba(255,255,255,0.9); }

        .card-footer { position: relative; z-index: 2; }

        .card-price { position: relative; z-index: 2; transition: background 0.35s ease, color 0.35s ease, transform 0.35s ease; }
        .card:hover .card-price {
            background: #fff !important;
            color: #CC0000 !important;
            transform: scale(1.03);
        }

        .card-detail { position: relative; z-index: 2; transition: background 0.35s ease, color 0.35s ease; }
        .card:hover .card-detail {
            background: rgba(255,255,255,0.22) !important;
            color: #fff !important;
        }
    </style>
</head>
<body class="bg-[#0a0a0a] text-white">

{{-- ═══════════ STICKY HEADER ═══════════ --}}
<header id="site-header"
        class="fixed top-0 left-0 right-0 z-[100]
                   px-6 py-4
                   bg-black/40 backdrop-blur-[10px] [-webkit-backdrop-filter:blur(10px)]
                   border-b border-white/[.06]
                   transition-[background,padding,border-color,box-shadow] duration-[400ms]">

    <div class="max-w-[80rem] mx-auto flex items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="/" class="group flex items-center gap-2.5 no-underline shrink-0" aria-label="Kenan Auto Ana Sayfa">
            <div class="w-9 h-9 bg-red-600 rounded-full flex items-center justify-center
                            font-bold text-base text-white
                            transition-colors duration-200 group-hover:bg-red-500">K</div>
            <span class="whitespace-nowrap text-base md:text-lg font-semibold text-white tracking-[.02em]">
                    Kenan <span class="text-red-400">Auto</span>
                </span>
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden md:flex gap-8" aria-label="Ana menü">
            @foreach ([
                ['/araclarimiz', 'Araçlarımız'],
                ['#panels',      'Araç Buldur'],
                ['#panels',      'Araç Sat'],
                ['/hizmetler',   'Hizmetler'],
                ['/hakkimizda',  'Hakkımızda'],
                ['#iletisim',    'İletişim'],
            ] as [$href, $label])
                <a href="{{ $href }}"
                   class="relative text-white/75 no-underline text-sm font-medium
                          transition-colors duration-[250ms] hover:text-white
                          after:content-[''] after:absolute after:bottom-[-4px] after:left-0
                          after:w-full after:h-0.5 after:bg-red-600 after:rounded-sm
                          after:scale-x-0 after:origin-left
                          after:transition-transform after:duration-300
                          hover:after:scale-x-100">{{ $label }}</a>
            @endforeach
        </nav>

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <a href="tel:+905001234567"
               class="hidden sm:flex items-center gap-1.5
                          text-white/70 no-underline text-[.8125rem]
                          transition-colors duration-200 hover:text-white"
               aria-label="Bizi arayın">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z"/>
                </svg>
                +90 500 123 45 67
            </a>

            <a href="#iletisim"
               class="bg-red-600 text-white rounded-full px-[1.125rem] py-2
                          text-[.8125rem] font-semibold no-underline
                          transition-[background,transform] duration-200
                          hover:bg-red-500 hover:scale-[1.03]">İletişim</a>

            <button id="hamburger"
                    class="hamburger flex flex-col gap-[5px] bg-transparent border-0 cursor-pointer p-1 md:hidden"
                    aria-label="Menüyü aç/kapat" aria-expanded="false">
                <span class="block w-[22px] h-0.5 bg-white rounded-sm transition-[transform,opacity] duration-300"></span>
                <span class="block w-[22px] h-0.5 bg-white rounded-sm transition-[transform,opacity] duration-300"></span>
                <span class="block w-[22px] h-0.5 bg-white rounded-sm transition-[transform,opacity] duration-300"></span>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" role="navigation" aria-label="Mobil menü">
        @foreach ([
            ['/araclarimiz',      'Araçlarımız'],
            ['#panels',           'Araç Buldur'],
            ['#panels',           'Araç Sat'],
            ['/hizmetler',        'Hizmetler'],
            ['/hakkimizda',       'Hakkımızda'],
            ['#iletisim',         'İletişim'],
            ['tel:+905001234567', '+90 500 123 45 67'],
        ] as [$href, $label])
            <a href="{{ $href }}"
               class="mobile-nav-link relative block
                      text-white/80 no-underline text-[.9375rem] font-medium
                      py-2 pl-3.5
                      transition-colors duration-[250ms] hover:text-red-400
                      before:content-[''] before:absolute before:left-0 before:top-[15%] before:bottom-[15%]
                      before:w-[3px] before:bg-red-600 before:rounded-sm
                      before:-translate-x-2 before:opacity-0
                      before:transition-[transform,opacity] before:duration-[250ms]
                      hover:before:translate-x-0 hover:before:opacity-100">{{ $label }}</a>
        @endforeach
    </div>
</header>

{{-- ═══════════ HERO SCROLL STAGE ═══════════ --}}
<div id="hero-stage" class="relative h-[300vh]">
    <div id="hero-sticky" role="banner"
         class="sticky top-0 h-screen overflow-hidden flex items-stretch">

        {{-- Panels — revealed as hero image slides away --}}
        <div id="panels-bg"
             class="absolute inset-0 flex flex-col md:flex-row overflow-hidden">

            {{-- LEFT: Araç Al --}}
            <div id="panel-buy"
                 class="panel-item buy relative overflow-hidden cursor-pointer min-h-[50%] md:min-h-0"
                 onmouseenter="setPanel('buy')"
                 onclick="setPanel('buy')">

                <div class="panel-bg absolute inset-0"
                     style="background: linear-gradient(rgba(0,0,0,0.45),rgba(0,0,0,0.45)), url('/images/panel-buy.jpg') center/cover no-repeat;"></div>

                <div class="panel-side-label absolute inset-0 flex items-center justify-center
                                text-white/70 font-black uppercase tracking-[.2em] text-sm
                                md:[writing-mode:vertical-rl] md:[text-orientation:mixed]">
                    ARAÇ AL
                </div>

                <div class="panel-content absolute inset-0 flex flex-col items-center justify-center
                                text-center px-8 py-10 opacity-0 translate-y-4">
                    <h2 class="text-5xl font-black text-white mb-3">Araç Al</h2>
                    <p class="text-white/60 text-sm leading-relaxed mb-6 max-w-xs">
                        Binlerce incelenmiş araç arasından<br>hayalindekini bul. Şeffaf fiyat.
                    </p>
                    <ul class="text-left text-sm text-white/55 space-y-2 mb-7">
                        <li class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="#f87171"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Ekspertiz Raporlu Araçlar
                        </li>
                        <li class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="#f87171"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Garanti &amp; Sigorta Desteği
                        </li>
                        <li class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="#f87171"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Kredi &amp; Taksit Seçenekleri
                        </li>
                    </ul>
                    <a href="/arac-al"
                       class="inline-flex items-center gap-2 bg-red-600 text-white
                                  px-7 py-3 rounded-full text-sm font-bold no-underline
                                  hover:bg-red-500 transition-colors duration-200">
                        Araçları İncele →
                    </a>
                </div>
            </div>

            {{-- RIGHT: Araç Sat --}}
            <div id="panel-sell"
                 class="panel-item sell relative overflow-hidden cursor-pointer min-h-[50%] md:min-h-0"
                 onmouseenter="setPanel('sell')"
                 onclick="setPanel('sell')">

                <div class="panel-bg absolute inset-0"
                     style="background: linear-gradient(rgba(0,0,0,0.45),rgba(0,0,0,0.45)), url('/images/panel-sell.jpg') center/cover no-repeat;"></div>

                <div class="panel-side-label absolute inset-0 flex items-center justify-center
                                text-white/70 font-black uppercase tracking-[.2em] text-sm
                                md:[writing-mode:vertical-rl] md:[text-orientation:mixed]">
                    ARAÇ SAT
                </div>

                <div class="panel-content absolute inset-0 flex flex-col items-center justify-center
                                text-center px-8 py-10 opacity-0 translate-y-4">
                    <h2 class="text-5xl font-black text-white mb-3">Araç Sat</h2>
                    <p class="text-white/60 text-sm leading-relaxed mb-6 max-w-xs">
                        Hızlı değerleme, anında nakit teklif.<br>Tüm evrakları biz halledelim.
                    </p>
                    <ul class="text-left text-sm text-white/55 space-y-2 mb-7">
                        <li class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="#fca5a5"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Ücretsiz Araç Değerleme
                        </li>
                        <li class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="#fca5a5"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Anında Nakit Ödeme
                        </li>
                        <li class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="#fca5a5"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Tüm Evrakları Biz Halledelim
                        </li>
                    </ul>
                    <a href="/arac-sat"
                       class="inline-flex items-center gap-2 bg-white text-[#991b1b]
                                  px-7 py-3 rounded-full text-sm font-bold no-underline
                                  hover:bg-gray-100 transition-colors duration-200">
                        Teklifinizi Alın →
                    </a>
                </div>
            </div>

        </div>
        {{-- end panels-bg --}}

        {{-- Hero image overlay — slides right on scroll --}}
        <div id="hero-overlay" aria-hidden="true"
             class="absolute inset-0 will-change-transform flex flex-col">

            <div id="hero-bg"
                 class="absolute inset-0
                            bg-[linear-gradient(160deg,#1a1a1a_0%,#2d0000_35%,#1a1a1a_100%)]
                            before:content-[''] before:absolute before:left-0 before:top-0 before:bottom-0 before:w-1/2
                            before:bg-[linear-gradient(160deg,#CC0000_0%,#e00000_60%,#aa0000_100%)]
                            before:[clip-path:polygon(0_0,100%_0,68%_100%,0_100%)]"></div>

            <div id="car-layer" aria-hidden="true"
                 class="absolute inset-0 flex items-center md:items-end justify-center
                            will-change-transform pointer-events-none z-[5] [transform-origin:60%_bottom]">
                <img id="car-img" src="/images/car-kenan.png" alt="Kenan Auto Araç"
                     class="w-full md:w-[72%] md:max-w-[680px] h-auto object-contain mix-blend-screen block md:mb-[-1%]"/>
            </div>

            <div id="hero-gradient"
                 class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/40"></div>
        </div>

        {{-- Hero text content --}}
        <div id="hero-content"
             class="absolute inset-0 z-10 flex flex-col items-center justify-center
                        text-center p-6 will-change-[opacity,transform]">

            <h1 class="text-[clamp(1.625rem,7.5vw,2.25rem)] md:text-[clamp(2.75rem,8vw,6.5rem)]
                           font-extrabold leading-[1.05] tracking-[-0.025em] text-white
                           mb-5 [text-shadow:0_2px_20px_rgba(0,0,0,.3)]">
                Hayalindeki<br>
                <span class="bg-gradient-to-r from-[#ff6b6b] to-white bg-clip-text text-transparent">Araca Kavuş</span>
            </h1>

            <p class="text-[.9375rem] md:text-[clamp(1rem,2.5vw,1.1875rem)]
                          text-white/85 max-w-[36rem] leading-[1.7]
                          mb-8 md:mb-10 [text-shadow:0_1px_8px_rgba(0,0,0,.4)]">
                Kenan Auto ile güvenilir, hızlı ve şeffaf araç alım satım deneyimi.
                Türkiye'nin en geniş ikinci el araç portföyü.
            </p>

            <div class="flex flex-nowrap gap-2 justify-center mb-12 md:flex-wrap md:gap-4">
                <a href="#panels"
                   class="bg-red-600 text-white rounded-full
                              py-3 px-[1.125rem] md:py-[.9375rem] md:px-9
                              text-[.8125rem] md:text-[.9375rem] font-semibold no-underline whitespace-nowrap
                              inline-flex items-center gap-2
                              transition-[background,transform,box-shadow] duration-200
                              hover:bg-red-500 hover:scale-[1.04]
                              hover:shadow-[0_16px_32px_rgba(220,38,38,.35)]">
                    Araç Bul
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </a>
                <a href="#panels"
                   class="border border-white/30 text-white rounded-full
                              py-3 px-[1.125rem] md:py-[.9375rem] md:px-9
                              text-[.8125rem] md:text-[.9375rem] font-medium no-underline whitespace-nowrap
                              backdrop-blur-sm inline-flex items-center gap-2
                              transition-[border-color,background,transform] duration-200
                              hover:border-white/60 hover:bg-white/[.08] hover:scale-[1.03]">
                    Aracını Sat
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <div class="absolute bottom-8 left-1/2 -translate-x-1/2
                            flex flex-col items-center gap-2
                            text-white/40 text-xs tracking-[.08em] uppercase pointer-events-none"
                 aria-hidden="true">
                <span>Keşfet</span>
                <div class="w-px h-10 bg-gradient-to-b from-white/40 to-transparent
                                [animation:scrollBounce_1.8s_ease-in-out_infinite]"></div>
            </div>
        </div>

    </div>
</div>
{{-- end hero-stage --}}

{{-- ═══════════ ÖNE ÇIKAN ARAÇLAR ═══════════ --}}
@if(isset($oneCikanAraclar) && $oneCikanAraclar->count() > 0)
<section class="relative overflow-hidden py-8" id="oneCikanSection"
         style="background-image: linear-gradient(rgba(255,255,255,0.55), rgba(255,255,255,0.55)), url('/images/one_cikan_arac.png');
                background-size: cover;
                background-position: center;">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        {{-- Tek satır header --}}
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2 min-w-0">
                <span class="text-[10px] text-red-600 font-bold tracking-[.15em] uppercase shrink-0">Öne Çıkan</span>
                <span class="text-base font-extrabold text-gray-900 shrink-0">Seçili Araçlarımız</span>
                <span class="text-xs text-gray-400 hidden sm:inline truncate">— uzman ekibimizin önerileri</span>
            </div>
            <a href="/araclarimiz"
               class="shrink-0 inline-flex items-center gap-1 text-xs font-bold text-white bg-red-600
                      hover:bg-red-700 transition-colors whitespace-nowrap px-3 py-1.5 rounded-lg ml-4">
                Tümünü Gör →
            </a>
        </div>

        {{-- Slider wrapper --}}
        <div class="relative" style="padding: 0 24px;">
            {{-- Sol fade --}}
            <div class="absolute top-0 bottom-0 left-0 w-12 z-10 pointer-events-none"
                 style="background: linear-gradient(to right, rgba(255,255,255,0.85), transparent);"></div>
            {{-- Sağ fade --}}
            <div class="absolute top-0 bottom-0 right-0 w-12 z-10 pointer-events-none"
                 style="background: linear-gradient(to left, rgba(255,255,255,0.85), transparent);"></div>

            <div class="overflow-hidden" id="araclarSlider">
                <div class="flex select-none" id="araclarTrack" style="gap:16px; padding:12px 0; will-change:transform; transition:transform 0.5s cubic-bezier(0.4,0,0.2,1);">
                    @foreach($oneCikanAraclar as $i => $arac)
                        @php
                            $kapak    = $arac->kapakFoto;
                            $markaAd  = $arac->marka->ad ?? '';
                            $modelAd  = $arac->aracModel->ad ?? '';
                            $paketAd  = $arac->paket->ad ?? $arac->seri ?? '';
                            $isHibrit = in_array(strtolower($arac->yakit_turu ?? ''), ['hibrit', 'elektrik']);
                        @endphp

                        {{-- Tüm kart tıklanabilir --}}
                        <a href="/araclarimiz/{{ $arac->slug }}"
                           class="flex-shrink-0 block overflow-hidden group arac-card arac-card-glass"
                           style="text-decoration: none; color: inherit; cursor: pointer;"
                           data-index="{{ $i }}">

                            {{-- Fotoğraf alanı --}}
                            <div style="width:100%; height:160px; overflow:hidden; position:relative; border-radius:16px 16px 0 0; background:#f0f0f0;">
                                @if($kapak)
                                    <img src="{{ Storage::url($kapak->dosya_yolu) }}"
                                         alt="{{ $markaAd }} {{ $modelAd }}"
                                         class="group-hover:scale-105"
                                         style="width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.5s ease;">
                                @else
                                    <div style="width:100%; height:100%; background:#f9f0f0; display:flex; align-items:center; justify-content:center;">
                                        <span style="font-size:3rem; font-weight:900; color:rgba(204,0,0,0.2); text-transform:uppercase; line-height:1; font-family:inherit;">
                                            {{ strtoupper(substr($markaAd ?: 'A', 0, 1)) }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Badges --}}
                                <div style="position:absolute; top:8px; left:8px; display:flex; flex-direction:column; gap:4px;">
                                    @if($arac->one_cikan)
                                        <span style="font-size:10px; font-weight:700; background:#dc2626; color:white; padding:2px 7px; border-radius:999px; line-height:1.4; white-space:nowrap;">Öne Çıkan</span>
                                    @endif
                                    @if($isHibrit)
                                        <span style="font-size:10px; font-weight:700; background:#22c55e; color:white; padding:2px 7px; border-radius:999px; line-height:1.4; white-space:nowrap;">{{ ucfirst($arac->yakit_turu) }}</span>
                                    @endif
                                </div>
                                <div class="shine"></div>
                            </div>

                            {{-- Kart alt kısmı --}}
                            <div class="card-body" style="background:white; padding:12px;">
                                {{-- Marka + Model --}}
                                <div class="card-brand-model" style="position:relative; z-index:1; font-weight:700; font-size:0.875rem; color:#111827; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; line-height:1.3;">
                                    {{ $markaAd }} {{ $modelAd }}
                                </div>
                                <div class="card-package" style="position:relative; z-index:1; font-size:0.6875rem; color:#9ca3af; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-top:2px; height:16px;">{{ $paketAd }}</div>

                                {{-- Ayırıcı çizgi --}}
                                <div class="card-divider" style="position:relative; z-index:1; border-top:1px solid #f3f4f6; margin:8px 0;"></div>

                                {{-- Specs 2×2 grid --}}
                                <div style="display:grid; grid-template-columns:1fr 1fr; gap:4px 6px; margin-bottom:10px;">
                                    <div class="spec-tag" style="position:relative; z-index:1; display:flex; align-items:center; gap:3px; font-size:0.6875rem; color:#6b7280;">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                        {{ $arac->yil }}
                                    </div>
                                    @if($arac->yakit_turu)
                                    <div class="spec-tag" style="position:relative; z-index:1; display:flex; align-items:center; gap:3px; font-size:0.6875rem; color:#6b7280; overflow:hidden;">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;"><path d="M5 22V4a1 1 0 011-1h8a1 1 0 011 1v9h2a2 2 0 012 2v3a1 1 0 01-1 1h-1"/><path d="M5 13h10"/></svg>
                                        <span style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ ucfirst($arac->yakit_turu) }}</span>
                                    </div>
                                    @endif
                                    @if($arac->vites_turu)
                                    <div class="spec-tag" style="position:relative; z-index:1; display:flex; align-items:center; gap:3px; font-size:0.6875rem; color:#6b7280; overflow:hidden;">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;"><circle cx="5" cy="7" r="2"/><circle cx="19" cy="7" r="2"/><circle cx="5" cy="17" r="2"/><path d="M5 9v6M19 9v2a4 4 0 01-4 4H8"/></svg>
                                        <span style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ ucfirst($arac->vites_turu) }}</span>
                                    </div>
                                    @endif
                                    @if($arac->kilometre)
                                    <div class="spec-tag" style="position:relative; z-index:1; display:flex; align-items:center; gap:3px; font-size:0.6875rem; color:#6b7280; white-space:nowrap;">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><path d="M12 12l-3-2"/><circle cx="12" cy="12" r="1" fill="currentColor" stroke="none"/></svg>
                                        {{ number_format($arac->kilometre, 0, ',', '.') }} km
                                    </div>
                                    @endif
                                </div>

                                {{-- Fiyat + Detay butonu --}}
                                <div class="card-footer" style="position:relative; z-index:2; display:flex; align-items:center; gap:6px;">
                                    <div class="card-price" style="position:relative; z-index:2; flex:1; background:#dc2626; color:white; padding:5px 6px; border-radius:8px; font-weight:700; font-size:0.75rem; text-align:center; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ number_format($arac->fiyat, 0, ',', '.') }} ₺
                                    </div>
                                    <div class="card-detail" style="position:relative; z-index:2; flex-shrink:0; background:#f3f4f6; color:#374151; padding:5px 8px; border-radius:8px; font-size:0.6875rem; font-weight:600; white-space:nowrap;">
                                        Detay →
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Nokta göstergesi (JS tarafından doldurulur) --}}
            <div class="flex justify-center gap-2 mt-4" id="araclarDots"></div>
        </div>
    </div>
</section>
@endif

@if(isset($servisNoktalari) && $servisNoktalari->count() > 0)
    <section class="bg-[#0a0a0a] py-8 border-t border-white/[.04] relative overflow-hidden">

        <div class="absolute inset-0 pointer-events-none"
             style="background-image:linear-gradient(rgba(204,0,0,.025) 1px,transparent 1px),
                linear-gradient(90deg,rgba(204,0,0,.025) 1px,transparent 1px);
                background-size:48px 48px;"></div>

        <div class="text-center mb-6 relative z-10">
            <div class="inline-flex items-center gap-2 mb-3">
                <div class="w-6 h-px bg-red-600 opacity-60"></div>
                <span class="text-[10px] text-red-600 font-bold tracking-[.18em] uppercase">Hizmet Ağımız</span>
                <div class="w-6 h-px bg-red-600 opacity-60"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-2">Servis Noktalarımız</h2>
            <p class="text-sm text-white/30">Türkiye genelinde güvenilir servis ağımızla yanınızdayız</p>
        </div>

        @if($servisNoktalari->count() === 1)
            @php $nokta = $servisNoktalari->first(); @endphp
            <div class="flex justify-center px-6 relative z-10">
                <div class="bg-[#111] border border-white/[.08] rounded-2xl p-5
                        flex items-center gap-4 min-w-[260px]
                        hover:border-red-600/30 hover:shadow-[0_12px_32px_rgba(0,0,0,.5)]
                        transition-all duration-300"
                     style="animation:floatCard 5s ease-in-out infinite;">
                    <div class="w-14 h-14 rounded-xl bg-[#181818] border border-white/[.06]
                            flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if($nokta->logo)
                            <img src="{{ Storage::url($nokta->logo) }}" alt="{{ $nokta->ad }}"
                                 class="w-full h-full object-contain p-2">
                        @else
                            <span class="text-red-500 font-black text-xl">
                            {{ strtoupper(substr($nokta->ad, 0, 1)) }}
                        </span>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white/90">{{ $nokta->ad }}</div>
                        <div class="flex items-center gap-2 mt-1">
                            @if($nokta->sehir)
                                <span class="text-[11px] text-white/35">{{ $nokta->sehir }}</span>
                            @endif
                            @if($nokta->sehir && $nokta->kategori)
                                <div class="w-1 h-1 rounded-full bg-white/20"></div>
                            @endif
                            @if($nokta->kategori)
                                <span class="text-[11px] text-red-500/70">{{ $nokta->kategori }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="relative z-10">
                <div class="overflow-hidden relative" id="servisMarquee" style="cursor:grab;">
                    <div class="absolute top-0 bottom-0 left-0 w-32 z-10 pointer-events-none"
                         style="background:linear-gradient(to right,#0a0a0a 20%,transparent);"></div>
                    <div class="absolute top-0 bottom-0 right-0 w-32 z-10 pointer-events-none"
                         style="background:linear-gradient(to left,#0a0a0a 20%,transparent);"></div>

                    <div class="flex gap-3 py-3 select-none" id="servisTrack" style="width:max-content;">
                        @foreach($servisNoktalari as $i => $nokta)
                            <div class="flex-shrink-0 bg-[#111] border border-white/[.08] rounded-2xl p-5
                                flex items-center gap-4 hover:border-red-600/30 transition-all duration-300"
                                 style="animation:floatCard 5s ease-in-out {{ $i * 0.4 }}s infinite;">
                                <div class="w-12 h-12 rounded-xl bg-[#181818] border border-white/[.06]
                                    flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($nokta->logo)
                                        <img src="{{ Storage::url($nokta->logo) }}" alt="{{ $nokta->ad }}"
                                             class="w-full h-full object-contain p-2">
                                    @else
                                        <span class="text-red-500 font-black text-lg">
                                    {{ strtoupper(substr($nokta->ad, 0, 1)) }}
                                </span>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-white/90 whitespace-nowrap">{{ $nokta->ad }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($nokta->sehir)
                                            <span class="text-[11px] text-white/35">{{ $nokta->sehir }}</span>
                                        @endif
                                        @if($nokta->sehir && $nokta->kategori)
                                            <div class="w-1 h-1 rounded-full bg-white/20"></div>
                                        @endif
                                        @if($nokta->kategori)
                                            <span class="text-[11px] text-red-500/70">{{ $nokta->kategori }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Sonsuz döngü için kopya --}}
                        @foreach($servisNoktalari as $nokta)
                            <div class="flex-shrink-0 bg-[#111] border border-white/[.08] rounded-2xl p-5
                                flex items-center gap-4 hover:border-red-600/30 transition-all duration-300">
                                <div class="w-12 h-12 rounded-xl bg-[#181818] border border-white/[.06]
                                    flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($nokta->logo)
                                        <img src="{{ Storage::url($nokta->logo) }}" alt="{{ $nokta->ad }}"
                                             class="w-full h-full object-contain p-2">
                                    @else
                                        <span class="text-red-500 font-black text-lg">
                                    {{ strtoupper(substr($nokta->ad, 0, 1)) }}
                                </span>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-white/90 whitespace-nowrap">{{ $nokta->ad }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($nokta->sehir)
                                            <span class="text-[11px] text-white/35">{{ $nokta->sehir }}</span>
                                        @endif
                                        @if($nokta->sehir && $nokta->kategori)
                                            <div class="w-1 h-1 rounded-full bg-white/20"></div>
                                        @endif
                                        @if($nokta->kategori)
                                            <span class="text-[11px] text-red-500/70">{{ $nokta->kategori }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <p class="text-center text-[11px] text-white/10 mt-2 tracking-widest">← sürükle →</p>
            </div>
        @endif

    </section>
@endif

{{-- ═══════════ CONTACT STRIP ═══════════ --}}
<section id="iletisim" class="bg-[#111] px-6 py-16 text-center border-t border-white/[.06]">
    <p class="text-white/40 text-xs tracking-[.1em] uppercase mb-3">Bizimle iletişime geçin</p>
    <h2 class="text-[clamp(1.75rem,4vw,2.5rem)] font-bold text-white mb-3">Sorunuz mu var?</h2>
    <p class="text-white/50 text-[.9375rem] max-w-[30rem] mx-auto mb-8">
        WhatsApp veya telefon ile bize ulaşın. Uzman ekibimiz size en kısa sürede yardımcı olsun.
    </p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="https://wa.me/905001234567?text=Merhaba%2C%20Kenan%20Auto%20hakk%C4%B1nda%20bilgi%20almak%20istiyorum."
           target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 bg-[#25d366] text-white
                      px-7 py-[.875rem] rounded-full text-[.9375rem] font-semibold
                      no-underline transition-colors duration-200 hover:bg-[#1fba59]">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            WhatsApp'tan Yaz
        </a>
        <a href="tel:+905001234567"
           class="inline-flex items-center gap-2 border border-white/25 text-white
                      px-7 py-[.875rem] rounded-full text-[.9375rem] font-medium
                      no-underline transition-[border-color,background] duration-200
                      hover:border-white/50 hover:bg-white/[.05]">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z"/>
            </svg>
            Hemen Ara
        </a>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-[#0a0a0a] px-6 py-6 text-center border-t border-white/[.04]">
    <p class="text-white/25 text-[.8125rem]">&copy; {{ date('Y') }} Kenan Auto. Tüm hakları saklıdır.</p>
</footer>

{{-- ═══════════ WHATSAPP FAB ═══════════ --}}
<a id="whatsapp-fab"
   href="https://wa.me/905001234567?text=Merhaba%2C%20Kenan%20Auto%20hakk%C4%B1nda%20bilgi%20almak%20istiyorum."
   target="_blank" rel="noopener noreferrer"
   aria-label="WhatsApp ile iletişime geçin"
   class="group fixed bottom-6 right-6 z-[200]
              flex items-center bg-[#25d366] rounded-full text-white no-underline overflow-hidden
              shadow-[0_6px_24px_rgba(37,211,102,.4)]
              transition-[box-shadow,transform] duration-300
              hover:shadow-[0_10px_32px_rgba(37,211,102,.55)] hover:scale-[1.05]">
        <span class="max-w-0 group-hover:max-w-[10rem] overflow-hidden whitespace-nowrap
                     text-sm font-semibold
                     transition-[max-width,padding] duration-[450ms]
                     group-hover:pl-[1.125rem]">WhatsApp'tan Yaz</span>
    <div class="w-[3.25rem] h-[3.25rem] flex items-center justify-center shrink-0">
        <svg width="26" height="26" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </div>
</a>

<script>
    (function () {
        'use strict';

        var header      = document.getElementById('site-header');
        var heroOverlay = document.getElementById('hero-overlay');
        var heroContent = document.getElementById('hero-content');
        var heroStage   = document.getElementById('hero-stage');

        function updateHero() {
            var scrollY  = window.scrollY;
            var vh       = window.innerHeight;
            var progress = Math.max(0, Math.min(1, scrollY / (vh * 1.8)));

            // Header
            header.classList.toggle('scrolled', scrollY > 40);

            // Araba 3D animasyonu
            var carLayer = document.getElementById('car-layer');
            var tx = progress * 130;
            var tz = -(progress * 400);
            var ry = -(progress * 28);
            var sc = 1 - progress * 0.45;
            carLayer.style.transform =
                'perspective(1000px) translateX(' + tx.toFixed(1) + '%) ' +
                'translateZ(' + tz.toFixed(0) + 'px) ' +
                'rotateY(' + ry.toFixed(1) + 'deg) ' +
                'scale(' + sc.toFixed(3) + ')';

            // Hero overlay solar ve pointer events kapanır
            heroOverlay.style.opacity = Math.max(0, 1 - progress * 1.5).toFixed(3);
            heroOverlay.style.pointerEvents = (progress >= 0.6) ? 'none' : '';
            heroContent.style.pointerEvents = (progress >= 0.6) ? 'none' : '';

            // Hero metin solar
            var fade = Math.max(0, 1 - progress * 2.2);
            heroContent.style.opacity   = fade;
            heroContent.style.transform = 'translateY(' + (-progress * 40).toFixed(1) + 'px)';
        }

        window.addEventListener('scroll', updateHero, { passive: true });
        updateHero();

        // Hamburger
        var hamburger  = document.getElementById('hamburger');
        var mobileMenu = document.getElementById('mobile-menu');
        hamburger.addEventListener('click', function () {
            var isOpen = mobileMenu.classList.toggle('open');
            hamburger.classList.toggle('open', isOpen);
            hamburger.setAttribute('aria-expanded', isOpen);
        });
        mobileMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                mobileMenu.classList.remove('open');
                hamburger.classList.remove('open');
                hamburger.setAttribute('aria-expanded', 'false');
            });
        });

        // Araç Bul / Aracını Sat butonları — yavaş scroll
        document.querySelectorAll('a[href="#panels"]').forEach(function (a) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                var start    = window.scrollY;
                var target   = window.innerHeight * 1.85;
                var duration = 1200;
                var startTime = null;

                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    var elapsed = timestamp - startTime;
                    var prog = Math.min(elapsed / duration, 1);
                    var ease = prog < 0.5 ? 2*prog*prog : -1+(4-2*prog)*prog;
                    window.scrollTo(0, start + (target - start) * ease);
                    if (prog < 1) {
                        requestAnimationFrame(step);
                    }
                }
                requestAnimationFrame(step);
            });
        });

    }());

    // Panel genişleme efekti
    function setPanel(side) {
        document.getElementById('panel-buy').classList.remove('active');
        document.getElementById('panel-sell').classList.remove('active');
        document.getElementById('panel-' + side).classList.add('active');
    }

    // Sayfa açılınca Araç Al aktif
    setPanel('buy');


    // Öne çıkan araçlar — otomatik slider (transform tabanlı)
    (function(){
        var viewport = document.getElementById('araclarSlider');
        var track    = document.getElementById('araclarTrack');
        var dotsEl   = document.getElementById('araclarDots');
        if(!viewport || !track) return;

        var cards = Array.prototype.slice.call(track.querySelectorAll('.arac-card'));
        var total = cards.length;
        if(!total) return;

        var GAP          = 16;
        var currentIndex = 0;
        var perPage      = 1;
        var timer        = null;

        function getPerPage() { return window.innerWidth >= 768 ? 3 : 1; }

        function setupCards() {
            perPage = getPerPage();
            var w = Math.floor((viewport.clientWidth - GAP * (perPage - 1)) / perPage);
            cards.forEach(function(c) { c.style.width = w + 'px'; c.style.flexShrink = '0'; });
        }

        function totalGroups() { return Math.ceil(total / perPage); }

        function buildDots() {
            if(!dotsEl) return;
            dotsEl.innerHTML = '';
            var n = totalGroups();
            for(var i = 0; i < n; i++) {
                var btn = document.createElement('button');
                btn.style.cssText = 'height:8px; width:8px; border-radius:999px; background:#d1d5db; border:none; padding:0; cursor:pointer; transition:all 0.3s ease; display:inline-block;';
                btn.setAttribute('aria-label', 'Grup ' + (i + 1));
                (function(g) {
                    btn.addEventListener('click', function() { goTo(g * perPage); });
                })(i);
                dotsEl.appendChild(btn);
            }
        }

        function updateDots() {
            if(!dotsEl) return;
            var group = Math.floor(currentIndex / perPage);
            var btns  = dotsEl.querySelectorAll('button');
            btns.forEach(function(b, i) {
                b.style.background = (i === group) ? '#dc2626' : '#d1d5db';
                b.style.width      = (i === group) ? '20px'   : '8px';
            });
        }

        function goTo(idx) {
            currentIndex = ((idx % total) + total) % total;
            var cardW = Math.floor((viewport.clientWidth - GAP * (perPage - 1)) / perPage);
            track.style.transform = 'translateX(-' + currentIndex * (cardW + GAP) + 'px)';
            updateDots();
        }

        function next() {
            if(currentIndex >= total - 1) {
                // Sona gelince animasyonsuz sıfırla, sonra devam
                track.style.transition = 'none';
                goTo(0);
                track.getBoundingClientRect(); // reflow zorla
                track.style.transition = 'transform 0.5s cubic-bezier(0.4,0,0.2,1)';
            } else {
                goTo(currentIndex + 1);
            }
        }

        function startTimer() { if(!timer) timer = setInterval(next, 4000); }
        function stopTimer()  { clearInterval(timer); timer = null; }

        viewport.addEventListener('mouseenter', stopTimer);
        viewport.addEventListener('mouseleave', startTimer);

        var resizeT;
        window.addEventListener('resize', function() {
            clearTimeout(resizeT);
            resizeT = setTimeout(function() {
                track.style.transition = 'none';
                setupCards();
                buildDots();
                goTo(0);
                track.getBoundingClientRect();
                track.style.transition = 'transform 0.5s cubic-bezier(0.4,0,0.2,1)';
                startTimer();
            }, 200);
        });

        // İlk yükleme
        setupCards();
        buildDots();
        goTo(0);
        startTimer();
    }());

    // Servis noktaları marquee — sadece birden fazla kayıt varsa çalışır
    (function(){
        var outer = document.getElementById('servisMarquee');
        var track = document.getElementById('servisTrack');
        if(!outer || !track) return; // Tek kayıt veya boşsa çık

        var SPEED = 0.5, pos = 0, halfW = 0;
        var isDrag = false, startX = 0, startPos = 0;
        var velX = 0, lastX = 0, lastT = 0;

        function init(){ halfW = track.scrollWidth / 2; loop(); }

        function loop(){
            requestAnimationFrame(loop);
            if(isDrag) return;
            if(Math.abs(velX) > 0.1){ pos += velX; velX *= 0.94; }
            else { velX = 0; pos -= SPEED; }
            if(pos <= -halfW) pos += halfW;
            if(pos > 0) pos -= halfW;
            track.style.transform = 'translateX(' + pos + 'px)';
        }

        function dragStart(x){
            isDrag = true; startX = x; startPos = pos;
            velX = 0; lastX = x; lastT = Date.now();
            outer.style.cursor = 'grabbing';
        }
        function dragMove(x){
            if(!isDrag) return;
            var now = Date.now(), dt = now - lastT;
            if(dt > 0) velX = (x - lastX) / dt * 16;
            lastX = x; lastT = now;
            pos = startPos + (x - startX);
            if(pos <= -halfW) pos += halfW;
            if(pos > 0) pos -= halfW;
            track.style.transform = 'translateX(' + pos + 'px)';
        }
        function dragEnd(){ isDrag = false; outer.style.cursor = 'grab'; }

        outer.addEventListener('mousedown', function(e){ dragStart(e.clientX); e.preventDefault(); });
        document.addEventListener('mousemove', function(e){ dragMove(e.clientX); });
        document.addEventListener('mouseup', dragEnd);
        outer.addEventListener('touchstart', function(e){ dragStart(e.touches[0].clientX); }, {passive:true});
        outer.addEventListener('touchmove', function(e){ dragMove(e.touches[0].clientX); }, {passive:true});
        outer.addEventListener('touchend', dragEnd);

        init();
    }());
</script>

</body>
</html>
