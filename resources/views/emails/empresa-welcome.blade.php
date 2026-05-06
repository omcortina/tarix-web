<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #22c5bc 0%, #1ba8a0 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .email-body {
            padding: 40px;
            color: #333;
        }
        .email-body h2 {
            color: #1a2e44;
            font-size: 18px;
            margin-top: 0;
        }
        .email-body p {
            line-height: 1.6;
            margin: 15px 0;
            color: #555;
        }
        .credentials-box {
            background-color: #f9f9f9;
            border-left: 4px solid #22c5bc;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .credentials-box strong {
            display: block;
            color: #1a2e44;
            margin-bottom: 8px;
        }
        .credentials-box div {
            margin: 8px 0;
            font-family: 'Courier New', monospace;
            color: #333;
        }
        .cta-button {
            display: inline-block;
            background-color: #22c5bc;
            color: white !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
        }
        .cta-button:hover {
            background-color: #1ba8a0;
        }
        .email-features {
            margin: 25px 0;
        }
        .feature-item {
            display: flex;
            gap: 12px;
            margin: 5px 0;
            padding: 10px 0;
        }
        .feature-icon {
            color: #22c5bc;
            font-weight: bold;
        }
        .email-footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #e0e0e0;
        }
        .email-footer a {
            color: #22c5bc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>¡Bienvenido a TARIX!</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Hola {{ $user->name }},</h2>

            <p>Nos complace informarte que tu cuenta de <strong>Empresa</strong> en TARIX ha sido creada exitosamente.</p>

            <!-- Credenciales -->
            <div class="credentials-box">
                <strong>Tus datos de acceso</strong>
                <div><strong>Email:</strong> {{ $user->email }}</div>
                @if($plainPassword)
                <div><strong>Contraseña temporal:</strong> <code style="background:#f0f0f0; padding: 2px 8px; border-radius: 4px; font-size: 14px; letter-spacing: 1px;">{{ $plainPassword }}</code></div>
                @endif
                <div><strong>Estado:</strong> Activo (acceso inmediato)</div>
            </div>
            @if($plainPassword)
            <p style="background:#fff8e1; border-left: 4px solid #f39c12; padding: 10px 14px; border-radius: 4px; font-size: 13px; color: #7d5a00;">
                Por seguridad, se te pedira que cambies tu contrasena en el primer inicio de sesion.
            </p>
            @endif

            <!-- Features -->
            <div class="email-features">
                <strong style="color: #1a2e44; display: block;">Con tu acceso podrás:</strong>
                <div class="feature-item">
                    <span>1. Solicitar clasificaciones arancelarias para tus productos</span>
                </div>
                <div class="feature-item">
                    <span>2. Consultar el estado de tus solicitudes en tiempo real</span>
                </div>
                <div class="feature-item">
                    <span>3. Acceder a reportes y documentación de clasificaciones</span>
                </div>
                <div class="feature-item">
                    <span>4. Descargar certificados de clasificación</span>
                </div>
            </div>

            <!-- CTA Button -->
            <p style="text-align: center;">
                <a href="{{ $loginUrl }}" class="cta-button">Iniciar Sesión</a>
            </p>

            <p>Si tienes alguna pregunta o necesitas ayuda para comenzar, no dudes en contactarnos a través de info@tarix.com.co o por teléfono +57 302 467 4923.</p>

            <p>
                Saludos cordiales,<br>
                <strong>El equipo de TARIX</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>© 2026 TARIX | Soluciones en Comercio Exterior</p>
            <p>
                <a href="https://tarix.com.co">tarix.com.co</a> | 
                <a href="mailto:info@tarix.com.co">info@tarix.com.co</a>
            </p>
            <p>Hecho en Colombia 🇨🇴</p>
        </div>
    </div>
</body>
</html>
