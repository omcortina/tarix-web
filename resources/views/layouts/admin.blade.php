<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | TARIX Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('extra_css')
</head>
<body>
    @include('admin.partials.navbar')

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        @if (session('success'))
            <div class="alert alert-success">
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
            const adminSidebar = document.getElementById('adminSidebar');

            if (hamburgerAdmin && adminSidebar) {
                hamburgerAdmin.addEventListener('click', function() {
                    hamburgerAdmin.classList.toggle('active');
                    adminSidebar.classList.toggle('active');
                });

                const sidebarLinks = adminSidebar.querySelectorAll('a');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        hamburgerAdmin.classList.remove('active');
                        adminSidebar.classList.remove('active');
                    });
                });

                document.addEventListener('click', function(event) {
                    if (!event.target.closest('.admin-navbar') && !event.target.closest('.admin-sidebar')) {
                        hamburgerAdmin.classList.remove('active');
                        adminSidebar.classList.remove('active');
                    }
                });
            }
        });

        function confirmDelete(event, itemId, itemType) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas eliminar este ' + itemType + '? Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + itemId).submit();
                }
            });
        }
    </script>

    @yield('extra_js')
</body>
</html>
