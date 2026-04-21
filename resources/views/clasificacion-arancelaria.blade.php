<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificación Arancelaria | TARIX</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <nav>
        <a href="/" class="nav-logo">
            <img src="{{ asset('img/logo.png') }}" alt="TARIX Logo" class="logo-img">
            <div class="logo-text">
                <span class="logo-name">TARIX</span>
                <span class="logo-sub">Soluciones en Comercio Exterior</span>
            </div>
        </a>
        <div class="nav-links">
            <a href="/#inicio">Inicio</a>
            <a href="/#nosotros">Nosotros</a>
            <a href="/#servicios">Servicios</a>
            <a href="/#recursos">Recursos</a>
            <a href="/#contacto">Contacto</a>
            <a href="/#contacto" class="nav-cta">Contáctanos</a>
        </div>
    </nav>

    <!-- HERO SERVICIO -->
    <section class="hero-servicio">
        <div class="hero-servicio-bg" style="background: linear-gradient(135deg, #0d2340 0%, #1ba8a0 100%);"></div>
        <div class="hero-servicio-content">
            <div class="breadcrumb">
                <a href="/">Inicio</a> / <a href="/#servicios">Servicios</a> / Clasificación Arancelaria
            </div>
            <h1>Clasificación Arancelaria</h1>
            <p>Determinación precisa y estratégica de la subpartida arancelaria correcta para tus productos</p>
        </div>
    </section>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="servicio-contenido">
        <div class="servicio-inner">
            <!-- COLUMNA IZQUIERDA -->
            <div class="servicio-left">
                <div class="section-block">
                    <h2>¿Qué es la Clasificación Arancelaria?</h2>
                    <p>La clasificación arancelaria es el proceso mediante el cual se determina la subpartida correcta dentro de la Nomenclatura Común del Mercosur (NCM) o el Sistema Armonizado (SA) para cada producto. Esta clasificación es fundamental porque:</p>
                    <ul class="benefit-list">
                        <li><strong>Define los aranceles:</strong> Determina el porcentaje de impuestos a pagar</li>
                        <li><strong>Establece regulaciones:</strong> Identifica restricciones o requisitos especiales</li>
                        <li><strong>Optimiza costos:</strong> Permite aprovechar acuerdos comerciales preferenciales</li>
                        <li><strong>Evita sanciones:</strong> Previene multas por clasificación incorrecta</li>
                    </ul>
                </div>

                <div class="section-block">
                    <h2>Nuestro Proceso</h2>
                    <div class="process-steps">
                        <div class="step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h3>Análisis del Producto</h3>
                                <p>Revisamos en detalle las características físicas, composición, función y presentación de tu producto.</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h3>Investigación Normativa</h3>
                                <p>Consultamos la NCM, SA, reglas de interpretación y criterios de autoridades aduanales.</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h3>Concepto Fundamentado</h3>
                                <p>Emitimos un concepto detallado con fundamentos técnicos y normativos verificables.</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h3>Seguimiento</h3>
                                <p>Acompañamiento en la presentación ante aduanas y gestión de consultas adicionales.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA (SIDEBAR) -->
            <aside class="servicio-sidebar">
                <div class="sidebar-box">
                    <h3>¿Necesitas Clasificación Arancelaria?</h3>
                    <p>Contáctanos hoy y recibe una consulta inicial gratuita.</p>
                    <a href="/#contacto" class="btn-primary">Solicitar Asesoría</a>
                </div>
            </aside>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="servicio-cta">
        <h2>¿Tienes dudas sobre clasificación arancelaria?</h2>
        <p>Nuestro equipo de expertos está listo para ayudarte a optimizar tu operación de importación/exportación</p>
        <a href="/#contacto" class="btn-primary btn-large">Contáctanos Ahora</a>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-top">
            <div class="footer-brand">
                <div class="nav-logo" style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <img src="{{ asset('img/logo.png') }}" alt="TARIX Logo" style="width:36px;height:36px;">
                    <div>
                        <div
                            style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:18px;color:#fff;letter-spacing:3px;">
                            TARIX</div>
                        <div style="font-size:8px;color:#22c5bc;letter-spacing:1.5px;text-transform:uppercase;">
                            Soluciones en Comercio Exterior</div>
                    </div>
                </div>
                <p>Expertos en comercio exterior que acompañan a tu empresa en cada paso de la operación internacional
                    con precisión, seguridad y compromiso.</p>
            </div>
            <div class="footer-col">
                <h4>Navegación</h4>
                <a href="/#inicio">Inicio</a>
                <a href="/#nosotros">Nosotros</a>
                <a href="/#servicios">Servicios</a>
                <a href="/#recursos">Recursos</a>
                <a href="/#contacto">Contacto</a>
            </div>
            <div class="footer-col">
                <h4>Servicios</h4>
                <a href="/clasificacion-arancelaria">Clasificación Arancelaria</a>
                <a href="#">Valoración Aduanera</a>
                <a href="#">Origen de Mercancías</a>
                <a href="#">Asesoría en Importaciones</a>
                <a href="#">Consultoría</a>
            </div>
            <div class="footer-col">
                <h4>Contacto</h4>
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
        // Smooth nav active state
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            nav.style.boxShadow = window.scrollY > 10 ? '0 4px 30px rgba(0,0,0,.4)' : '0 2px 20px rgba(0,0,0,.3)';
        });
    </script>
</body>

</html>
