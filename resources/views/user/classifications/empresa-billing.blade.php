@extends('layouts.user')

@section('title', 'Facturación y Totales')

@section('page_title', 'Facturación y Totales')

@section('extra_css')
<style>
    .billing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    .billing-stat {
        background: white;
        border-radius: 8px;
        padding: 22px 24px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        border-top: 4px solid #22c5bc;
    }
    .billing-stat.warning { border-color: #f39c12; }
    .billing-stat.success { border-color: #4CAF50; }
    .billing-stat.info    { border-color: #667eea; }
    .billing-stat .bs-label {
        font-size: 11px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .billing-stat .bs-value {
        font-size: 26px;
        font-weight: 800;
        color: #0d2340;
        line-height: 1;
    }
    .billing-stat .bs-sub {
        font-size: 12px;
        color: #bbb;
        margin-top: 4px;
    }

    .user-billing-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .ubc-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
    }
    .ubc-name {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .ubc-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #22c5bc;
        color: white;
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .ubc-name-text strong {
        display: block;
        font-size: 15px;
        color: #0d2340;
    }
    .ubc-name-text small {
        font-size: 12px;
        color: #aaa;
    }
    .ubc-total {
        text-align: right;
    }
    .ubc-total .amount {
        font-size: 20px;
        font-weight: 800;
        color: #0d2340;
    }
    .ubc-total .label {
        font-size: 11px;
        color: #aaa;
        text-transform: uppercase;
    }
    .ubc-breakdown {
        display: flex;
        flex-wrap: wrap;
        gap: 0;
    }
    .ubc-status-row {
        flex: 1;
        min-width: 200px;
        padding: 14px 24px;
        border-right: 1px solid #f5f5f5;
        border-bottom: 1px solid #f5f5f5;
    }
    .ubc-status-row:last-child {
        border-right: none;
    }
    .ubc-status-row .sr-status {
        font-size: 12px;
        font-weight: 600;
        color: #777;
        margin-bottom: 4px;
    }
    .ubc-status-row .sr-cost {
        font-size: 16px;
        font-weight: 700;
        color: #333;
    }
    .ubc-status-row .sr-qty {
        font-size: 11px;
        color: #bbb;
    }

    .no-users {
        background: white;
        border-radius: 8px;
        padding: 60px 20px;
        text-align: center;
        color: #aaa;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #0d2340;
        margin: 0 0 16px 0;
    }
</style>
@endsection

@section('content')
<div class="classifications-container">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Resumen general -->
    <div class="billing-grid">
        <div class="billing-stat">
            <div class="bs-label">Total Facturado</div>
            <div class="bs-value">${{ number_format($totalGeneral, 0, ',', '.') }}</div>
            <div class="bs-sub">{{ $cantidadTotal }} clasificación(es) en total</div>
        </div>
        <div class="billing-stat warning">
            <div class="bs-label">Pendiente de Pago</div>
            <div class="bs-value">${{ number_format($totalPendientePago, 0, ',', '.') }}</div>
            <div class="bs-sub">Pago no verificado</div>
        </div>
        <div class="billing-stat success">
            <div class="bs-label">Pagado y Verificado</div>
            <div class="bs-value">${{ number_format($totalPagado, 0, ',', '.') }}</div>
            <div class="bs-sub">Pago confirmado</div>
        </div>
        <div class="billing-stat info">
            <div class="bs-label">Usuarios Activos</div>
            <div class="bs-value">{{ $companyUsers->count() }}</div>
            <div class="bs-sub">Con acceso a clasificaciones</div>
        </div>
    </div>

    <!-- Detalle por usuario -->
    <h2 class="section-title">Detalle por Usuario</h2>

    @if ($companyUsers->count() > 0)
        @foreach ($companyUsers as $cu)
            @php
                $userRows = $resumenPorUsuario->get($cu->id, collect());
                $userTotal = $userRows->sum('total');
            @endphp
            <div class="user-billing-card">
                <div class="ubc-header">
                    <div class="ubc-name">
                        <div class="ubc-avatar">{{ strtoupper(substr($cu->name, 0, 1)) }}</div>
                        <div class="ubc-name-text">
                            <strong>{{ $cu->name }}</strong>
                            <small>{{ $cu->email }}</small>
                        </div>
                    </div>
                    <div class="ubc-total">
                        <div class="label">Total</div>
                        <div class="amount">${{ number_format($userTotal, 0, ',', '.') }}</div>
                    </div>
                </div>

                @if ($userRows->count() > 0)
                    <div class="ubc-breakdown">
                        @foreach ($userRows as $row)
                            <div class="ubc-status-row">
                                <div class="sr-status">{{ $row->status }}</div>
                                <div class="sr-cost">${{ number_format($row->total, 0, ',', '.') }}</div>
                                <div class="sr-qty">{{ $row->cantidad }} clasificación(es)</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 16px 24px; font-size: 13px; color: #bbb;">
                        Sin clasificaciones registradas.
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="no-users">
            <i class="fa fa-users" style="font-size: 40px; margin-bottom: 12px; display: block;"></i>
            <p>No hay usuarios asociados a tu empresa.</p>
        </div>
    @endif

</div>
@endsection
