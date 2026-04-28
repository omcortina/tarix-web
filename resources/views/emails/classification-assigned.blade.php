<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Clasificación Asignada - TARIX</title>
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
            background-color: #22c5bc;
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
            color: #22c5bc;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .greeting p {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .classification-box {
            background-color: #f9f9f9;
            border-left: 4px solid #22c5bc;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .classification-box h3 {
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
        
        .client-info {
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            font-size: 14px;
        }
        
        .client-info h4 {
            color: #22c5bc;
            margin-bottom: 10px;
            margin-top: 0;
            font-size: 14px;
        }
        
        .client-info p {
            margin: 5px 0;
            color: #333;
        }
        
        .cta-button {
            display: inline-block;
            background-color: #22c5bc;
            color: white !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
            font-size: 14px;
        }
        
        .cta-button:hover {
            background-color: #1ba8a0;
        }
        
        .info-text {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-size: 13px;
            color: #856404;
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
            color: #22c5bc;
            text-decoration: none;
        }
        
        .items-count {
            display: inline-block;
            background-color: #22c5bc;
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
            <h1>Nueva Clasificación Asignada</h1>
            <p>TARIX - Sistema de Clasificación Arancelaria</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                <h2>Hola, {{ $clasificador->name }}</h2>
                <p>Se te ha asignado una nueva solicitud de clasificación arancelaria que requiere tu revisión.</p>
            </div>
            
            <div class="classification-box">
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
                    <span class="detail-label">Número de Items:&nbsp;</span>
                    <span class="detail-value"><span>{{ $classification->items->count() }}</span></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Estado:&nbsp;</span>
                    <span class="detail-value">{{ $classification->status }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Costo Total:&nbsp;</span>
                    <span class="detail-value"><strong>${{ number_format($classification->total_cost, 2, ',', '.') }}</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Fecha de Creación:&nbsp;</span>
                    <span class="detail-value">{{ $classification->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            
            <div class="client-info">
                <h4>Información del Cliente</h4>
                <p><strong>Nombre:</strong> {{ $cliente->name }}</p>
                <p><strong>Email:</strong> {{ $cliente->email }}</p>
                <p><strong>Teléfono:</strong> {{ $cliente->phone ?? 'No registrado' }}</p>
                <p><strong>Tipo de Cliente:</strong> {{ $cliente->client_type === 'PREFERENTIAL' ? 'Cliente Preferencial' : 'Cliente General' }}</p>
            </div>
            
            <div class="info-text">
                <strong>Nota:</strong> Esta clasificación está pendiente de verificación de pago del cliente. Una vez que el pago sea verificado, podrás iniciar el proceso de clasificación.
            </div>
            
            <center>
                <a href="{{ $dashboardUrl }}" class="cta-button">Ver en Dashboard</a>
            </center>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} TARIX. Todos los derechos reservados.</p>
            <p>Este correo fue enviado porque se te asignó una nueva clasificación.</p>
            <p>Si tienes preguntas, <a href="mailto:{{ env('MAIL_FROM_ADDRESS', 'info@tarix.com.co') }}">contáctanos</a></p>
        </div>
    </div>
</body>
</html>
