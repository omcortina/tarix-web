@extends('layouts.cotizador')

@section('title', 'Enviar Cotización')

@section('extra_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css">
@endsection

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Enviar Cotización</h1>
    <a href="{{ route('cotizador.quotes.history') }}" class="btn-secondary">
        <i class="fa fa-history"></i> Historial
    </a>
</div>

@if($accounts->isEmpty())
    <div class="alert alert-warning">
        <i class="fa fa-exclamation-triangle"></i>
        No tienes cuentas de correo configuradas.
        <a href="{{ route('cotizador.email-accounts.create') }}">Configura una cuenta</a> para enviar cotizaciones.
    </div>
@else

<div class="form-card">
    <form action="{{ route('cotizador.quotes.send.post') }}" method="POST" id="sendQuoteForm" enctype="multipart/form-data">
        @csrf

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Cuenta de envío <span class="required">*</span></label>
                <select name="email_account_id" class="form-input @error('email_account_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar cuenta --</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ old('email_account_id') == $account->id ? 'selected' : '' }}>
                            {{ $account->name }} ({{ $account->email }})
                        </option>
                    @endforeach
                </select>
                @error('email_account_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Usar plantilla</label>
                <select name="template_id" id="template-selector" class="form-input">
                    <option value="">-- Sin plantilla (redactar libremente) --</option>
                    @foreach($templates as $tpl)
                        <option value="{{ $tpl->id }}" {{ old('template_id') == $tpl->id ? 'selected' : '' }}>
                            {{ $tpl->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Correos destinatarios <span class="required">*</span></label>
            <div id="recipients-list">
                <div class="recipient-row" style="display:flex;gap:8px;margin-bottom:8px;align-items:center;">
                    <input type="email" name="to_emails[]" class="form-input" placeholder="cliente@empresa.com" required style="flex:1">
                    <button type="button" class="btn-remove-recipient" onclick="removeRecipient(this)" style="display:none;padding:6px 10px;background:#fee2e2;border:1px solid #fca5a5;border-radius:6px;cursor:pointer;color:#dc2626;font-size:13px;">✕</button>
                </div>
            </div>
            <button type="button" onclick="addRecipient()" style="margin-top:4px;font-size:13px;color:#1d7afc;background:none;border:none;cursor:pointer;padding:0;">+ Agregar otro destinatario</button>
            @error('to_emails')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            @error('to_emails.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nombre del destinatario</label>
            <input type="text" name="to_name" class="form-input"
                value="{{ old('to_name') }}" placeholder="Nombre completo (opcional)">
            <small class="form-hint">Variable: <code>@{{nombre_cliente}}</code></small>
        </div>

        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label">Cargo del cotizador</label>
                <input type="text" name="sender_title" class="form-input"
                    value="{{ old('sender_title') }}" placeholder="Ej: Asesor Comercial">
                <small class="form-hint">Aparece en la firma del correo. Variable: <code>@{{cargo_cotizador}}</code></small>
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono del cotizador</label>
                <input type="text" name="sender_phone" class="form-input"
                    value="{{ old('sender_phone') }}" placeholder="+57 300 000 0000">
                <small class="form-hint">Aparece en la firma del correo. Variable: <code>@{{telefono_cotizador}}</code></small>
            </div>
        </div>

        {{-- Datos adicionales para variables de plantilla --}}
        <details class="form-details-block" {{ old('to_company') || old('to_nit') || old('to_phone') || old('to_city') || old('quote_total') || old('quote_validity') ? 'open' : '' }}>
            <summary class="form-details-summary">Datos adicionales del destinatario <span class="form-hint-inline">(usados para reemplazar variables en la plantilla)</span></summary>
            <div class="form-details-body">
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Empresa / Organización</label>
                        <input type="text" name="to_company" class="form-input"
                            value="{{ old('to_company') }}" placeholder="Nombre de la empresa">
                        <small class="form-hint">Variable: <code>@{{empresa_cliente}}</code></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NIT / Cédula</label>
                        <input type="text" name="to_nit" class="form-input"
                            value="{{ old('to_nit') }}" placeholder="123456789-0">
                        <small class="form-hint">Variable: <code>@{{nit_cliente}}</code></small>
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="to_phone" class="form-input"
                            value="{{ old('to_phone') }}" placeholder="+57 300 000 0000">
                        <small class="form-hint">Variable: <code>@{{telefono_cliente}}</code></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ciudad</label>
                        <input type="text" name="to_city" class="form-input"
                            value="{{ old('to_city') }}" placeholder="Bogotá, Medellín...">
                        <small class="form-hint">Variable: <code>@{{ciudad_cliente}}</code></small>
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Valor total cotización</label>
                        <input type="text" name="quote_total" class="form-input"
                            value="{{ old('quote_total') }}" placeholder="$ 1.500.000">
                        <small class="form-hint">Variable: <code>@{{total}}</code></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Vigencia de la oferta</label>
                        <input type="text" name="quote_validity" class="form-input"
                            value="{{ old('quote_validity') }}" placeholder="30 días">
                        <small class="form-hint">Variable: <code>@{{vigencia}}</code></small>
                    </div>
                </div>
            </div>
        </details>

        <div class="form-group">
            <label class="form-label">Adjuntar archivos de soporte</label>
            <input type="file" name="attachments[]" class="form-input" multiple
                accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
            <div class="hint-text">Opcional. Puede seleccionar varios archivos. PDF, Word, Excel o imágenes. Máximo 20 MB por archivo.</div>
            @error('attachments')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            @error('attachments.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Asunto <span class="required">*</span></label>
            <input type="text" name="subject" id="subject-input" class="form-input @error('subject') is-invalid @enderror"
                value="{{ old('subject') }}" placeholder="Asunto del correo" required maxlength="255">
            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Mensaje <span class="required">*</span></label>
            <div id="quill-editor" style="min-height:320px;"></div>
            <textarea name="body" id="body-hidden" style="display:none;">{{ old('body') }}</textarea>
            @error('body')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary" id="send-btn">
                <i class="fa fa-paper-plane"></i> Enviar Cotización
            </button>
            <a href="{{ route('cotizador.dashboard') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

@endif
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

    // Cargar old body si existe
    const oldBody = document.getElementById('body-hidden').value;
    if (oldBody) quill.clipboard.dangerouslyPasteHTML(oldBody);

    // Al seleccionar plantilla, cargar asunto y cuerpo via AJAX
    document.getElementById('template-selector').addEventListener('change', function() {
        const id = this.value;
        if (!id) return;

        fetch('{{ route("cotizador.templates.body", ":id") }}'.replace(':id', id))
            .then(r => r.json())
            .then(data => {
                document.getElementById('subject-input').value = data.subject;
                quill.clipboard.dangerouslyPasteHTML(data.body);
            });
    });

    document.getElementById('sendQuoteForm').addEventListener('submit', function(e) {
        document.getElementById('body-hidden').value = quill.root.innerHTML;

        // Prevenir doble clic
        const btn = document.getElementById('send-btn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Enviando...';
    });

    function addRecipient() {
        const list = document.getElementById('recipients-list');
        const row = document.createElement('div');
        row.className = 'recipient-row';
        row.style.cssText = 'display:flex;gap:8px;margin-bottom:8px;align-items:center;';
        row.innerHTML = `<input type="email" name="to_emails[]" class="form-input" placeholder="otro@empresa.com" style="flex:1">
            <button type="button" class="btn-remove-recipient" onclick="removeRecipient(this)" style="padding:6px 10px;background:#fee2e2;border:1px solid #fca5a5;border-radius:6px;cursor:pointer;color:#dc2626;font-size:13px;">✕</button>`;
        list.appendChild(row);
        updateRemoveButtons();
    }

    function removeRecipient(btn) {
        btn.closest('.recipient-row').remove();
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.recipient-row');
        rows.forEach((row, i) => {
            const removeBtn = row.querySelector('.btn-remove-recipient');
            removeBtn.style.display = rows.length > 1 ? 'block' : 'none';
        });
    }
</script>
@endsection
