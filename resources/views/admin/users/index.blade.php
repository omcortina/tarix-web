<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios Externos | Admin TARIX</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .page-container {
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .breadcrumb {
            font-size: 13px;
            color: #8899a6;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .page-header {
            margin-bottom: 40px;
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

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .alert-success {
            background: #f0fff4;
            color: #22863a;
            border: 1px solid #85e89d;
        }

        .alert-error {
            background: #fff5f5;
            color: #c53030;
            border: 1px solid #feb2b2;
        }

        .section {
            margin-bottom: 50px;
        }

        .section-title {
            font-family: "Montserrat", sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #1a2e44;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            font-size: 24px;
            color: #22c5bc;
        }

        .badge-count {
            background: #FFEBEE;
            color: #c53030;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }

        .users-grid {
            display: grid;
            gap: 20px;
        }

        .user-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e0e8ed;
            transition: all 0.3s ease;
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 20px;
            align-items: start;
        }

        .user-card:hover {
            box-shadow: 0 8px 24px rgba(34, 197, 188, 0.12);
            border-color: #22c5bc;
        }

        .user-avatar {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #22c5bc 0%, #1e9b8f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 20px;
            flex-shrink: 0;
        }

        .user-main-info {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .user-name {
            font-family: "Montserrat", sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: #1a2e44;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 14px;
            color: #8899a6;
        }

        .user-detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-detail-item i {
            color: #22c5bc;
            width: 16px;
        }

        .user-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }

        .btn-verify {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            white-space: nowrap;
            font-family: "Montserrat", sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-general {
            background: #E8F5E9;
            color: #2e7d32;
            border: 1px solid #81c784;
        }

        .btn-general:hover {
            background: #c8e6c9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
        }

        .btn-preferential {
            background: #fff3e0;
            color: #e65100;
            border: 1px solid #ffb74d;
        }

        .btn-preferential:hover {
            background: #ffe0b2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(230, 81, 0, 0.2);
        }

        .btn-reject {
            background: #ffebee;
            color: #c53030;
            border: 1px solid #ef5350;
        }

        .btn-reject:hover {
            background: #ffcdd2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(197, 48, 48, 0.2);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #f8fffe;
            border-radius: 12px;
            color: #8899a6;
        }

        .empty-state i {
            font-size: 56px;
            color: #e0e8ed;
            margin-bottom: 16px;
        }

        .empty-state p {
            font-size: 16px;
            margin: 0;
        }

        .badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #E8F5E9;
            color: #2e7d32;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .badge-preferential {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff3e0;
            color: #e65100;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .verified-card {
            grid-template-columns: auto 1fr auto auto;
            align-items: center;
        }

        .verified-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #2e7d32;
        }

        @media (max-width: 768px) {
            .user-card,
            .verified-card {
                grid-template-columns: 1fr;
            }

            .user-actions {
                flex-direction: row;
                gap: 8px;
                order: -1;
            }

            .btn-verify {
                flex: 1;
            }

            .page-container {
                padding: 20px;
            }

            .page-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    @include('admin.partials.navbar')

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        <div class="page-container">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span> / </span>
                <span>Gestionar Usuarios Externos</span>
            </div>

            <!-- Header -->
            <div class="page-header">
                <h1 class="page-title">Gestionar Usuarios Externos</h1>
                <p class="page-subtitle">Verifica y clasifica nuevos usuarios registrados en el sistema</p>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fa fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Users Pending Verification -->
            <div class="section">
                <div class="section-title">
                    <i class="fa fa-clock-o"></i>
                    Pendientes de Verificación
                    <span class="badge-count">{{ $unverifiedUsers->count() }}</span>
                </div>

                @if ($unverifiedUsers->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-inbox"></i>
                        <p>No hay usuarios pendientes de verificación</p>
                    </div>
                @else
                    <div class="users-grid">
                        @foreach ($unverifiedUsers as $user)
                            <div class="user-card">
                                <!-- Avatar -->
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>

                                <!-- Info -->
                                <div class="user-main-info">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-details">
                                        <div class="user-detail-item">
                                            <i class="fa fa-envelope"></i>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                        @if ($user->phone)
                                            <div class="user-detail-item">
                                                <i class="fa fa-phone"></i>
                                                <span>{{ $user->phone }}</span>
                                            </div>
                                        @endif
                                        <div class="user-detail-item">
                                            <i class="fa fa-calendar"></i>
                                            <span>{{ $user->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="user-actions">
                                    <form method="POST" action="{{ route('admin.users.verify-general', $user) }}" style="display: contents;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-verify btn-general" title="Clasificar como Cliente General">
                                            <i class="fa fa-user"></i> General
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.verify-preferential', $user) }}" style="display: contents;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-verify btn-preferential" title="Clasificar como Cliente Preferencial">
                                            <i class="fa fa-star"></i> Preferencial
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.reject', $user) }}" style="display: contents;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-verify btn-reject" onclick="return confirm('¿Deseas rechazar este registro? Esta acción no se puede deshacer.');" title="Rechazar este usuario">
                                            <i class="fa fa-trash"></i> Rechazar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Verified Users -->
            <div class="section">
                <div class="section-title">
                    <i class="fa fa-check-circle"></i>
                    Usuarios Verificados
                    <span class="badge-count" style="background: #E3F2FD; color: #1565c0;">{{ $verifiedUsers->count() }}</span>
                </div>

                @if ($verifiedUsers->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-inbox"></i>
                        <p>No hay usuarios verificados aún</p>
                    </div>
                @else
                    <div class="users-grid">
                        @foreach ($verifiedUsers as $user)
                            <div class="user-card verified-card">
                                <!-- Avatar -->
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>

                                <!-- Info -->
                                <div class="user-main-info">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-details">
                                        <div class="user-detail-item">
                                            <i class="fa fa-envelope"></i>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                        @if ($user->phone)
                                            <div class="user-detail-item">
                                                <i class="fa fa-phone"></i>
                                                <span>{{ $user->phone }}</span>
                                            </div>
                                        @endif
                                        <div class="user-detail-item">
                                            <i class="fa fa-calendar"></i>
                                            <span>Verificado: {{ $user->verified_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Client Type Badge -->
                                @if ($user->client_type === 'GENERAL')
                                    <div class="badge-verified">
                                        <i class="fa fa-user"></i> Cliente General
                                    </div>
                                @else
                                    <div class="badge-preferential">
                                        <i class="fa fa-star"></i> Cliente Preferencial
                                    </div>
                                @endif

                                <!-- Verified Status -->
                                <div class="verified-status">
                                    <i class="fa fa-check-circle"></i> Verificado
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>