<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias | TARIX</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        body { background: #f5f7fa; }
        .news-header { 
            background: linear-gradient(135deg, #1ba8a0 0%, #0d2340 100%);
            color: white;
            padding: 100px 20px;
            text-align: center;
            margin-bottom: 60px;
        }
        .news-header h1 { 
            font-size: 42px;
            margin: 0 0 15px 0;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
        }
        .news-header p { 
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.95;
        }
        .news-container { 
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 80px;
        }
        .news-grid { 
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }
        .news-card { 
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .news-card:hover { 
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .news-card-header { 
            padding: 24px;
            background: #f8f9fa;
            border-bottom: 2px solid #e0e0e0;
        }
        .news-date { 
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        .news-card h3 { 
            margin: 0;
            font-size: 18px;
            color: #0d2340;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            line-height: 1.4;
        }
        .news-card-body { 
            padding: 24px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .news-excerpt { 
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }
        .news-footer { 
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid #e0e0e0;
        }
        .news-author { 
            font-size: 12px;
            color: #999;
        }
        .btn-read-more { 
            display: inline-block;
            padding: 8px 16px;
            background: #22c5bc;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-read-more:hover { 
            background: #1ba8a0;
        }
        .empty-state { 
            text-align: center;
            padding: 80px 20px;
            color: #999;
        }
        .empty-state p { 
            font-size: 16px;
            margin-bottom: 30px;
        }
        .pagination { 
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 50px;
            flex-wrap: wrap;
        }
        .pagination a, .pagination span { 
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #0066cc;
            font-size: 14px;
        }
        .pagination .active { 
            background: #0066cc;
            color: white;
            border-color: #0066cc;
        }
        .pagination a:hover { 
            background: #f0f0f0;
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
            <a href="/">{{ __('articles.news') == 'Noticias' ? 'Inicio' : 'Home' }}</a>
            <a href="/#nosotros">{{ __('articles.news') == 'Noticias' ? 'Nosotros' : 'About' }}</a>
            <a href="/#servicios">{{ __('articles.news') == 'Noticias' ? 'Servicios' : 'Services' }}</a>
            <a href="/noticias" class="active">{{ __('articles.news') }}</a>
            <a href="/#recursos">{{ __('articles.news') == 'Noticias' ? 'Recursos' : 'Resources' }}</a>
            <a href="/#contacto">{{ __('articles.news') == 'Noticias' ? 'Contacto' : 'Contact' }}</a>
            <a href="/#contacto" class="nav-cta">{{ __('articles.news') == 'Noticias' ? 'Contáctanos' : 'Contact Us' }}</a>
            <div class="language-selector">
                <a href="{{ route('lang.set', 'es') }}" class="lang-btn {{ app()->getLocale() === 'es' ? 'active' : '' }}">ES</a>
                <a href="{{ route('lang.set', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>
        </div>
    </nav>

    <!-- NEWS HEADER -->
    <div class="news-header">
        <h1>{{ __('articles.news') }}</h1>
        <p>{{ __('articles.news') == 'Noticias' ? 'Mantente actualizado con las últimas noticias y artículos sobre comercio exterior y soluciones empresariales' : 'Stay updated with the latest news and articles on foreign trade and business solutions' }}</p>
    </div>

    <!-- MAIN CONTENT -->
    <div class="news-container">
        @if($articles->count())
            <div class="news-grid">
                @foreach($articles as $article)
                    <div class="news-card">
                        <div class="news-card-header">
                            <div class="news-date">{{ $article->created_at->translatedFormat('d M Y') }}</div>
                            <h3>{{ $article->title }}</h3>
                        </div>
                        <div class="news-card-body">
                            <p class="news-excerpt">{{ $article->excerpt ?: substr(strip_tags($article->content), 0, 150) . '...' }}</p>
                            <div class="news-footer">
                                <span class="news-author">Por {{ $article->user->name ?? 'Admin' }}</span>
                                <a href="{{ route('articles.show', $article->slug) }}" class="btn-read-more">Ver más</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $articles->links() }}
            </div>
        @else
            <div class="empty-state">
                <p>No hay noticias disponibles en este momento.</p>
                <a href="/" class="btn-primary">Volver al inicio</a>
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
