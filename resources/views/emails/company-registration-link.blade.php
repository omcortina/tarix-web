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
            background-color: #22c5bc;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .email-header p {
            margin: 8px 0 0;
            font-size: 14px;
            opacity: 0.9;
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
        .info-box {
            background-color: #f0fdfc;
            border-left: 4px solid #22c5bc;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-box strong {
            display: block;
            color: #1a2e44;
            margin-bottom: 6px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-box span {
            font-size: 16px;
            font-weight: 600;
            color: #22c5bc;
        }
        .btn-register {
            display: inline-block;
            background-color: #22c5bc !important;
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 15px;
            margin: 10px 0;
        }
        .btn-container {
            text-align: center;
            margin: 30px 0;
        }
        .link-fallback {
            background-color: #f9f9f9;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 12px 16px;
            font-size: 12px;
            color: #6b7280;
            word-break: break-all;
            margin-top: 10px;
        }
        .email-footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>TARIX</h1>
            <p>Soluciones de Comercio Internacional</p>
        </div>

        <div class="email-body">
            <h2>Has sido invitado a registrarte</h2>

            <p>Has recibido una invitación para crear tu cuenta en la plataforma TARIX como miembro de:</p>

            <div class="info-box">
                <strong>Empresa</strong>
                <span>{{ $company->name }}</span>
            </div>

            <p>Haz clic en el botón a continuación para completar tu registro. Este enlace es personal y está asociado a tu empresa.</p>

            <div class="btn-container">
                <a href="{{ $registrationUrl }}" class="btn-register">Completar mi Registro</a>
            </div>

            <p style="font-size: 13px; color: #9ca3af;">Si el botón no funciona, copia y pega este enlace en tu navegador:</p>
            <div class="link-fallback">{{ $registrationUrl }}</div>

            <p style="font-size: 13px; margin-top: 24px; color: #9ca3af;">Si no solicitaste esta invitación, puedes ignorar este correo.</p>
        </div>

        <div class="email-footer">
            &copy; {{ date('Y') }} TARIX. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
