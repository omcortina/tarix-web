<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Contacto | Admin - TARIX</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        body { background: #f5f7fa; font-family: 'Inter', sans-serif; }
        .admin-container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        .breadcrumb { font-size: 14px; color: #666; margin-bottom: 20px; }
        .breadcrumb a { color: #22c5bc; text-decoration: none; margin: 0 5px; }
        .contact-card { background: white; border-radius: 8px; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .contact-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 30px; border-bottom: 2px solid #f0f0f0; padding-bottom: 20px; }
        .contact-header h1 { font-size: 24px; color: #0d2340; margin: 0; }
        .badge { display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; }
        .badge-unread { background: #fff3e0; color: #e65100; }
        .badge-read { background: #e8f5e9; color: #2e7d32; }
        .info-row { margin-bottom: 24px; }
        .info-label { font-weight: 600; color: #0d2340; margin-bottom: 6px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-value { color: #666; font-size: 16px; line-height: 1.6; }
        .info-value a { color: #0066cc; text-decoration: none; }
        .info-value a:hover { text-decoration: underline; }
        .score { font-size: 12px; color: #999; margin-top: 4px; }
        .date { font-size: 13px; color: #999; margin-top: 4px; }
        .actions { display: flex; gap: 10px; margin-top: 40px; padding-top: 30px; border-top: 2px solid #f0f0f0; }
        .btn { padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-back { background: #e0e0e0; color: #333; }
        .btn-back:hover { background: #d0d0d0; }
        .btn-delete { background: #ff6b6b; color: white; }
        .btn-delete:hover { background: #ff5252; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="admin-container">
        <div style="margin-bottom: 20px; display: flex; gap: 8px; align-items: center; font-size: 14px; color: #666;">
            <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Dashboard
            </a>
            <span>/</span>
            <a href="{{ route('admin.contacts.index') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Contactos
            </a>
            <span>/</span>
            <span>Ver Mensaje</span>
        </div>

        <div class="contact-card">
            <div class="contact-header">
                <div>
                    <h1>{{ $contact->name }}</h1>
                    <span class="badge {{ $contact->is_read ? 'badge-read' : 'badge-unread' }}">
                        {{ $contact->is_read ? 'Leído' : 'Nuevo' }}
                    </span>
                </div>
                <div class="date">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value"><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></div>
            </div>

            <div class="info-row">
                <div class="info-label">Teléfono</div>
                <div class="info-value">{{ $contact->phone ?? '—' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Empresa</div>
                <div class="info-value">{{ $contact->company ?? '—' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Mensaje</div>
                <div class="info-value" style="background: #f9f9f9; padding: 16px; border-radius: 6px; border-left: 4px solid #22c5bc;">
                    {!! nl2br(e($contact->message)) !!}
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Seguridad</div>
                <div class="score">
                    Score reCAPTCHA: {{ number_format($contact->recaptcha_score, 2) }} / 1.00
                    <br>
                    <small style="color: #666;">
                        @if($contact->recaptcha_score >= 0.9)
                            ✓ Confiable
                        @elseif($contact->recaptcha_score >= 0.5)
                            ⚠ Moderado
                        @else
                            ✗ Sospechoso
                        @endif
                    </small>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-back">← Volver</a>
                <form id="deleteForm" action="{{ route('admin.contacts.destroy', $contact) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-delete" onclick="confirmDelete(event)">Eliminar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas eliminar este mensaje? Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
</body>
</html>
