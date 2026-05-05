<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificación Aprobada - TARIX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background-color: #4CAF50; padding: 30px 20px; text-align: center; color: white; }
        .header h1 { font-size: 24px; font-weight: 700; margin: 0; }
        .header p { font-size: 14px; opacity: 0.95; margin-top: 8px; }
        .content { padding: 30px; }
        .greeting h2 { font-size: 18px; color: #4CAF50; margin-bottom: 10px; font-weight: 700; }
        .greeting p { color: #666; font-size: 14px; margin-bottom: 8px; }
        .approved-badge { background-color: #e8f5e9; border: 2px solid #43a047; color: #4CAF50; padding: 15px 20px; border-radius: 8px; text-align: center; margin: 20px 0; font-weight: 700; font-size: 18px; }
        .client-box { background-color: #f9f9f9; border-left: 4px solid #22c5bc; padding: 15px; border-radius: 4px; margin: 15px 0; font-size: 14px; }
        .client-box h4 { color: #22c5bc; margin-bottom: 8px; margin-top: 0; font-size: 14px; }
        .client-box p { margin: 4px 0; color: #444; }
        .detail-box { background-color: #f1f8e9; border-left: 4px solid #4CAF50; padding: 20px; margin: 20px 0; border-radius: 4px; }
        .detail-box h3 { color: #1a2e44; font-size: 16px; margin-bottom: 15px; margin-top: 0; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; font-size: 14px; }
        .detail-label { color: #666; font-weight: 600; }
        .detail-value { color: #333; text-align: right; }
        .cta-button { display: inline-block; background-color: #4CAF50; color: white !important; text-decoration: none; padding: 12px 28px; border-radius: 6px; margin: 20px 0; font-weight: 600; font-size: 14px; }
        .footer { background-color: #f9f9f9; padding: 20px; text-align: center; color: #666; font-size: 12px; border-top: 1px solid #e0e0e0; }
        .footer a { color: #22c5bc; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Clasificación Aprobada</h1>
            <p>TARIX - Sistema de Clasificación Arancelaria</p>
        </div>

        <div class="content">
            <div class="greeting">
                <h2>Hola, {{ $empresaUser->name }}</h2>
                <p>Nos complace informarte que la siguiente clasificación ha sido <strong>aprobada</strong> por nuestro equipo de expertos.</p>
            </div>

            <div class="client-box">
                <h4>Cliente</h4>
                <p><strong>Nombre:</strong> {{ $cliente->name }}</p>
                <p><strong>Email:</strong> {{ $cliente->email }}</p>
            </div>

            <div class="detail-box">
                <h3>Detalles de la Clasificación</h3>

                <div class="detail-row">
                    <span class="detail-label">Radicado:&nbsp;</span>
                    <span class="detail-value"><strong>{{ $classification->radicado }}</strong></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Estado:&nbsp;</span>
                    <span class="detail-value">Aprobado</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Total de Ítems:&nbsp;</span>
                    <span class="detail-value">{{ $classification->items->count() }}</span>
                </div>

                @if($classification->total_price)
                    <div class="detail-row">
                        <span class="detail-label">Costo Total:&nbsp;</span>
                        <span class="detail-value"><strong>${{ number_format($classification->total_price, 2) }}</strong></span>
                    </div>
                @endif

                <div class="detail-row">
                    <span class="detail-label">Fecha de Aprobación:&nbsp;</span>
                    <span class="detail-value">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <center>
                <a href="{{ $dashboardUrl }}" class="cta-button">Ver Clasificaciones</a>
            </center>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} TARIX. Todos los derechos reservados.</p>
            <p>Este correo fue enviado porque una clasificación asociada a tu cuenta fue aprobada.</p>
            <p>Si tienes preguntas, <a href="mailto:{{ env('MAIL_FROM_ADDRESS', 'info@tarix.com.co') }}">contáctanos</a></p>
        </div>
    </div>
</body>
</html>
