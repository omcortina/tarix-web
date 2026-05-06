<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-user.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @yield('extra_css')
</head>
<body>
    <div class="user-wrapper">
        <!-- Mobile Top Bar -->
        <div class="user-top-bar" style="display: none;" id="mobileTopBar">
            <h1>TARIX</h1>
            <button class="user-hamburger" id="hamburgerBtn">
                <i class="fa fa-bars"></i>
                <i class="fa fa-times" style="display: none;"></i>
            </button>
        </div>

        <!-- Sidebar -->
        <aside class="user-sidebar" id="userSidebar">
            <div class="user-sidebar-logo">
                <h2>TARIX</h2>
            </div>

            <ul class="user-sidebar-menu">
                <li>
                    <a href="{{ route('user.dashboard') }}" @if(Route::currentRouteName() === 'user.dashboard') class="active" @endif>
                        <i class="fa fa-home"></i>
                        {{ __('app.sidebar_home') }}
                    </a>
                </li>

                @if (Auth::user()->user_type === 'CLASIFICADOR')
                    <li>
                        <a href="{{ route('clasificador.index') }}" @if(Route::currentRouteName() === 'clasificador.index' || Route::currentRouteName() === 'clasificador.show') class="active" @endif>
                            <i class="fa fa-list"></i>
                            Clasificaciones
                        </a>
                    </li>

                @elseif (Auth::user()->user_type === 'EMPRESA')
                    <li>
                        <a href="{{ route('user.empresa.classifications') }}" @if(Str::startsWith(Route::currentRouteName(), 'user.empresa') && !in_array(Route::currentRouteName(), ['user.empresa.billing', 'user.empresa.send-link'])) class="active" @endif>
                            <i class="fa fa-building"></i>
                            Clasificaciones de la empresa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.empresa.billing') }}" @if(Route::currentRouteName() === 'user.empresa.billing') class="active" @endif>
                            <i class="fa fa-usd"></i>
                            Facturación y Totales
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.procedures') }}" @if(Route::currentRouteName() === 'user.procedures') class="active" @endif>
                            <i class="fa fa-folder-open"></i>
                            {{ __('app.dashboard_procedures_title') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.empresa.send-link') }}" @if(Route::currentRouteName() === 'user.empresa.send-link') class="active" @endif>
                            <i class="fa fa-link"></i>
                            Link de Registro
                        </a>
                    </li>

                @else
                    <li>
                        <a href="{{ route('user.classifications') }}" @if(Route::currentRouteName() === 'user.classifications' || Route::currentRouteName() === 'user.classifications.create') class="active" @endif>
                            <i class="fa fa-list"></i>
                            Clasificaciones
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.procedures') }}" @if(Route::currentRouteName() === 'user.procedures') class="active" @endif>
                            <i class="fa fa-folder-open"></i>
                            {{ __('app.dashboard_procedures_title') }}
                        </a>
                    </li>
                @endif
            </ul>

            <div class="user-sidebar-bottom">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="user-logout-btn">
                        <i class="fa fa-sign-out"></i>
                        {{ __('app.sidebar_logout') }}
                    </button>
                </form>
            </div>
        </aside>

        <!-- Content -->
        <main class="user-content">
            <div class="user-header">
                <h1>@yield('page_title')</h1>
                <div class="user-info">
                    <div class="user-info-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info-text">
                        <small>{{ __('app.dashboard_account') }}</small>
                        <strong>
                            @if (Auth::user()->user_type === 'CLASIFICADOR')
                                {{ __('app.user_type_clasificador') }}
                            @elseif (Auth::user()->user_type === 'EMPRESA')
                                Empresa
                            @else
                                {{ Auth::user()->client_type ?? __('app.dashboard_account_type') }}
                            @endif
                        </strong>
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- jQuery + DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ocultar alertas después de 3 segundos
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 3000);
            });

            // Funcionalidad del menú hamburguesa
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const userSidebar = document.getElementById('userSidebar');
            const mobileTopBar = document.getElementById('mobileTopBar');
            
            // Solo ejecutar si los elementos existen
            if (hamburgerBtn && userSidebar && mobileTopBar) {
                const barsIcon = hamburgerBtn.querySelector('.fa-bars');
                const timesIcon = hamburgerBtn.querySelector('.fa-times');

                function updateMobileView() {
                    if (window.innerWidth <= 768) {
                        mobileTopBar.style.display = 'flex';
                    } else {
                        mobileTopBar.style.display = 'none';
                        userSidebar.classList.remove('active');
                        hamburgerBtn.classList.remove('active');
                        barsIcon.style.display = 'flex';
                        timesIcon.style.display = 'none';
                    }
                }

                updateMobileView();

                hamburgerBtn.addEventListener('click', function() {
                    userSidebar.classList.toggle('active');
                    hamburgerBtn.classList.toggle('active');
                    
                    if (userSidebar.classList.contains('active')) {
                        barsIcon.style.display = 'none';
                        timesIcon.style.display = 'flex';
                    } else {
                        barsIcon.style.display = 'flex';
                        timesIcon.style.display = 'none';
                    }
                });

                const menuLinks = userSidebar.querySelectorAll('.user-sidebar-menu a');
                menuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        userSidebar.classList.remove('active');
                        hamburgerBtn.classList.remove('active');
                        barsIcon.style.display = 'flex';
                        timesIcon.style.display = 'none';
                    });
                });

                document.addEventListener('click', function(event) {
                    if (window.innerWidth <= 768 && !event.target.closest('.user-sidebar') && !event.target.closest('.user-hamburger')) {
                        userSidebar.classList.remove('active');
                        hamburgerBtn.classList.remove('active');
                        barsIcon.style.display = 'flex';
                        timesIcon.style.display = 'none';
                    }
                });

                window.addEventListener('resize', updateMobileView);
            }
        });
    </script>
    @yield('extra_js')
</body>
</html>
