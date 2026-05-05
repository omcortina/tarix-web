<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificación Registrada - TARIX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background-color: #22c5bc; padding: 30px 20px; text-align: center; color: white; }
        .header h1 { font-size: 24px; font-weight: 700; margin: 0; }
        .header p { font-size: 14px; opacity: 0.95; margin-top: 8px; }
        .content { padding: 30px; }
        .greeting h2 { font-size: 18px; color: #22c5bc; margin-bottom: 10px; font-weight: 700; }
        .greeting p { color: #666; font-size: 14px; margin-bottom: 8px; }
        .info-box { background-color: #f0fffe; border-left: 4px solid #22c5bc; padding: 20px; margin: 20px 0; border-radius: 4px; }
        .info-box h3 { color: #1a2e44; font-size: 16px; margin-bottom: 15px; margin-top: 0; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; font-size: 14px; }
        .detail-label { color: #666; font-weight: 600; }
        .detail-value { color: #333; text-align: right; }
        .radicado-badge { display: inline-block; background-color: #22c5bc; color: white; padding: 8px 18px; border-radius: 20px; font-weight: 700; font-size: 16px; letter-spacing: 1px; margin: 10px 0; }
        .cta-button { display: inline-block; background-color: #22c5bc; color: white !important; text-decoration: none; padding: 12px 28px; border-radius: 6px; margin: 20px 0; font-weight: 600; font-size: 14px; }
        .info-text { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 4px; font-size: 13px; color: #856404; }
        .footer { background-color: #f9f9f9; padding: 20px; text-align: center; color: #666; font-size: 12px; border-top: 1px solid #e0e0e0; }
        .footer a { color: #22c5bc; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Clasificación Registrada</h1>
            <p>TARIX - Sistema de Clasificación Arancelaria</p>
        </div>

        <div class="content">
            <div class="greeting">
                <h2>Hola, {{ $cliente->name }}</h2>
                <p>Tu solicitud de clasificación arancelaria ha sido registrada exitosamente en nuestro sistema.</p>
            </div>

            <center>
                <span class="radicado-badge">{{ $classification->radicado }}</span>
            </center>

            <div class="info-box">
                <h3>Detalles de la Clasificación</h3>

                <div class="detail-row">
                    <span class="detail-label">Radicado:&nbsp;</span>
                    <span class="detail-value"><strong>{{ $classification->radicado }}</strong></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Tipo:&nbsp;</span>
                    <span class="detail-value">{{ $classification->type === 'general' ? 'Mercancía General' : 'Unidad Funcional' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Total de ítems:&nbsp;</span>
                    <span class="detail-value">{{ $classification->items->count() }}</span>
                </div>

                @if($showPrice)
                <div class="detail-row">
                    <span class="detail-label">Costo Total:&nbsp;</span>
                    <span class="detail-value"><strong>${{ number_format($classification->total_cost, 0, ',', '.') }}</strong></span>
                </div>
                @endif

                <div class="detail-row">
                    <span class="detail-label">Fecha de Creación:&nbsp;</span>
                    <span class="detail-value">{{ $classification->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <div class="info-text">
                <strong>Próximo paso:</strong>
                @if($showPrice)
                    Tu clasificación está pendiente de verificación de pago. Una vez confirmado, nuestro equipo iniciará el proceso de clasificación.
                @else
                    Tu clasificación ha sido registrada y será procesada por nuestro equipo de clasificadores.
                @endif
            </div>

            <center>
                <a href="{{ $proceduresUrl }}" class="cta-button">Consultar Estado</a>
            </center>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} TARIX. Todos los derechos reservados.</p>
            <p>Este correo fue enviado porque registraste una nueva clasificación arancelaria.</p>
            <p>Si tienes preguntas, <a href="mailto:{{ env('MAIL_FROM_ADDRESS', 'info@tarix.com.co') }}">contáctanos</a></p>
        </div>
    </div>
</body>
</html>
