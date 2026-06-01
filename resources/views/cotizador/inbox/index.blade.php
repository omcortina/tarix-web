@extends(auth()->user()->user_type === 'ADMIN' ? 'layouts.admin' : 'layouts.cotizador')

@section('title', 'Bandeja de Entrada')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Bandeja de Entrada</h1>
</div>

@if(!$accounts || $accounts->isEmpty())
    <div class="alert alert-warning">
        <i class="fa fa-exclamation-triangle"></i>
        No tienes cuentas de correo configuradas.
        <a href="{{ route('cotizador.email-accounts.create') }}">Configura una cuenta</a> para sincronizar tu bandeja.
    </div>
@else

<div class="inbox-layout">
    {{-- Selector de cuenta + botón sincronizar --}}
    <div class="inbox-toolbar">
        <form method="GET" action="{{ route('cotizador.inbox') }}" class="account-switcher-form">
            <label class="form-label" style="margin:0;">Cuenta:</label>
            <select name="account_id" class="form-input" id="account-select" onchange="this.form.submit()" style="width:auto;min-width:220px;">
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}" {{ $selectedAccount && $selectedAccount->id == $acc->id ? 'selected' : '' }}>
                        {{ $acc->name }} ({{ $acc->email }})
                    </option>
                @endforeach
            </select>
        </form>

        @if($selectedAccount)
        <form method="POST" action="{{ route('cotizador.inbox.sync') }}" style="display:inline;" id="sync-form">
            @csrf
            <input type="hidden" name="account_id" value="{{ $selectedAccount->id }}">
            <button type="submit" class="btn-secondary" id="sync-btn">
                <i class="fa fa-refresh"></i> Sincronizar
            </button>
        </form>
        @endif
    </div>

    {{-- Listado de correos --}}
    @if($selectedAccount)
        @if($emails->isEmpty())
            <div class="empty-state">
                <i class="fa fa-inbox"></i>
                <p>No hay correos sincronizados para esta cuenta. Haz clic en <strong>Sincronizar</strong> para traer los más recientes.</p>
            </div>
        @else
            <div class="inbox-list">
                @foreach($emails as $email)
                <a href="{{ route('cotizador.inbox.show', $email) }}" class="inbox-item {{ $email->is_read ? 'read' : 'unread' }}">
                    @php
                        $rawName = $email->from_name ?: $email->from_email;
                        preg_match('/[a-zA-Z0-9]/u', $rawName, $m);
                        $initial = strtoupper($m[0] ?? '?');
                        $palette = ['#1db899','#3b82f6','#f59e0b','#7c3aed','#dc2626','#0891b2'];
                        $avatarColor = $palette[(ord($initial) + 26) % count($palette)];
                    @endphp
                    <div class="inbox-avatar" style="background:{{ $avatarColor }}">{{ $initial }}</div>
                    <div class="inbox-item-status">
                        @if(!$email->is_read)
                            <span class="unread-dot"></span>
                        @endif
                    </div>
                    <div class="inbox-item-from">
                        <strong>{{ $email->from_name ?: $email->from_email }}</strong>
                        <small>{{ $email->from_email }}</small>
                    </div>
                    <div class="inbox-item-subject">
                        <span class="{{ $email->is_read ? '' : 'fw-bold' }}">{{ $email->subject }}</span>
                    </div>
                    <div class="inbox-item-meta">
                        @if($email->has_attachments)
                            <i class="fa fa-paperclip" title="Tiene adjuntos"></i>
                        @endif
                        <span class="inbox-date">{{ $email->received_at?->diffForHumans() ?? '-' }}</span>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $emails->appends(['account_id' => $selectedAccount->id])->links('vendor.pagination.custom') }}
            </div>
        @endif
    @endif
</div>
@endif
@endsection

@section('scripts')
<script>
    document.getElementById('sync-form')?.addEventListener('submit', function() {
        const btn = document.getElementById('sync-btn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sincronizando...';
    });
</script>
@endsection
