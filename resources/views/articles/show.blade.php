<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} | TARIX</title>
    <meta name="description" content="{{ Str::limit(strip_tags($article->excerpt ?? $article->content ?? ''), 160) }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/blog/' . $article->slug) }}" />
    <link rel="alternate" hreflang="es" href="{{ url('/blog/' . $article->slug) }}" />
    <link rel="alternate" hreflang="en" href="{{ url('/blog/' . $article->slug) }}" />
    <link rel="alternate" hreflang="x-default" href="{{ url('/blog/' . $article->slug) }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/articles.css') }}">
    <style>
        .article-header {
            background: #001B30;
            color: #FFFFFF;
            padding: 100px 20px;
            text-align: center;
            margin-bottom: 60px;
        }
        .article-header h1 {
            font-size: clamp(24px, 4vw, 38px);
            margin: 0 0 16px 0;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            line-height: 1.3;
            max-width: 820px;
            margin-left: auto;
            margin-right: auto;
        }
        .article-meta {
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 14px;
            opacity: 0.75;
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
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
            color: #001B30;
            margin-top: 35px;
            margin-bottom: 15px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }
        .article-content h3 {
            font-size: 18px;
            color: #1D9E75;
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
        .back-link {
            display: inline-block;
            margin-bottom: 24px;
            padding: 10px 18px;
            background: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s;
        }
        .back-link:hover { background: #e0e0e0; }
        .related-section { margin-top: 80px; }
        .related-title {
            font-size: 24px;
            color: #001B30;
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        .related-card:hover { transform: translateY(-5px); }
        .related-card-content { padding: 24px; }
        .related-date {
            font-size: 12px;
            color: #999;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .related-card h3 {
            font-size: 16px;
            color: #001B30;
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
            color: #1D9E75;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s;
        }
        .related-link:hover { color: #26b887; }
        @media (max-width: 600px) {
            .article-content { padding: 28px 20px; }
        }
    </style>
            transition: background 0.2s;
        }
    </style>
</head>

<body>
    <!-- NAV -->
    <nav>
        <a href="/" class="nav-logo">
            <div class="logo-text">
                <img src="{{ asset('img/logo.png') }}" alt="Comercio Internacional">
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
            <a href="{{ route('login') }}" class="nav-cta">{{ __('articles.login') }}</a>
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
            <span>{{ __('articles.by') }} {{ $article->user->name ?? 'Admin' }}</span>
        </div>
    </div>

    <!-- ARTICLE CONTENT -->
    <div class="article-container">
        <a href="/blog" class="back-link">{{ __('articles.back_to_news') }}</a>

        <div class="article-content">
            <!-- Media Gallery Section -->
            @if($article->media()->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 40px; margin-bottom: 40px;">
                    @foreach($article->media()->orderBy('order')->get() as $media)
                        <div>
                            @if($media->type === 'image')
                                <figure style="margin: 0;">
                                    <img src="{{ $media->url }}" 
                                         alt="{{ $media->description }}"
                                         style="width: 100%; height: auto; max-height: 500px; object-fit: cover; border-radius: 6px;">
                                    @if($media->description)
                                        <figcaption style="margin-top: 12px; font-size: 14px; color: #666; font-style: italic;">
                                            {{ $media->description }}
                                        </figcaption>
                                    @endif
                                </figure>

                            @elseif($media->type === 'youtube')
                                @php
                                    $embedId = $media->youtube_embed;
                                @endphp
                                @if($embedId)
                                    <div style="position: relative; width: 100%; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 6px;">
                                        <iframe 
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                            src="https://www.youtube.com/embed/{{ $embedId }}" 
                                            title="YouTube video"
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                @else
                                    <div style="background: #f0f0f0; padding: 40px; text-align: center; border-radius: 6px; color: #999;">
                                        <p>{{ __('articles.invalid_youtube') }}</p>
                                        <p style="font-size: 12px; margin-top: 8px;">{{ __('articles.url_saved') }}: <code style="background: #e0e0e0; padding: 4px 8px; border-radius: 3px;">{{ $media->url }}</code></p>
                                    </div>
                                @endif
                                @if($media->description)
                                    <p style="margin-top: 12px; font-size: 14px; color: #666; font-style: italic;">
                                        {{ $media->description }}
                                    </p>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            {!! nl2br($article->content) !!}
        </div>

        <!-- LEAD MAGNET -->
        <div class="article-cta-box">
            <div class="article-cta-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4Z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M2 6L12 13L22 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="article-cta-text">
                <h3>{{ __('articles.cta_title') }}</h3>
                <p>{{ __('articles.cta_body') }}</p>
            </div>
            <a href="https://wa.me/573024674923?text={{ urlencode(__('articles.cta_whatsapp_msg')) }}" class="article-cta-btn" target="_blank" rel="noopener noreferrer">{{ __('articles.cta_btn') }}</a>
        </div>

        <!-- Comments Section -->
        @include('includes.article-comments')

        @if($related->count())
            <div class="related-section">
                <h2 class="related-title">{{ __('articles.related_articles') }}</h2>
                <div class="related-grid">
                    @foreach($related as $relatedArticle)
                        <div class="related-card">
                            <div class="related-card-content">
                                <div class="related-date">{{ $relatedArticle->created_at->translatedFormat('d M Y') }}</div>
                                <h3>{{ $relatedArticle->title }}</h3>
                                <p class="related-excerpt">{{ $relatedArticle->excerpt ?: substr(strip_tags($relatedArticle->content), 0, 100) . '...' }}</p>
                                <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="related-link">{{ __('articles.read_more') }} →</a>
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
                    <div class="logo-text">
                        <img src="{{ asset('img/logo.png') }}" alt="Comercio Internacional">
                        <span class="logo-sub">{{ __('articles.solutions') }}</span>
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
        <div class="footer-legal">
            <span>NIT: 900.XXX.XXX-X &nbsp;&middot;&nbsp; Bogot&aacute; D.C., Colombia &nbsp;&middot;&nbsp; Lun &ndash; Vie: 8:00 a.m. &ndash; 6:00 p.m.</span>
            <a href="/privacidad">{{ __('privacidad.footer_privacy') }}</a>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} TARIX | {{ __('articles.solutions') }}. {{ __('articles.all_rights_reserved') }}</span>
            <span>{{ __('articles.made_in_colombia') }}</span>
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
