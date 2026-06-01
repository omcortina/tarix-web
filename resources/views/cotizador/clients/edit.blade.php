@extends(auth()->user()->user_type === 'ADMIN' ? 'layouts.admin' : 'layouts.cotizador')

@section('title', 'Editar Cliente')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Editar Cliente</h1>
    <a href="{{ route('cotizador.clients') }}" class="btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
</div>

<div class="form-card">
    <form action="{{ route('cotizador.clients.update', $client) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Nombre <span class="required">*</span></label>
                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                    value="{{ old('name', $client->name) }}" required maxlength="120">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Correo electrónico <span class="required">*</span></label>
                <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                    value="{{ old('email', $client->email) }}" required maxlength="180">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Empresa / Organización</label>
                <input type="text" name="company" class="form-input @error('company') is-invalid @enderror"
                    value="{{ old('company', $client->company) }}" maxlength="150">
                @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">NIT / Cédula</label>
                <input type="text" name="nit" class="form-input @error('nit') is-invalid @enderror"
                    value="{{ old('nit', $client->nit) }}" maxlength="30">
                @error('nit')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="text" name="phone" class="form-input @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $client->phone) }}" maxlength="30">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Ciudad</label>
                <input type="text" name="city" class="form-input @error('city') is-invalid @enderror"
                    value="{{ old('city', $client->city) }}" maxlength="80">
                @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Notas internas</label>
            <textarea name="notes" class="form-input @error('notes') is-invalid @enderror"
                rows="3" maxlength="500">{{ old('notes', $client->notes) }}</textarea>
            @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fa fa-save"></i> Actualizar Cliente
            </button>
            <a href="{{ route('cotizador.clients') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
