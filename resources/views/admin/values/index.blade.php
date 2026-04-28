@extends('layouts.admin')

@section('title', 'Gestionar Valores')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/admin-services-index.css') }}">
<style>
    .admin-container {
        display: block;
    }

    .order-badge {
        background: #f0fffe;
        color: #22c5bc;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-toggle {
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-toggle:hover {
        opacity: 0.8;
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb" style="margin-bottom: 20px; display: flex; gap: 8px; align-items: center; font-size: 14px; color: #666;">
        <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">Dashboard</a>
        <span>/</span>
        <span>Valores</span>
    </div>

    <!-- Header -->
    <div class="admin-header">
        <h1>Gestionar Valores</h1>
        <a href="{{ route('admin.values.create') }}">+ Nuevo Valor</a>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table or Empty State -->
    @if($values->count() > 0)
        <table class="services-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Icono</th>
                    <th>Color</th>
                    <th>Estado</th>
                    <th>Orden</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($values as $value)
                    <tr>
                        <td>
                            <div class="service-title">{{ $value->getTranslation('name', app()->getLocale()) }}</div>
                            <div class="service-slug">{{ $value->getTranslation('name', app()->getLocale() === 'es' ? 'en' : 'es') }}</div>
                        </td>
                        <td>
                            <div style="width: 36px; height: 36px; background-color: {{ $value->icon_color }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;">
                                    {!! $value->icon_svg !!}
                                </svg>
                            </div>
                        </td>
                        <td>
                            <span class="color-badge" style="background-color: {{ $value->icon_color }}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                {{ $value->icon_color }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $value->is_active ? 'status-published' : 'status-draft' }}">
                                {{ $value->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <span class="order-badge">{{ $value->order }}</span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.values.edit', $value) }}" class="btn-edit">Editar</a>
                                <form id="toggleForm-{{ $value->id }}" action="{{ route('admin.values.toggle', $value) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-toggle" style="background: {{ $value->is_active ? '#fff3e0' : '#e8f5e9' }}; color: {{ $value->is_active ? '#f57c00' : '#388e3c' }};">
                                        {{ $value->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                                <form id="deleteForm-{{ $value->id }}" action="{{ route('admin.values.destroy', $value) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete" onclick="confirmDelete(event, '{{ $value->id }}')">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <h2>Sin valores aún</h2>
            <p>Comienza creando tu primer valor haciendo clic en el botón de arriba.</p>
            <a href="{{ route('admin.values.create') }}" class="btn-primary">Crear Primer Valor</a>
        </div>
    @endif
</div>

@endsection

@section('extra_js')
    <script>
        function confirmDelete(event, valueId) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53e3e',
                cancelButtonColor: '#999',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + valueId).submit();
                }
            });
        }
    </script>
@endsection
