@extends(auth()->user()->user_type === 'ADMIN' ? 'layouts.admin' : 'layouts.cotizador')
@php $routePrefix = auth()->user()->user_type === 'ADMIN' ? 'admin' : 'cotizador'; @endphp

@section('title', 'Ver Correo')

@section('extra_css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css">
@endsection

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Correo Recibido</h1>
    <a href="{{ route($routePrefix.'.inbox', ['account_id' => $inboxEmail->email_account_id]) }}" class="btn-secondary">
        <i class="fa fa-arrow-left"></i> Bandeja
    </a>
</div>

<div class="email-view-card">
    <div class="email-header-block">
        <div class="email-meta-row">
            <span class="meta-label">De:</span>
            <span>{{ $inboxEmail->from_name ?: $inboxEmail->from_email }}@if($inboxEmail->from_name && $inboxEmail->from_email) <small style="color:#9ca3af;"> &lt;{{ $inboxEmail->from_email }}&gt;</small>@endif</span>
        </div>
        <div class="email-meta-row">
            <span class="meta-label">Para:</span>
            <span>{{ $inboxEmail->to_email }}</span>
        </div>
        <div class="email-meta-row">
            <span class="meta-label">Asunto:</span>
            <strong>{{ $inboxEmail->subject }}</strong>
        </div>
        <div class="email-meta-row">
            <span class="meta-label">Recibido:</span>
            <span>{{ $inboxEmail->received_at?->format('d/m/Y H:i:s') ?? '-' }}</span>
        </div>
        @if($inboxEmail->has_attachments)
        <div class="email-meta-row">
            <span class="meta-label">Adjuntos:</span>
            <span>
                @if($attachments->isNotEmpty())
                    @foreach($attachments as $att)
                        <a href="{{ route($routePrefix.'.inbox.attachment.download', [$inboxEmail, $att]) }}"
                           class="attachment-chip" title="{{ $att->original_name }}" download>
                            <i class="fa {{ $att->isImage() ? 'fa-file-image-o' : 'fa-file-o' }}"></i>
                            {{ Str::limit($att->original_name, 40) }}
                            <small>({{ $att->formattedSize() }})</small>
                        </a>
                    @endforeach
                @else
                    <span class="text-muted"><i class="fa fa-paperclip"></i> Este correo tiene archivos adjuntos. Vuelve a sincronizar para descargarlos.</span>
                @endif
            </span>
        </div>
        @endif
    </div>

    <div class="email-body-block">
        @if($inboxEmail->body_html)
            <iframe
                id="email-body-frame"
                sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin"
                srcdoc="{!! htmlspecialchars($inboxEmail->body_html, ENT_QUOTES, 'UTF-8') !!}"
                style="width:100%; border:none; min-height:400px;"
                onload="autoResizeFrame(this)"
            ></iframe>
        @elseif($inboxEmail->body_text)
            <pre class="email-body-text">{{ $inboxEmail->body_text }}</pre>
        @else
            <p class="text-muted">Sin contenido.</p>
        @endif
    </div>
</div>

{{-- Respuestas anteriores --}}
@if($replies->isNotEmpty())
<div class="admin-section" style="margin-top:24px;">
    <h2 class="section-title">Respuestas enviadas</h2>
    @foreach($replies as $reply)
    <div class="reply-block">
        <div class="reply-meta">
            <i class="fa fa-reply"></i>
            <strong>{{ $reply->sender->name }}</strong> respondió a <strong>{{ $reply->to_email }}</strong>
            — {{ $reply->sent_at?->format('d/m/Y H:i') }}
            @if($reply->success)
                <span class="badge badge-success">Enviado</span>
            @else
                <span class="badge badge-danger" title="{{ $reply->error_message }}">Error</span>
            @endif
        </div>
        <div class="reply-subject">Asunto: {{ $reply->subject }}</div>
        <div class="reply-body">{!! $reply->body !!}</div>
    </div>
    @endforeach
</div>
@endif

{{-- Formulario de respuesta --}}
<div class="admin-section" style="margin-top:24px;">
    <h2 class="section-title">Responder</h2>

    @if($accounts->isEmpty())
        <div class="alert alert-warning">
            <i class="fa fa-exclamation-triangle"></i>
            No tienes cuentas SMTP configuradas para responder.
            <a href="{{ route('cotizador.email-accounts.create') }}">Configura una cuenta</a>.
        </div>
    @else
    <div class="form-card" style="margin-top:12px;">
        <form action="{{ route($routePrefix.'.inbox.reply', $inboxEmail) }}" method="POST" id="replyForm">
            @csrf

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Responder desde <span class="required">*</span></label>
                    <select name="email_account_id" class="form-input" required>
                        <option value="">-- Seleccionar cuenta --</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}"
                                {{ $inboxEmail->email_account_id == $acc->id ? 'selected' : '' }}>
                                {{ $acc->name }} ({{ $acc->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Usar plantilla</label>
                    <select name="template_id" id="reply-template-selector" class="form-input">
                        <option value="">-- Sin plantilla --</option>
                        @foreach($templates as $tpl)
                            <option value="{{ $tpl->id }}">{{ $tpl->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Asunto <span class="required">*</span></label>
                <input type="text" name="subject" id="reply-subject" class="form-input"
                    value="Re: {{ $inboxEmail->subject }}" required maxlength="255">
            </div>

            <div class="form-group">
                <label class="form-label">Mensaje <span class="required">*</span></label>
                <div id="reply-editor" style="min-height:280px;"></div>
                <textarea name="body" id="reply-body-hidden" style="display:none;"></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary" id="reply-btn">
                    <i class="fa fa-reply"></i> Enviar Respuesta
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const replyQuill = new Quill('#reply-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                [{ 'color': [] }],
                ['clean']
            ]
        }
    });

    // Cargar plantilla al seleccionar
    document.getElementById('reply-template-selector')?.addEventListener('change', function() {
        const id = this.value;

        if (!id) {
            document.getElementById('reply-subject').value = '';
            replyQuill.setText('');
            return;
        }

        fetch('{{ route("cotizador.templates.body", ":id") }}'.replace(':id', id))
            .then(r => r.json())
            .then(data => {
                document.getElementById('reply-subject').value = data.subject;
                replyQuill.clipboard.dangerouslyPasteHTML(data.body);
            });
    });

    document.getElementById('replyForm')?.addEventListener('submit', function(e) {
        document.getElementById('reply-body-hidden').value = replyQuill.root.innerHTML;
        const btn = document.getElementById('reply-btn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Enviando...';
    });
</script>

<style>
.attachment-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #f0f4f8;
    border: 1px solid #d1dce8;
    border-radius: 4px;
    padding: 4px 10px;
    font-size: 13px;
    color: #1D9E75;
    text-decoration: none;
    margin: 2px 4px 2px 0;
    transition: background 0.15s;
}
.attachment-chip:hover {
    background: #e0ede8;
    color: #178f66;
}
.attachment-chip small {
    color: #6b7c93;
}
#email-body-frame {
    display: block;
    width: 100%;
    min-height: 400px;
    border: none;
    background: #fff;
}
</style>

<script>
function autoResizeFrame(frame) {
    try {
        const doc = frame.contentDocument || frame.contentWindow.document;
        frame.style.height = (doc.documentElement.scrollHeight + 20) + 'px';
    } catch(e) {
        frame.style.height = '600px';
    }
}
// Re-ajustar si la imagen del correo carga después
document.getElementById('email-body-frame')?.addEventListener('load', function() {
    autoResizeFrame(this);
    setTimeout(() => autoResizeFrame(this), 800);
});
</script>
@endsection
