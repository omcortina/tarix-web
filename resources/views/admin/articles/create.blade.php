<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($article) ? 'Editar' : 'Crear' }} Artículo | Admin - TARIX</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
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

                <div class="form-checkbox">
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
        // Auto-save on input
        const titleInput = document.getElementById('title');
        const contentInput = document.getElementById('content');
        
        titleInput?.addEventListener('change', () => {
            console.log('Artículo modificado - considera guardar cambios');
        });

        contentInput?.addEventListener('change', () => {
            console.log('Artículo modificado - considera guardar cambios');
        });
    </script>
</body>
</html>
