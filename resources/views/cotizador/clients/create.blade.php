@extends(auth()->user()->user_type === 'ADMIN' ? 'layouts.admin' : 'layouts.cotizador')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Nuevo Cliente</h1>
    <a href="{{ route('cotizador.clients') }}" class="btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
</div>

<div class="form-card">
    <form action="{{ route('cotizador.clients.store') }}" method="POST">
        @csrf

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Nombre <span class="required">*</span></label>
                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Nombre completo" required maxlength="120">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Correo electrónico <span class="required">*</span></label>
                <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="cliente@empresa.com" required maxlength="180">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Empresa / Organización</label>
                <input type="text" name="company" class="form-input @error('company') is-invalid @enderror"
                    value="{{ old('company') }}" placeholder="Nombre de la empresa" maxlength="150">
                @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">NIT / Cédula</label>
                <input type="text" name="nit" class="form-input @error('nit') is-invalid @enderror"
                    value="{{ old('nit') }}" placeholder="123456789-0" maxlength="30">
                @error('nit')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="text" name="phone" class="form-input @error('phone') is-invalid @enderror"
                    value="{{ old('phone') }}" placeholder="+57 300 000 0000" maxlength="30">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Ciudad</label>
                <input type="text" name="city" class="form-input @error('city') is-invalid @enderror"
                    value="{{ old('city') }}" placeholder="Bogotá, Medellín..." maxlength="80">
                @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Notas internas</label>
            <textarea name="notes" class="form-input @error('notes') is-invalid @enderror"
                rows="3" placeholder="Observaciones sobre el cliente (opcional)" maxlength="500">{{ old('notes') }}</textarea>
            @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fa fa-save"></i> Guardar Cliente
            </button>
            <a href="{{ route('cotizador.clients') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
