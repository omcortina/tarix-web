<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificación Aprobada - TARIX</title>
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
            background-color: #4CAF50;
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
            color: #4CAF50;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .greeting p {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .success-box {
            background-color: #e8f5e9;
            border-left: 4px solid #4CAF50;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .success-box h3 {
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
        
        .items-summary {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            font-size: 14px;
        }
        
        .items-summary h4 {
            color: #4CAF50;
            margin-bottom: 10px;
            margin-top: 0;
            font-size: 14px;
        }
        
        .items-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .items-summary li {
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .items-summary li:last-child {
            border-bottom: none;
        }
        
        .items-summary li:before {
            color: #4CAF50;
            font-weight: bold;
            margin-right: 8px;
        }
        
        .next-steps {
            background-color: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-size: 13px;
            color: #1565c0;
        }
        
        .next-steps h4 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .cta-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
            font-size: 14px;
        }
        
        .cta-button:hover {
            background-color: #45a049;
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
            color: #4CAF50;
            text-decoration: none;
        }
        
        .radicado-badge {
            display: inline-block;
            background-color: #4CAF50;
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
            <h1>¡Clasificación Aprobada!</h1>
            <p>TARIX - Sistema de Clasificación Arancelaria</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                <h2>Hola, {{ $cliente->name }}</h2>
                <p>Nos complace informarte que tu solicitud de clasificación arancelaria ha sido <strong>completamente verificada y aprobada</strong>.</p>
            </div>
            
            <div class="success-box">
                <h3>Resumen de la Clasificación</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Radicado:&nbsp;</span>
                    <span class="detail-value">{{ $classification->radicado }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Tipo:&nbsp;</span>
                    <span class="detail-value">{{ $classification->type === 'general' ? 'Mercancía General' : 'Unidad Funcional' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Total de Items:&nbsp;</span>
                    <span class="detail-value"><strong>{{ $classification->items->count() }}</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Estado:&nbsp;</span>
                    <span class="detail-value"><strong>Aprobado</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Fecha de Aprobación:&nbsp;</span>
                    <span class="detail-value">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            
            <div class="items-summary">
                <h4>Items Clasificados:</h4>
                <ul>
                    @foreach($classification->items as $item)
                        <li>{{ $item->commercial_name }}@if($item->final_tariff) - Código: {{ $item->final_tariff }}@endif</li>
                    @endforeach
                </ul>
            </div>
            
            <div class="next-steps">
                <h4>Próximos Pasos:</h4>
                <p>Puedes descargar tu documento de clasificación desde el portal. Esta información está disponible en tu cuenta para futuras consultas y cumplimiento aduanal.</p>
            </div>
            
            <center>
                <a href="{{ $proceduresUrl }}" class="cta-button">Consultar en mi portal</a>
            </center>
            
            <div style="background-color: #fff9e6; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 4px; font-size: 13px; color: #856404;">
                <strong>Importante:</strong> Conserva esta información para propósitos aduanales. Puedes descargar o imprimir tu certificado de clasificación desde tu cuenta en cualquier momento.
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} TARIX. Todos los derechos reservados.</p>
            <p>Tu clasificación ha sido aprobada exitosamente. Gracias por confiar en TARIX.</p>
            <p>Si tienes preguntas, <a href="mailto:{{ env('MAIL_FROM_ADDRESS', 'info@tarix.com.co') }}">contáctanos</a></p>
        </div>
    </div>
</body>
</html>
