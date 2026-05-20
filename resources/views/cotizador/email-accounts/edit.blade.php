@extends('layouts.cotizador')

@section('title', 'Editar Cuenta de Correo')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Editar Cuenta: {{ $emailAccount->name }}</h1>
    <a href="{{ route('cotizador.email-accounts') }}" class="btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
</div>

<div class="form-card">
    <form action="{{ route('cotizador.email-accounts.update', $emailAccount) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-section-title">Información General</div>
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Nombre de la cuenta <span class="required">*</span></label>
                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                    value="{{ old('name', $emailAccount->name) }}" required maxlength="120">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Dirección de correo <span class="required">*</span></label>
                <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                    value="{{ old('email', $emailAccount->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-section-divider">
            <div class="form-section-title">Configuración IMAP</div>
        </div>
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Servidor IMAP</label>
                <input type="text" name="imap_host" class="form-input"
                    value="{{ old('imap_host', $emailAccount->imap_host) }}" placeholder="imap.gmail.com">
            </div>
            <div class="form-group">
                <label class="form-label">Puerto IMAP</label>
                <input type="number" name="imap_port" class="form-input"
                    value="{{ old('imap_port', $emailAccount->imap_port) }}">
            </div>
        </div>
        <div class="form-row-3">
            <div class="form-group">
                <label class="form-label">Cifrado IMAP</label>
                <select name="imap_encryption" class="form-input">
                    @foreach(['ssl','tls','starttls','none'] as $enc)
                        <option value="{{ $enc }}" {{ old('imap_encryption', $emailAccount->imap_encryption) == $enc ? 'selected' : '' }}>
                            {{ strtoupper($enc) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Usuario IMAP</label>
                <input type="text" name="imap_username" class="form-input"
                    value="{{ old('imap_username', $emailAccount->imap_username) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Nueva contraseña IMAP</label>
                <input type="password" name="imap_password" class="form-input" autocomplete="new-password"
                    placeholder="Dejar en blanco para no cambiar">
            </div>
        </div>

        <div class="form-section-divider">
            <div class="form-section-title">Configuración SMTP</div>
        </div>
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Servidor SMTP</label>
                <input type="text" name="smtp_host" class="form-input"
                    value="{{ old('smtp_host', $emailAccount->smtp_host) }}" placeholder="smtp.gmail.com">
            </div>
            <div class="form-group">
                <label class="form-label">Puerto SMTP</label>
                <input type="number" name="smtp_port" class="form-input"
                    value="{{ old('smtp_port', $emailAccount->smtp_port) }}">
            </div>
        </div>
        <div class="form-row-3">
            <div class="form-group">
                <label class="form-label">Cifrado SMTP</label>
                <select name="smtp_encryption" class="form-input">
                    @foreach(['tls','ssl','starttls','none'] as $enc)
                        <option value="{{ $enc }}" {{ old('smtp_encryption', $emailAccount->smtp_encryption) == $enc ? 'selected' : '' }}>
                            {{ strtoupper($enc) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Usuario SMTP</label>
                <input type="text" name="smtp_username" class="form-input"
                    value="{{ old('smtp_username', $emailAccount->smtp_username) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Nueva contraseña SMTP</label>
                <input type="password" name="smtp_password" class="form-input" autocomplete="new-password"
                    placeholder="Dejar en blanco para no cambiar">
            </div>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Nombre del remitente</label>
                <input type="text" name="smtp_from_name" class="form-input"
                    value="{{ old('smtp_from_name', $emailAccount->smtp_from_name) }}">
            </div>
            <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:4px;">
                <label class="form-label checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ $emailAccount->is_active ? 'checked' : '' }}>
                    Cuenta activa
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fa fa-save"></i> Actualizar
            </button>
            <a href="{{ route('cotizador.email-accounts') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
