@extends('layouts.admin')

@section('title', 'Gestionar Usuarios')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/index-user.css') }}">
<style>
    .tabs-container {
        margin-bottom: 30px;
    }

    .tabs-header {
        display: flex;
        gap: 8px;
        border-bottom: 2px solid #e0e8ed;
        margin-bottom: 24px;
    }

    .tab-button {
        background: none;
        border: none;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 600;
        color: #8899a6;
        cursor: pointer;
        position: relative;
        transition: color 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .tab-button:hover {
        color: #22c5bc;
    }

    .tab-button.active {
        color: #22c5bc;
    }

    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: #22c5bc;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .clients-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .clients-section {
        display: flex;
        flex-direction: column;
    }

    .left-section {
        border-right: 1px solid #e0e8ed;
        padding-right: 24px;
    }

    .right-section {
        padding-left: 24px;
    }

    .alert {
        animation: slideInDown 0.3s ease-out;
    }

    .alert.fade-out {
        animation: slideOutUp 0.3s ease-out forwards;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideOutUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }

    @media (max-width: 1200px) {
        .clients-container {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .left-section {
            border-right: none;
            border-bottom: 1px solid #e0e8ed;
            padding-right: 0;
            padding-bottom: 30px;
        }

        .right-section {
            padding-left: 0;
            padding-top: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span> / </span>
        <span>Gestionar Usuarios</span>
    </div>

    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">Gestionar Usuarios</h1>
        <p class="page-subtitle">Administra clientes y clasificadores del sistema</p>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success" id="success-alert">
            <i class="fa fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error" id="error-alert">
            <i class="fa fa-exclamation-circle"></i>
            <div>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="tabs-container">
        <div class="tabs-header">
            <button class="tab-button active" onclick="switchTab('clientes')">
                <i class="fa fa-users"></i> Clientes
            </button>
            <button class="tab-button" onclick="switchTab('clasificadores')">
                <i class="fa fa-check-square"></i> Clasificadores
            </button>
        </div>

        <!-- Tab: Clientes -->
        <div id="tab-clientes" class="tab-content active">
            <div class="clients-container">
                <!-- Verified Users - Left Side -->
                <div class="clients-section left-section">
                    <div class="section">
                        <div class="section-title">
                            <i class="fa fa-check-circle"></i>
                            Clientes Verificados
                            <span class="badge-count" style="background: #E3F2FD; color: #1565c0;">{{ $verifiedUsers->count() }}</span>
                        </div>

                        @if ($verifiedUsers->isEmpty())
                            <div class="empty-state">
                                <i class="fa fa-inbox"></i>
                                <p>No hay clientes verificados aún</p>
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

                                        <!-- Badges -->
                                        <div class="badges-group">
                                            @if ($user->client_type === 'GENERAL')
                                                <div class="badge-verified">
                                                    <i class="fa fa-user"></i> General
                                                </div>
                                            @else
                                                <div class="badge-preferential">
                                                    <i class="fa fa-star"></i> Preferencial
                                                </div>
                                            @endif

                                            <div class="verified-status">
                                                <i class="fa fa-check-circle"></i> Verificado
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pending Users - Right Side -->
                <div class="clients-section right-section">
                    <div class="section">
                        <div class="section-title">
                            <i class="fa fa-clock-o"></i>
                            Pendientes de Verificación
                            <span class="badge-count">{{ $unverifiedUsers->count() }}</span>
                        </div>

                        @if ($unverifiedUsers->isEmpty())
                            <div class="empty-state">
                                <i class="fa fa-inbox"></i>
                                <p>No hay clientes pendientes de verificación</p>
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
                </div>
            </div>
        </div>

        <!-- Tab: Clasificadores -->
        <div id="tab-clasificadores" class="tab-content">
            <!-- Botón para crear Clasificador -->
            <div style="margin-bottom: 30px;">
                <a href="{{ route('admin.users.create-clasificador') }}" style="display: inline-block; padding: 12px 24px; background: #22c5bc; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: background 0.2s;">
                    <i class="fa fa-plus"></i> Crear Usuario Clasificador
                </a>
            </div>

            <div class="section">
                <div class="section-title">
                    <i class="fa fa-check-square"></i>
                    Usuarios Clasificadores
                    <span class="badge-count" style="background: #FFF3E0; color: #e65100;">{{ $clasificadores->count() }}</span>
                </div>

                @if ($clasificadores->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-inbox"></i>
                        <p>No hay usuarios clasificadores creados aún</p>
                    </div>
                @else
                    <div class="users-grid">
                        @foreach ($clasificadores as $user)
                            <div class="user-card verified-card">
                                <!-- Avatar -->
                                <div class="user-avatar" style="background: #FFF3E0; color: #e65100;">
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
                                            <span>Creado: {{ $user->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="user-actions">
                                        <a href="{{ route('admin.users.edit-clasificador', $user) }}" class="btn-verify btn-general" title="Editar información del clasificador">
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.delete-clasificador', $user) }}" style="display: contents;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-verify btn-reject" onclick="return confirm('¿Deseas eliminar este clasificador? Esta acción no se puede deshacer.');" title="Eliminar este clasificador">
                                                <i class="fa fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Badges -->
                                <div class="badges-group">
                                    <div class="badge-verified" style="background: #FFF3E0; color: #e65100;">
                                        <i class="fa fa-check-square"></i> Clasificador
                                    </div>

                                    <div class="verified-status" style="background: #e8f5e9; color: #2e7d32;">
                                        <i class="fa fa-check-circle"></i> Activo
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
    <script>
        function autoHideAlert(alertId, duration) {
            const alertElement = document.getElementById(alertId);
            if (alertElement) {
                setTimeout(() => {
                    alertElement.classList.add('fade-out');
                    setTimeout(() => {
                        alertElement.remove();
                    }, 300);
                }, duration);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            autoHideAlert('success-alert', 3000);
            autoHideAlert('error-alert', 3000);
        });

        function switchTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));

            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(btn => btn.classList.remove('active'));

            document.getElementById('tab-' + tabName).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
@endsection
