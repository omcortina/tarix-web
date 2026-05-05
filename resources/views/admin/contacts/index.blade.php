@extends('layouts.admin')

@section('title', 'Mensajes de Contacto')

@section('extra_css')
<style>
    .message-row.unread { background: #f0f9ff; font-weight: 600; }
    .badge-unread { background: #fff3e0; color: #e65100; }
    .badge-read { background: #e8f5e9; color: #2e7d32; }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">Dashboard</a>
        <span>/</span>
        <span>Mensajes de Contacto</span>
    </div>

    <div class="admin-header">
        <h1>Mensajes de Contacto</h1>
    </div>

    @if($contacts->count())
        <div class="messages-table">
            <table class="table" id="adminTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Empresa</th>
                        <th>Estado</th>
                        <th>Acciones</th>
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
    @else
        <div class="empty-state">
            <p>No hay mensajes de contacto aún.</p>
        </div>
    @endif
</div>
@endsection

@section('extra_js')
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
@endsection
