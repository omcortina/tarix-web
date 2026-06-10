{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">

    <url>
        <loc>{{ url('/') }}</loc>
        <xhtml:link rel="alternate" hreflang="es" href="{{ url('/') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/') }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('/') }}"/>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    <url>
        <loc>{{ url('/blog') }}</loc>
        <xhtml:link rel="alternate" hreflang="es" href="{{ url('/blog') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/blog') }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('/blog') }}"/>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ url('/privacidad') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>

    @foreach($articles as $article)
    <url>
        <loc>{{ url('/blog/' . $article->slug) }}</loc>
        <xhtml:link rel="alternate" hreflang="es" href="{{ url('/blog/' . $article->slug) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/blog/' . $article->slug) }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('/blog/' . $article->slug) }}"/>
        <lastmod>{{ $article->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    @foreach($services as $service)
    <url>
        <loc>{{ url('/' . $service->slug) }}</loc>
        <xhtml:link rel="alternate" hreflang="es" href="{{ url('/' . $service->slug) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/' . $service->slug) }}"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ url('/' . $service->slug) }}"/>
        <lastmod>{{ $service->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

</urlset>
