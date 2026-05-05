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
    <link rel="stylesheet" href="{{ asset('css/admin-general.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('extra_css')
</head>
<body>
    @include('admin.partials.navbar')

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

        // Auto-ocultar mensaje de éxito
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

    <!-- jQuery y DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        // Inicializar DataTables automáticamente
        $(document).ready(function() {
            if ($.fn.dataTable.isDataTable('#adminTable')) {
                $('#adminTable').DataTable().destroy();
            }
            
            $('#adminTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                order: [],
                ordering: false,
                dom: '<"dt-wrapper"<"dt-head"<"dt-controls"<"dt-length"l><"dt-search"f>>>tr<"dt-footer"<"dt-info"i><"dt-pagination"p>>>',
                drawCallback: function() {
                    $('ul.pagination').addClass('pagination-custom');
                    $('ul.pagination li').each(function() {
                        $(this).addClass('page-item');
                        $(this).find('a, span').addClass('page-link');
                    });
                }
            });
        });
    </script>

    @yield('extra_js')
</body>
</html>
