<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clasificacion - {{ $classification->radicado }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; color: #333; font-size: 11px; margin: 30px 35px; }
        /* Header */
        .header { display: table; width: 100%; margin-bottom: 20px; border-bottom: 3px solid #22c5bc; padding-bottom: 14px; }
        .header-left  { display: table-cell; width: 50%; vertical-align: middle; }
        .header-right { display: table-cell; width: 50%; vertical-align: middle; text-align: right; }
        .brand        { font-size: 26px; color: #22c5bc; font-weight: 900; letter-spacing: 2px; }
        .brand-sub    { font-size: 9px; color: #888; margin-top: 2px; }
        .doc-title    { font-size: 16px; color: #1a2e44; font-weight: 700; }
        .doc-radicado { font-size: 13px; color: #22c5bc; font-weight: 700; margin-top: 4px; }
        .doc-date     { font-size: 9px; color: #aaa; margin-top: 3px; }

        /* Info grid (2 col) */
        .info-grid { display: table; width: 100%; margin-bottom: 18px; border-collapse: separate; border-spacing: 8px 0; }
        .info-box  { display: table-cell; width: 49%; vertical-align: top; background: #f8f9fa; border: 1px solid #e0e0e0; padding: 11px 13px; border-radius: 4px; }
        .info-box h4 { font-size: 9px; color: #22c5bc; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 7px; font-weight: 700; }
        .info-row { margin: 3px 0; font-size: 10px; color: #444; }
        .info-row strong { color: #1a2e44; }

        /* Status badge */
        .status-badge { display: inline-block; padding: 2px 9px; border-radius: 12px; font-size: 9px; font-weight: 700; }
        .s-creado      { background: #E3F2FD; color: #1565C0; }
        .s-pendiente   { background: #FFF3E0; color: #E65100; }
        .s-en-proceso  { background: #E8EAF6; color: #303F9F; }
        .s-verificado  { background: #E0F7FA; color: #00838F; }
        .s-aprobado    { background: #E8F5E9; color: #2E7D32; }
        .s-cancelado   { background: #FDECEA; color: #B71C1C; }

        /* Section title */
        .section-title { font-size: 11px; font-weight: 700; color: #1a2e44; margin: 18px 0 8px; border-left: 4px solid #22c5bc; padding-left: 8px; }

        /* Items table */
        table.items-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        table.items-table thead tr { background-color: #1a2e44; }
        table.items-table th { color: #fff; padding: 7px 8px; text-align: left; font-size: 9px; text-transform: uppercase; letter-spacing: 0.4px; font-weight: 700; }
        table.items-table td { padding: 7px 8px; font-size: 10px; border-bottom: 1px solid #eee; vertical-align: top; color: #444; }
        table.items-table tbody tr:nth-child(even) td { background-color: #f9f9f9; }

        /* Item detail sub-row */
        .detail-block { margin-top: 4px; font-size: 9px; color: #777; }
        .detail-block span { display: inline-block; margin-right: 8px; }
        .detail-label { font-weight: 700; color: #555; }

        /* Tariff highlight */
        .tariff { font-size: 12px; font-weight: 700; color: #22c5bc; }
        .obs-note { font-size: 9px; color: #555; font-style: italic; margin-top: 3px; }

        /* Item status */
        .item-status { display: inline-block; padding: 2px 7px; border-radius: 10px; font-size: 9px; font-weight: 700; }
        .is-pendiente  { background: #FFF3E0; color: #E65100; }
        .is-verificado { background: #E8F5E9; color: #2E7D32; }
        .is-devolucion { background: #FDECEA; color: #B71C1C; }

        /* Totals */
        .totals-bar { width: 100%; border-collapse: separate; border-spacing: 8px 0; margin-top: 16px; }
        .totals-bar td { width: 33%; text-align: center; padding: 12px 14px; border-radius: 4px; vertical-align: middle; }
        .totals-card { background: #f8f9fa; border: 1px solid #e0e0e0; }
        .totals-main { background: #1a2e44; border: 1px solid #1a2e44; }
        .t-cell-label { font-size: 9px; color: #888; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 5px; }
        .t-cell-value { font-size: 15px; font-weight: 700; color: #1a2e44; }
        .totals-main .t-cell-label { color: #aaa; }
        .totals-main .t-cell-value { color: #fff; font-size: 17px; }
        .t-paid-tag { font-size: 8px; color: #22c5bc; margin-top: 3px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

        /* History */
        table.hist-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        table.hist-table th { background: #f0f0f0; color: #555; padding: 6px 8px; font-size: 9px; text-transform: uppercase; text-align: left; }
        table.hist-table td { padding: 6px 8px; font-size: 10px; border-bottom: 1px solid #f0f0f0; color: #444; }

        /* Footer */
        .footer { margin-top: 28px; padding-top: 12px; border-top: 1px solid #e0e0e0; text-align: center; font-size: 8px; color: #bbb; }
        .footer strong { color: #22c5bc; }

        /* Page break helper */
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
<div class="page">

    {{-- ── HEADER ─────────────────────────────────────────────── --}}
    <div class="header">
        <div class="header-left">
            <div class="brand">TARIX</div>
            <div class="brand-sub">Clasificacion Arancelaria Profesional</div>
        </div>
        <div class="header-right">
            <div class="doc-title">Reporte de Clasificacion</div>
            <div class="doc-radicado">{{ $classification->radicado }}</div>
            <div class="doc-date">Generado: {{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    {{-- ── INFO GENERAL ─────────────────────────────────────────── --}}
    <div class="info-grid">
        <div class="info-box">
            <h4>Datos de la Clasificacion</h4>
            <div class="info-row"><strong>Radicado:</strong> {{ $classification->radicado }}</div>
            <div class="info-row"><strong>Tipo:</strong> {{ $classification->type === 'general' ? 'Mercancia General' : 'Unidad Funcional' }}</div>
            <div class="info-row">
                <strong>Estado:</strong>&nbsp;
                @php
                    $statusMap = [
                        'Creado'            => 's-creado',
                        'Pendiente de pago' => 's-pendiente',
                        'En proceso'        => 's-en-proceso',
                        'Verificado'        => 's-verificado',
                        'Aprobado'          => 's-aprobado',
                        'Cancelado'         => 's-cancelado',
                    ];
                    $sc = $statusMap[$classification->status] ?? 's-creado';
                @endphp
                <span class="status-badge {{ $sc }}">{{ $classification->status }}</span>
            </div>
            <div class="info-row"><strong>Fecha creacion:</strong> {{ $classification->created_at->format('d/m/Y H:i') }}</div>
            @if($classification->payment_verified_at)
            <div class="info-row"><strong>Pago verificado:</strong> {{ \Carbon\Carbon::parse($classification->payment_verified_at)->format('d/m/Y') }}</div>
            @endif
        </div>

        <div class="info-box">
            <h4>Partes Involucradas</h4>
            <div class="info-row"><strong>Solicitante:</strong> {{ $classification->user->name ?? '-' }}</div>
            <div class="info-row"><strong>Email:</strong> {{ $classification->user->email ?? '-' }}</div>
            @if($classification->user->company)
            <div class="info-row"><strong>Empresa:</strong> {{ $classification->user->company->name }}</div>
            @endif
            @if($classification->clasificador)
            <div class="info-row"><strong>Clasificador:</strong> {{ $classification->clasificador->name }}</div>
            @endif
            <div class="info-row"><strong>Items:</strong> {{ $classification->items->count() }}</div>
        </div>
    </div>

    {{-- ── ITEMS ─────────────────────────────────────────────────── --}}
    <div class="section-title">Items de la Clasificacion</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width:4%;">#</th>
                <th style="width:18%;">Nombre Comercial</th>
                <th style="width:15%;">Nombre Tecnico</th>
                <th style="width:12%;">Materia</th>
                <th style="width:12%;">Funcion</th>
                <th style="width:12%;">Destino</th>
                <th style="width:10%;">Arancel Sugerido</th>
                <th style="width:10%;">Arancel Final</th>
                <th style="width:7%;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classification->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $item->commercial_name ?? '-' }}</strong></td>
                <td>{{ $item->technical_name ?? '-' }}</td>
                <td>{{ $item->matter ?? '-' }}</td>
                <td>{{ $item->function ?? '-' }}</td>
                <td>{{ $item->destination ?? '-' }}</td>
                <td>{{ $item->suggested_tariff ?? '-' }}</td>
                <td>
                    @if($item->final_tariff)
                        <span class="tariff">{{ $item->final_tariff }}</span>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @php
                        $ic = match($item->status) {
                            'Verificado'  => 'is-verificado',
                            'Devolucion', 'Devolución' => 'is-devolucion',
                            default       => 'is-pendiente',
                        };
                    @endphp
                    <span class="item-status {{ $ic }}">{{ $item->status }}</span>
                </td>
            </tr>
            @if($item->observations || $item->clasificador_observations || $item->revision_note)
            <tr>
                <td></td>
                <td colspan="8">
                    @if($item->observations)
                    <div class="detail-block"><span class="detail-label">Observaciones:</span> {{ $item->observations }}</div>
                    @endif
                    @if($item->clasificador_observations)
                    <div class="detail-block"><span class="detail-label">Obs. clasificador:</span> {{ $item->clasificador_observations }}</div>
                    @endif
                    @if($item->revision_note)
                    <div class="detail-block"><span class="detail-label">Nota devolucion:</span> {{ $item->revision_note }}</div>
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    {{-- ── TOTALES ───────────────────────────────────────────────── --}}
    @php $isPaid = $classification->payment_verified; @endphp
    <table class="totals-bar">
        <tr>
            <td class="totals-card">
                <div class="t-cell-label">Subtotal</div>
                <div class="t-cell-value">${{ number_format($classification->subtotal ?? 0, 0, ',', '.') }}</div>
            </td>
            <td class="totals-card">
                <div class="t-cell-label">IVA ({{ $classification->iva_percentage ?? 0 }}%)</div>
                <div class="t-cell-value">${{ number_format($classification->iva_amount ?? 0, 0, ',', '.') }}</div>
            </td>
            <td class="totals-main">
                <div class="t-cell-label">{{ $isPaid ? 'Total Pagado' : 'Total a Pagar' }}</div>
                <div class="t-cell-value">${{ number_format($classification->total_cost ?? 0, 0, ',', '.') }}</div>
                @if($isPaid)<div class="t-paid-tag">Pago verificado</div>@endif
            </td>
        </tr>
    </table>

    {{-- ── FOOTER ───────────────────────────────────────────────── --}}
    <div class="footer">
        <strong>TARIX</strong> — Clasificacion Arancelaria Profesional &nbsp;|&nbsp;
        Documento generado el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
    </div>

</div>
</body>
</html>
