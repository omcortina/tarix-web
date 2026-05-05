<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario Cliente | Admin TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .page-container {
            padding: 40px;
            width: calc(100% - 260px);
            margin-left: 260px;
        }
        @media (max-width: 768px) {
            .page-container { width: 100%; margin-left: 0; padding: 24px; }
        }
        .breadcrumb { font-size: 13px; color: #8899a6; margin-bottom: 30px; font-weight: 700; }
        .breadcrumb a { color: #22c5bc; text-decoration: none; margin: 0 4px; }
        .page-title { font-family: "Montserrat", sans-serif; font-size: 28px; font-weight: 800; color: #1a2e44; margin-bottom: 8px; }
        .page-subtitle { font-size: 14px; color: #8899a6; }
        .page-header { margin-bottom: 40px; }
        .form-card { background: white; border-radius: 12px; padding: 40px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .form-group { margin-bottom: 24px; }
        .form-group label { display: block; font-family: "Montserrat", sans-serif; font-size: 14px; font-weight: 600; color: #1a2e44; margin-bottom: 8px; }
        .form-group input, .form-group select {
            width: 100%; padding: 12px 16px; border: 1px solid #e0e0e0;
            border-radius: 8px; font-size: 14px; font-family: "Inter", sans-serif;
            transition: border-color 0.2s; box-sizing: border-box;
        }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #22c5bc; box-shadow: 0 0 0 3px rgba(34,197,188,0.1); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-error { color: #c53030; font-size: 13px; margin-top: 6px; }
        .btn-primary { background: #22c5bc; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; flex: 1; }
        .btn-primary:hover { background: #1ba8a0; }
        .btn-secondary { background: #f0f0f0; color: #333; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; text-align: center; transition: background 0.2s; flex: 1; }
        .btn-secondary:hover { background: #e0e0e0; }
        .alert { padding: 16px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
        .form-info { background: #e3f2fd; color: #1565c0; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; line-height: 1.6; }
        .password-section { background: #f9f9f9; padding: 20px; border-radius: 8px; margin-top: 8px; }
    </style>
</head>
<body>
    @include('admin.partials.navbar')

    <div class="page-container">
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.users.index') }}">Usuarios</a> /
            <span>Editar Cliente</span>
        </div>

        <div class="page-header">
            <h1 class="page-title">Editar Usuario Cliente</h1>
            <p class="page-subtitle">Actualiza la información de {{ $user->name }}</p>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Error:</strong>
                    <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-info">
                <i class="fa fa-info-circle"></i>
                Puedes actualizar los datos del cliente y restablecer su contraseña. Si cambias la contraseña, el usuario deberá cambiarla en su próximo inicio de sesión.
            </div>

            <form method="POST" action="{{ route('admin.users.update-externo', $user) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nombre Completo *</label>
                        <input type="text" id="name" name="name"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Ej: Juan Pérez" required>
                        @error('name') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico *</label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $user->email) }}"
                            placeholder="correo@ejemplo.com" required>
                        @error('email') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="text" id="phone" name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            placeholder="Ej: 3001234567">
                        @error('phone') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="company_id">Empresa</label>
                        <select id="company_id" name="company_id">
                            <option value="">Sin empresa</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" @selected(old('company_id', $user->company_id) == $company->id)>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_id') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="password-section">
                    <p style="font-size: 13px; color: #666; margin: 0 0 16px 0;"><i class="fa fa-lock"></i> Restablecer contraseña (opcional — deja en blanco para no cambiarla)</p>

                    <div class="form-row">
                        <div class="form-group" style="margin-bottom: 12px;">
                            <label for="password">Nueva Contraseña</label>
                            <div style="position: relative;">
                                <input type="password" id="password" name="password"
                                    placeholder="Mínimo 8 caracteres"
                                    style="padding-right: 40px;">
                                <button type="button" onclick="toggleVis('password')" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#888; padding:0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/></svg>
                                </button>
                            </div>
                            @error('password') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 12px;">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <div style="position: relative;">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Confirma la nueva contraseña"
                                    style="padding-right: 40px;">
                                <button type="button" onclick="toggleVis('password_confirmation')" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#888; padding:0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 4px;">
                        <span id="pwdIndicator" style="font-size: 12px; color: #22c5bc; display: none;"></span>
                        <button type="button" onclick="generatePassword()" style="padding: 8px 18px; background: #22c5bc; color: #fff; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">Generar contraseña</button>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary"><i class="fa fa-save"></i> Guardar Cambios</button>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary"><i class="fa fa-times"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    function generatePassword() {
        const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lower = 'abcdefghijklmnopqrstuvwxyz';
        const digits = '0123456789';
        const special = '!@#$%&*?';
        const all = upper + lower + digits + special;
        let pwd = [
            upper[Math.floor(Math.random() * upper.length)],
            lower[Math.floor(Math.random() * lower.length)],
            digits[Math.floor(Math.random() * digits.length)],
            special[Math.floor(Math.random() * special.length)],
        ];
        for (let i = 4; i < 12; i++) pwd.push(all[Math.floor(Math.random() * all.length)]);
        pwd = pwd.sort(() => Math.random() - 0.5).join('');
        document.getElementById('password').value = pwd;
        document.getElementById('password_confirmation').value = pwd;
        document.getElementById('password').type = 'text';
        document.getElementById('password_confirmation').type = 'text';
        const ind = document.getElementById('pwdIndicator');
        ind.textContent = 'Contraseña generada: ' + pwd;
        ind.style.display = 'inline';
    }

    function toggleVis(fieldId) {
        const f = document.getElementById(fieldId);
        f.type = f.type === 'password' ? 'text' : 'password';
    }
</script>
</html>
