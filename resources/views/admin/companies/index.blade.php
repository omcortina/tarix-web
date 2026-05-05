@extends('layouts.admin')

@section('title', 'Gestión de Empresas')

@section('extra_css')
<style>
    .admin-header { display: flex; justify-content: space-between; align-items: center; }
    .admin-header h1 { font-size: 32px; }
    .companies-table { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">Dashboard</a>
        <span>/</span>
        <span>Empresas</span>
    </div>

    <div class="admin-header">
        <h1>Gestión de Empresas</h1>
        <a href="{{ route('admin.companies.create') }}" class="btn-new">+ Nueva Empresa</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if ($companies->count() > 0)
        <div class="companies-table">
            <table class="table" id="adminTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>NIT</th>
                        <th>Contacto</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Usuarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $company)
                        <tr>
                            <td>
                                <strong>{{ $company->name }}</strong>
                                @if($company->isTarix())
                                    <span class="badge badge-info" style="margin-left: 8px;">(Default)</span>
                                @endif
                            </td>
                            <td>{{ $company->nit ?? '-' }}</td>
                            <td>{{ $company->contact_name ?? '-' }}</td>
                            <td>{{ $company->contact_email ?? '-' }}</td>
                            <td>
                                @if($company->is_active)
                                    <span class="badge badge-success">Activa</span>
                                @else
                                    <span class="badge badge-warning">Inactiva</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $company->users()->count() }}</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.companies.show', $company) }}" class="btn-view">
                                        Ver
                                    </a>
                                    @if(!$company->isTarix())
                                        <a href="{{ route('admin.companies.edit', $company) }}" class="btn-edit">
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" id="deleteForm-{{ $company->id }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-delete" onclick="confirmDelete(event, '{{ $company->id }}', 'empresa')">
                                                Eliminar
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
            <i class="fa fa-info-circle"></i> No hay empresas registradas. <a href="{{ route('admin.companies.create') }}" style="color: #1565c0; font-weight: 600;">Crear una nueva</a>
        </div>
    @endif
</div>
@endsection
