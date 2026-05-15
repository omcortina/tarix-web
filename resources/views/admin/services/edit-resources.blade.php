@extends('layouts.admin')

@section('title', 'Gestionar Recursos - ' . $service->title)

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/admin-services-resources.css') }}">
@endsection

@section('content')
<div class="admin-container">
        <!-- Header -->
        <div class="admin-header">
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
                <a href="{{ route('admin.services.index') }}">Servicios</a> /
                <a href="{{ route('admin.services.edit', $service) }}">{{ $service->title }}</a> /
                Recursos Útiles
            </div>
            <h1>Gestionar Información Útil</h1>
            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">{{ $service->title }}</p>
        </div>

        <!-- Mensajes de sesión -->
        @if($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        <!-- Formulario para agregar recurso -->
        <div class="admin-form-box">
            <h3 style="margin-top: 0; color: #1a2d3a; font-family: 'Montserrat', sans-serif;">Agregar Nuevo Recurso</h3>
            
            <form action="{{ route('admin.services.store-resource', $service) }}" method="POST">
                @csrf

                <div class="form-group @error('title') error @enderror">
                    <label for="title">Título del Recurso</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Ej: Nomenclatura Común del Mercosur (NCM)">
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group @error('url') error @enderror">
                    <label for="url">URL</label>
                    <input type="url" id="url" name="url" value="{{ old('url') }}" placeholder="https://ejemplo.com">
                    @error('url')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label for="is_active">Activar este recurso</label>
                    </div>
                    <div class="hint">Si está marcado, el recurso será visible en la página del servicio</div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Agregar Recurso</button>
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>

        <!-- Lista de recursos -->
        <div class="resources-list">
            @if($service->usefulResources->count())
                <div style="padding: 20px; background: #f9f9f9; border-bottom: 1px solid #f0f2f5;">
                    <p style="margin: 0; font-size: 12px; color: #666;">{{ $service->usefulResources->count() }} recurso(s) agregado(s)</p>
                </div>
                @foreach($service->usefulResources as $resource)
                    <div class="resource-item" style="opacity: {{ $resource->is_active ? '1' : '0.6' }}; background: {{ $resource->is_active ? '#fff' : '#f9f9f9' }};">
                        <div class="resource-info">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                <h4 style="margin: 0;">{{ $resource->title }}</h4>
                                <span style="display: inline-block; font-size: 11px; padding: 3px 8px; border-radius: 3px; background: {{ $resource->is_active ? '#e8f5e9' : '#fff3e0' }}; color: {{ $resource->is_active ? '#2e7d32' : '#f57c00' }}; font-weight: 600;">
                                    {{ $resource->is_active ? 'Activo' : '✗ Inactivo' }}
                                </span>
                            </div>
                            <p>{{ $resource->url }}</p>
                        </div>
                        <div class="resource-actions">
                            <form action="{{ route('admin.services.toggle-resource', [$service, $resource]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-icon-toggle" title="{{ $resource->is_active ? 'Desactivar recurso' : 'Activar recurso' }}">
                                    @if($resource->is_active)
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                            <circle cx="12" cy="12" r="4" fill="currentColor"/>
                                        </svg>
                                    @else
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                            <form id="deleteForm-{{ $resource->id }}" action="{{ route('admin.services.destroy-resource', [$service, $resource]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-icon-delete" title="Eliminar recurso" onclick="confirmDelete(event, '{{ $resource->id }}')">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 7H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M6 7V19C6 20.1 6.9 21 8 21H16C17.1 21 18 20.1 18 19V7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 10V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M12 10V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M15 10V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <p>No hay recursos útiles agregados. ¡Agrega uno arriba!</p>
                </div>
            @endif
        </div>

        <!-- Botón de volver -->
        <div style="margin-top: 30px;">
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-secondary">Volver a Editar Servicio</a>
        </div>
    </div>
@endsection

@section('extra_js')
<script>
    function confirmDelete(event, resourceId) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar este recurso? Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff6b6b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + resourceId).submit();
            }
        });
    }
</script>
@endsection
