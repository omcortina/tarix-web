@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div class="page-actions">
        <a href="{{ route('admin.services.create') }}" class="btn-primary">
            <i class="fa fa-plus"></i> Nuevo Servicio
        </a>

        <a href="{{ route('admin.articles.create') }}" class="btn-primary">
            <i class="fa fa-plus"></i> Nuevo Artículo
        </a>
    </div>
</div>

<!-- STATS -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa fa-briefcase"></i>
        </div>
        <div class="stat-label">Servicios</div>
        <div class="stat-value">{{ $servicesCount }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa fa-check"></i>
        </div>
        <div class="stat-label">Servicios Publicados</div>
        <div class="stat-value">{{ $publishedCount }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa fa-newspaper-o"></i>
        </div>
        <div class="stat-label">Artículos</div>
        <div class="stat-value">{{ $articlesCount }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa fa-rss"></i>
        </div>
        <div class="stat-label">Artículos Publicados</div>
        <div class="stat-value">{{ $publishedArticlesCount }}</div>
    </div>
</div>

<!-- RECENT SERVICES -->
<div class="content-section">
    <h2 class="section-title">
        <i class="fa fa-briefcase"></i>
        Servicios Recientes
    </h2>

    @if ($services->count() > 0)
        <ul class="services-list">
            @foreach ($services as $service)
                <li class="service-item">
                    <div class="service-info">
                        <div class="service-title">{{ getSpanish($service->title) }}</div>
                        <div class="service-slug">/{{ $service->slug }}</div>
                        <div style="font-size: 12px; color: #999; margin-top: 4px;">
                            Estado: <span style="font-weight: 600; color: {{ $service->published ? '#2e7d32' : '#e65100' }};">{{ $service->published ? 'Publicado' : 'Borrador' }}</span>
                        </div>
                    </div>
                    <div class="service-actions">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn-small btn-edit">
                            <i class="fa fa-pencil"></i> Editar
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="empty-state">
            <i class="fa fa-inbox"></i>
            <p>No hay servicios creados aún</p>
            <a href="{{ route('admin.services.create') }}" class="btn-primary">
                <i class="fa fa-plus"></i> Crear Primer Servicio
            </a>
        </div>
    @endif
</div>
<br>
<!-- RECENT ARTICLES -->
<div class="content-section">
    <h2 class="section-title">
        <i class="fa fa-newspaper-o"></i>
        Artículos Recientes
    </h2>

    @if ($articles->count() > 0)
        <ul class="services-list">
            @foreach ($articles as $article)
                <li class="service-item">
                    <div class="service-info">
                        <div class="service-title">{{ getSpanish($article->title) }}</div>
                        <div class="service-slug">/{{ $article->slug }}</div>
                        <div style="font-size: 12px; color: #999; margin-top: 4px;">
                            Estado: <span style="font-weight: 600; color: {{ $article->published ? '#2e7d32' : '#e65100' }};">{{ $article->published ? 'Publicado' : 'Borrador' }}</span>
                        </div>
                    </div>
                    <div class="service-actions">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn-small btn-edit">
                            <i class="fa fa-pencil"></i> Editar
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="empty-state">
            <i class="fa fa-inbox"></i>
            <p>No hay artículos creados aún</p>
            <a href="{{ route('admin.articles.create') }}" class="btn-primary">
                <i class="fa fa-plus"></i> Crear Primer Artículo
            </a>
        </div>
    @endif
</div>
@endsection
