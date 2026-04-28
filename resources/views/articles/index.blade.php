<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog | TARIX</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/articles.css') }}">
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
                <span class="logo-sub">{{ __('articles.solutions') }}</span>
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
            <a href="/blog" class="active">{{ __('articles.news') }}</a>
            <a href="/#recursos">{{ __('articles.resources') }}</a>
            <a href="/#contacto">{{ __('articles.contact') }}</a>
            <a href="{{ route('register') }}" class="nav-cta">{{ __('articles.register') }}</a>
            <a href="{{ route('login') }}" class="nav-cta">{{ __('articles.login') }}</a>
            <div class="language-selector">
                <a href="{{ route('lang.set', 'es') }}" class="lang-btn {{ app()->getLocale() === 'es' ? 'active' : '' }}">ES</a>
                <a href="{{ route('lang.set', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>
        </div>
    </nav>

    <!-- NEWS HEADER -->
    <div class="news-header">
        <h1>{{ __('articles.news') }}</h1>
        <p>{{ __('articles.news') == 'Blog' ? 'Mantente actualizado con los últimos artículos sobre comercio exterior y soluciones empresariales' : 'Stay updated with the latest articles on foreign trade and business solutions' }}</p>
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
                            
                            <!-- Media Badges -->
                            @if($article->images()->count() > 0 || $article->videos()->count() > 0)
                                <div style="display: flex; gap: 8px; margin-bottom: 12px; flex-wrap: wrap;">
                                    @if($article->images()->count() > 0)
                                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; background: #e3f2fd; color: #1976d2; border-radius: 3px; font-size: 11px; font-weight: 600;">
                                            <i class="fa fa-image"></i>
                                            {{ $article->images()->count() }} imagen(es)
                                        </span>
                                    @endif
                                    @if($article->videos()->count() > 0)
                                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; background: #ffebee; color: #c62828; border-radius: 3px; font-size: 11px; font-weight: 600;">
                                            <i class="fa fa-play-circle"></i>
                                            {{ $article->videos()->count() }} video(s)
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="news-footer">
                                <span class="news-author">Por {{ $article->user->name ?? 'Admin' }}</span>
                                <a href="{{ route('articles.show', $article->slug) }}" class="btn-read-more">Ver más</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <div class="empty-state">
                <p>No hay artículos disponibles en este momento.</p>
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
                            {{ __('articles.solutions') }}</div>
                    </div>
                </div>
                <p>{{ __('articles.footer_experts') }}</p>
            </div>
            <div class="footer-col">
                <h4>{{ __('articles.navigation') }}</h4>
                <a href="/">{{ __('articles.home') }}</a>
                <a href="/#nosotros">{{ __('articles.about') }}</a>
                <a href="/#servicios">{{ __('articles.services') }}</a>
                <a href="/blog">{{ __('articles.news') }}</a>
                <a href="/#recursos">{{ __('articles.resources') }}</a>
                <a href="/#contacto">{{ __('articles.contact') }}</a>
            </div>
            <div class="footer-col">
                <h4>{{ __('articles.services') }}</h4>
                @forelse($services->where('show_in_footer', true) as $service)
                    <a href="/{{ $service->slug }}">{{ $service->title }}</a>
                @empty
                    <p style="font-size: 12px; color: #999;">{{ __('articles.no_services_available') }}</p>
                @endforelse
            </div>
            <div class="footer-col">
                <h4>{{ __('articles.footer_contact') }}</h4>
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
                    <a href="mailto:info@tarix.com.co">info@tarix.com.co</a>
                </div>
                <div class="footer-contact-item">
                    <span class="footer-icon icon-phone">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 10.5V7C17 5.9 16.1 5 15 5H9C7.9 5 7 5.9 7 7V17C7 18.1 7.9 19 9 19H15C16.1 19 17 18.1 17 17V13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M9.5 8H14.5M9.5 15H14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span>+57 302 467 4923</span>
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
        <div class="footer-bottom">
            <span>© {{ date('Y') }} TARIX | {{ __('articles.solutions') }}. {{ __('articles.all_rights_reserved') }}</span>
            <span>{{ __('articles.made_in_colombia') }} 🇨🇴</span>
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

        // Video Modal
        function openVideoModal(youtubeId) {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoFrame');
            iframe.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1`;
            modal.style.display = 'flex';
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoFrame');
            iframe.src = '';
            modal.style.display = 'none';
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('videoModal');
            if (event.target === modal) {
                closeVideoModal();
            }
        });

        // Close with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeVideoModal();
            }
        });
    </script>

    <!-- Video Modal -->
    <div id="videoModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; align-items: center; justify-content: center;">
        <div style="position: relative; width: 90%; max-width: 900px; aspect-ratio: 16/9;">
            <button onclick="closeVideoModal()" style="position: absolute; top: -40px; right: 0; background: white; border: none; color: #333; font-size: 24px; cursor: pointer; padding: 0; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">✕</button>
            <iframe id="videoFrame" 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        </div>
    </div>
</body>

</html>
