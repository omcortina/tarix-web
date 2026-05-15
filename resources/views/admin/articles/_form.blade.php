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
                            Imagen actual guardada
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
                            Video YouTube actual guardado
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
