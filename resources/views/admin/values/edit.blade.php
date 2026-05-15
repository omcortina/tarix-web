@extends('layouts.admin')

@section('title', 'Editar Valor')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/admin-services-form.css') }}">
@endsection

@section('content')
<div class="admin-container">
        <div style="margin-bottom: 20px; display: flex; gap: 8px; align-items: center; font-size: 14px; color: #666;">
            <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Dashboard
            </a>
            <span>/</span>
            <a href="{{ route('admin.values.index') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Valores
            </a>
            <span>/</span>
            <span>Editar</span>
        </div>

        <div class="form-header">
            <h1>Editar Valor</h1>
            <p>Actualiza los datos del valor</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px;">
            <form class="form-card" method="POST" action="{{ route('admin.values.update', $value) }}">
                @csrf
                @method('PUT')

                <!-- INFORMACIÓN BÁSICA -->
                <div class="form-section">
                    <div class="form-section-title">Información Básica</div>
                    
                    <div class="form-group full">
                        <label for="name">Nombre del Valor *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $value->getTranslation('name', 'es')) }}" placeholder="Precisión arancelaria" required>
                        <div class="hint">Se traducirá automáticamente al inglés</div>
                    </div>

                    <div class="form-group full">
                        <label for="description">Descripción *</label>
                        <textarea id="description" name="description" placeholder="Descripción del valor..." required>{{ old('description', $value->getTranslation('description', 'es')) }}</textarea>
                        <div class="hint">Se traducirá automáticamente al inglés</div>
                    </div>
                </div>

                <!-- CONFIGURACIÓN DEL ICONO -->
                <div class="form-section">
                    <div class="form-section-title">Configuración del Icono</div>
                    
                    <div class="form-group full">
                        <label for="icon_color">Color del Icono *</label>
                        <input type="color" id="icon_color" name="icon_color" value="{{ old('icon_color', $value->icon_color) }}" required>
                        <div class="hint">Elige el color de fondo del icono</div>
                    </div>

                    <div class="form-group full">
                        <label for="icon_svg">SVG del Icono *</label>
                        <textarea id="icon_svg" name="icon_svg" placeholder="Pega aquí solo las etiquetas del icono (paths, circles, etc)" required>{{ old('icon_svg', $value->icon_svg) }}</textarea>
                        <div class="hint">Sin la etiqueta &lt;svg&gt;, solo los elementos internos</div>
                    </div>
                </div>

                <!-- ORDEN -->
                <div class="form-section">
                    <div class="form-section-title">Configuración</div>
                    
                    <div class="form-group full">
                        <label for="order">Orden de Aparición *</label>
                        <input type="number" id="order" name="order" value="{{ old('order', $value->order) }}" required>
                        <div class="hint">Número para ordenar los valores (1, 2, 3...)</div>
                    </div>

                    <div class="form-group full">
                        <div class="checkbox-group">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $value->is_active) ? 'checked' : '' }}>
                            <label for="is_active">Activo (visible en el sitio)</label>
                        </div>
                    </div>
                </div>

                <!-- ACCIONES -->
                <div class="form-actions">
                    <a href="{{ route('admin.values.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar valor</button>
                </div>
            </form>

            <!-- PREVIEW -->
            <div class="form-card" style="position: sticky; top: 100px; height: fit-content;">
                <div class="form-section-title">Vista Previa</div>
                
                <div id="preview" style="text-align: center;">
                    <div id="icon-preview" style="width: 80px; height: 80px; margin: 0 auto 20px; background-color: {{ $value->icon_color }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 50px; height: 50px;">
                            {!! $value->icon_svg !!}
                        </svg>
                    </div>
                    <h6 id="preview-name" style="font-weight: 700; color: #1a2e44; margin-bottom: 10px;">{{ $value->getTranslation('name', 'es') }}</h6>
                    <p id="preview-desc" style="font-size: 13px; color: #6b7c93; line-height: 1.5;">{{ Str::limit($value->getTranslation('description', 'es'), 100) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
<script>
    document.getElementById('name').addEventListener('input', function() {
        document.getElementById('preview-name').textContent = this.value || 'Nombre del Valor';
    });
    document.getElementById('description').addEventListener('input', function() {
        document.getElementById('preview-desc').textContent = this.value || 'Descripción del valor';
    });
    document.getElementById('icon_color').addEventListener('input', function() {
        document.getElementById('icon-preview').style.backgroundColor = this.value;
    });
    document.getElementById('icon_svg').addEventListener('input', function() {
        const svg = document.querySelector('#icon-preview svg');
        if (this.value.trim()) {
            svg.innerHTML = this.value;
        }
    });

    document.getElementById('name').dispatchEvent(new Event('input'));
    document.getElementById('description').dispatchEvent(new Event('input'));
    document.getElementById('icon_color').dispatchEvent(new Event('input'));
    document.getElementById('icon_svg').dispatchEvent(new Event('input'));
</script>
@endsection
