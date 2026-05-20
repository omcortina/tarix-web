<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | TARIX Cotizador</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cotizador.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('extra_css')
</head>
<body>
    <!-- NAVBAR -->
    <div class="admin-navbar">
        <div class="admin-brand">
            <button class="hamburger-admin" id="hamburgerAdmin" aria-label="Toggle menu">
                <i class="fa fa-bars"></i>
                <i class="fa fa-times"></i>
            </button>
            TARIX Cotizador
        </div>
        <div class="admin-user">
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Cotizador</div>
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
    <aside class="admin-sidebar" id="adminSidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('cotizador.dashboard') }}" class="{{ request()->routeIs('cotizador.dashboard') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="fa fa-home"></i></div>
                    <span>Dashboard</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>
            <li>
                <a href="{{ route('cotizador.quotes.send') }}" class="{{ request()->routeIs('cotizador.quotes.*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="fa fa-paper-plane"></i></div>
                    <span>Enviar Cotización</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>
            <li>
                <a href="{{ route('cotizador.templates') }}" class="{{ request()->routeIs('cotizador.templates*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="fa fa-file-text-o"></i></div>
                    <span>Plantillas</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>
            <li>
                <a href="{{ route('cotizador.inbox') }}" class="{{ request()->routeIs('cotizador.inbox*') ? 'active' : '' }}">
                    <div class="menu-icon">
                        <i class="fa fa-inbox"></i>
                        @php
                            $unread = \App\Models\InboxEmail::whereHas('emailAccount', fn($q) => $q->where('created_by', auth()->id()))
                                ->where('is_read', false)->count();
                        @endphp
                        @if($unread > 0)
                            <span class="badge-count">{{ $unread > 99 ? '99+' : $unread }}</span>
                        @endif
                    </div>
                    <span>Bandeja de Entrada</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>
            <li>
                <a href="{{ route('cotizador.email-accounts') }}" class="{{ request()->routeIs('cotizador.email-accounts*') ? 'active' : '' }}">
                    <div class="menu-icon"><i class="fa fa-cog"></i></div>
                    <span>Cuentas de Correo</span>
                    <div class="menu-indicator"></div>
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        @if (session('success'))
            <div class="alert alert-success" id="global-success-alert">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">
                <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerAdmin = document.getElementById('hamburgerAdmin');
            const adminSidebar   = document.getElementById('adminSidebar');

            if (hamburgerAdmin && adminSidebar) {
                hamburgerAdmin.addEventListener('click', function() {
                    hamburgerAdmin.classList.toggle('active');
                    adminSidebar.classList.toggle('active');
                });
                document.addEventListener('click', function(event) {
                    if (!event.target.closest('.admin-navbar') && !event.target.closest('.admin-sidebar')) {
                        hamburgerAdmin.classList.remove('active');
                        adminSidebar.classList.remove('active');
                    }
                });
            }
        });

        const successAlert = document.getElementById('global-success-alert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(function() { successAlert.remove(); }, 500);
            }, 3000);
        }

        function confirmDelete(event, itemId, itemType) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas eliminar este ' + itemType + '? Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + itemId).submit();
                }
            });
        }
    </script>
    @yield('scripts')
</body>
</html>
