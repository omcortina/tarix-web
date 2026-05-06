<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro en proceso - TARIX</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #22c5bc;
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        .header h1 {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }
        .header p {
            font-size: 14px;
            opacity: 0.95;
        }
        .content {
            padding: 40px;
        }
        .greeting h2 {
            font-size: 20px;
            color: #1a2e44;
            margin-bottom: 12px;
            font-weight: 700;
        }
        .greeting p {
            color: #555;
            font-size: 15px;
            margin-bottom: 10px;
        }
        .status-box {
            background-color: #fff8e1;
            border-left: 4px solid #f59e0b;
            padding: 20px 24px;
            margin: 28px 0;
            border-radius: 8px;
        }
        .status-box h3 {
            color: #b45309;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .status-box p {
            color: #555;
            font-size: 14px;
        }
        .steps {
            margin: 28px 0;
        }
        .steps h3 {
            font-size: 15px;
            font-weight: 700;
            color: #1a2e44;
            margin-bottom: 14px;
        }
        .step {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 12px;
        }
        .step-num {
            background-color: #22c5bc;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .step p {
            color: #555;
            font-size: 14px;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 24px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>TARIX</h1>
            <p>Soluciones de Comercio Internacional</p>
        </div>

        <div class="content">
            <div class="greeting">
                <h2>Hola, {{ $user->name }}</h2>
                <p>Gracias por completar tu registro en la plataforma TARIX. Hemos recibido tu solicitud correctamente.</p>
            </div>

            <div class="status-box">
                <h3>Tu cuenta está en proceso de verificación</h3>
                <p>Un administrador revisará tu información y activará tu cuenta en el menor tiempo posible. Recibirás un correo de confirmación cuando esté lista.</p>
            </div>

            <div class="steps">
                <h3>¿Qué sigue?</h3>
                <div class="step">
                    <div class="step-num">1</div>
                    <p>Nuestro equipo revisará los datos de tu registro.</p>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <p>Recibirás un correo electrónico confirmando la activación de tu cuenta.</p>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <p>Podrás iniciar sesión y acceder a todos los servicios de la plataforma.</p>
                </div>
            </div>

            <p style="font-size: 13px; color: #9ca3af;">Si tienes alguna duda, comunícate con nosotros respondiendo este correo.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} TARIX. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
