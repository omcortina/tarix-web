<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Servicios - TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-services-index.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- NAV -->
    <nav>
        <a href="/" class="nav-logo">
            <div class="logo-icon">
                <div class="logo-t">T</div>
            </div>
            <div class="logo-text">
                <span class="logo-name">TARIX</span>
                <span class="logo-sub">Soluciones en Comercio Exterior</span>
            </div>
        </a>
        <div class="nav-links">
            <a href="/">Volver al Sitio</a>
            <a href="{{ route('admin.dashboard') }}" class="nav-cta">Admin</a>
        </div>
    </nav>

    <div class="admin-container">
        <div style="margin-bottom: 20px; display: flex; gap: 8px; align-items: center; font-size: 14px; color: #666;">
            <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Dashboard
            </a>
            <span>/</span>
            <span>Servicios</span>
        </div>

        <div class="admin-header">
            <h1>Gestionar Servicios</h1>
            <a href="{{ route('admin.services.create') }}">+ Nuevo Servicio</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($services->count() > 0)
            <table class="services-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Slug</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td>
                                <div class="service-title">{{ $service->title }}</div>
                                <div class="service-slug">{{ $service->subtitle }}</div>
                            </td>
                            <td>{{ $service->slug }}</td>
                            <td>
                                <span class="status-badge {{ $service->published ? 'status-published' : 'status-draft' }}">
                                    {{ $service->published ? 'Publicado' : 'Borrador' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn-edit">Editar</a>
                                    <form id="deleteForm-{{ $service->id }}" action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-delete" onclick="confirmDelete(event, '{{ $service->id }}')">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <h2>Sin servicios aún</h2>
                <p>Comienza creando tu primer servicio haciendo clic en el botón de arriba.</p>
                <a href="{{ route('admin.services.create') }}" class="btn-primary">Crear Primer Servicio</a>
            </div>
        @endif
    </div>

    <script>
        function confirmDelete(event, serviceId) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas eliminar este servicio? Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + serviceId).submit();
                }
            });
        }
    </script>
</body>
</html>
