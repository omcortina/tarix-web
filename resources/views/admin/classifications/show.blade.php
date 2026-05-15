@extends('layouts.admin')

@section('title', 'Clasificación ' . $classification->radicado)

@section('extra_css')
<style>
    .cls-back { margin-bottom: 20px; }
    .cls-back a { font-size: 13px; color: #666; text-decoration: none; }
    .cls-back a:hover { color: #22c5bc; }

    .cls-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }
    .cls-header h1 { font-size: 22px; font-weight: 700; color: #1a2e44; margin: 0; }
    .cls-header-right { display: flex; align-items: center; gap: 12px; }

    .status-badge {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }
    .status-creado            { background: #E3F2FD; color: #1565C0; }
    .status-pendiente-de-pago { background: #FFF3E0; color: #E65100; }
    .status-en-proceso        { background: #E8EAF6; color: #303F9F; }
    .status-verificado        { background: #E0F7FA; color: #00838F; }
    .status-aprobado          { background: #E8F5E9; color: #2E7D32; }
    .status-cancelado         { background: #FDECEA; color: #B71C1C; }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }
    .info-card {
        background: #fff;
        border-radius: 8px;
        padding: 18px 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    }
    .info-card h3 {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #22c5bc;
        margin: 0 0 12px;
    }
    .info-row {
        display: flex;
        gap: 8px;
        font-size: 13px;
        margin-bottom: 7px;
        color: #444;
    }
    .info-row .lbl { color: #888; min-width: 120px; font-weight: 500; }
    .info-row .val { font-weight: 600; color: #1a2e44; }

    .section-title {
        font-size: 15px;
        font-weight: 700;
        color: #1a2e44;
        margin: 0 0 12px;
        padding-left: 10px;
        border-left: 4px solid #22c5bc;
    }

    .items-wrapper { display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px; }
    .item-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        overflow: hidden;
    }
    .item-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        background: #f8fffe;
        border-bottom: 1px solid #eef;
    }
    .item-num { font-size: 12px; font-weight: 700; color: #22c5bc; }
    .item-name { font-size: 14px; font-weight: 700; color: #1a2e44; }
    .item-card-body {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px 20px;
        padding: 14px 18px;
    }
    .item-field .fld-label { font-size: 11px; color: #aaa; font-weight: 600; margin-bottom: 2px; }
    .item-field .fld-value { font-size: 13px; color: #333; }
    .item-field.full { grid-column: 1 / -1; }

    .tariff-box {
        background: #e8f5e9;
        border-left: 3px solid #22c5bc;
        border-radius: 4px;
        padding: 10px 14px;
        grid-column: 1 / -1;
    }
    .tariff-box .fld-label { color: #1a7a5e; }
    .tariff-box .fld-value { font-size: 16px; font-weight: 700; color: #1a7a5e; }

    .revision-box {
        background: #fdecea;
        border-left: 3px solid #d32f2f;
        border-radius: 4px;
        padding: 10px 14px;
        grid-column: 1 / -1;
    }
    .revision-box .fld-label { color: #b71c1c; }
    .revision-box .fld-value { font-size: 13px; color: #555; font-style: italic; }

    .is-badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; }
    .is-pendiente  { background: #FFF3E0; color: #E65100; }
    .is-verificado { background: #E8F5E9; color: #2E7D32; }
    .is-devolucion { background: #FDECEA; color: #B71C1C; }

    .totals-row-bar {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
        margin-bottom: 24px;
    }
    .total-card {
        background: #fff;
        border-radius: 8px;
        padding: 16px 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        text-align: center;
    }
    .total-card.main { background: #1a2e44; }
    .total-card .tc-label { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .total-card .tc-value { font-size: 20px; font-weight: 700; color: #1a2e44; }
    .total-card.main .tc-label { color: #aaa; }
    .total-card.main .tc-value { color: #fff; font-size: 22px; }
    .paid-tag { font-size: 11px; color: #22c5bc; font-weight: 700; margin-top: 4px; }

    .print-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #f0f0f0;
        color: #333;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }
    .print-btn:hover { background: #e0e0e0; }

    @media (max-width: 768px) {
        .info-grid { grid-template-columns: 1fr; }
        .totals-row-bar { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

<div class="cls-back">
    <a href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i> Volver</a>
</div>

<div class="cls-header">
    <div>
        <h1>{{ $classification->radicado }}</h1>
        <div style="font-size:13px;color:#888;margin-top:4px;">
            Solicitante: <strong>{{ $classification->user->name }}</strong>
            @if($classification->user->company)
                &nbsp;—&nbsp; Empresa: <strong>{{ $classification->user->company->name }}</strong>
            @endif
        </div>
    </div>
    <div class="cls-header-right">
        <span class="status-badge status-{{ str_replace(' ', '-', strtolower($classification->status)) }}">
            {{ $classification->status }}
        </span>
        <a href="{{ route('user.classifications.pdf', $classification) }}" target="_blank" class="print-btn">
            <i class="fa fa-print"></i> Imprimir PDF
        </a>
        @if(in_array($classification->status, ['Creado', 'Pendiente de pago']))
            <form method="POST" action="{{ route('admin.classifications.cancel', $classification) }}" style="display:inline;"
                  onsubmit="return confirm('¿Cancelar la clasificación {{ $classification->radicado }}?')">
                @csrf @method('PATCH')
                <button type="submit" style="padding:8px 16px;background:#FDECEA;color:#B71C1C;border:1px solid #ef9a9a;border-radius:6px;font-size:13px;font-weight:600;cursor:pointer;">
                    <i class="fa fa-ban"></i> Cancelar
                </button>
            </form>
        @endif
    </div>
</div>

{{-- ── INFO GENERAL ─────────────────────────────────────────── --}}
<div class="info-grid">
    <div class="info-card">
        <h3>Datos de la Clasificación</h3>
        <div class="info-row"><span class="lbl">Radicado</span><span class="val">{{ $classification->radicado }}</span></div>
        <div class="info-row"><span class="lbl">Tipo</span><span class="val">{{ $classification->type === 'general' ? 'Mercancía General' : 'Unidad Funcional' }}</span></div>
        <div class="info-row"><span class="lbl">Estado</span><span class="val">{{ $classification->status }}</span></div>
        <div class="info-row"><span class="lbl">Creada</span><span class="val">{{ $classification->created_at->format('d/m/Y H:i') }}</span></div>
        <div class="info-row"><span class="lbl">Pago verificado</span><span class="val">{{ $classification->payment_verified ? 'Sí — ' . \Carbon\Carbon::parse($classification->payment_verified_at)->format('d/m/Y') : 'No' }}</span></div>
    </div>
    <div class="info-card">
        <h3>Partes</h3>
        <div class="info-row"><span class="lbl">Solicitante</span><span class="val">{{ $classification->user->name }}</span></div>
        <div class="info-row"><span class="lbl">Email</span><span class="val">{{ $classification->user->email }}</span></div>
        @if($classification->user->company)
        <div class="info-row"><span class="lbl">Empresa</span><span class="val">{{ $classification->user->company->name }}</span></div>
        @endif
        @if($classification->clasificador)
        <div class="info-row"><span class="lbl">Clasificador</span><span class="val">{{ $classification->clasificador->name }}</span></div>
        @endif
        <div class="info-row"><span class="lbl">Total ítems</span><span class="val">{{ $classification->items->count() }}</span></div>
    </div>
</div>

{{-- ── TOTALES ───────────────────────────────────────────────── --}}
<div class="section-title" style="margin-bottom:14px;">Totales</div>
@php $isPaid = $classification->payment_verified; @endphp
<div class="totals-row-bar">
    <div class="total-card">
        <div class="tc-label">Subtotal</div>
        <div class="tc-value">${{ number_format($classification->subtotal ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="total-card">
        <div class="tc-label">IVA ({{ $classification->iva_percentage ?? 0 }}%)</div>
        <div class="tc-value">${{ number_format($classification->iva_amount ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="total-card main">
        <div class="tc-label">{{ $isPaid ? 'Total Pagado' : 'Total a Pagar' }}</div>
        <div class="tc-value">${{ number_format($classification->total_cost ?? 0, 0, ',', '.') }}</div>
        @if($isPaid)<div class="paid-tag">Pago verificado</div>@endif
    </div>
</div>

{{-- ── ITEMS ─────────────────────────────────────────────────── --}}
<div class="section-title">Ítems ({{ $classification->items->count() }})</div>
<div class="items-wrapper">
    @foreach($classification->items as $i => $item)
    @php
        $ic = match($item->status) {
            'Verificado'  => 'is-verificado',
            'Devolución', 'Devolucion' => 'is-devolucion',
            default       => 'is-pendiente',
        };
    @endphp
    <div class="item-card">
        <div class="item-card-header">
            <div>
                <div class="item-num">Ítem #{{ $i + 1 }}</div>
                <div class="item-name">{{ $item->commercial_name ?? '-' }}</div>
            </div>
            <span class="is-badge {{ $ic }}">{{ $item->status }}</span>
        </div>
        <div class="item-card-body">
            @if($item->technical_name)
            <div class="item-field">
                <div class="fld-label">Nombre Técnico</div>
                <div class="fld-value">{{ $item->technical_name }}</div>
            </div>
            @endif
            @if($item->matter)
            <div class="item-field">
                <div class="fld-label">Materia Prima</div>
                <div class="fld-value">{{ $item->matter }}</div>
            </div>
            @endif
            @if($item->function)
            <div class="item-field">
                <div class="fld-label">Función / Uso</div>
                <div class="fld-value">{{ $item->function }}</div>
            </div>
            @endif
            @if($item->destination)
            <div class="item-field">
                <div class="fld-label">Destino / Aplicación</div>
                <div class="fld-value">{{ $item->destination }}</div>
            </div>
            @endif
            @if($item->suggested_tariff)
            <div class="item-field">
                <div class="fld-label">Arancel Sugerido</div>
                <div class="fld-value">{{ $item->suggested_tariff }}</div>
            </div>
            @endif
            @if($item->observations)
            <div class="item-field full">
                <div class="fld-label">Observaciones del cliente</div>
                <div class="fld-value">{{ $item->observations }}</div>
            </div>
            @endif
            @if($item->status === 'Verificado' && $item->final_tariff)
            <div class="tariff-box">
                <div class="fld-label">Subpartida Final Asignada</div>
                <div class="fld-value">{{ $item->final_tariff }}</div>
                @if($item->clasificador_observations)
                <div style="font-size:12px;color:#555;font-style:italic;margin-top:6px;">{{ $item->clasificador_observations }}</div>
                @endif
            </div>
            @endif
            @if($item->revision_note)
            <div class="revision-box">
                <div class="fld-label">Nota de Devolución</div>
                <div class="fld-value">{{ $item->revision_note }}</div>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>

@endsection
