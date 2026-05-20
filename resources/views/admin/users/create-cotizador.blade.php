<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario Cotizador | Admin TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .page-container { padding: 40px; width: calc(100% - 260px); margin-left: 260px; }
        @media (max-width: 768px) { .page-container { width: 100%; margin-left: 0; padding: 24px; } }
        .breadcrumb { font-size: 13px; color: #8899a6; margin-bottom: 30px; font-weight: 700; }
        .breadcrumb a { color: #22c5bc; text-decoration: none; margin: 0 4px; }
        .page-title { font-family: "Montserrat", sans-serif; font-size: 28px; font-weight: 800; color: #1a2e44; margin-bottom: 8px; }
        .page-subtitle { font-size: 14px; color: #8899a6; }
        .form-card { background: white; border-radius: 12px; padding: 40px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .form-group { margin-bottom: 24px; }
        .form-group label { display: block; font-family: "Montserrat", sans-serif; font-size: 14px; font-weight: 600; color: #1a2e44; margin-bottom: 8px; }
        .form-group input { width: 100%; padding: 12px 16px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: "Inter", sans-serif; box-sizing: border-box; }
        .form-group input:focus { outline: none; border-color: #22c5bc; box-shadow: 0 0 0 3px rgba(34,197,188,.1); }
        .form-error { color: #c53030; font-size: 13px; margin-top: 6px; }
        .form-actions { gap: 12px; margin-top: 30px; }
        .btn-primary { background: #22c5bc; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; flex: 1; }
        .btn-primary:hover { background: #1ba8a0; }
        .btn-secondary { background: #f0f0f0; color: #333; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; text-align: center; flex: 1; }
        .alert-error { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; padding: 16px; border-radius: 8px; margin-bottom: 20px; }
        .form-info { background: #E8F5E9; color: #2e7d32; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; line-height: 1.6; }
    </style>
</head>
<body>
    @include('admin.partials.navbar')

    <div class="page-container">
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.users.index') }}">Usuarios</a> /
            <span>Crear Cotizador</span>
        </div>

        <div class="page-header">
            <h1 class="page-title">Crear Usuario Cotizador</h1>
            <p class="page-subtitle">Agrega un nuevo usuario con acceso al módulo de cotizaciones</p>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <div class="alert-error">
                    <strong>Error:</strong>
                    <ul style="margin: 8px 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-info">
                <i class="fa fa-info-circle"></i>
                El usuario cotizador podrá enviar cotizaciones por correo, gestionar plantillas y sincronizar su bandeja de entrada desde el panel de cotizaciones.
            </div>

            <form method="POST" action="{{ route('admin.users.store-cotizador') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nombre Completo <span style="color: #c53030;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        required maxlength="255" placeholder="Nombre del cotizador">
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico <span style="color: #c53030;">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        required placeholder="correo@empresa.com">
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña <span style="color: #c53030;">*</span></label>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <div style="position: relative; flex: 1;">
                            <input type="password" id="password" name="password" required minlength="8"
                                placeholder="Mínimo 8 caracteres"
                                style="width: 100%; padding-right: 40px; box-sizing: border-box;">
                            <button type="button" onclick="toggleVisibility('password', this)"
                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #999; padding: 0;">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <button type="button" onclick="generatePassword()" title="Generar contraseña segura"
                            style="padding: 9px 14px; background: #22c5bc; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; white-space: nowrap; display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                            <i class="fa fa-key"></i> Generar
                        </button>
                    </div>
                    <div id="password-strength" style="margin-top: 6px; font-size: 11px; display: none;"></div>
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña <span style="color: #c53030;">*</span></label>
                    <div style="position: relative;">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            required placeholder="Repite la contraseña"
                            style="width: 100%; padding-right: 40px; box-sizing: border-box;">
                        <button type="button" onclick="toggleVisibility('password_confirmation', this)"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #999; padding: 0;">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fa fa-save"></i> Crear Usuario Cotizador
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

<script>
function generatePassword() {
    const upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lower   = 'abcdefghijklmnopqrstuvwxyz';
    const digits  = '0123456789';
    const special = '!@#$%&*?';
    const all     = upper + lower + digits + special;

    let pwd = [
        upper  [Math.floor(Math.random() * upper.length)],
        lower  [Math.floor(Math.random() * lower.length)],
        digits [Math.floor(Math.random() * digits.length)],
        special[Math.floor(Math.random() * special.length)],
    ];

    for (let i = pwd.length; i < 12; i++) {
        pwd.push(all[Math.floor(Math.random() * all.length)]);
    }

    pwd = pwd.sort(() => Math.random() - 0.5).join('');

    const pwdField     = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');

    pwdField.value     = pwd;
    confirmField.value = pwd;

    pwdField.type     = 'text';
    confirmField.type = 'text';

    const indicator = document.getElementById('password-strength');
    indicator.style.display = 'block';
    indicator.innerHTML = '<span style="color:#2e7d32; font-weight:700;">Contraseña generada:</span> '
        + '<code style="background:#f5f5f5; padding: 2px 8px; border-radius:4px; font-size:13px; user-select:all;">' + pwd + '</code>'
        + ' <span style="color:#999;">(cópiala antes de guardar)</span>';
}

function toggleVisibility(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const icon  = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>
