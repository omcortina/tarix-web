<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($article) ? 'Editar' : 'Crear' }} Artículo | Admin - TARIX</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: #f5f7fa; font-family: 'Inter', sans-serif; }
        .admin-container { max-width: 900px; margin: 0 auto; padding: 40px 20px; }
        .breadcrumb { font-size: 14px; color: #666; margin-bottom: 20px; }
        .breadcrumb a { color: #22c5bc; text-decoration: none; margin: 0 5px; }
        .admin-header h1 { font-size: 28px; color: #0d2340; margin-bottom: 30px; }
        .form-card { background: white; border-radius: 8px; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 24px; }
        .form-group label { display: block; font-weight: 600; color: #0d2340; margin-bottom: 8px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-input, .form-textarea, .form-select { width: 100%; padding: 12px 16px; border: 1.5px solid #dce4ef; border-radius: 6px; font-size: 14px; font-family: 'Inter', sans-serif; transition: border-color 0.2s; }
        .form-input:focus, .form-textarea:focus, .form-select:focus { outline: none; border-color: #22c5bc; }
        .form-textarea { min-height: 300px; resize: vertical; }
        .form-checkbox { margin-top: 20px; }
        .form-checkbox input { margin-right: 8px; width: 18px; height: 18px; cursor: pointer; }
        .form-checkbox label { display: inline-block; font-weight: 500; color: #333; text-transform: none; letter-spacing: normal; font-size: 14px; }
        .form-error { color: #ff6b6b; font-size: 12px; margin-top: 4px; }
        .form-actions { display: flex; gap: 12px; margin-top: 40px; padding-top: 30px; border-top: 2px solid #f0f0f0; }
        .btn { padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: #22c5bc; color: white; }
        .btn-primary:hover { background: #1ba8a0; }
        .btn-secondary { background: #e0e0e0; color: #333; }
        .btn-secondary:hover { background: #d0d0d0; }
        .btn-small { padding: 8px 12px; font-size: 12px; }
        .btn-danger { background: #ff6b6b; color: white; }
        .btn-danger:hover { background: #ff5252; }
        .media-section { background: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 6px; padding: 20px; margin-bottom: 24px; }
        .media-section h3 { color: #0d2340; font-size: 16px; margin-bottom: 16px; }
        .media-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 20px; }
        .media-item { background: white; border: 1px solid #dce4ef; border-radius: 6px; overflow: hidden; }
        .media-preview { width: 100%; height: 120px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .media-preview img { width: 100%; height: 100%; object-fit: cover; }
        .media-preview iframe { width: 100%; height: 100%; border: none; }
        .media-preview .icon { font-size: 40px; color: #ccc; }
        .media-info { padding: 12px; }
        .media-type { font-size: 11px; text-transform: uppercase; color: #999; font-weight: 600; }
        .media-desc { font-size: 13px; color: #333; margin: 8px 0; word-break: break-word; max-height: 40px; overflow: hidden; }
        .media-actions { display: flex; gap: 6px; }
        .media-actions .btn-small { margin: 0; }
        .media-add-form { display: grid; grid-template-columns: 1fr 1fr auto; gap: 12px; align-items: flex-end; }
        .media-add-form input { margin-bottom: 0; }
        @media (max-width: 768px) {
            .media-grid { grid-template-columns: 1fr; }
            .media-add-form { grid-template-columns: 1fr; }
        }
        .loading { display: none; }
        .loading.show { display: inline-block; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div style="margin-bottom: 20px; display: flex; gap: 8px; align-items: center; font-size: 14px; color: #666;">
            <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Dashboard
            </a>
            <span>/</span>
            <a href="{{ route('admin.articles.index') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Artículos
            </a>
            <span>/</span>
            <span>{{ isset($article) ? 'Editar' : 'Crear' }}</span>
        </div>

        <div class="admin-header">
            <h1>{{ isset($article) ? 'Editar Artículo' : 'Nuevo Artículo' }}</h1>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ isset($article) ? route('admin.articles.update', $article) : route('admin.articles.store') }}">
                @csrf
                @if(isset($article))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="title">Título del Artículo *</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        class="form-input{{ $errors->has('title') ? ' is-invalid' : '' }}"
                        value="{{ old('title', getSpanish($article->title ?? '')) }}"
                        placeholder="Ingresa el título del artículo"
                        required
                    >
                    @error('title')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="excerpt">Resumen (Opcional)</label>
                    <textarea 
                        id="excerpt" 
                        name="excerpt" 
                        class="form-input{{ $errors->has('excerpt') ? ' is-invalid' : '' }}"
                        placeholder="Un breve resumen del artículo (máx. 500 caracteres)"
                        style="min-height: 80px;"
                    >{{ old('excerpt', getSpanish($article->excerpt ?? '')) }}</textarea>
                    @error('excerpt')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Contenido del Artículo *</label>
                    <textarea
                        rows="80" 
                        id="content" 
                        name="content" 
                        class="form-input{{ $errors->has('content') ? ' is-invalid' : '' }}"
                        placeholder="Escribe el contenido completo de tu artículo aquí..."
                        required
                    >{{ old('content', getSpanish($article->content ?? '')) }}</textarea>
                    @error('content')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Media Section -->
                <div class="media-section">
                    <h3>Galería Multimedia</h3>
                    <p style="margin: 0 0 16px 0; color: #666; font-size: 13px;">Agrega URL de imagen o video de YouTube (opcional)</p>
                    
                    @php
                        $existingImageMedia = null;
                        $existingYoutubeMedia = null;
                        if(isset($article)) {
                            $existingImageMedia = $article->media()->where('type', 'image')->first();
                            $existingYoutubeMedia = $article->media()->where('type', 'youtube')->first();
                        }
                    @endphp
                    
                    <div class="form-group">
                        <label for="media_image_url">URL de Imagen</label>
                        <input 
                            type="text" 
                            id="media_image_url" 
                            name="media_image_url"
                            class="form-input{{ $errors->has('media_image_url') ? ' is-invalid' : '' }}"
                            placeholder="https://ejemplo.com/imagen.jpg"
                            value="{{ old('media_image_url', $existingImageMedia ? $existingImageMedia->url : '') }}"
                        >
                        @error('media_image_url')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        @if($existingImageMedia)
                            <div style="margin-top: 8px; padding: 8px; background: #e3f2fd; border-radius: 4px; font-size: 12px; color: #1976d2;">
                                ✓ Imagen actual guardada
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="media_youtube_url">URL de YouTube</label>
                        <input 
                            type="text" 
                            id="media_youtube_url" 
                            name="media_youtube_url"
                            class="form-input{{ $errors->has('media_youtube_url') ? ' is-invalid' : '' }}"
                            placeholder="https://www.youtube.com/watch?v=..."
                            value="{{ old('media_youtube_url', $existingYoutubeMedia ? $existingYoutubeMedia->url : '') }}"
                        >
                        @error('media_youtube_url')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        @if($existingYoutubeMedia)
                            <div style="margin-top: 8px; padding: 8px; background: #ffe3e3; border-radius: 4px; font-size: 12px; color: #c62828;">
                                ✓ Video YouTube actual guardado
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="media_description">Descripción (Opcional)</label>
                        <textarea 
                            id="media_description" 
                            name="media_description"
                            class="form-input"
                            placeholder="Descripción de la imagen o video"
                            style="min-height: 60px;"
                        >{{ old('media_description', isset($article) && ($existingImageMedia || $existingYoutubeMedia) ? getSpanish(($existingImageMedia ?? $existingYoutubeMedia)->description ?? '') : '') }}</textarea>
                    </div>

                    <div style="padding: 12px; background: #f0f8ff; border-left: 4px solid #22c5bc; border-radius: 4px; font-size: 13px; color: #333;">
                        <strong>Nota:</strong> Completa solo una URL (imagen O YouTube). Se guardará cuando publiques o actualices el artículo.
                    </div>
                </div>

                <div class="form-checkbox">
                    <input type="hidden" name="published" value="0">
                    <input 
                        type="checkbox" 
                        id="published" 
                        name="published" 
                        value="1"
                        {{ old('published', $article->published ?? false) ? 'checked' : '' }}
                    >
                    <label for="published">Publicar este artículo</label>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($article) ? 'Actualizar' : 'Publicar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Validar que no se envíen ambas URLs
        document.querySelector('form').addEventListener('submit', function(e) {
            const imageUrl = document.getElementById('media_image_url').value.trim();
            const youtubeUrl = document.getElementById('media_youtube_url').value.trim();
            
            if (imageUrl && youtubeUrl) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    html: 'Por favor completa solo <strong>UNA URL</strong>:<br>- URL de Imagen<br>- O URL de YouTube<br><br>(No ambas)',
                    confirmButtonColor: '#22c5bc',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }
        });
    </script>
</body>
</html>
