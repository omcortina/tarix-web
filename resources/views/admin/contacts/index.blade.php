<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto | Admin - TARIX</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        body { background: #f5f7fa; font-family: 'Inter', sans-serif; }
        .admin-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .admin-header h1 { font-size: 28px; color: #0d2340; margin: 0; }
        .breadcrumb { font-size: 14px; color: #666; margin-bottom: 20px; }
        .breadcrumb a { color: #22c5bc; text-decoration: none; margin: 0 5px; }
        .messages-table { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .table { width: 100%; border-collapse: collapse; }
        .table th { background: #f8f9fa; padding: 16px; text-align: left; font-weight: 600; color: #0d2340; border-bottom: 1px solid #e0e0e0; }
        .table td { padding: 16px; border-bottom: 1px solid #e0e0e0; }
        .table tr:hover { background: #f8f9fa; }
        .message-row { cursor: pointer; }
        .message-row.unread { background: #f0f9ff; font-weight: 600; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-unread { background: #fff3e0; color: #e65100; }
        .badge-read { background: #e8f5e9; color: #2e7d32; }
        .btn-view { padding: 6px 12px; background: #0066cc; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; }
        .btn-view:hover { background: #0052a3; }
        .btn-delete { padding: 6px 12px; background: #ff6b6b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; }
        .btn-delete:hover { background: #ff5252; }
        .empty-state { text-align: center; padding: 60px 20px; color: #999; }
        .pagination { margin-top: 30px; display: flex; justify-content: center; gap: 5px; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #0066cc; }
        .pagination .active { background: #0066cc; color: white; border-color: #0066cc; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="admin-container">
        <div style="margin-bottom: 20px; display: flex; gap: 8px; align-items: center; font-size: 14px; color: #666;">
            <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Dashboard
            </a>
            <span>/</span>
            <span>Mensajes de Contacto</span>
        </div>

        <div class="admin-header">
            <h1>Mensajes de Contacto</h1>
        </div>

        @if($contacts->count())
            <div class="messages-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Nombre</th>
                            <th style="width: 25%;">Email</th>
                            <th style="width: 15%;">Empresa</th>
                            <th style="width: 15%;">Estado</th>
                            <th style="width: 25%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                            <tr class="message-row {{ !$contact->is_read ? 'unread' : '' }}">
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->company ?? '—' }}</td>
                                <td>
                                    <span class="badge {{ $contact->is_read ? 'badge-read' : 'badge-unread' }}">
                                        {{ $contact->is_read ? 'Leído' : 'Nuevo' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="btn-view">Ver</a>
                                    <form id="deleteForm-{{ $contact->id }}" action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-delete" onclick="confirmDelete(event, '{{ $contact->id }}', 'mensaje')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $contacts->links() }}
            </div>
        @else
            <div class="empty-state">
                <p>No hay mensajes de contacto en este momento.</p>
            </div>
        @endif
    </div>

    <script>
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
</body>
</html>
