<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .change-pw-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f6f9;
        }
        .change-pw-card {
            background: white;
            border-radius: 12px;
            padding: 48px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.10);
        }
        .change-pw-icon {
            width: 56px;
            height: 56px;
            background: #fff3e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            color: #e65100;
        }
        .change-pw-card h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: #0d2340;
            text-align: center;
            margin: 0 0 8px;
        }
        .change-pw-card .subtitle {
            font-size: 13px;
            color: #888;
            text-align: center;
            margin-bottom: 28px;
            line-height: 1.5;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-family: 'Montserrat', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap input {
            width: 100%;
            padding: 10px 40px 10px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            color: #333;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        .input-wrap input:focus {
            outline: none;
            border-color: #22c5bc;
        }
        .input-wrap button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #aaa;
            padding: 0;
            font-size: 14px;
        }
        .requirements {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 12px;
            color: #666;
        }
        .requirements ul {
            margin: 6px 0 0;
            padding-left: 18px;
        }
        .requirements li {
            margin-bottom: 2px;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #22c5bc;
            color: white;
            border: none;
            border-radius: 6px;
            font-family: 'Montserrat', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: #1aada5;
        }
        .form-error {
            color: #c62828;
            font-size: 12px;
            margin-top: 4px;
        }
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
<div class="change-pw-container">
    <div class="change-pw-card">
        <h1>Cambiar Contraseña</h1>
        <p class="subtitle">
            Por seguridad, debes establecer una contraseña personal antes de continuar.
        </p>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="requirements">
            La contraseña debe tener:
            <ul>
                <li>Mínimo 8 caracteres</li>
                <li>Al menos una letra mayúscula</li>
                <li>Al menos un número</li>
                <li>Al menos un carácter especial (!@#$%&*?)</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <div class="form-group">
                <label for="password">Nueva Contraseña</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password"
                           placeholder="Escribe tu nueva contraseña" required autofocus>
                    <button type="button" onclick="toggleVis('password', this)">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <div class="input-wrap">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="Repite la contraseña" required>
                    <button type="button" onclick="toggleVis('password_confirmation', this)">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit">Guardar y Continuar</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="text-align:center; margin-top:16px;">
            @csrf
            <button type="submit" style="background:none; border:none; color:#aaa; font-size:12px; cursor:pointer; text-decoration:underline;">
                Cerrar sesión
            </button>
        </form>
    </div>
</div>

<script>
function toggleVis(id, btn) {
    const f = document.getElementById(id);
    const i = btn.querySelector('i');
    if (f.type === 'password') {
        f.type = 'text';
        i.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        f.type = 'password';
        i.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>
