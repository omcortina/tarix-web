<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisión Requerida - TARIX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            background-color: #ff9800;
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.95;
            margin-top: 8px;
        }
        
        .content {
            padding: 30px;
        }
        
        .greeting {
            margin-bottom: 20px;
        }
        
        .greeting h2 {
            font-size: 18px;
            color: #ff9800;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .greeting p {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .item-box {
            background-color: #fff8f3;
            border-left: 4px solid #ff9800;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .item-box h3 {
            color: #1a2e44;
            font-size: 16px;
            margin-bottom: 15px;
            margin-top: 0;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 14px;
        }
        
        .detail-label {
            color: #666;
            font-weight: 600;
        }
        
        .detail-value {
            color: #333;
            text-align: right;
        }
        
        .observations-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            font-size: 14px;
            border: 1px solid #e0e0e0;
        }
        
        .observations-box h4 {
            color: #ff9800;
            margin-bottom: 10px;
            margin-top: 0;
            font-size: 14px;
        }
        
        .observations-box p {
            margin: 0;
            color: #333;
        }
        
        .alert-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-size: 13px;
            color: #856404;
        }
        
        .cta-button {
            display: inline-block;
            background-color: #ff9800;
            color: white !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
            font-size: 14px;
        }
        
        .cta-button:hover {
            background-color: #e68900;
        }
        
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #e0e0e0;
        }
        
        .footer a {
            color: #ff9800;
            text-decoration: none;
        }
        
        .radicado-badge {
            display: inline-block;
            background-color: #ff9800;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Revisión Requerida</h1>
            <p>TARIX - Sistema de Clasificación Arancelaria</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                <h2>Hola, {{ $cliente->name }}</h2>
                <p>El clasificador ha revisado tu solicitud y requiere que corrijas o completes información en uno de los ítems.</p>
            </div>
            
            <div class="item-box">
                <h3>Información del Ítem</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Radicado:&nbsp;</span>
                    <span class="detail-value">{{ $classification->radicado }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Nombre Comercial:&nbsp;</span>
                    <span class="detail-value">{{ $item->commercial_name }}</span>
                </div>
                
                @if($item->technical_name)
                <div class="detail-row">
                    <span class="detail-label">Nombre Técnico:&nbsp;</span>
                    <span class="detail-value">{{ $item->technical_name }}</span>
                </div>
                @endif
            </div>
            
            <div class="observations-box">
                <h4>Observaciones del Clasificador:</h4>
                <p>{!! nl2br(e($correction->observations)) !!}</p>
            </div>
            
            <div class="alert-box">
                <strong>Acción Requerida:</strong> Por favor accede al sistema y responde a esta corrección. Puedes enviar observaciones adicionales y/o archivos de soporte.
            </div>
            
            <center>
                <a href="{{ $responseUrl }}" class="cta-button">Responder a la Corrección</a>
            </center>
            
            <div style="background-color: #e8f5e9; border-left: 4px solid #4CAF50; padding: 15px; margin: 20px 0; border-radius: 4px; font-size: 13px; color: #2e7d32;">
                <strong>Consejo:</strong> Una vez que respondas con las correcciones, el clasificador revisará tu respuesta nuevamente. Esta iteración es normal en el proceso de clasificación.
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} TARIX. Todos los derechos reservados.</p>
            <p>Este correo fue enviado porque se requiere una corrección en tu clasificación.</p>
            <p>Si tienes preguntas, <a href="mailto:{{ env('MAIL_FROM_ADDRESS', 'info@tarix.com.co') }}">contáctanos</a></p>
        </div>
    </div>
</body>
</html>
