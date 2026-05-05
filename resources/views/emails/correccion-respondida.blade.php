<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corrección Respondida - TARIX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background-color: #7b1fa2; padding: 30px 20px; text-align: center; color: white; }
        .header h1 { font-size: 24px; font-weight: 700; margin: 0; }
        .header p { font-size: 14px; opacity: 0.95; margin-top: 8px; }
        .content { padding: 30px; }
        .greeting h2 { font-size: 18px; color: #7b1fa2; margin-bottom: 10px; font-weight: 700; }
        .greeting p { color: #666; font-size: 14px; margin-bottom: 8px; }
        .item-box { background-color: #f3e5f5; border-left: 4px solid #7b1fa2; padding: 20px; margin: 20px 0; border-radius: 4px; }
        .item-box h3 { color: #1a2e44; font-size: 16px; margin-bottom: 15px; margin-top: 0; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; font-size: 14px; }
        .detail-label { color: #666; font-weight: 600; }
        .detail-value { color: #333; text-align: right; }
        .response-box { background-color: #f9f9f9; border: 1px solid #e0e0e0; padding: 15px; border-radius: 4px; margin: 15px 0; font-size: 14px; }
        .response-box h4 { color: #7b1fa2; margin-bottom: 8px; margin-top: 0; font-size: 14px; }
        .response-box p { margin: 0; color: #444; white-space: pre-wrap; }
        .client-box { background-color: #f9f9f9; border-left: 4px solid #22c5bc; padding: 15px; border-radius: 4px; margin: 15px 0; font-size: 14px; }
        .client-box h4 { color: #22c5bc; margin-bottom: 8px; margin-top: 0; font-size: 14px; }
        .client-box p { margin: 4px 0; color: #444; }
        .cta-button { display: inline-block; background-color: #7b1fa2; color: white !important; text-decoration: none; padding: 12px 28px; border-radius: 6px; margin: 20px 0; font-weight: 600; font-size: 14px; }
        .info-text { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 4px; font-size: 13px; color: #856404; }
        .footer { background-color: #f9f9f9; padding: 20px; text-align: center; color: #666; font-size: 12px; border-top: 1px solid #e0e0e0; }
        .footer a { color: #22c5bc; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Corrección Respondida</h1>
            <p>TARIX - Sistema de Clasificación Arancelaria</p>
        </div>

        <div class="content">
            <div class="greeting">
                <h2>Hola, {{ $clasificador->name }}</h2>
                <p>El cliente ha respondido a tu solicitud de corrección para el ítem <strong>{{ $item->commercial_name }}</strong>.</p>
            </div>

            <div class="client-box">
                <h4>Cliente</h4>
                <p><strong>Nombre:</strong> {{ $cliente->name }}</p>
                <p><strong>Email:</strong> {{ $cliente->email }}</p>
            </div>

            <div class="item-box">
                <h3>Detalles del Ítem</h3>

                <div class="detail-row">
                    <span class="detail-label">Radicado:</span>
                    <span class="detail-value"><strong>{{ $classification->radicado }}</strong></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Ítem:</span>
                    <span class="detail-value">{{ $item->commercial_name }}</span>
                </div>

                @if($item->technical_name)
                <div class="detail-row">
                    <span class="detail-label">Nombre Técnico:</span>
                    <span class="detail-value">{{ $item->technical_name }}</span>
                </div>
                @endif
            </div>

            <div class="response-box">
                <h4>Solicitud Original de Corrección</h4>
                <p>{{ $correction->correction_note }}</p>
            </div>

            <div class="response-box">
                <h4>Respuesta del Cliente</h4>
                <p>{{ $correction->client_response }}</p>
            </div>

            <div class="info-text">
                <strong>Acción requerida:</strong> El ítem ha vuelto a estado "Pendiente". Por favor ingresa a la clasificación para revisar la respuesta del cliente y continuar con el proceso.
            </div>

            <center>
                <a href="{{ $dashboardUrl }}" class="cta-button">Ver Clasificación</a>
            </center>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} TARIX. Todos los derechos reservados.</p>
            <p>Este correo fue enviado porque un cliente respondió a tu solicitud de corrección.</p>
            <p>Si tienes preguntas, <a href="mailto:{{ env('MAIL_FROM_ADDRESS', 'info@tarix.com.co') }}">contáctanos</a></p>
        </div>
    </div>
</body>
</html>
