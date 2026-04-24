<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->title }} | TARIX</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <!-- NAV -->
    <nav>
        <a href="/" class="nav-logo">
            <div class="logo-icon">
                <div class="logo-t">T</div>
            </div>
            <div class="logo-text">
                <span class="logo-name">TARIX</span>
                <span class="logo-sub">{{ __('service.solutions') }}</span>
            </div>
        </a>
        
        <!-- Hamburger Menu Button -->
        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <div class="nav-links" id="navMenu">
            <a href="/#inicio">{{ __('service.home') }}</a>
            <a href="/#nosotros">{{ __('service.about') }}</a>
            <a href="/#servicios">{{ __('service.services_nav') }}</a>
            <a href="/blog">{{ __('service.news') }}</a>
            <a href="/#recursos">{{ __('service.resources') }}</a>
            <a href="/#contacto">{{ __('service.contact') }}</a>
            <a href="/#contacto" class="nav-cta">{{ __('service.contact_us') }}</a>
            <div class="language-selector">
                <a href="{{ route('lang.set', 'es') }}" class="lang-btn {{ app()->getLocale() === 'es' ? 'active' : '' }}">ES</a>
                <a href="{{ route('lang.set', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>
        </div>
    </nav>

    <!-- HERO SERVICIO -->
    <section class="hero-servicio">
        <div class="hero-servicio-bg" style="background: linear-gradient(135deg, #0d2340 0%, #1ba8a0 100%);"></div>
        <div class="hero-servicio-content">
            <div class="breadcrumb">
                <a href="/">{{ __('service.home') }}</a> / <a href="/#servicios">{{ __('service.services_nav') }}</a> / {{ $service->title }}
            </div>
            <h1>{{ $service->title }}</h1>
            <p>{{ $service->subtitle }}</p>
        </div>
    </section>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="servicio-contenido">
        <div class="servicio-inner">
            <!-- COLUMNA IZQUIERDA -->
            <div class="servicio-left">
                @if($service->what_is_section)
                    <div class="section-block">
                        <h2>{{ __('service.what_is') }} {{ $service->title }}?</h2>
                        <p>{!! nl2br(e($service->what_is_section)) !!}</p>
                    </div>
                @endif

                @if($service->process_section)
                    <div class="section-block">
                        <h2>{{ __('service.our_process') }}</h2>
                        <p>{!! nl2br(e($service->process_section)) !!}</p>
                    </div>
                @endif

                @if($service->why_section)
                    <div class="section-block">
                        <h2>{{ __('service.why_choose_us') }}</h2>
                        <p>{!! nl2br(e($service->why_section)) !!}</p>
                    </div>
                @endif
            </div>

            <!-- COLUMNA DERECHA (SIDEBAR) -->
            <aside class="servicio-sidebar">
                <div class="sidebar-box">
                    <h3>{{ __('service.need_service') }} {{ $service->title }}?</h3>
                    <p>{{ __('service.contact_today') }}</p>
                    <a href="/#contacto" class="btn-primary">{{ __('service.request_advisory') }}</a>
                </div>

                <div class="sidebar-box">
                    <h3>{{ __('service.useful_info') }}</h3>
                    @php
                        $activeResources = $service->usefulResources->where('is_active', true);
                    @endphp
                    @if($activeResources->count())
                        <ul class="info-list">
                            @foreach($activeResources as $resource)
                                <li><a href="{{ $resource->url }}" target="_blank">{{ $resource->title }}</a></li>
                            @endforeach
                        </ul>
                    @else
                        <p style="color: #666; font-size: 14px;">{{ __('service.no_resources') }}</p>
                    @endif
                </div>
            </aside>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="servicio-cta">
        <h2>{{ __('service.have_questions') }} {{ $service->title }}?</h2>
        <p>{{ __('service.our_team_ready') }}</p>
        <a href="/#contacto" class="btn-primary btn-large">{{ __('service.contact_now') }}</a>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-top">
            <div class="footer-brand">
                <div class="nav-logo" style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <div class="logo-icon">
                        <div class="logo-t">T</div>
                    </div>
                    <div>
                        <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:18px;color:#fff;letter-spacing:3px;">TARIX</div>
                        <div style="font-size:8px;color:#22c5bc;letter-spacing:1.5px;text-transform:uppercase;">{{ __('service.solutions') }}</div>
                    </div>
                </div>
                <p>{{ __('service.footer_experts') }}</p>
            </div>
            <div class="footer-col">
                <h4>{{ __('service.navigation') }}</h4>
                <a href="/#inicio">{{ __('service.home') }}</a>
                <a href="/#nosotros">{{ __('service.about') }}</a>
                <a href="/#servicios">{{ __('service.services_nav') }}</a>
                <a href="/blog">{{ __('service.news') }}</a>
                <a href="/#recursos">{{ __('service.resources') }}</a>
                <a href="/#contacto">{{ __('service.contact') }}</a>
            </div>
            <div class="footer-col">
                <h4>{{ __('service.services') }}</h4>
                @php
                    $footerServices = \App\Models\Service::where('show_in_footer', true)->where('published', true)->orderBy('id', 'asc')->get();
                @endphp
                @if($footerServices->count())
                    @foreach($footerServices as $footerService)
                        <a href="/{{ $footerService->slug }}">{{ getSpanish($footerService->title) }}</a>
                    @endforeach
                @else
                    <p style="color: #999; font-size: 14px;">{{ __('service.no_services_available') }}</p>
                @endif
            </div>
            <div class="footer-col">
                <h4>{{ __('service.footer_contact') }}</h4>
                <div class="footer-contact-item">
                    <span class="footer-icon icon-website">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M2 12H22M12 2C14 5 14 8.5 14 12C14 15.5 14 19 12 22M12 2C10 5 10 8.5 10 12C10 15.5 10 19 12 22" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </span>
                    <a href="https://tarix.com.co">tarix.com.co</a>
                </div>
                <div class="footer-contact-item">
                    <span class="footer-icon icon-email">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 7L12 12.5L21 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 5H20C21.1 5 22 5.9 22 7V17C22 18.1 21.1 19 20 19H4C2.9 19 2 18.1 2 17V7C2 5.9 2.9 5 4 5Z" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </span>
                    <a href="mailto:contacto@tarix.com.co">contacto@tarix.com.co</a>
                </div>
                <div class="footer-contact-item">
                    <span class="footer-icon icon-phone">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 10.5V7C17 5.9 16.1 5 15 5H9C7.9 5 7 5.9 7 7V17C7 18.1 7.9 19 9 19H15C16.1 19 17 18.1 17 17V13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M9.5 8H14.5M9.5 15H14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span>+57 300 000 0000</span>
                </div>
                <div class="footer-contact-item">
                    <span class="footer-icon icon-instagram">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="2" width="20" height="20" rx="4.5" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="17.5" cy="6.5" r="0.75" fill="currentColor"/>
                        </svg>
                    </span>
                    <a href="https://instagram.com/tarix-soluciones">@tarix-soluciones</a>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-bottom">
            <span>© {{ date('Y') }} TARIX | {{ __('service.solutions') }}. {{ __('service.all_rights_reserved') }}</span>
            <span>{{ __('service.made_in_colombia') }}</span>
        </div>
    </footer>

    <!-- WHATSAPP FLOATING BUTTON -->
    <a href="https://wa.me/573000000000" class="whatsapp-float" target="_blank" rel="noopener noreferrer" title="Contáctanos por WhatsApp">
        <i class="fa fa-whatsapp" style="font-size: 32px;"></i>
    </a>

    <script>
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            nav.style.boxShadow = window.scrollY > 10 ? '0 4px 30px rgba(0,0,0,.4)' : '0 2px 20px rgba(0,0,0,.3)';
        });

        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const navMenu = document.getElementById('navMenu');
            
            // Toggle menu when hamburger is clicked
            hamburgerBtn.addEventListener('click', function() {
                hamburgerBtn.classList.toggle('active');
                navMenu.classList.toggle('active');
            });
            
            // Close menu when a link is clicked
            const navLinks = navMenu.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    hamburgerBtn.classList.remove('active');
                    navMenu.classList.remove('active');
                });
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('nav')) {
                    hamburgerBtn.classList.remove('active');
                    navMenu.classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>
