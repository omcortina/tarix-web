@extends(auth()->user()->user_type === 'ADMIN' ? 'layouts.admin' : 'layouts.cotizador')

@section('title', 'Clientes')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/index-user.css') }}">
@endsection

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Clientes</h1>
    <a href="{{ route('cotizador.clients.create') }}" class="btn-primary">
        <i class="fa fa-plus"></i> Nuevo Cliente
    </a>
</div>

<div class="form-card" style="padding:0;overflow:hidden;">
    @if($clients->isEmpty())
        <div style="padding:40px;text-align:center;color:#6b7280;">
            <i class="fa fa-users" style="font-size:36px;margin-bottom:12px;display:block;color:#d1d5db;"></i>
            No hay clientes guardados. <a href="{{ route('cotizador.clients.create') }}">Agrega el primero</a>.
        </div>
    @else
        <table class="admin-table" id="adminTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Empresa</th>
                    <th>Teléfono</th>
                    <th>Ciudad</th>
                    <th style="width:120px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td><strong>{{ $client->name }}</strong></td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->company ?: '—' }}</td>
                    <td>{{ $client->phone ?: '—' }}</td>
                    <td>{{ $client->city ?: '—' }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('cotizador.clients.edit', $client) }}" class="btn-verify btn-edit" title="Editar">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <form id="deleteForm-{{ $client->id }}" action="{{ route('cotizador.clients.destroy', $client) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" class="btn-verify btn-reject" title="Eliminar"
                                    onclick="confirmDelete(event, {{ $client->id }}, 'cliente')">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:16px 20px;">
            {{ $clients->links('vendor.pagination.custom') }}
        </div>
    @endif
</div>
@endsection
