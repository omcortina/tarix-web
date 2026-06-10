<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('privacidad.page_title') }}</title>
    <meta name="description" content="{{ __('privacidad.meta_desc') }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/privacidad') }}" />
    <link rel="alternate" hreflang="es" href="{{ url('/privacidad') }}" />
    <link rel="alternate" hreflang="en" href="{{ url('/privacidad') }}" />
    <link rel="alternate" hreflang="x-default" href="{{ url('/privacidad') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        .privacy-hero {
            background: #001B30;
            padding: 100px 24px 60px;
            text-align: center;
        }
        .privacy-hero h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
        }
        .privacy-hero p {
            color: rgba(255,255,255,0.65);
            font-size: 15px;
        }
        .privacy-body {
            max-width: 820px;
            margin: 0 auto;
            padding: 60px 24px 80px;
        }
        .privacy-body h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #001B30;
            margin: 40px 0 12px;
            border-left: 4px solid #1D9E75;
            padding-left: 14px;
        }
        .privacy-body h2:first-child {
            margin-top: 0;
        }
        .privacy-body p, .privacy-body li {
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            line-height: 1.75;
            color: #4D4D4D;
        }
        .privacy-body ul {
            margin: 10px 0 10px 20px;
        }
        .privacy-body a {
            color: #1D9E75;
            text-decoration: underline;
        }
        .privacy-updated {
            display: inline-block;
            font-size: 12px;
            background: #eaf5f0;
            color: #1D9E75;
            padding: 4px 12px;
            border-radius: 20px;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #1D9E75;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav>
        <a href="/" class="nav-logo">
            <div class="logo-text">
                <img src="{{ asset('img/logo.png') }}" alt="Comercio Internacional">
                <span class="logo-sub">{{ __('app.soluciones') }}</span>
            </div>
        </a>

        <!-- Hamburger Menu Button -->
        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="nav-links" id="navMenu">
            <a href="/#inicio">{{ __('app.inicio') }}</a>
            <a href="/#nosotros">{{ __('app.nosotros') }}</a>
            <a href="/#servicios">{{ __('app.servicios') }}</a>
            <a href="/blog">{{ __('app.blog') }}</a>
            <a href="/#recursos">{{ __('app.recursos') }}</a>
            <a href="/#contacto">{{ __('app.contacto') }}</a>
            <a href="{{ route('login') }}" class="nav-cta">{{ __('app.login') }}</a>
            <div class="language-selector">
                <a href="{{ route('lang.set', 'es') }}" class="lang-btn {{ app()->getLocale() === 'es' ? 'active' : '' }}">ES</a>
                <a href="{{ route('lang.set', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <div class="privacy-hero">
        <h1>{{ __('privacidad.hero_title') }}</h1>
        <p>{{ __('privacidad.hero_subtitle') }}</p>
    </div>

    <!-- CONTENT -->
    <div class="privacy-body">
        <a href="/" class="back-link">{{ __('privacidad.back_link') }}</a>
        <span class="privacy-updated">{{ __('privacidad.last_updated') }} {{ date('d/m/Y') }}</span>

        <h2>{{ __('privacidad.s1_title') }}</h2>
        <p>
            <strong>TARIX S.A.S.</strong> — NIT: 900.XXX.XXX-X<br>
            Cartagena, Colombia<br>
            {{ __('privacidad.s1_body') }} <a href="mailto:gerenciacomercial@tarix.com.co">gerenciacomercial@tarix.com.co</a><br>
            {{ __('privacidad.s1_phone') }} +57 302 467 4923
        </p>

        <h2>{{ __('privacidad.s2_title') }}</h2>
        <p>{{ __('privacidad.s2_intro') }}</p>
        <ul>
            <li>{{ __('privacidad.s2_item1') }}</li>
            <li>{{ __('privacidad.s2_item2') }}</li>
            <li>{{ __('privacidad.s2_item3') }}</li>
            <li>{{ __('privacidad.s2_item4') }}</li>
        </ul>

        <h2>{{ __('privacidad.s3_title') }}</h2>
        <p>{{ __('privacidad.s3_intro') }}</p>
        <ul>
            <li>{{ __('privacidad.s3_item1') }}</li>
            <li>{{ __('privacidad.s3_item2') }}</li>
            <li>{{ __('privacidad.s3_item3') }}</li>
            <li>{{ __('privacidad.s3_item4') }}</li>
            <li>{{ __('privacidad.s3_item5') }}</li>
        </ul>

        <h2>{{ __('privacidad.s4_title') }}</h2>
        <p>
            {!! __('privacidad.s4_body', [
                'law1' => '<strong>Ley 1581 de 2012</strong>',
                'law2' => '<strong>Decreto 1377 de 2013</strong>',
            ]) !!}
        </p>

        <h2>{{ __('privacidad.s5_title') }}</h2>
        <p>{{ __('privacidad.s5_intro') }}</p>
        <ul>
            <li>{{ __('privacidad.s5_item1') }}</li>
            <li>{{ __('privacidad.s5_item2') }}</li>
            <li>{{ __('privacidad.s5_item3') }}</li>
            <li>{{ __('privacidad.s5_item4') }}</li>
            <li>{{ __('privacidad.s5_item5') }}</li>
        </ul>

        <h2>{{ __('privacidad.s6_title') }}</h2>
        <p>{{ __('privacidad.s6_body') }}</p>

        <h2>{{ __('privacidad.s7_title') }}</h2>
        <p>{{ __('privacidad.s7_body') }}</p>

        <h2>{{ __('privacidad.s8_title') }}</h2>
        <p>{{ __('privacidad.s8_body') }}</p>

        <h2>{{ __('privacidad.s9_title') }}</h2>
        <p>
            {!! __('privacidad.s9_body', [
                'email' => '<a href="mailto:gerenciacomercial@tarix.com.co">gerenciacomercial@tarix.com.co</a>',
            ]) !!}
        </p>

        <h2>{{ __('privacidad.s10_title') }}</h2>
        <p>{{ __('privacidad.s10_body') }}</p>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-top">
            <div class="footer-brand">
                <div class="nav-logo" style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <div class="logo-text">
                        <img src="{{ asset('img/logo.png') }}" alt="Comercio Internacional">
                        <span class="logo-sub">{{ __('app.soluciones') }}</span>
                    </div>
                </div>
                <p>{{ __('privacidad.footer_experts') }}</p>
            </div>
            <div class="footer-col">
                <h4>{{ __('privacidad.footer_nav') }}</h4>
                <a href="/">{{ __('app.inicio') }}</a>
                <a href="/#nosotros">{{ __('app.nosotros') }}</a>
                <a href="/#servicios">{{ __('app.servicios') }}</a>
                <a href="/blog">{{ __('app.blog') }}</a>
                <a href="/#contacto">{{ __('app.contacto') }}</a>
            </div>
            <div class="footer-col">
                <h4>{{ __('privacidad.footer_legal') }}</h4>
                <a href="/privacidad">{{ __('privacidad.footer_privacy') }}</a>
            </div>
            <div class="footer-col">
                <h4>{{ __('privacidad.footer_contact') }}</h4>
                <div class="footer-contact-item">
                    <span>gerenciacomercial@tarix.com.co</span>
                </div>
                <div class="footer-contact-item">
                    <span>+57 302 467 4923</span>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-legal">
            <span>{{ __('privacidad.footer_legal_row') }}</span>
            <a href="/privacidad">{{ __('privacidad.footer_privacy') }}</a>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} TARIX | {{ __('app.soluciones') }}. {{ __('privacidad.footer_rights') }}</span>
            <span>{{ __('privacidad.footer_colombia') }}</span>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const navMenu = document.getElementById('navMenu');

            hamburgerBtn.addEventListener('click', function() {
                hamburgerBtn.classList.toggle('active');
                navMenu.classList.toggle('open');
            });

            document.addEventListener('click', function(e) {
                if (!hamburgerBtn.contains(e.target) && !navMenu.contains(e.target)) {
                    hamburgerBtn.classList.remove('active');
                    navMenu.classList.remove('open');
                }
            });
        });
    </script>

</body>
</html>
