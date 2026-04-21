<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('app.title') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <!-- NAV -->
    <nav>
        <a href="#" class="nav-logo">
            <div class="logo-icon">
                <div class="logo-t">T</div>
            </div>
            <div class="logo-text">
                <span class="logo-name">TARIX</span>
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
            <a href="/noticias">{{ __('app.noticias') }}</a>
            <a href="#recursos">{{ __('app.recursos') }}</a>
            <a href="#contacto">{{ __('app.contacto') }}</a>
            <a href="#contacto" class="nav-cta">{{ __('app.contactanos') }}</a>
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
                <a href="#servicios" class="btn-primary">{{ __('app.conoce_servicios') }}</a>
                <a href="#contacto" class="btn-secondary">{{ __('app.contactanos') }}</a>
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
        <div class="section-label">{{ __('app.por_que_elegirnos') }}</div>
        <h2 class="section-title">{{ __('app.nuestros_valores') }}</h2>
        <p class="section-desc">{{ __('app.trabajamos_altos_estandares') }}</p>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon icon-precision">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="6" stroke="currentColor" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="2" fill="currentColor"/>
                    </svg>
                </div>
                <div class="value-name">{{ __('app.value_precision_name') }}</div>
                <div class="value-desc">{{ __('app.value_precision_desc') }}</div>
            </div>
            <div class="value-card">
                <div class="value-icon icon-security">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L4 5.5V11C4 17 12 22 12 22S20 17 20 11V5.5L12 2Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <path d="M10 12L11.5 13.5L14 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="value-name">{{ __('app.value_security_name') }}</div>
                <div class="value-desc">{{ __('app.value_security_desc') }}</div>
            </div>
            <div class="value-card">
                <div class="value-icon icon-experience">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M7 9.5C7.8 8.5 9.3 7.5 12 7.5C14.7 7.5 16.2 8.5 17 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <circle cx="9" cy="11" r="0.8" fill="currentColor"/>
                        <circle cx="15" cy="11" r="0.8" fill="currentColor"/>
                        <path d="M8.5 15.5C9.5 17 10.8 18 12 18C13.2 18 14.5 17 15.5 15.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="value-name">{{ __('app.value_experience_name') }}</div>
                <div class="value-desc">{{ __('app.value_experience_desc') }}</div>
            </div>
            <div class="value-card">
                <div class="value-icon icon-efficiency">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 20H21V4M5 16L9 12L12 14L19 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="19" cy="8" r="1.5" fill="currentColor"/>
                    </svg>
                </div>
                <div class="value-name">{{ __('app.value_efficiency_name') }}</div>
                <div class="value-desc">{{ __('app.value_efficiency_desc') }}</div>
            </div>
            <div class="value-card">
                <div class="value-icon icon-commitment">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 8L14.5 4.5M11 8L9.5 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M7 8H2V20C2 21.1 2.9 22 4 22H20C21.1 22 22 21.1 22 20V8H17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.5 11.5L11.5 13.5L15.5 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="value-name">{{ __('app.value_commitment_name') }}</div>
                <div class="value-desc">{{ __('app.value_commitment_desc') }}</div>
            </div>
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
                <div class="service-card">
                    <div class="service-icon {{ $service->icon_class ?? 'icon-classification' }}">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M8 9L16 9M8 13L13 13M8 17L12 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <a href="/{{ $service->slug }}" style="text-decoration: none; color: inherit;">
                        <div class="service-title">{{ $service->title }}</div>
                        <p class="service-desc">{{ Str::limit($service->subtitle, 120) }}</p>
                    </a>
                </div>
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

    <!-- CONTACT -->
    <section class="contact reveal" id="contacto">
        <div class="contact-inner">
            <div class="section-label">{{ __('app.escribenos') }}</div>
            <h2 class="section-title">{{ __('app.contactanos') }}</h2>
            <p class="section-desc">{{ __('app.dudas_comercio') }}
                {{ __('app.contact_text_end') }}</p>
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
                <button type="submit" form="contactForm" class="btn-primary" id="submitBtn">{{ __('app.form_submit_btn') }}</button>
            </div>
            
            <!-- Mensajes de estado -->
            <div id="successMessage" class="alert alert-success" style="display:none; margin-top: 20px;">
                {{ __('app.form_success_message') }}
            </div>
            <div id="errorMessage" class="alert alert-error" style="display:none; margin-top: 20px;"></div>
        </div>
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
                        <div
                            style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:18px;color:#fff;letter-spacing:3px;">
                            TARIX</div>
                        <div style="font-size:8px;color:#22c5bc;letter-spacing:1.5px;text-transform:uppercase;">
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
                <a href="/noticias">{{ __('app.noticias') }}</a>
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
            <span>© {{ date('Y') }} TARIX | Soluciones en Comercio Exterior. Todos los derechos reservados.</span>
            <span>Hecho en Colombia 🇨🇴</span>
        </div>
    </footer>

    <!-- WHATSAPP FLOATING BUTTON -->
    <a href="https://wa.me/573000000000" class="whatsapp-float" target="_blank" rel="noopener noreferrer" title="Contáctanos por WhatsApp">
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
                grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY") }}', { action: 'submit' })
                    .then(token => {
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
                    mostrarExito(data.message);
                    contactForm.reset();
                    limpiarErrores();
                } else {
                    mostrarError(data.message || 'Error al enviar.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarError('Error de conexión.');
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
    @if(env('RECAPTCHA_SITE_KEY'))
        <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
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
    </script>
</body>

</html>
