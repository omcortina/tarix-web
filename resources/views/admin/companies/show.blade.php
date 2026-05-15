@extends('layouts.admin')

@section('title', $company->name)

@section('extra_css')
<style>
    .admin-container { max-width: 100%; }
    .admin-header { display: flex; justify-content: space-between; align-items: center; }
    .admin-header h1 { font-size: 28px; }
    .card { padding: 30px; margin-bottom: 30px; }
    .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0; }
    .card-header h2 { font-size: 18px; }
    .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
    .info-row .label { width: 30%; }
    .info-row .value { flex: 1; word-break: break-word; }
    .info-row .value a { color: #22c5bc; text-decoration: none; }
    .info-row .value a:hover { text-decoration: underline; }
    .btn-edit { background: #1976D2; color: white; }
    .btn-edit:hover { background: #0f6ece; }
    .btn-danger { background: #ff6b6b; color: white; }
    .btn-danger:hover { background: #ff5252; }
    .section-title { font-size: 18px; font-weight: 700; color: #0d2340; margin-bottom: 20px; margin-top: 30px; }
    .dt-wrapper {width: 100%;padding: 0px !important; display: flex; flex-direction: column}
    .badge-cancelado { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; background: #FDECEA; color: #b71c1c; }
    .btn-cancel-classification { background: none; border: 1px solid #d32f2f; color: #d32f2f; padding: 4px 10px; border-radius: 5px; font-size: 12px; font-weight: 600; cursor: pointer; transition: background 0.2s, color 0.2s; }
    .btn-cancel-classification:hover { background: #d32f2f; color: white; }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.companies.index') }}">Empresas</a>
        <span>/</span>
        <span>{{ $company->name }}</span>
    </div>

    <div class="admin-header">
        <h1>{{ $company->name }}</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Company Details Card -->
    <div class="card">
        <div class="card-header">
            <h2>Información de la empresa</h2>
            @if(!$company->isTarix())
                <div class="card-actions">
                    <a href="{{ route('admin.companies.edit', $company) }}" class="btn btn-sm btn-edit">
                        <i class="fa fa-edit"></i> Editar
                    </a>
                </div>
            @endif
        </div>

        <div class="info-row">
            <span class="label">Nombre:</span>
            <span class="value">
                {{ $company->name }}
                @if($company->isTarix())
                    <span class="badge badge-info" style="margin-left: 8px;">(Default - Tarix)</span>
                @endif
            </span>
        </div>

        <div class="info-row">
            <span class="label">NIT:</span>
            <span class="value">{{ $company->nit ?? 'No especificado' }}</span>
        </div>

        <div class="info-row">
            <span class="label">Contacto:</span>
            <span class="value">{{ $company->contact_name ?? 'No especificado' }}</span>
        </div>

        <div class="info-row">
            <span class="label">Email:</span>
            <span class="value">
                @if($company->contact_email)
                    <a href="mailto:{{ $company->contact_email }}">{{ $company->contact_email }}</a>
                @else
                    No especificado
                @endif
            </span>
        </div>

        <div class="info-row">
            <span class="label">Teléfono:</span>
            <span class="value">{{ $company->contact_phone ?? 'No especificado' }}</span>
        </div>

        <div class="info-row">
            <span class="label">Dirección:</span>
            <span class="value">{{ $company->address ?? 'No especificado' }}</span>
        </div>

        <div class="info-row">
            <span class="label">Estado:</span>
            <span class="value">
                @if($company->is_active)
                    <span class="badge badge-success">Activa</span>
                @else
                    <span class="badge badge-warning">Inactiva</span>
                @endif
            </span>
        </div>

        <div class="info-row" style="border-bottom: none;">
            <span class="label">Creada:</span>
            <span class="value">{{ $company->created_at->format('d/m/Y H:i') }}</span>
        </div>

        @if(!$company->isTarix())
            @if($company->users()->count() === 0)
                <div style="margin-top: 25px; padding-top: 15px; border-top: 2px solid #f0f0f0;">
                    <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro? Esta acción no se puede deshacer.')">
                            <i class="fa fa-trash"></i> Eliminar Empresa
                        </button>
                    </form>
                </div>
            @endif
        @endif
    </div>

    <!-- Users Section -->
    <div class="card">
        <div class="card-header">
            <h2>Usuarios Asociados ({{ $users->count() }})</h2>
        </div>

        @if ($users->count() > 0)
            <div class="table-responsive">
                <table id="usersTable" class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Verificado</th>
                            <th>Fecha Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $user->user_type }}</span>
                                </td>
                                <td>
                                    @if($user->is_verified)
                                        <span class="badge badge-success">Sí</span>
                                    @else
                                        <span class="badge badge-warning">No</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> No hay usuarios asociados a esta empresa.
            </div>
        @endif
    </div>

    <!-- Classifications Section -->
    <div class="card">
        <div class="card-header">
            <h2>Clasificaciones ({{ $classifications->count() }})</h2>
        </div>

        @if ($classifications->count() > 0)
            <div class="table-responsive">
                <table id="classificationsTable" class="table">
                    <thead>
                        <tr>
                            <th>Radicado</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Items</th>
                            <th>Costo</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classifications as $classification)
                            <tr>
                                <td>{{ $classification->radicado }}</td>
                                <td>{{ $classification->user->name ?? '-' }}</td>
                                <td>
                                    @if ($classification->status === 'Cancelado')
                                        <span class="badge-cancelado">Cancelado</span>
                                    @else
                                        <span class="badge badge-info">{{ $classification->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $classification->items->count() }}</td>
                                <td>${{ number_format($classification->total_cost, 0, ',', '.') }}</td>
                                <td>{{ $classification->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div style="display:flex;gap:10px;align-items:center;">
                                        <a href="{{ route('admin.classifications.show', $classification) }}"
                                           style="color:#22c5bc;font-size:13px;font-weight:600;text-decoration:none;">
                                            Ver
                                        </a>
                                        @if (in_array($classification->status, ['Creado', 'Pendiente de pago']))
                                            <form method="POST"
                                                  action="{{ route('admin.classifications.cancel', $classification) }}"
                                                  id="form-cancel-{{ $classification->id }}"
                                                  style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button"
                                                        class="btn-cancel-classification"
                                                        onclick="confirmCancel('form-cancel-{{ $classification->id }}', '{{ addslashes($classification->radicado) }}')"
                                                        title="Cancelar clasificación">
                                                    <i class="fa fa-ban"></i> Cancelar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> No hay clasificaciones de esta empresa.
            </div>
        @endif
    </div>
</div>
@endsection

@section('extra_js')
<script>
function confirmCancel(formId, radicado) {
    Swal.fire({
        title: '¿Cancelar clasificación?',
        text: 'La clasificación ' + radicado + ' será marcada como Cancelado. Esta acción puede registrarse en el historial.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'No, volver'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}

$(document).ready(function() {
    const dtConfig = {
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
        order: [],
        ordering: false,
        dom: '<"dt-wrapper"<"dt-head"<"dt-controls"<"dt-length"l><"dt-search"f>>>tr<"dt-footer"<"dt-info"i><"dt-pagination"p>>>',
        drawCallback: function() {
            $(this.api().table().container()).find('ul.pagination').addClass('pagination-custom');
        }
    };

    @if ($users->count() > 0)
    $('#usersTable').DataTable(dtConfig);
    @endif

    @if ($classifications->count() > 0)
    $('#classificationsTable').DataTable(dtConfig);
    @endif
});
</script>
@endsection
