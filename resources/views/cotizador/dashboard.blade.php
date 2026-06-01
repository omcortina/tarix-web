@extends(auth()->user()->user_type === 'ADMIN' ? 'layouts.admin' : 'layouts.cotizador')

@section('title', 'Dashboard')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Dashboard</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#E3F2FD;">
            <i class="fa fa-paper-plane" style="color:#1565C0;font-size:22px;"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $totalSent }}</div>
            <div class="stat-label">Cotizaciones Enviadas</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#E8F5E9;">
            <i class="fa fa-file-text-o" style="color:#2E7D32;font-size:22px;"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $totalTemplates }}</div>
            <div class="stat-label">Plantillas</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFF3E0;">
            <i class="fa fa-inbox" style="color:#E65100;font-size:22px;"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $totalInbox }}</div>
            <div class="stat-label">Correos en Bandeja</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFEBEE;">
            <i class="fa fa-envelope-o" style="color:#C62828;font-size:22px;"></i>
        </div>
        <div class="stat-info">
            <div class="stat-number">{{ $unreadInbox }}</div>
            <div class="stat-label">Sin Leer</div>
        </div>
    </div>
</div>

<div class="admin-section">
    <div class="section-header">
        <h2 class="section-title">Cotizaciones Recientes</h2>
        <a href="{{ route('cotizador.quotes.send') }}" class="btn-primary">
            <i class="fa fa-plus"></i> Nueva Cotización
        </a>
    </div>

    @if($recentSent->isEmpty())
        <div class="form-card">
            <div class="empty-state">
                <i class="fa fa-paper-plane-o"></i>
                <p>No hay cotizaciones enviadas aún.</p>
            </div>
        </div>
    @else
        <div class="form-card" style="padding: 0; overflow: hidden;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Destinatario</th>
                        <th>Asunto</th>
                        <th>Cuenta usada</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentSent as $quote)
                    <tr>
                        <td>
                            <div>{{ $quote->to_name ?: $quote->to_email }}</div>
                            <small class="text-muted">{{ $quote->to_email }}</small>
                        </td>
                        <td>{{ Str::limit($quote->subject, 50) }}</td>
                        <td>{{ $quote->emailAccount->name ?? '-' }}</td>
                        <td>
                            @if($quote->success)
                                <span class="badge badge-success">Enviado</span>
                            @else
                                <span class="badge badge-danger">Error</span>
                            @endif
                        </td>
                        <td>{{ $quote->sent_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
