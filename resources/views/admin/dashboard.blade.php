@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('extra_css')
<style>
    .dash-greeting {
        margin-bottom: 24px;
    }
    .dash-greeting h1 {
        font-size: 26px;
        font-weight: 700;
        color: #1a2e44;
        margin: 0;
    }
    .dash-greeting p {
        color: #888;
        font-size: 13px;
        margin-top: 4px;
    }
    .dash-section-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #aaa;
        margin: 0 0 10px 2px;
    }
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }
    .kpi-card {
        background: #fff;
        border-radius: 10px;
        padding: 18px 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .kpi-icon i {
        font-size: 18px;
        color: #fff;
    }
    .kpi-num {
        font-size: 28px;
        font-weight: 700;
        color: #1a2e44;
        line-height: 1;
    }
    .kpi-lbl {
        font-size: 12px;
        color: #888;
        margin-top: 3px;
        font-weight: 500;
    }
    .kpi-sub {
        font-size: 11px;
        color: #bbb;
        margin-top: 2px;
    }
    .dash-two-col {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 18px;
        margin-bottom: 20px;
    }
    .dash-card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .dash-card-title {
        font-size: 14px;
        font-weight: 700;
        color: #1a2e44;
        margin: 0 0 14px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .dash-card-title i { color: #22c5bc; font-size: 13px; }
    .dash-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .dash-table thead th {
        padding: 8px 12px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #aaa;
        text-transform: uppercase;
        border-bottom: 1px solid #f0f0f0;
    }
    .dash-table tbody td {
        padding: 9px 12px;
        border-bottom: 1px solid #f8f8f8;
        color: #444;
        vertical-align: middle;
    }
    .dash-table tbody tr:last-child td { border-bottom: none; }
    .dash-table tbody tr:hover { background: #fafffe; }
    .ds-badge {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }
    .ds-badge.creado      { background: #E3F2FD; color: #1565C0; }
    .ds-badge.pendiente   { background: #FFF3E0; color: #E65100; }
    .ds-badge.en-proceso  { background: #E8EAF6; color: #303F9F; }
    .ds-badge.verificado  { background: #E0F7FA; color: #00838F; }
    .ds-badge.aprobado    { background: #E8F5E9; color: #2E7D32; }
    .ds-badge.cancelado   { background: #FDECEA; color: #B71C1C; }
    .qa-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 7px;
        background: #f8fffe;
        text-decoration: none;
        color: #333;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #e0f7f6;
        margin-bottom: 8px;
        transition: background 0.15s;
    }
    .qa-link:hover { background: #e0f7f6; }
    .qa-link i { color: #22c5bc; width: 16px; text-align: center; }
    .alert-card {
        border-left: 4px solid #D32F2F;
        margin-top: 12px;
    }
    .content-two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 20px;
    }
    .content-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .content-list-item:last-child { border-bottom: none; }
    .content-list-title { font-size: 13px; font-weight: 600; color: #333; }
    .content-list-slug { font-size: 11px; color: #bbb; }
    .see-all-link {
        font-size: 12px;
        color: #22c5bc;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin-top: 12px;
    }
    @media (max-width: 1100px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        .dash-two-col { grid-template-columns: 1fr; }
        .content-two-col { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

<div class="dash-greeting">
    <h1>Bienvenido, {{ auth()->user()->name }}</h1>
    <p>Resumen general del sistema</p>
</div>

<div class="dash-section-label">Clasificaciones</div>
<div class="kpi-grid" style="margin-bottom:24px;">
    <div class="kpi-card">
        <div class="kpi-icon" style="background:#22c5bc;">
            <i class="fa fa-folder-open"></i>
        </div>
        <div>
            <div class="kpi-num">{{ $totalClassifications }}</div>
            <div class="kpi-lbl">Total</div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon" style="background:#F57C00;">
            <i class="fa fa-clock-o"></i>
        </div>
        <div>
            <div class="kpi-num">{{ $pendingPaymentCount }}</div>
            <div class="kpi-lbl">Pendientes de Pago</div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon" style="background:#1976D2;">
            <i class="fa fa-cog"></i>
        </div>
        <div>
            <div class="kpi-num">{{ $inProcessCount }}</div>
            <div class="kpi-lbl">En Proceso</div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon" style="background:#388E3C;">
            <i class="fa fa-check-circle"></i>
        </div>
        <div>
            <div class="kpi-num">{{ $approvedCount }}</div>
            <div class="kpi-lbl">Aprobadas</div>
        </div>
    </div>
</div>

<div class="dash-section-label">Usuarios y Empresas</div>
<div class="kpi-grid" style="margin-bottom:28px;">
    <div class="kpi-card">
        <div class="kpi-icon" style="background:#7B1FA2;">
            <i class="fa fa-users"></i>
        </div>
        <div>
            <div class="kpi-num">{{ $activeUsersCount }}</div>
            <div class="kpi-lbl">Clientes Activos</div>
            <div class="kpi-sub">Externos y empresa verificados</div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon" style="background:#D32F2F;">
            <i class="fa fa-user-times"></i>
        </div>
        <div>
            <div class="kpi-num">{{ $pendingUsersCount }}</div>
            <div class="kpi-lbl">Pendientes de Verificar</div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon" style="background:#303F9F;">
            <i class="fa fa-users"></i>
        </div>
        <div>
            <div class="kpi-num">{{ $clasificadoresCount }}</div>
            <div class="kpi-lbl">Clasificadores Activos</div>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon" style="background:#00796B;">
            <i class="fa fa-building"></i>
        </div>
        <div>
            <div class="kpi-num">{{ $activeCompaniesCount }}</div>
            <div class="kpi-lbl">Empresas Activas</div>
        </div>
    </div>
</div>

<div class="dash-two-col">
    <div class="dash-card">
        <p class="dash-card-title"><i class="fa fa-list-alt"></i> Clasificaciones Recientes</p>
        <table class="dash-table">
            <thead>
                <tr>
                    <th>Radicado</th>
                    <th>Solicitante</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentClassifications as $c)
                    @php
                        $badgeMap = [
                            'Creado'            => 'creado',
                            'Pendiente de pago' => 'pendiente',
                            'En proceso'        => 'en-proceso',
                            'Verificado'        => 'verificado',
                            'Aprobado'          => 'aprobado',
                            'Cancelado'         => 'cancelado',
                        ];
                        $badgeClass = $badgeMap[$c->status] ?? 'creado';
                    @endphp
                    <tr>
                        <td style="font-weight:600;color:#22c5bc;white-space:nowrap;">{{ $c->radicado }}</td>
                        <td>{{ $c->user->name ?? '-' }}</td>
                        <td><span class="ds-badge {{ $badgeClass }}">{{ $c->status }}</span></td>
                        <td style="color:#bbb;white-space:nowrap;">{{ $c->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#ccc;padding:20px;">Sin clasificaciones registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.billing') }}" class="see-all-link">Ver facturación y totales &rarr;</a>
    </div>

    <div>
        <div class="dash-card" style="margin-bottom:16px;">
            <p class="dash-card-title"><i class="fa fa-bolt"></i> Acceso Rapido</p>
            <a href="{{ route('admin.users.index') }}" class="qa-link">
                <i class="fa fa-users"></i> Gestionar Usuarios
            </a>
            <a href="{{ route('admin.companies.index') }}" class="qa-link">
                <i class="fa fa-building"></i> Gestionar Empresas
            </a>
            <a href="{{ route('admin.classifications.settings') }}" class="qa-link">
                <i class="fa fa-sliders"></i> Config. Clasificaciones
            </a>
            <a href="{{ route('admin.articles.index') }}" class="qa-link">
                <i class="fa fa-newspaper-o"></i> Articulos
            </a>
            <a href="{{ route('admin.services.index') }}" class="qa-link">
                <i class="fa fa-briefcase"></i> Servicios
            </a>
            <a href="{{ route('admin.billing') }}" class="qa-link">
                <i class="fa fa-dollar"></i> Facturacion
            </a>
        </div>

        @if($pendingUsersCount > 0)
            <div class="dash-card alert-card">
                <p class="dash-card-title" style="color:#D32F2F;margin-bottom:8px;">
                    <i class="fa fa-exclamation-circle" style="color:#D32F2F;"></i> Atencion Requerida
                </p>
                <p style="font-size:13px;color:#555;margin:0;">
                    <strong style="font-size:22px;color:#D32F2F;">{{ $pendingUsersCount }}</strong>
                    usuario(s) esperan verificacion.
                </p>
                <a href="{{ route('admin.users.index') }}" style="display:inline-block;margin-top:10px;font-size:12px;background:#FDECEA;color:#B71C1C;padding:6px 12px;border-radius:4px;text-decoration:none;font-weight:600;">
                    Revisar ahora &rarr;
                </a>
            </div>
        @endif

        @if($pendingPaymentCount > 0)
            <div class="dash-card" style="border-left:4px solid #F57C00;{{ $pendingUsersCount > 0 ? 'margin-top:16px;' : '' }}">
                <p class="dash-card-title" style="color:#E65100;margin-bottom:8px;">
                    <i class="fa fa-credit-card" style="color:#F57C00;"></i> Pagos Pendientes
                </p>
                <p style="font-size:13px;color:#555;margin:0;">
                    <strong style="font-size:22px;color:#E65100;">{{ $pendingPaymentCount }}</strong>
                    clasificacion(es) aguardan confirmacion de pago.
                </p>
            </div>
        @endif
    </div>
</div>

<div class="content-two-col">
    <div class="dash-card">
        <p class="dash-card-title"><i class="fa fa-briefcase"></i> Servicios Recientes</p>
        @forelse($services as $service)
            <div class="content-list-item">
                <div>
                    <div class="content-list-title">{{ getSpanish($service->title) }}</div>
                    <div class="content-list-slug">/{{ $service->slug }}</div>
                </div>
                <span style="font-size:11px;font-weight:600;color:{{ $service->published ? '#2e7d32' : '#e65100' }};">
                    {{ $service->published ? 'Publicado' : 'Borrador' }}
                </span>
            </div>
        @empty
            <p style="color:#ccc;font-size:13px;margin:0;">Sin servicios registrados.</p>
        @endforelse
        <a href="{{ route('admin.services.index') }}" class="see-all-link">Ver todos &rarr;</a>
    </div>

    <div class="dash-card">
        <p class="dash-card-title"><i class="fa fa-newspaper-o"></i> Articulos Recientes</p>
        @forelse($articles as $article)
            <div class="content-list-item">
                <div>
                    <div class="content-list-title">{{ Str::limit(getSpanish($article->title), 40) }}</div>
                    <div class="content-list-slug">/{{ $article->slug }}</div>
                </div>
                <span style="font-size:11px;font-weight:600;color:{{ $article->published ? '#2e7d32' : '#e65100' }};">
                    {{ $article->published ? 'Publicado' : 'Borrador' }}
                </span>
            </div>
        @empty
            <p style="color:#ccc;font-size:13px;margin:0;">Sin articulos registrados.</p>
        @endforelse
        <a href="{{ route('admin.articles.index') }}" class="see-all-link">Ver todos &rarr;</a>
    </div>
</div>

@endsection
