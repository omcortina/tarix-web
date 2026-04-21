<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} | TARIX</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        body { background: #f5f7fa; }
        .article-header {
            background: linear-gradient(135deg, #1ba8a0 0%, #0d2340 100%);
            color: white;
            padding: 100px 20px;
            text-align: center;
            margin-bottom: 50px;
        }
        .article-header h1 {
            font-size: 38px;
            margin: 0 0 20px 0;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            line-height: 1.3;
        }
        .article-meta {
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 14px;
            opacity: 0.95;
        }
        .article-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px 80px;
        }
        .article-content {
            background: white;
            border-radius: 8px;
            padding: 50px 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 60px;
        }
        .article-content p {
            font-size: 16px;
            line-height: 1.8;
            color: #333;
            margin-bottom: 20px;
        }
        .article-content h2 {
            font-size: 24px;
            color: #0d2340;
            margin-top: 35px;
            margin-bottom: 15px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }
        .article-content h3 {
            font-size: 18px;
            color: #1ba8a0;
            margin-top: 25px;
            margin-bottom: 12px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }
        .article-content ul, .article-content ol {
            margin-bottom: 20px;
            padding-left: 30px;
        }
        .article-content li {
            margin-bottom: 10px;
            line-height: 1.8;
        }
        .breadcrumb {
            font-size: 13px;
            color: #666;
            margin-bottom: 30px;
        }
        .breadcrumb a {
            color: #22c5bc;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s;
        }
        .back-link:hover {
            background: #e0e0e0;
        }
        .related-section {
            margin-top: 80px;
        }
        .related-title {
            font-size: 24px;
            color: #0d2340;
            margin-bottom: 30px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        .related-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .related-card:hover {
            transform: translateY(-5px);
        }
        .related-card-content {
            padding: 24px;
        }
        .related-date {
            font-size: 12px;
            color: #999;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .related-card h3 {
            font-size: 16px;
            color: #0d2340;
            margin: 0 0 12px 0;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            line-height: 1.4;
        }
        .related-excerpt {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .related-link {
            display: inline-block;
            color: #22c5bc;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s;
        }
        .related-link:hover {
            color: #1ba8a0;
        }
        .language-selector {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .lang-btn {
            padding: 6px 12px;
            border: 2px solid transparent;
            background: transparent;
            color: #666;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            transition: all 0.2s;
        }
        .lang-btn.active {
            color: #22c5bc;
            border-bottom: 2px solid #22c5bc;
        }
        .lang-btn:hover {
            color: #22c5bc;
        }
    </style>
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
                <span class="logo-sub">Soluciones en Comercio Exterior</span>
            </div>
        </a>
        
        <!-- Hamburger Menu Button -->
        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <div class="nav-links" id="navMenu">
            <a href="/">{{ __('articles.home') }}</a>
            <a href="/#nosotros">{{ __('articles.about') }}</a>
            <a href="/#servicios">{{ __('articles.services') }}</a>
            <a href="/noticias" class="active">{{ __('articles.news') }}</a>
            <a href="/#recursos">{{ __('articles.resources') }}</a>
            <a href="/#contacto">{{ __('articles.contact') }}</a>
            <a href="/#contacto" class="nav-cta">{{ __('articles.contact_us') }}</a>
            <div class="language-selector">
                <a href="{{ route('lang.set', 'es') }}" class="lang-btn {{ app()->getLocale() === 'es' ? 'active' : '' }}">ES</a>
                <a href="{{ route('lang.set', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>
        </div>
    </nav>

    <!-- ARTICLE HEADER -->
    <div class="article-header">
        <h1>{{ $article->title }}</h1>
        <div class="article-meta">
            <span>{{ $article->created_at->translatedFormat('d \\d\\e F \\d\\e Y') }}</span>
            <span>Por {{ $article->user->name ?? 'Admin' }}</span>
        </div>
    </div>

    <!-- ARTICLE CONTENT -->
    <div class="article-container">
        <a href="/noticias" class="back-link"> Volver a Noticias</a>

        <div class="article-content">
            {!! nl2br($article->content) !!}
        </div>

        @if($related->count())
            <div class="related-section">
                <h2 class="related-title">Artículos Relacionados</h2>
                <div class="related-grid">
                    @foreach($related as $relatedArticle)
                        <div class="related-card">
                            <div class="related-card-content">
                                <div class="related-date">{{ $relatedArticle->created_at->translatedFormat('d M Y') }}</div>
                                <h3>{{ $relatedArticle->title }}</h3>
                                <p class="related-excerpt">{{ $relatedArticle->excerpt ?: substr(strip_tags($relatedArticle->content), 0, 100) . '...' }}</p>
                                <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="related-link">Leer más →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-top">
            <div class="footer-brand">
                <div class="nav-logo" style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                    <div class="logo-icon">
                        <div class="logo-t">T</div>
                    </div>
                    <div>
                        <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:18px;color:#fff;letter-spacing:3px;">
                            TARIX</div>
                        <div style="font-size:8px;color:#22c5bc;letter-spacing:1.5px;text-transform:uppercase;">
                            Soluciones en Comercio Exterior</div>
                    </div>
                </div>
                <p>Expertos en comercio exterior que acompañan a tu empresa en cada paso de la operación internacional con precisión, seguridad y compromiso.</p>
            </div>
            <div class="footer-col">
                <h4>{{ __('articles.navigation') }}</h4>
                <a href="/">{{ __('articles.home') }}</a>
                <a href="/#nosotros">{{ __('articles.about') }}</a>
                <a href="/#servicios">{{ __('articles.services') }}</a>
                <a href="/noticias">{{ __('articles.news') }}</a>
                <a href="/#recursos">{{ __('articles.resources') }}</a>
                <a href="/#contacto">{{ __('articles.contact') }}</a>
            </div>
            <div class="footer-col">
                <h4>{{ __('articles.services') }}</h4>
                @forelse(\App\Models\Service::where('show_in_footer', true)->get() as $service)
                    <a href="/{{ $service->slug }}">{{ $service->title }}</a>
                @empty
                    <p style="font-size: 12px; color: #999;">No hay servicios disponibles</p>
                @endforelse
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
