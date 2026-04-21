<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f7fafc;
        }

        .admin-navbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #1a1a1a;
        }

        .admin-brand i {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #22c5bc 0%, #1e9b8f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 14px;
        }

        .user-role {
            font-size: 12px;
            color: #999;
        }

        .btn-logout {
            background: none;
            border: none;
            color: #e53e3e;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .btn-logout:hover {
            color: #c53030;
        }

        .admin-sidebar {
            width: 240px;
            background: white;
            border-right: 1px solid #e2e8f0;
            padding: 24px 0;
            min-height: calc(100vh - 65px);
            position: fixed;
            left: 0;
            top: 65px;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #f0fffe;
            color: #22c5bc;
            border-left-color: #22c5bc;
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
        }

        .admin-main {
            margin-left: 240px;
            padding: 32px;
            min-height: calc(100vh - 65px);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .page-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .btn-primary {
            background: linear-gradient(135deg, #22c5bc 0%, #1e9b8f 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(34, 197, 188, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: #22c5bc;
            box-shadow: 0 4px 12px rgba(34, 197, 188, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: #f0fffe;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #22c5bc;
            font-size: 24px;
            margin-bottom: 12px;
        }

        .stat-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .stat-value {
            font-family: 'Montserrat', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .content-section {
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 24px;
        }

        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: #22c5bc;
        }

        .services-list {
            list-style: none;
        }

        .service-item {
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s ease;
        }

        .service-item:last-child {
            border-bottom: none;
        }

        .service-item:hover {
            background: #f7fafc;
        }

        .service-info {
            flex: 1;
        }

        .service-title {
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .service-slug {
            font-size: 12px;
            color: #999;
        }

        .service-actions {
            display: flex;
            gap: 8px;
        }

        .btn-small {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-edit {
            background: #e3f2fd;
            color: #1976d2;
        }

        .btn-edit:hover {
            background: #bbdefb;
        }

        .btn-delete {
            background: #ffebee;
            color: #e53e3e;
        }

        .btn-delete:hover {
            background: #ffcdd2;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 16px;
        }

        .empty-state p {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-main {
                margin-left: 0;
            }

            .page-header {
                flex-direction: column;
                gap: 16px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #f0fff4;
            color: #22863a;
            border: 1px solid #85e89d;
        }
    </style>
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
            <a href="{{ route('admin.services.create') }}" class="btn-primary">
                <i class="fa fa-plus"></i> Nuevo Servicio
            </a>
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
