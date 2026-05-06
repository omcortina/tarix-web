@extends('layouts.admin')

@section('title', 'Facturación y Totales')

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

    .company-billing-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .cbc-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
    }
    .cbc-name {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .cbc-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #22c5bc;
        color: white;
        font-size: 15px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .cbc-name-text strong {
        display: block;
        font-size: 15px;
        color: #0d2340;
    }
    .cbc-name-text small {
        font-size: 12px;
        color: #aaa;
    }
    .cbc-totals {
        display: flex;
        gap: 32px;
        align-items: center;
    }
    .cbc-totals .ct-item {
        text-align: right;
    }
    .cbc-totals .ct-item .amount {
        font-size: 18px;
        font-weight: 800;
        color: #0d2340;
        display: block;
    }
    .cbc-totals .ct-item .label {
        font-size: 10px;
        color: #aaa;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .cbc-totals .ct-item.pending .amount { color: #f39c12; }
    .cbc-totals .ct-item.paid .amount    { color: #4CAF50; }

    .cbc-breakdown {
        display: flex;
        flex-wrap: wrap;
        gap: 0;
    }
    .cbc-status-row {
        flex: 1;
        min-width: 200px;
        padding: 14px 24px;
        border-right: 1px solid #f5f5f5;
        border-bottom: 1px solid #f5f5f5;
    }
    .cbc-status-row:last-child { border-right: none; }
    .cbc-status-row .sr-status {
        font-size: 12px;
        font-weight: 600;
        color: #777;
        margin-bottom: 4px;
    }
    .cbc-status-row .sr-cost {
        font-size: 16px;
        font-weight: 700;
        color: #333;
    }
    .cbc-status-row .sr-qty {
        font-size: 11px;
        color: #bbb;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #0d2340;
        margin: 0 0 16px 0;
    }
    .no-companies {
        background: white;
        border-radius: 8px;
        padding: 60px 20px;
        text-align: center;
        color: #aaa;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }
    .page-heading {
        font-size: 22px;
        font-weight: 800;
        color: #0d2340;
        margin: 0 0 24px 0;
    }
</style>
@endsection

@section('content')
<h1 class="page-heading">Facturación y Totales</h1>

<!-- Resumen global -->
<div class="billing-grid">
    <div class="billing-stat">
        <div class="bs-label">Total Facturado</div>
        <div class="bs-value">${{ number_format($totalGlobal, 0, ',', '.') }}</div>
        <div class="bs-sub">{{ $cantidadGlobal }} clasificación(es) en total</div>
    </div>
    <div class="billing-stat warning">
        <div class="bs-label">Pendiente de Pago</div>
        <div class="bs-value">${{ number_format($totalPendienteGlobal, 0, ',', '.') }}</div>
        <div class="bs-sub">Pago no verificado</div>
    </div>
    <div class="billing-stat success">
        <div class="bs-label">Pagado y Verificado</div>
        <div class="bs-value">${{ number_format($totalPagadoGlobal, 0, ',', '.') }}</div>
        <div class="bs-sub">Pago confirmado</div>
    </div>
    <div class="billing-stat info">
        <div class="bs-label">Empresas Activas</div>
        <div class="bs-value">{{ $companiesData->count() }}</div>
        <div class="bs-sub">Con clasificaciones</div>
    </div>
</div>

<!-- Detalle por empresa -->
<h2 class="section-title">Detalle por Empresa</h2>

@if ($companiesData->count() > 0)
    @foreach ($companiesData as $item)
        <div class="company-billing-card">
            <div class="cbc-header">
                <div class="cbc-name">
                    <div class="cbc-avatar">{{ strtoupper(substr($item['company']->name, 0, 1)) }}</div>
                    <div class="cbc-name-text">
                        <strong>{{ $item['company']->name }}</strong>
                        <small>{{ $item['usuarios_activos'] }} usuario(s) &mdash; {{ $item['cantidad'] }} clasificación(es)</small>
                    </div>
                </div>
                <div class="cbc-totals">
                    <div class="ct-item pending">
                        <span class="amount">${{ number_format($item['pendiente_pago'], 0, ',', '.') }}</span>
                        <span class="label">Pendiente</span>
                    </div>
                    <div class="ct-item paid">
                        <span class="amount">${{ number_format($item['pagado'], 0, ',', '.') }}</span>
                        <span class="label">Pagado</span>
                    </div>
                    <div class="ct-item">
                        <span class="amount">${{ number_format($item['total'], 0, ',', '.') }}</span>
                        <span class="label">Total</span>
                    </div>
                </div>
            </div>

            @if ($item['resumen']->count() > 0)
                <div class="cbc-breakdown">
                    @foreach ($item['resumen'] as $row)
                        <div class="cbc-status-row">
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
    <div class="no-companies">
        <i class="fa fa-building" style="font-size: 40px; margin-bottom: 12px; display: block;"></i>
        <p>No hay empresas activas con clasificaciones.</p>
    </div>
@endif

@endsection
