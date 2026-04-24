<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <!-- NAVBAR -->
    <div class="admin-navbar">
        <div class="admin-brand">
            <i class="fa fa-cog"></i>
            TARIX Admin
        </div>
        <div class="admin-user">
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Administrador</div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa fa-sign-out"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </div>

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="active">
                    <i class="fa fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.services.index') }}">
                    <i class="fa fa-briefcase"></i>
                    Servicios
                </a>
            </li>
            <li>
                <a href="{{ route('admin.articles.index') }}">
                    <i class="fa fa-newspaper-o"></i>
                    Artículos
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contacts.index') }}">
                    <i class="fa fa-envelope"></i>
                    Mensajes
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

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
    </main>
</body>
</html>
