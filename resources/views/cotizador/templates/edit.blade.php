@extends('layouts.cotizador')

@section('title', 'Editar Plantilla')

@section('extra_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css">
@endsection

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Editar Plantilla</h1>
    <a href="{{ route('cotizador.templates') }}" class="btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
</div>

<div class="form-card">
    <form action="{{ route('cotizador.templates.update', $template) }}" method="POST" id="templateForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nombre interno <span class="required">*</span></label>
            <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                value="{{ old('name', $template->name) }}" required maxlength="120">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Asunto del correo <span class="required">*</span></label>
            <input type="text" name="subject" class="form-input @error('subject') is-invalid @enderror"
                value="{{ old('subject', $template->subject) }}" required maxlength="255">
            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="form-hint">Variables disponibles en el asunto: <code>@{{nombre_cliente}}</code>, <code>@{{empresa_cliente}}</code>, <code>@{{ciudad_cliente}}</code>, <code>@{{fecha}}</code></small>
        </div>

        <div class="form-group">
            <label class="form-label">Cuerpo del mensaje <span class="required">*</span></label>
            <div id="quill-editor" style="min-height:300px;"></div>
            <textarea name="body" id="body-hidden" style="display:none;">{{ old('body', $template->body) }}</textarea>
            @error('body')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            <small class="form-hint">Variables disponibles: <code>@{{nombre_cliente}}</code>, <code>@{{email_cliente}}</code>, <code>@{{empresa_cliente}}</code>, <code>@{{nit_cliente}}</code>, <code>@{{telefono_cliente}}</code>, <code>@{{ciudad_cliente}}</code>, <code>@{{total}}</code>, <code>@{{vigencia}}</code>, <code>@{{fecha}}</code>, <code>@{{remitente}}</code></small>
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">
                <input type="checkbox" name="is_active" value="1" {{ $template->is_active ? 'checked' : '' }}>
                Plantilla activa
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fa fa-save"></i> Actualizar
            </button>
            <a href="{{ route('cotizador.templates') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ]
        }
    });

    // Cargar el cuerpo existente
    const existingBody = document.getElementById('body-hidden').value;
    if (existingBody) {
        quill.clipboard.dangerouslyPasteHTML(existingBody);
    }

    document.getElementById('templateForm').addEventListener('submit', function() {
        document.getElementById('body-hidden').value = quill.root.innerHTML;
    });
</script>
@endsection
