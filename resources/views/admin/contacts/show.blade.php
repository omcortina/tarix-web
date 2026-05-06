@extends('layouts.admin')

@section('title', 'Ver Contacto')

@section('extra_css')
<style>
    .breadcrumb {
        display: flex;
        gap: 8px;
        align-items: center;
        font-size: 13px;
        color: #999;
        margin-bottom: 24px;
    }
    .breadcrumb a {
        color: #22c5bc;
        text-decoration: none;
        font-weight: 600;
    }
    .contact-card {
        background: white;
        border-radius: 8px;
        padding: 32px 36px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        max-width: 820px;
    }
    .contact-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }
    .contact-card-header h2 {
        font-size: 20px;
        color: #0d2340;
        margin: 0 0 8px;
    }
    .badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-unread { background: #fff3e0; color: #e65100; }
    .badge-read   { background: #e8f5e9; color: #2e7d32; }
    .date-label {
        font-size: 13px;
        color: #aaa;
        margin-top: 4px;
    }
    .info-row { margin-bottom: 22px; }
    .info-label {
        font-size: 11px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 15px;
        color: #333;
        line-height: 1.6;
    }
    .info-value a { color: #22c5bc; text-decoration: none; }
    .info-value a:hover { text-decoration: underline; }
    .message-box {
        background: #f9f9f9;
        padding: 16px 20px;
        border-radius: 6px;
        border-left: 4px solid #22c5bc;
        font-size: 14px;
        color: #444;
        line-height: 1.7;
    }
    .card-actions {
        display: flex;
        gap: 10px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #f0f0f0;
    }
    .btn-back {
        padding: 10px 22px;
        background: #e5e7eb;
        color: #374151;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-delete {
        padding: 10px 22px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }
</style>
@endsection

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.contacts.index') }}">Mensajes</a>
    <span>/</span>
    <span>Ver Mensaje</span>
</div>

<div class="contact-card">
    <div class="contact-card-header">
        <div>
            <h2>{{ $contact->name }}</h2>
            <span class="badge {{ $contact->is_read ? 'badge-read' : 'badge-unread' }}">
                {{ $contact->is_read ? 'Leído' : 'Nuevo' }}
            </span>
        </div>
        <div class="date-label">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
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
        <div class="info-value">
            <div class="message-box">{!! nl2br(e($contact->message)) !!}</div>
        </div>
    </div>

    <div class="card-actions">
        <a href="{{ route('admin.contacts.index') }}" class="btn-back">Volver</a>
        <form id="deleteForm" action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="margin: 0;">
            @csrf
            @method('DELETE')
            <button type="button" class="btn-delete" onclick="confirmDeleteContact()">Eliminar</button>
        </form>
    </div>
</div>

<script>
    function confirmDeleteContact() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar este mensaje? Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
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

@endsection
