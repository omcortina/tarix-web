@extends(auth()->user()->user_type === 'ADMIN' ? 'layouts.admin' : 'layouts.cotizador')

@section('title', 'Plantillas de Mensaje')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Plantillas de Mensaje</h1>
    <a href="{{ route('cotizador.templates.create') }}" class="btn-primary">
        <i class="fa fa-plus"></i> Nueva Plantilla
    </a>
</div>

@if($templates->isEmpty())
    <div class="form-card">
        <div class="empty-state">
            <i class="fa fa-file-text-o"></i>
            <p>No hay plantillas creadas aún. Las plantillas te permiten reutilizar mensajes comunes para cotizaciones y respuestas.</p>
            <a href="{{ route('cotizador.templates.create') }}" class="btn-primary">Crear primera plantilla</a>
        </div>
    </div>
@else
    <div class="form-card" style="padding: 0; overflow: hidden;">
        <table class="admin-table" id="adminTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Asunto</th>
                    @if(auth()->user()->user_type === 'ADMIN')
                    <th>Creada por</th>
                    @endif
                    <th>Estado</th>
                    <th>Creada</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $template)
                <tr>
                    <td><strong>{{ $template->name }}</strong></td>
                    <td>{{ Str::limit($template->subject, 60) }}</td>
                    @if(auth()->user()->user_type === 'ADMIN')
                    <td>{{ $template->creator->name ?? '-' }}</td>
                    @endif
                    <td>
                        @if($template->is_active)
                            <span class="badge badge-success">Activa</span>
                        @else
                            <span class="badge badge-secondary">Inactiva</span>
                        @endif
                    </td>
                    <td>{{ $template->created_at->format('d/m/Y') }}</td>
                    <td class="actions-cell">
                        <a href="{{ route('cotizador.templates.edit', $template) }}" class="btn-icon-action btn-edit" title="Editar">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <form id="delete-form-{{ $template->id }}" action="{{ route('cotizador.templates.destroy', $template) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button" class="btn-icon-action btn-delete" title="Eliminar"
                            onclick="confirmDelete(event, {{ $template->id }}, 'plantilla')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
