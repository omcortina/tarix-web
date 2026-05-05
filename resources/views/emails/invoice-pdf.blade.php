<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura - {{ $classification->radicado }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; color: #333; font-size: 12px; }
        .page { padding: 30px; }

        /* Header */
        .header { display: table; width: 100%; margin-bottom: 25px; border-bottom: 3px solid #22c5bc; padding-bottom: 15px; }
        .header-logo { display: table-cell; width: 50%; vertical-align: middle; }
        .header-logo h1 { font-size: 28px; color: #22c5bc; font-weight: 900; letter-spacing: 2px; }
        .header-logo p { font-size: 10px; color: #666; margin-top: 3px; }
        .header-invoice { display: table-cell; width: 50%; vertical-align: middle; text-align: right; }
        .header-invoice h2 { font-size: 18px; color: #1a2e44; font-weight: 700; }
        .header-invoice p { font-size: 10px; color: #666; margin-top: 4px; }
        .radicado { font-size: 13px; color: #22c5bc; font-weight: 700; margin-top: 5px; }

        /* Info boxes */
        .info-grid { display: table; width: 100%; margin-bottom: 20px; }
        .info-box { display: table-cell; width: 48%; vertical-align: top; background: #f8f9fa; border: 1px solid #e0e0e0; padding: 12px; border-radius: 4px; }
        .info-box + .info-box { padding-left: 12px; margin-left: 4%; }
        .info-box h4 { font-size: 10px; color: #22c5bc; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; font-weight: 700; }
        .info-box p { font-size: 11px; color: #444; margin: 3px 0; }
        .info-box strong { color: #1a2e44; }

        /* Items table */
        .section-title { font-size: 13px; font-weight: 700; color: #1a2e44; margin: 20px 0 10px; border-left: 4px solid #22c5bc; padding-left: 8px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #1a2e44; color: white; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 8px 10px; font-size: 11px; border-bottom: 1px solid #eee; vertical-align: top; }
        tr:nth-child(even) td { background-color: #f9f9f9; }

        /* Totals */
        .totals-wrapper { margin-top: 10px; }
        .totals-table { width: 320px; margin-left: auto; border: 1px solid #e0e0e0; border-radius: 4px; overflow: hidden; }
        .totals-row { display: table; width: 100%; }
        .totals-row td { padding: 8px 15px; font-size: 12px; border-bottom: 1px solid #eee; }
        .totals-row .label { color: #666; width: 60%; }
        .totals-row .value { text-align: right; color: #333; font-weight: 600; }
        .totals-total { background-color: #1a2e44; }
        .totals-total td { color: white !important; font-size: 14px; font-weight: 700; border-bottom: none; }

        /* Footer */
        .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #e0e0e0; text-align: center; font-size: 9px; color: #999; }
        .footer strong { color: #22c5bc; }
        .status-badge { display: inline-block; background-color: #e8f5e9; color: #1b5e20; border: 1px solid #43a047; padding: 3px 10px; border-radius: 12px; font-size: 10px; font-weight: 700; margin-top: 5px; }
    </style>
</head>
<body>
<div class="page">

    <!-- Header -->
    <div class="header">
        <div class="header-logo">
            <h1>TARIX</h1>
            <p>Clasificación Arancelaria Profesional</p>
        </div>
        <div class="header-invoice">
            <h2>FACTURA DE SERVICIO</h2>
            <p>Fecha: {{ now()->format('d/m/Y') }}</p>
            <p class="radicado">Radicado: {{ $classification->radicado }}</p>
            <div class="status-badge">APROBADO</div>
        </div>
    </div>

    <!-- Info: Cliente + Empresa -->
    <div class="info-grid">
        <div class="info-box">
            <h4>Cliente</h4>
            <p><strong>{{ $cliente->name }}</strong></p>
            <p>{{ $cliente->email }}</p>
            @if($cliente->company)
            <p>Empresa: {{ $cliente->company->name }}</p>
            @endif
            <p>Tipo: {{ $cliente->client_type === 'PREFERENCIAL' ? 'Preferencial' : 'General' }}</p>
        </div>
        <div class="info-box">
            <h4>Clasificación</h4>
            <p><strong>Radicado:</strong> {{ $classification->radicado }}</p>
            <p><strong>Tipo:</strong> {{ $classification->type === 'unidad_funcional' ? 'Unidad Funcional' : 'General' }}</p>
            <p><strong>Total Ítems:</strong> {{ $classification->items->count() }}</p>
            <p><strong>Fecha Aprobación:</strong> {{ $classification->updated_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <!-- Items -->
    <div class="section-title">Detalle de Ítems</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre Comercial</th>
                <th>Nombre Técnico</th>
                <th>Arancel Asignado</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classification->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->commercial_name }}</td>
                <td>{{ $item->technical_name ?? '-' }}</td>
                <td>{{ $item->assigned_tariff ?? $item->suggested_tariff ?? '-' }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals-wrapper">
        <table class="totals-table" style="width: 320px; margin-left: auto; border-collapse: collapse; border: 1px solid #e0e0e0;">
            <tr>
                <td style="padding: 8px 15px; font-size: 12px; border-bottom: 1px solid #eee; color: #666;">Subtotal</td>
                <td style="padding: 8px 15px; font-size: 12px; border-bottom: 1px solid #eee; text-align: right; font-weight: 600;">${{ number_format($classification->subtotal, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 15px; font-size: 12px; border-bottom: 1px solid #eee; color: #666;">IVA ({{ number_format($classification->iva_percentage, 0) }}%)</td>
                <td style="padding: 8px 15px; font-size: 12px; border-bottom: 1px solid #eee; text-align: right; font-weight: 600;">${{ number_format($classification->iva_amount, 2, ',', '.') }}</td>
            </tr>
            <tr style="background-color: #1a2e44;">
                <td style="padding: 10px 15px; font-size: 14px; color: white; font-weight: 700;">TOTAL A PAGAR</td>
                <td style="padding: 10px 15px; font-size: 14px; color: white; font-weight: 700; text-align: right;">${{ number_format($classification->total_cost, 2, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Generado por <strong>TARIX</strong> el {{ now()->format('d/m/Y H:i') }} | Este documento es un comprobante de servicio de clasificación arancelaria.</p>
    </div>

</div>
</body>
</html>
