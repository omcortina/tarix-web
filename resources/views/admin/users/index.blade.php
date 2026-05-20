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

    <!-- Tabs Navigation -->
    <div class="tabs-container">
        <div class="tabs-header">
            <button class="tab-button active" onclick="switchTab('clientes')">
                <i class="fa fa-users"></i> Clientes
            </button>
            <button class="tab-button" onclick="switchTab('clasificadores')">
                <i class="fa fa-check-square"></i> Clasificadores
            </button>
            <button class="tab-button" onclick="switchTab('cotizadores')">
                <i class="fa fa-send"></i> Cotizadores
            </button>
        </div>

        <!-- Tab: Clientes -->
        <div id="tab-clientes" class="tab-content active">

            <!-- Filtro por empresa -->
            <form style="margin-bottom: 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;"
                  onsubmit="filterByCompany(event)">
                <label style="font-size: 13px; font-weight: 600; color: #555;">Filtrar por empresa:</label>
                <select name="company_id" style="padding: 8px 14px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; min-width: 220px; color: #333;">
                    <option value="">Todas las empresas</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @selected($selectedCompanyId == $company->id)>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" style="padding: 8px 18px; background: #22c5bc; color: white; border: none; border-radius: 5px; font-size: 14px; font-weight: 600; cursor: pointer;">
                    Filtrar
                </button>
                @if ($selectedCompanyId)
                    <a href="{{ route('admin.users.index') }}" style="padding: 8px 14px; background: #f0f0f0; color: #555; border-radius: 5px; font-size: 14px; text-decoration: none; font-weight: 500;">
                        Limpiar
                    </a>
                @endif
            </form>

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

                                                <div class="user-actions" style="flex-direction: row; align-items: center; margin-left: 0; margin-top: 8px; gap: 8px;">
                                                    @if ($user->user_type === 'EMPRESA')
                                                        <a href="{{ route('admin.users.edit-empresa', $user) }}" class="btn-verify btn-edit" title="Editar usuario empresa">
                                                            <i class="fa fa-edit"></i> Editar
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.users.edit-externo', $user) }}" class="btn-verify btn-edit" title="Editar usuario">
                                                            <i class="fa fa-edit"></i> Editar
                                                        </a>
                                                    @endif
                                                    <form method="POST" action="{{ route('admin.users.desactivate', $user) }}" style="display: inline;" id="form-desactivate-{{ $user->id }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="button" class="btn-verify btn-reject" onclick="confirmAction('form-desactivate-{{ $user->id }}', '¿Desactivar usuario?', '¿Deseas desactivar a {{ addslashes($user->name) }}? Esta acción puede revertirse.')" title="Desactivar usuario">
                                                            <i class="fa fa-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Badges -->
                                        <div class="badges-group">
                                            @if ($user->user_type === 'EMPRESA')
                                                <div class="badge-verified" style="background: #FFF3E0; color: #e65100;">
                                                    <i class="fa fa-building"></i> Empresa
                                                </div>
                                            @elseif ($user->client_type === 'GENERAL')
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
                                            <form method="POST" action="{{ route('admin.users.reject', $user) }}" style="display: contents;" id="form-reject-{{ $user->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-verify btn-reject" onclick="confirmAction('form-reject-{{ $user->id }}', '¿Rechazar registro?', '¿Deseas rechazar a {{ addslashes($user->name) }}? Esta acción no se puede deshacer.', 'warning')" title="Rechazar este usuario">
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

                                        <!-- Actions -->
                                        <div class="user-actions" style="flex-direction: row; align-items: center; margin-left: 0; margin-top: 8px; gap: 8px;">
                                            <a href="{{ route('admin.users.edit-clasificador', $user) }}" class="btn-verify btn-edit" title="Editar información del clasificador">
                                                <i class="fa fa-edit"></i> Editar
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.delete-clasificador', $user) }}" style="display: contents;" id="form-del-clasificador-{{ $user->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-verify btn-reject" onclick="confirmAction('form-del-clasificador-{{ $user->id }}', '¿Eliminar clasificador?', '¿Deseas eliminar a {{ addslashes($user->name) }}? Esta acción no se puede deshacer.', 'warning')" title="Eliminar este clasificador">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
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

        <!-- Tab: Cotizadores -->
        <div id="tab-cotizadores" class="tab-content">
            <div style="margin-bottom: 30px;">
                <a href="{{ route('admin.users.create-cotizador') }}" style="display: inline-block; padding: 12px 24px; background: #22c5bc; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                    <i class="fa fa-plus"></i> Crear Usuario Cotizador
                </a>
            </div>

            <div class="section">
                <div class="section-title">
                    <i class="fa fa-send"></i>
                    Usuarios Cotizadores
                    <span class="badge-count" style="background: #E8F5E9; color: #2e7d32;">{{ $cotizadores->count() }}</span>
                </div>

                @if ($cotizadores->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-inbox"></i>
                        <p>No hay usuarios cotizadores creados aún</p>
                    </div>
                @else
                    <div class="users-grid">
                        @foreach ($cotizadores as $user)
                            <div class="user-card verified-card">
                                <div class="user-avatar" style="background: #E8F5E9; color: #2e7d32;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="user-main-info">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-details">
                                        <div class="user-detail-item">
                                            <i class="fa fa-envelope"></i>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                        <div class="user-detail-item">
                                            <i class="fa fa-calendar"></i>
                                            <span>Creado: {{ $user->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <div class="user-actions" style="flex-direction: row; align-items: center; margin-left: 0; margin-top: 8px; gap: 8px;">
                                            <a href="{{ route('admin.users.edit-cotizador', $user) }}" class="btn-verify btn-edit">
                                                <i class="fa fa-edit"></i> Editar
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.delete-cotizador', $user) }}" style="display: contents;" id="form-del-cotizador-{{ $user->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-verify btn-reject" onclick="confirmAction('form-del-cotizador-{{ $user->id }}', '¿Desactivar cotizador?', '¿Deseas desactivar a {{ addslashes($user->name) }}?', 'warning')">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="badges-group">
                                    <div class="badge-verified" style="background: #E8F5E9; color: #2e7d32;">
                                        <i class="fa fa-send"></i> Cotizador
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

        function filterByCompany(e) {
            e.preventDefault();
            const select = e.target.querySelector('select[name="company_id"]');
            const base = '{{ route('admin.users.index') }}';
            window.location.href = select.value ? base + '?company_id=' + select.value : base;
        }

        function confirmAction(formId, title, text, icon = 'question') {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#22c5bc',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

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
