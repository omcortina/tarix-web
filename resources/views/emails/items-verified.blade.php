<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items Verificados - TARIX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; color: #333; line-height: 1.6; }
        .container { max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background-color: #22c5bc; padding: 30px 20px; text-align: center; color: white; }
        .header h1 { font-size: 22px; font-weight: 700; margin: 0; }
        .header p { font-size: 14px; opacity: 0.95; margin-top: 8px; }
        .content { padding: 30px; }
        .greeting h2 { font-size: 18px; color: #22c5bc; margin-bottom: 10px; font-weight: 700; }
        .greeting p { color: #666; font-size: 14px; margin-bottom: 8px; }
        .info-box { background-color: #e0f7f6; border-left: 4px solid #22c5bc; padding: 16px 20px; margin: 20px 0; border-radius: 4px; }
        .info-box p { font-size: 14px; color: #333; margin: 4px 0; }
        .info-box strong { color: #1a7a5e; }
        .section-title { font-size: 16px; font-weight: 700; color: #1a2e44; margin: 24px 0 12px; border-bottom: 2px solid #e0f7f6; padding-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead tr { background-color: #22c5bc; color: white; }
        thead th { padding: 10px 12px; text-align: left; font-weight: 600; }
        tbody tr:nth-child(even) { background-color: #f9fffe; }
        tbody tr:nth-child(odd) { background-color: #ffffff; }
        tbody td { padding: 10px 12px; vertical-align: top; border-bottom: 1px solid #e8f5f4; color: #444; }
        .tariff-cell { font-weight: 700; color: #1a7a5e; white-space: nowrap; }
        .obs-cell { font-style: italic; color: #666; }
        .footer { background-color: #f9f9f9; padding: 20px 30px; text-align: center; border-top: 1px solid #eee; }
        .footer p { font-size: 12px; color: #999; margin: 4px 0; }
        .cta-button { display: inline-block; background-color: #22c5bc; color: white !important; padding: 12px 28px; border-radius: 5px; text-decoration: none; font-weight: 700; font-size: 14px; margin: 20px 0; }
        .badge { display: inline-block; background: #e0f7f6; color: #1a7a5e; font-weight: 700; padding: 3px 10px; border-radius: 12px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Todos los ítems han sido Verificados</h1>
            <p>Radicado: {{ $classification->radicado }}</p>
        </div>

        <div class="content">
            <div class="greeting">
                <h2>Hola, {{ $recipient->name }}</h2>
                <p>Nos complace informarle que todos los ítems de su solicitud de clasificación arancelaria han sido revisados y verificados por nuestro equipo de clasificadores.</p>
                <p>A continuación encontrará el detalle de los resultados.</p>
            </div>

            <div class="info-box">
                <p><strong>Radicado:</strong> {{ $classification->radicado }}</p>
                <p><strong>Tipo:</strong>
                    {{ $classification->type === 'general' ? 'Mercancía General' : 'Unidad Funcional' }}
                </p>
                <p><strong>Solicitante:</strong> {{ $classification->user->name }}</p>
                <p><strong>Total de Ítems Verificados:</strong>
                    <span class="badge">{{ $items->count() }}</span>
                </p>
            </div>

            <p class="section-title">Listado de Ítems Verificados</p>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Comercial</th>
                        <th>Subpartida Final</th>
                        <th>Observaciones del Clasificador</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $index => $item)
                    <tr>
                        <td style="text-align:center;font-weight:600;color:#888;">{{ $index + 1 }}</td>
                        <td>{{ $item->commercial_name }}</td>
                        <td class="tariff-cell">{{ $item->final_tariff ?? '-' }}</td>
                        <td class="obs-cell">{{ $item->clasificador_observations ?: '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <p style="margin-top: 24px; font-size: 14px; color: #555;">
                Su clasificación está siendo procesada. Recibirá una notificación adicional una vez que sea formalmente aprobada por nuestro equipo.
            </p>

            <center>
                <a href="{{ route('user.procedures') }}" class="cta-button">Ver Estado de la Clasificación</a>
            </center>
        </div>

        <div class="footer">
            <p>Este correo fue enviado automáticamente por el sistema TARIX.</p>
            <p>Si tiene alguna pregunta, contáctenos en <a href="mailto:{{ env('MAIL_FROM_ADDRESS', 'info@tarix.com.co') }}">{{ env('MAIL_FROM_ADDRESS', 'info@tarix.com.co') }}</a></p>
        </div>
    </div>
</body>
</html>
