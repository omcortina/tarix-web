@extends('layouts.admin')

@section('title', 'Configuración')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('css/classifications-settings.css') }}">
@endsection

@section('content')
    <div class="settings-container">
        <h1 style="margin-bottom: 30px; color: #333;">Configuración de Clasificaciones</h1>
        
        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Error al guardar:</strong>
                <ul style="margin: 5px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('admin.classifications.settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <fieldset style="border: none; padding: 0;">
                <legend style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: #2c3e50;">Precios por Item</legend>
                
                <div class="price-row">
                    <div class="form-group">
                        <label for="price_general">Precio Cliente GENERAL</label>
                        <input 
                            type="number" 
                            id="price_general" 
                            name="price_general" 
                            value="{{ $setting->price_general ?? 50000 }}" 
                            step="0.01"
                            min="0"
                            required
                        >
                        <div class="form-description">Precio por ítem para clientes regulares</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="price_preferential">Precio Cliente PREFERENCIAL</label>
                        <input 
                            type="number" 
                            id="price_preferential" 
                            name="price_preferential" 
                            value="{{ $setting->price_preferential ?? 30000 }}" 
                            step="0.01"
                            min="0"
                            required
                        >
                        <div class="form-description">Precio por ítem para clientes preferenciales</div>
                    </div>
                </div>
            </fieldset>

            <fieldset style="border: none; padding: 0; margin-top: 30px;">
                <legend style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: #2c3e50;">Impuestos</legend>

                <div class="price-row">
                    <div class="form-group">
                        <label for="iva_percentage">Porcentaje de IVA (%)</label>
                        <input
                            type="number"
                            id="iva_percentage"
                            name="iva_percentage"
                            value="{{ $setting->iva_percentage ?? 19 }}"
                            step="0.01"
                            min="0"
                            max="100"
                            required
                        >
                        <div class="form-description">Porcentaje de IVA aplicado al subtotal (ej: 19 para 19%)</div>
                    </div>
                </div>
            </fieldset>

            <fieldset style="border: none; padding: 0; margin-top: 30px;">
                <legend style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: #2c3e50;">Límites del Sistema</legend>
                
                <div class="limits-row">
                    <div class="form-group">
                        <label for="max_items">Máximo de Ítems por Clasificación</label>
                        <input 
                            type="number" 
                            id="max_items" 
                            name="max_items" 
                            value="{{ $setting->max_items ?? 50 }}" 
                            min="1"
                            required
                        >
                        <div class="form-description">Número máximo de ítems permitidos</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="max_attachment_size_mb">Tamaño Máximo de Anexos (MB)</label>
                        <input 
                            type="number" 
                            id="max_attachment_size_mb" 
                            name="max_attachment_size_mb" 
                            value="{{ $setting->max_attachment_size_mb ?? 10 }}" 
                            min="1"
                            required
                        >
                        <div class="form-description">Tamaño máximo por archivo adjunto</div>
                    </div>
                </div>
            </fieldset>
            
            <div class="button-group">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="text-decoration: none; display: inline-block;">
                    Volver
                </a>
                <button type="submit" class="btn btn-primary">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
