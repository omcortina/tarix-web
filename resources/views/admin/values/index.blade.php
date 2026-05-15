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
        transition: background 0.2s, color 0.2s;
    }

    .btn-deactivate {
        background: #FFF3E0;
        color: #F57C00;
        border: 1px solid #FFD699;
    }

    .btn-deactivate:hover {
        background: #F57C00;
        color: white;
        border-color: #F57C00;
    }

    .btn-activate {
        background: #E8F5E9;
        color: #388E3C;
        border: 1px solid #C8E6C9;
    }

    .btn-activate:hover {
        background: #388E3C;
        color: white;
        border-color: #388E3C;
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
        <div class="services-table">
            <table class="table" id="adminTable">
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
                                <span class="badge" style="background-color: {{ $value->icon_color }}; color: white;">
                                    {{ $value->icon_color }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $value->is_active ? 'badge-success' : 'badge-warning' }}">
                                    {{ $value->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $value->order }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.values.edit', $value) }}" class="btn-edit">Editar</a>
                                <form id="toggleForm-{{ $value->id }}" action="{{ route('admin.values.toggle', $value) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-toggle {{ $value->is_active ? 'btn-deactivate' : 'btn-activate' }}">
                                        {{ $value->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                                <form id="deleteForm-{{ $value->id }}" action="{{ route('admin.values.destroy', $value) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete" onclick="confirmDelete(event, '{{ $value->id }}')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
