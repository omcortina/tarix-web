<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario Clasificador | Admin TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .page-container {
            padding: 40px;
            width: calc(100% - 260px);
            margin-left: 260px;
            margin-top: 0;
        }

        @media (max-width: 768px) {
            .page-container {
                width: 100%;
                margin-left: 0;
                padding: 24px;
            }
        }

        .breadcrumb {
            font-size: 13px;
            color: #8899a6;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .breadcrumb a {
            color: #22c5bc;
            text-decoration: none;
            margin: 0 4px;
        }

        .page-title {
            font-family: "Montserrat", sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: #1a2e44;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #8899a6;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-family: "Montserrat", sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #1a2e44;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: "Inter", sans-serif;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #22c5bc;
            box-shadow: 0 0 0 3px rgba(34, 197, 188, 0.1);
        }

        .form-error {
            color: #c53030;
            font-size: 13px;
            margin-top: 6px;
        }

        .form-actions {
            gap: 12px;
            margin-top: 30px;
        }

        .btn-primary {
            background: #22c5bc;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            flex: 1;
        }

        .btn-primary:hover {
            background: #1ba8a0;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background 0.2s;
            flex: 1;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #fff5f5;
            color: #c53030;
            border: 1px solid #feb2b2;
        }

        .form-info {
            background: #e3f2fd;
            color: #1565c0;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            line-height: 1.6;
        }

        .form-info i {
            margin-right: 8px;
        }

        .password-section {
            background: #f9f9f9;
            padding: 16px;
            border-radius: 8px;
            margin-top: 16px;
        }

        .page-header {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    @include('admin.partials.navbar')

    <div class="page-container">
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.users.index') }}">Usuarios</a> /
            <span>Editar Clasificador</span>
        </div>

        <div class="page-header">
            <h1 class="page-title">Editar Usuario Clasificador</h1>
            <p class="page-subtitle">Actualiza la información del clasificador {{ $user->name }}</p>
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
                Puedes actualizar el nombre, email y contraseña del clasificador. La contraseña es opcional - déjala en blanco si no deseas cambiarla.
            </div>

            <form method="POST" action="{{ route('admin.users.update-clasificador', $user) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nombre Completo *</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}"
                        placeholder="Ej: Juan Pérez"
                        required
                    >
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}"
                        placeholder="Ej: juan@tarix.com.co"
                        required
                    >
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="password-section">
                    <p style="margin: 0 0 16px 0; font-weight: 600; color: #1a2e44;">Cambiar Contraseña (Opcional)</p>
                    
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label for="password">Nueva Contraseña</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Déjalo en blanco para mantener la contraseña actual"
                        >
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Confirma la nueva contraseña"
                        >
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fa fa-save"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                        <i class="fa fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
