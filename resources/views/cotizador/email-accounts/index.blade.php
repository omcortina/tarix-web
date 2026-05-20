@extends('layouts.cotizador')

@section('title', 'Cuentas de Correo')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Cuentas de Correo</h1>
    <a href="{{ route('cotizador.email-accounts.create') }}" class="btn-primary">
        <i class="fa fa-plus"></i> Nueva Cuenta
    </a>
</div>

<div class="info-banner">
    <i class="fa fa-info-circle"></i>
    Configura tus cuentas de correo: la parte <strong>IMAP</strong> sirve para sincronizar la bandeja de entrada, y la parte <strong>SMTP</strong> para enviar cotizaciones y respuestas.
</div>

@if($accounts->isEmpty())
    <div class="empty-state">
        <i class="fa fa-envelope-o"></i>
        <p>No hay cuentas configuradas. Agrega una cuenta para empezar.</p>
        <a href="{{ route('cotizador.email-accounts.create') }}" class="btn-primary">Agregar cuenta</a>
    </div>
@else
    <div class="cards-grid">
        @foreach($accounts as $account)
        <div class="account-card {{ $account->is_active ? '' : 'account-inactive' }}">
            <div class="account-card-header">
                <div class="account-icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="account-info">
                    <h3>{{ $account->name }}</h3>
                    <p>{{ $account->email }}</p>
                </div>
                <div class="account-status">
                    @if($account->is_active)
                        <span class="badge badge-success">Activa</span>
                    @else
                        <span class="badge badge-secondary">Inactiva</span>
                    @endif
                </div>
            </div>
            <div class="account-card-body">
                <div class="account-config-row">
                    <span class="config-label">IMAP:</span>
                    <span class="config-value">
                        @if($account->imap_host)
                            {{ $account->imap_host }}:{{ $account->imap_port }} ({{ $account->imap_encryption }})
                        @else
                            <em class="text-muted">No configurado</em>
                        @endif
                    </span>
                </div>
                <div class="account-config-row">
                    <span class="config-label">SMTP:</span>
                    <span class="config-value">
                        @if($account->smtp_host)
                            {{ $account->smtp_host }}:{{ $account->smtp_port }} ({{ $account->smtp_encryption }})
                        @else
                            <em class="text-muted">No configurado</em>
                        @endif
                    </span>
                </div>
            </div>
            <div class="account-card-actions">
                <a href="{{ route('cotizador.inbox', ['account_id' => $account->id]) }}" class="btn-sm btn-info" title="Ver bandeja">
                    <i class="fa fa-inbox"></i> Bandeja
                </a>
                <a href="{{ route('cotizador.email-accounts.edit', $account) }}" class="btn-sm btn-edit" title="Editar">
                    <i class="fa fa-pencil"></i> Editar
                </a>
                <form id="delete-form-{{ $account->id }}" action="{{ route('cotizador.email-accounts.destroy', $account) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                </form>
                <button type="button" class="btn-sm btn-delete" onclick="confirmDelete(event, {{ $account->id }}, 'cuenta de correo')">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
