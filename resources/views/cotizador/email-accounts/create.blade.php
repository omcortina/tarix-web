@extends(auth()->user()->user_type === 'ADMIN' ? 'layouts.admin' : 'layouts.cotizador')

@section('title', 'Nueva Cuenta de Correo')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Nueva Cuenta de Correo</h1>
    <a href="{{ route('cotizador.email-accounts') }}" class="btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
</div>

<div class="form-card">
    <form action="{{ route('cotizador.email-accounts.store') }}" method="POST">
        @csrf

        <div class="form-section-title">Información General</div>
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Nombre de la cuenta <span class="required">*</span></label>
                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Ej: Correo Ventas, Correo Principal..." required maxlength="120">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Dirección de correo <span class="required">*</span></label>
                <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="correo@empresa.com" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-section-divider">
            <div class="form-section-title">Configuración IMAP (Recibir / Sincronizar)</div>
            <small class="form-hint">Para sincronizar correos entrantes desde tu bandeja de entrada</small>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Servidor IMAP</label>
                <input type="text" name="imap_host" class="form-input @error('imap_host') is-invalid @enderror"
                    value="{{ old('imap_host') }}" placeholder="imap.gmail.com / imap.outlook.com">
                @error('imap_host')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Puerto IMAP</label>
                <input type="number" name="imap_port" class="form-input"
                    value="{{ old('imap_port', 993) }}" min="1" max="65535">
            </div>
        </div>
        <div class="form-row-3">
            <div class="form-group">
                <label class="form-label">Cifrado IMAP <span class="required">*</span></label>
                <select name="imap_encryption" class="form-input">
                    <option value="ssl" {{ old('imap_encryption','ssl') == 'ssl' ? 'selected' : '' }}>SSL (puerto 993)</option>
                    <option value="tls" {{ old('imap_encryption') == 'tls' ? 'selected' : '' }}>TLS</option>
                    <option value="starttls" {{ old('imap_encryption') == 'starttls' ? 'selected' : '' }}>STARTTLS</option>
                    <option value="none" {{ old('imap_encryption') == 'none' ? 'selected' : '' }}>Sin cifrado</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Usuario IMAP</label>
                <input type="text" name="imap_username" class="form-input"
                    value="{{ old('imap_username') }}" placeholder="correo@empresa.com o usuario">
            </div>
            <div class="form-group">
                <label class="form-label">Contraseña IMAP</label>
                <input type="password" name="imap_password" class="form-input" autocomplete="new-password"
                    placeholder="Contraseña o clave de aplicación">
            </div>
        </div>

        <div class="form-section-divider">
            <div class="form-section-title">Configuración SMTP (Enviar)</div>
            <small class="form-hint">Para enviar cotizaciones y respuestas</small>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Servidor SMTP</label>
                <input type="text" name="smtp_host" class="form-input @error('smtp_host') is-invalid @enderror"
                    value="{{ old('smtp_host') }}" placeholder="smtp.gmail.com / smtp.office365.com">
                @error('smtp_host')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Puerto SMTP</label>
                <input type="number" name="smtp_port" class="form-input"
                    value="{{ old('smtp_port', 587) }}" min="1" max="65535">
            </div>
        </div>
        <div class="form-row-3">
            <div class="form-group">
                <label class="form-label">Cifrado SMTP <span class="required">*</span></label>
                <select name="smtp_encryption" class="form-input">
                    <option value="tls" {{ old('smtp_encryption','tls') == 'tls' ? 'selected' : '' }}>TLS (puerto 587)</option>
                    <option value="ssl" {{ old('smtp_encryption') == 'ssl' ? 'selected' : '' }}>SSL (puerto 465)</option>
                    <option value="starttls" {{ old('smtp_encryption') == 'starttls' ? 'selected' : '' }}>STARTTLS</option>
                    <option value="none" {{ old('smtp_encryption') == 'none' ? 'selected' : '' }}>Sin cifrado</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Usuario SMTP</label>
                <input type="text" name="smtp_username" class="form-input"
                    value="{{ old('smtp_username') }}" placeholder="correo@empresa.com o usuario">
            </div>
            <div class="form-group">
                <label class="form-label">Contraseña SMTP</label>
                <input type="password" name="smtp_password" class="form-input" autocomplete="new-password"
                    placeholder="Contraseña o clave de aplicación">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Nombre del remitente</label>
            <input type="text" name="smtp_from_name" class="form-input"
                value="{{ old('smtp_from_name') }}" placeholder="Nombre que verá el destinatario">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fa fa-save"></i> Guardar Cuenta
            </button>
            <a href="{{ route('cotizador.email-accounts') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
