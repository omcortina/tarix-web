<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e5a96 0%, #0d3a6f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #22c5bc 0%, #1e9b8f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 24px;
            color: white;
        }

        .login-header h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 14px;
            color: #666;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 13px;
            color: #333;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #22c5bc;
            box-shadow: 0 0 0 3px rgba(34, 197, 188, 0.1);
        }

        .error-message {
            color: #e53e3e;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #22c5bc;
        }

        .remember-me label {
            margin: 0;
            text-transform: none;
            font-weight: 400;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #22c5bc 0%, #1e9b8f 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(34, 197, 188, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #22c5bc;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #1e9b8f;
        }

        .alert {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 6px;
            font-size: 13px;
        }

        .alert-error {
            background: #fff5f5;
            color: #c53030;
            border: 1px solid #feb2b2;
        }

        .alert-success {
            background: #f0fff4;
            color: #22863a;
            border: 1px solid #85e89d;
        }

        .credentials-hint {
            background: #f7fafc;
            border-left: 3px solid #22c5bc;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 12px;
            color: #4a5568;
        }

        .credentials-hint strong {
            display: block;
            color: #22c5bc;
            margin-bottom: 4px;
        }

        code {
            background: #edf2f7;
            padding: 2px 4px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo-icon">T</div>
            <h1>TARIX Admin</h1>
            <p>Gestiona tus contenidos del sitio</p>
        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-error">{{ $error }}</div>
            @endforeach
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Recuérdame en este dispositivo</label>
            </div>

            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>

        <div class="back-link">
            <a href="/">Volver al sitio</a>
        </div>
    </div>
</body>
</html>
