<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('app.title') }}</title>
    <meta name="description" content="{{ __('app.meta_desc') }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}" />
    <link rel="alternate" hreflang="es" href="{{ url('/') }}" />
    <link rel="alternate" hreflang="en" href="{{ url('/') }}" />
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Global Alert for Errors/Success -->
    @if (session('error'))
        <div class="global-alert alert-error" style="position: fixed; top: 20px; right: 20px; background: #fff5f5; color: #c53030; padding: 16px 20px; border-radius: 8px; border-left: 4px solid #ef5350; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 9999; max-width: 400px; animation: slideIn 0.3s ease;">
            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        <style>
            @keyframes slideIn {
                from { transform: translateX(450px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes fadeOut {
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(450px); }
            }
            .global-alert.fade-out {
                animation: fadeOut 0.3s ease forwards;
            }
        </style>
    @endif

    @if (session('success'))
        <div class="global-alert alert-success" style="position: fixed; top: 20px; right: 20px; background: #f0fff4; color: #22863a; padding: 16px 20px; border-radius: 8px; border-left: 4px solid #85e89d; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 9999; max-width: 400px; animation: slideIn 0.3s ease;">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- NAV -->
    <nav>
        <a href="#" class="nav-logo">
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
            <a href="#inicio">{{ __('app.inicio') }}</a>
            <a href="#nosotros">{{ __('app.nosotros') }}</a>
            <a href="#servicios">{{ __('app.servicios') }}</a>
            <a href="/blog">{{ __('app.blog') }}</a>
            <a href="#recursos">{{ __('app.recursos') }}</a>
            <a href="#contacto">{{ __('app.contacto') }}</a>
            <a href="{{ route('login') }}" class="nav-cta">{{ __('app.login') }}</a>
            <div class="language-selector">
                <a href="{{ route('lang.set', 'es') }}" class="lang-btn {{ app()->getLocale() === 'es' ? 'active' : '' }}">ES</a>
                <a href="{{ route('lang.set', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" id="inicio">
        <img src="{{ asset('img/img-index.png') }}" alt="Comercio Internacional" class="hero-image">
        <div class="hero-content">
            <div class="hero-tag">{{ __('app.expertos') }}</div>
            <h1>{{ __('app.titulo_hero') }} <span>{{ __('app.operacion_internacional') }}</span></h1>
            <p>{{ __('app.descripcion_hero') }}</p>
            <div class="hero-btns">
                <a href="#contacto" class="btn-primary">{{ __('app.contactanos') }}</a>
            </div>
        </div>
    </section>

    <!-- STATS BAR -->
    <div class="stats-bar">
        <div class="stat">
            <div class="stat-num">{{ __('app.stat_years') }}</div>
            <div class="stat-label">{{ __('app.years_experience') }}</div>
        </div>
        <div class="stat">
            <div class="stat-num">{{ __('app.stat_companies') }}</div>
            <div class="stat-label">{{ __('app.companies_advised') }}</div>
        </div>
        <div class="stat">
            <div class="stat-num">{{ __('app.stat_classifications') }}</div>
            <div class="stat-label">{{ __('app.classifications') }}</div>
        </div>
        <div class="stat">
            <div class="stat-num">{{ __('app.stat_committed') }}</div>
            <div class="stat-label">{{ __('app.committed_to_you') }}</div>
        </div>
    </div>

    <!-- VALUES -->
    <section class="values reveal" id="nosotros">
        <div class="values-header">
            <div class="section-label">{{ __('app.por_que_elegirnos') }}</div>
            <h2 class="section-title">
                {{ __('app.nuestros_valores_line1') }}<br>
                <span class="title-teal">{{ __('app.nuestros_valores_line2') }}</span>
            </h2>
            <p class="section-desc">{{ __('app.trabajamos_altos_estandares') }}</p>
            @auth
                <a href="{{ route('admin.values.index') }}" style="margin-top: 20px; display: inline-block; padding: 10px 20px; background: #22c5bc; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600;">
                    {{ __('app.gestionar_valores') }}
                </a>
            @endauth
        </div>

        <div class="values-grid">
            @forelse($values as $index => $value)
                <div class="value-card card-{{ $index + 1 }}">
                    <div class="value-card-top">
                        <div class="value-icon" style="background-color: {{ $value->icon_color }}; border-radius: 50%; width: 54px; height: 54px; display: flex; align-items: center; justify-content: center;">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 32px; height: 32px;">
                                {!! $value->icon_svg !!}
                            </svg>
                        </div>
                        <div class="value-card-number" style="color: {{ $value->icon_color }};">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <h3 class="value-name">{{ $value->getTranslation('name', app()->getLocale()) }}</h3>
                    <div class="value-divider" style="background-color: {{ $value->icon_color }};"></div>
                    <p class="value-desc">{{ $value->getTranslation('description', app()->getLocale()) }}</p>
                </div>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; color: #999; padding: 40px;">
                    No hay valores disponibles en este momento.
                </p>
            @endforelse
        </div>

        <!-- Commitment Banner -->
        <div class="values-commitment">
            <div class="values-commitment-content">
                <h3>{{ __('app.value_commitment_name') }}</h3>
                <p>{{ __('app.value_commitment_desc') }}</p>
            </div>
            <a href="https://wa.me/573003216903" class="btn-commitment">{{ __('app.value_commitment_btn') }} →</a>
        </div>
    </section>

    <!-- SERVICES -->
    <section class="services reveal" id="servicios">
        <div class="services-header">
            <div class="section-label">{{ __('app.lo_que_ofrecemos') }}</div>
            <h2 class="section-title">{{ __('app.nuestros_servicios') }}</h2>
            <p class="section-desc">{{ __('app.soluciones_especializadas') }}</p>
            @auth
                <a href="{{ route('admin.services.index') }}" style="margin-top: 20px; display: inline-block; padding: 10px 20px; background: #22c5bc; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600;">
                    {{ __('app.gestionar_servicios') }}
                </a>
            @endauth
        </div>
        <div class="services-grid">
            @forelse ($services as $service)
                <a href="/{{ $service->slug }}" class="service-card" style="text-decoration: none; color: inherit; display: block;">
                    <div class="service-icon {{ $service->icon_class ?? 'icon-classification' }}">
                        @php
                            $icon = $service->icon();
                        @endphp
                        @if($icon && $icon->svg)
                            {!! $icon->svg !!}
                        @else
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M8 9L16 9M8 13L13 13M8 17L12 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        @endif
                    </div>
                    <div class="service-title">{{ $service->title }}</div>
                    <p class="service-desc">{{ Str::limit($service->subtitle, 120) }}</p>
                </a>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; color: #999; padding: 40px;">
                    No hay servicios disponibles en este momento.
                </p>
            @endforelse
        </div>
    </section>

    <!-- WHY TARIX -->
    <section class="why reveal" id="recursos">
        <div class="why-inner">
            <div class="why-left">
                <div class="section-label">{{ __('app.nuestro_enfoque') }}</div>
                <h2 class="section-title" style="color:white">{{ __('app.por_que_elegir_tarix') }}</h2>
                <p class="section-desc">{{ __('app.combinamos_expertise') }}
                    {{ __('app.soluciones_reales') }}</p>
                <div class="why-list">
                    <div class="why-item">
                        <div class="why-check">✓</div>
                        <div>
                            <div class="why-item-title">{{ __('app.why_item_1_title') }}</div>
                            <div class="why-item-desc">{{ __('app.why_item_1_desc') }}</div>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-check">✓</div>
                        <div>
                            <div class="why-item-title">{{ __('app.why_item_2_title') }}</div>
                            <div class="why-item-desc">{{ __('app.why_item_2_desc') }}</div>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-check">✓</div>
                        <div>
                            <div class="why-item-title">{{ __('app.why_item_3_title') }}</div>
                            <div class="why-item-desc">{{ __('app.why_item_3_desc') }}</div>
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-check">✓</div>
                        <div>
                            <div class="why-item-title">{{ __('app.why_item_4_title') }}</div>
                            <div class="why-item-desc">{{ __('app.why_item_4_desc') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="why-right">
                <div class="why-metric">
                    <div class="why-metric-num">{{ __('app.stat_years') }}</div>
                    <div class="why-metric-label">{{ __('app.why_metric_years') }}</div>
                </div>
                <div class="why-metric">
                    <div class="why-metric-num">{{ __('app.stat_companies') }}</div>
                    <div class="why-metric-label">{{ __('app.why_metric_companies') }}</div>
                </div>
                <div class="why-metric">
                    <div class="why-metric-num">+1K</div>
                    <div class="why-metric-label">{{ __('app.why_metric_classifications') }}</div>
                </div>
                <div class="why-metric">
                    <div class="why-metric-num">{{ __('app.stat_committed') }}</div>
                    <div class="why-metric-label">{{ __('app.why_metric_committed') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIOS -->
    <section class="testimonials reveal" id="testimonios">
        <div class="testimonials-inner">
            <div class="section-label">Clientes</div>
            <h2 class="section-title">Lo que dicen nuestros clientes</h2>
            <p class="section-desc">Empresas que confían en TARIX para optimizar su comercio exterior.</p>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-quote-icon">&ldquo;</div>
                    <p class="testimonial-text">Gracias a TARIX logramos clasificar correctamente toda nuestra mercancía y evitamos sobrecostos en aduanas. Su equipo es muy profesional y responde rápido.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">M</div>
                        <div>
                            <strong>Marcela Gómez</strong>
                            <span>Gerente de Logística — ImportaCol S.A.S.</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-quote-icon">&ldquo;</div>
                    <p class="testimonial-text">El proceso de registro INVIMA para nuestros productos fue mucho más ágil de lo esperado. TARIX conoce cada detalle normativo y eso marca la diferencia.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">J</div>
                        <div>
                            <strong>Julián Herrera</strong>
                            <span>Director Comercial — TechMed Colombia</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-quote-icon">&ldquo;</div>
                    <p class="testimonial-text">Llevamos más de dos años trabajando con TARIX y no cambiaríamos el apoyo que nos brindan. Siempre dispuestos a resolver dudas y orientarnos ante cambios de regulación.</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">A</div>
                        <div>
                            <strong>Adriana Montoya</strong>
                            <span>Coordinadora de Comercio Exterior — Grupo Andino</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT -->
    <section class="contact reveal" id="contacto">
        <div class="contact-inner">

            <!-- LEFT: info panel -->
            <div class="contact-left">
                <div class="section-label">{{ __('app.escribenos') }}</div>
                <h2 class="section-title contact-title">{{ __('app.contactanos') }}</h2>
                <p class="contact-desc">{{ __('app.dudas_comercio') }} {{ __('app.contact_text_end') }}</p>

                <div class="contact-info-list">
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 7L12 12.5L21 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 5H20C21.1 5 22 5.9 22 7V17C22 18.1 21.1 19 20 19H4C2.9 19 2 18.1 2 17V7C2 5.9 2.9 5 4 5Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </div>
                        <div>
                            <div class="contact-info-label">Email</div>
                            <a href="mailto:gerenciacomercial@tarix.com.co" class="contact-info-value">gerenciacomercial@tarix.com.co</a>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.014 8.008C6.014 8.008 8.006 12.49 10.886 15.375C13.766 18.26 18.25 20.248 18.25 20.248L20.5 18C20.5 18 21.5 17 20.5 15.5L17.5 13C16.5 12 15.5 12.5 15.5 12.5L13.5 14C13.5 14 11 12.5 9.5 11C8 9.5 6.5 7 6.5 7L8 5C8 5 8.5 4 7.5 3L5 0C3.5-1 2.5 0 2.5 0L0.252 2.252C0.252 2.252 2.014 4.008 6.014 8.008Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" transform="translate(1.5 1.5)"/>
                            </svg>
                        </div>
                        <div>
                            <div class="contact-info-label">WhatsApp</div>
                            <a href="https://wa.me/573003216903" target="_blank" rel="noopener noreferrer" class="contact-info-value">+57 300 321 6903</a>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M2 12H22M12 2C14 5 14 8.5 14 12C14 15.5 14 19 12 22M12 2C10 5 10 8.5 10 12C10 15.5 10 19 12 22" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </div>
                        <div>
                            <div class="contact-info-label">Web</div>
                            <a href="https://tarix.com.co" target="_blank" rel="noopener noreferrer" class="contact-info-value">tarix.com.co</a>
                        </div>
                    </div>
                </div>

                <div class="contact-divider"></div>
                <p class="contact-tagline">Respondemos en menos de 24 horas hábiles.</p>
            </div>

            <!-- RIGHT: form card -->
            <div class="contact-right">
                <div class="contact-card">
                    <form id="contactForm" class="contact-form">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('app.form_label_name') }}</label>
                            <input type="text" id="name" name="name" placeholder="{{ __('app.form_placeholder_name') }}" required class="form-input">
                            <span class="form-error" id="nameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="company">{{ __('app.form_label_company') }}</label>
                            <input type="text" id="company" name="company" placeholder="{{ __('app.form_placeholder_company') }}" class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('app.form_label_email') }}</label>
                            <input type="email" id="email" name="email" placeholder="{{ __('app.form_placeholder_email') }}" required class="form-input">
                            <span class="form-error" id="emailError"></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('app.form_label_phone') }}</label>
                            <input type="tel" id="phone" name="phone" placeholder="{{ __('app.form_placeholder_phone') }}" class="form-input">
                        </div>
                        <div class="form-group full">
                            <label for="message">{{ __('app.form_label_message') }}</label>
                            <textarea id="message" name="message" placeholder="{{ __('app.form_placeholder_message') }}" required class="form-input"></textarea>
                            <span class="form-error" id="messageError"></span>
                        </div>

                        <!-- reCAPTCHA v3 (invisible) -->
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                    </form>
                    <div class="form-submit">
                        <button type="submit" form="contactForm" class="btn-primary btn-contact-submit" id="submitBtn">{{ __('app.form_submit_btn') }}</button>
                    </div>

                    <!-- Mensajes de estado -->
                    <div id="successMessage" class="alert alert-success" style="display:none; margin-top: 20px;">
                        {{ __('app.form_success_message') }}
                    </div>
                    <div id="errorMessage" class="alert alert-error" style="display:none; margin-top: 20px;"></div>
                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-top">
            <div class="footer-brand">
                <div class="nav-logo" style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <div class="logo-text">
                        <img src="{{ asset('img/logo.png') }}" alt="Comercio Internacional">
                        <div style="font-size:8px;color:#1D9E75;letter-spacing:1.5px;text-transform:uppercase;">
                            {{ __('app.soluciones') }}</div>
                    </div>
                </div>
                <p>{{ __('app.footer_expertos') }}</p>
            </div>
            <div class="footer-col">
                <h4>{{ __('app.footer_navegacion') }}</h4>
                <a href="#inicio">{{ __('app.inicio') }}</a>
                <a href="#nosotros">{{ __('app.nosotros') }}</a>
                <a href="#servicios">{{ __('app.servicios') }}</a>
                <a href="/blog">{{ __('app.blog') }}</a>
                <a href="#recursos">{{ __('app.recursos') }}</a>
                <a href="#contacto">{{ __('app.contacto') }}</a>
            </div>
            <div class="footer-col">
                <h4>{{ __('app.footer_servicios') }}</h4>
                @forelse($services->where('show_in_footer', true) as $service)
                    <a href="/{{ $service->slug }}">{{ $service->title }}</a>
                @empty
                    <p style="font-size: 12px; color: #999;">{{ __('app.no_servicios') }}</p>
                @endforelse
            </div>
            <div class="footer-col">
                <h4>{{ __('app.footer_contacto') }}</h4>
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
                    <a href="mailto:gerenciacomercial@tarix.com.co">gerenciacomercial@tarix.com.co</a>
                </div>
                <div class="footer-contact-item">
                    <span class="footer-icon icon-phone">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 10.5V7C17 5.9 16.1 5 15 5H9C7.9 5 7 5.9 7 7V17C7 18.1 7.9 19 9 19H15C16.1 19 17 18.1 17 17V13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M9.5 8H14.5M9.5 15H14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span>+57 300 321 6903</span>
                </div>
                <div class="footer-contact-item">
                    <span class="footer-icon icon-linkedin">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 8C3 6.9 3.9 6 5 6H19C20.1 6 21 6.9 21 8V20C21 21.1 20.1 22 19 22H5C3.9 22 3 21.1 3 20V8Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                            <path d="M7 11V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M7 8.5C7 9.32843 6.32843 10 5.5 10C4.67157 10 4 9.32843 4 8.5C4 7.67157 4.67157 7 5.5 7C6.32843 7 7 7.67157 7 8.5Z" fill="currentColor"/>
                            <path d="M11 17V11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M11 11.5C11 10.1193 12.1193 9 13.5 9C14.8807 9 16 10.1193 16 11.5V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <a href="https://www.linkedin.com/in/jeison-ruiz">Jeison Ruiz</a>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-legal">
            <span>NIT: 902079556-5 &nbsp;&middot;&nbsp; Cartagena, Colombia &nbsp;&middot;&nbsp; Lun &ndash; Vie: 8:00 a.m. &ndash; 6:00 p.m.</span>
            <a href="/privacidad">{{ __('privacidad.footer_privacy') }}</a>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} TARIX | Soluciones en Comercio Exterior. Todos los derechos reservados.</span>
            <span>Hecho en Colombia</span>
        </div>
    </footer>

    <!-- WHATSAPP FLOATING BUTTON -->
    <a href="https://wa.me/573003216903" class="whatsapp-float" target="_blank" rel="noopener noreferrer" title="Contáctanos por WhatsApp">
        <i class="fa fa-whatsapp" style="font-size: 32px;"></i>
    </a>

    <script>
        // Scroll reveal
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.12
        });
        reveals.forEach(el => observer.observe(el));

        // Smooth nav active state
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            nav.style.boxShadow = window.scrollY > 10 ? '0 4px 30px rgba(0,0,0,.4)' : '0 2px 20px rgba(0,0,0,.3)';
        });

        // Contact form logic
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');

        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Ejecutar reCAPTCHA
            grecaptcha.ready(() => {
                grecaptcha.execute('{{ config("recaptcha.site_key") }}', { action: 'submit' })
                    .then(token => {
                        console.log('reCAPTCHA token generado:', token.substring(0, 50) + '...');
                        document.getElementById('g-recaptcha-response').value = token;
                        enviarFormulario();
                    })
                    .catch(error => {
                        console.error('reCAPTCHA error:', error);
                        mostrarError('Error con reCAPTCHA. Por favor, recarga la página.');
                    });
            });
        });

        function enviarFormulario() {
            if (!validarFormulario()) return;

            submitBtn.disabled = true;
            submitBtn.textContent = 'Enviando...';

            const formData = new FormData(contactForm);

            fetch('{{ route("contact.store") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Mensaje enviado!',
                        text: data.message,
                        confirmButtonColor: '#22c5bc',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            contactForm.reset();
                            limpiarErrores();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al enviar.',
                        confirmButtonColor: '#d32f2f',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'Ocurrió un error al enviar tu mensaje. Por favor intenta nuevamente.',
                    confirmButtonColor: '#d32f2f',
                    confirmButtonText: 'Aceptar'
                });
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Enviar Mensaje';
            });
        }

        function validarFormulario() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();

            limpiarErrores();
            let esValido = true;

            if (!name) {
                mostrarErrorCampo('name', 'El nombre es requerido');
                esValido = false;
            }

            if (!email || !isValidEmail(email)) {
                mostrarErrorCampo('email', 'Email válido requerido');
                esValido = false;
            }

            if (message.length < 10) {
                mostrarErrorCampo('message', 'Mínimo 10 caracteres');
                esValido = false;
            }

            return esValido;
        }

        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function limpiarErrores() {
            document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
            errorMessage.style.display = 'none';
            successMessage.style.display = 'none';
        }

        function mostrarErrorCampo(campoId, mensaje) {
            document.getElementById(campoId + 'Error').textContent = mensaje;
        }

        function mostrarExito(mensaje) {
            successMessage.textContent = mensaje;
            successMessage.style.display = 'block';
            errorMessage.style.display = 'none';
        }

        function mostrarError(mensaje) {
            errorMessage.textContent = mensaje;
            errorMessage.style.display = 'block';
            successMessage.style.display = 'none';
        }
    </script>

    <!-- reCAPTCHA v3 -->
    @if(config('recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.site_key') }}"></script>
    @else
        <script>
            console.error('RECAPTCHA_SITE_KEY no está configurado en el servidor');
            document.addEventListener('DOMContentLoaded', function() {
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Error de configuración';
                }
            });
        </script>
    @endif

    <!-- Mobile Menu Toggle -->
    <script>
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

        // Auto-hide global alerts after 2.5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.global-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('fade-out');
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 2500);
            });
        });
    </script>
</body>

</html>
