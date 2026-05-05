@extends('layouts.admin')

@section('title', 'Admin | Servicios')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/admin-services-index.css') }}">
@endsection

@section('content')
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

    @if($services->count() > 0)
        <div class="services-table">
            <table class="table" id="adminTable">
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
                                <span class="badge {{ $service->published ? 'badge-published' : 'badge-draft' }}">
                                    {{ $service->published ? 'Publicado' : 'Borrador' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn-edit">Editar</a>
                                <form id="deleteForm-{{ $service->id }}" action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete" onclick="confirmDelete(event, '{{ $service->id }}', 'servicio')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <h2>Sin servicios aún</h2>
            <p>Comienza creando tu primer servicio haciendo clic en el botón de arriba.</p>
            <a href="{{ route('admin.services.create') }}" class="btn-primary">Crear Primer Servicio</a>
        </div>
    @endif
</div>
@endsection
