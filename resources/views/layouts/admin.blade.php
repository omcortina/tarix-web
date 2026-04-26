<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | TARIX Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @yield('styles')
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
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="fa fa-briefcase"></i>
                    Servicios
                </a>
            </li>
            <li>
                <a href="{{ route('admin.values.index') }}" class="{{ request()->routeIs('admin.values.*') ? 'active' : '' }}">
                    <i class="fa fa-star"></i>
                    Valores
                </a>
            </li>
            <li>
                <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                    <i class="fa fa-newspaper-o"></i>
                    Artículos
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contacts.index') }}" class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fa fa-envelope"></i>
                    Mensajes
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show auto-alert" role="alert">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show auto-alert" role="alert">
                <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.auto-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    // Usar la API de bootstrap para cerrar el alert
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 2500);
            });
        });
    </script>
</body>
</html>
