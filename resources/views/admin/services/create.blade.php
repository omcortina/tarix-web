<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($service) ? 'Editar' : 'Crear' }} Servicio - TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-services-form.css') }}">
</head>
<body>
    <!-- NAV -->
    <nav>
        <a href="/" class="nav-logo">
            <div class="logo-icon">
                <div class="logo-t">T</div>
            </div>
            <div class="logo-text">
                <span class="logo-name">TARIX</span>
                <span class="logo-sub">Soluciones en Comercio Exterior</span>
            </div>
        </a>
        <div class="nav-links">
            <a href="/">Volver al Sitio</a>
            <a href="{{ route('admin.services.index') }}" class="nav-cta">Volver a Servicios</a>
        </div>
    </nav>

    <div class="admin-container">
        <div style="margin-bottom: 20px; display: flex; gap: 8px; align-items: center; font-size: 14px; color: #666;">
            <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Dashboard
            </a>
            <span>/</span>
            <a href="{{ route('admin.services.index') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Servicios
            </a>
            <span>/</span>
            <span>{{ isset($service) ? 'Editar' : 'Crear' }}</span>
        </div>

        <div class="form-header">
            <h1>{{ isset($service) ? 'Editar Servicio' : 'Crear Nuevo Servicio' }}</h1>
            <p>Completa los datos del servicio para publicarlo en el sitio web</p>
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

        <form class="form-card" method="POST" action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}">
            @csrf
            @if(isset($service))
                @method('PUT')
            @endif

            <!-- INFORMACIÓN BÁSICA -->
            <div class="form-section">
                <div class="form-section-title">Información Básica</div>
                
                <div class="form-group">
                    <div>
                        <label for="slug">URL Slug *</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $service->slug ?? '') }}" placeholder="clasificacion-arancelaria" required>
                        <div class="hint">Usado en la URL: /tu-slug</div>
                    </div>
                    <div>
                        <label for="title">Título del Servicio *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', getSpanish($service->title ?? '')) }}" placeholder="Clasificación Arancelaria" required>
                    </div>
                </div>

                <div class="form-group full">
                    <label for="subtitle">Subtítulo *</label>
                    <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', getSpanish($service->subtitle ?? '')) }}" placeholder="Descripción corta del servicio" required>
                </div>

                <div class="form-group full">
                    <label for="description">Descripción Breve *</label>
                    <textarea id="description" name="description" placeholder="Descripción que aparecerá en la tarjeta del servicio" required>{{ old('description', getSpanish($service->description ?? '')) }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Selecciona un Icono</label>
                    
                    <input type="hidden" id="icon_class" name="icon_class" value="{{ old('icon_class', $service->icon_class ?? 'icon-classification') }}">
                    
                    <div class="icon-gallery">
                        @foreach($icons as $icon)
                            <label class="icon-option">
                                <input type="radio" name="icon_class_radio" value="{{ $icon->class }}" {{ (old('icon_class', $service->icon_class ?? '') == $icon->class) ? 'checked' : '' }} onchange="document.getElementById('icon_class').value = this.value">
                                <div class="icon-item">
                                    <div class="icon-preview">
                                        {!! $icon->svg !!}
                                    </div>
                                    <div class="icon-label">{{ $icon->label }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- CONTENIDO DETALLADO -->
            <div class="form-section">
                <div class="form-section-title">Contenido de la Página</div>
                
                <div class="form-group full-width">
                    <label for="what_is_section">Sección "¿Qué es?"</label>
                    <textarea id="what_is_section" name="what_is_section" class="textarea-large" placeholder="Explicación detallada del servicio...">{{ old('what_is_section', getSpanish($service->what_is_section ?? '')) }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label for="process_section">Sección "Nuestro Proceso"</label>
                    <textarea id="process_section" name="process_section" class="textarea-large" placeholder="Descripción de los pasos del proceso...">{{ old('process_section', getSpanish($service->process_section ?? '')) }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label for="why_section">Sección "¿Por Qué Elegirnos?"</label>
                    <textarea id="why_section" name="why_section" class="textarea-large" placeholder="Razones por las que deberían elegir tus servicios...">{{ old('why_section', getSpanish($service->why_section ?? '')) }}</textarea>
                </div>
            </div>

            <!-- PUBLICACIÓN -->
            <div class="form-section">
                <div class="form-section-title">Publicación</div>
                
                <div class="form-group full">
                    <div class="checkbox-group">
                        <input type="hidden" name="published" value="0">
                        <input type="checkbox" id="published" name="published" value="1" 
                            {{ old('published', $service->published ?? true) ? 'checked' : '' }}>
                        <label for="published">Publicar este servicio</label>
                    </div>
                    <div class="hint">Si no está marcado, el servicio será guardado como borrador</div>
                </div>

                <div class="form-group full">
                    <div class="checkbox-group">
                        <input type="hidden" name="show_in_footer" value="0">
                        <input type="checkbox" id="show_in_footer" name="show_in_footer" value="1" 
                            {{ old('show_in_footer', $service->show_in_footer ?? false) ? 'checked' : '' }}>
                        <label for="show_in_footer">Mostrar este servicio en el footer</label>
                    </div>
                    <div class="hint">Si está marcado, aparecerá en la sección de servicios del footer de la página principal</div>
                </div>
            </div>

            <!-- ACCIONES -->
            <div class="form-actions">
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancelar</a>
                @if(isset($service) && $service->id)
                    <a href="{{ route('admin.services.edit-resources', $service) }}" class="btn btn-info">
                        Información útil
                    </a>
                @endif
                <button type="submit" class="btn btn-primary">
                    {{ isset($service) ? 'Actualizar servicio' : 'Crear servicio' }}
                </button>
            </div>
        </form>
    </div>
</body>
</html>
