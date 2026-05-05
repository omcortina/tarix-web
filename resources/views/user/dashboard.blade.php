@extends('layouts.user')

@section('title', __('app.dashboard_title'))

@section('page_title', __('app.dashboard_welcome', ['name' => Auth::user()->name]))

@section('content')
<div class="user-cards-grid">
    @if (Auth::user()->user_type === 'CLASIFICADOR')
        <!-- Estadísticas del Clasificador -->
        <div style="grid-column: 1 / -1; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
            <!-- Card: Pendiente de Pago -->
            <div class="stats-card pendiente-pago">
                <div class="stats-card-content">
                    <div class="stats-number">{{ $stats['pending_payment'] ?? 0 }}</div>
                    <div class="stats-label">{{ __('app.classification_pending_payment') }}</div>
                    <div class="stats-icon">
                        <i class="fa fa-clock"></i>
                    </div>
                </div>
            </div>
            
            <!-- Card: En Proceso -->
            <div class="stats-card en-proceso">
                <div class="stats-card-content">
                    <div class="stats-number">{{ $stats['in_process'] ?? 0 }}</div>
                    <div class="stats-label">{{ __('app.classification_in_process') }}</div>
                    <div class="stats-icon">
                        <i class="fa fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
            
            <!-- Card: Finalizadas -->
            <div class="stats-card finalizado">
                <div class="stats-card-content">
                    <div class="stats-number">{{ $stats['completed'] ?? 0 }}</div>
                    <div class="stats-label">{{ __('app.classification_completed') }}</div>
                    <div class="stats-icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Bandeja de Correspondencia (Solo para Clasificadores) -->
        <a href="{{ route('clasificador.index') }}" class="user-card bandeja">
            <div class="user-card-icon">
                <i class="fa fa-list"></i>
            </div>
            <h3>{{ __('app.dashboard_inbox_title') }}</h3>
            <p>{{ __('app.dashboard_inbox_desc') }}</p>
        </a>
    @elseif (Auth::user()->user_type === 'EMPRESA')
        <!-- Card 1: Clasificaciones de la Empresa -->
        <a href="{{ route('user.empresa.classifications') }}" class="user-card arancel">
            <div class="user-card-icon">
                <i class="fa fa-list"></i>
            </div>
            <h3>Clasificaciones de la empresa</h3>
            <p>Consulta todas las clasificaciones arancelarias registradas por los usuarios de tu empresa.</p>
        </a>

        <!-- Card 2: Facturación y Totales -->
        <a href="{{ route('user.empresa.billing') }}" class="user-card tramite">
            <div class="user-card-icon">
                <i class="fa fa-usd"></i>
            </div>
            <h3>Facturación y Totales</h3>
            <p>Revisa el resumen de facturación y los totales acumulados de tu empresa.</p>
        </a>

        <!-- Card 3: Consulta de Trámites -->
        <a href="{{ route('user.procedures') }}" class="user-card tramite">
            <div class="user-card-icon">
                <i class="fa fa-folder-open"></i>
            </div>
            <h3>{{ __('app.dashboard_procedures_title') }}</h3>
            <p>{{ __('app.dashboard_procedures_desc') }}</p>
        </a>
    @else
        <!-- Estadísticas del Externo -->
        <div style="grid-column: 1 / -1; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 20px;">
            <div class="stats-card pendiente-pago">
                <div class="stats-card-content">
                    <div class="stats-number">{{ $stats['pending'] ?? 0 }}</div>
                    <div class="stats-label">{{ $stats['pending_label'] ?? 'En Revisión' }}</div>
                    <div class="stats-icon"><i class="fa fa-clock-o"></i></div>
                </div>
            </div>
            <div class="stats-card en-proceso">
                <div class="stats-card-content">
                    <div class="stats-number">{{ $stats['in_process'] ?? 0 }}</div>
                    <div class="stats-label">{{ __('app.classification_in_process') }}</div>
                    <div class="stats-icon"><i class="fa fa-hourglass-half"></i></div>
                </div>
            </div>
            <div class="stats-card finalizado">
                <div class="stats-card-content">
                    <div class="stats-number">{{ $stats['completed'] ?? 0 }}</div>
                    <div class="stats-label">{{ __('app.classification_completed') }}</div>
                    <div class="stats-icon"><i class="fa fa-check-circle"></i></div>
                </div>
            </div>
        </div>

        <!-- Card 1: Clasificación Arancelaria -->
        <a href="{{ route('user.classifications') }}" class="user-card arancel">
            <div class="user-card-icon">
                <i class="fa fa-list"></i>
            </div>
            <h3>{{ __('app.dashboard_classification_title') }}</h3>
            <p>{{ __('app.dashboard_classification_desc') }}</p>
        </a>

        <!-- Card 2: Consulta de Trámites -->
        <a href="{{ route('user.procedures') }}" class="user-card tramite">
            <div class="user-card-icon">
                <i class="fa fa-folder-open"></i>
            </div>
            <h3>{{ __('app.dashboard_procedures_title') }}</h3>
            <p>{{ __('app.dashboard_procedures_desc') }}</p>
        </a>
    @endif
</div>

<style>
    .stats-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    
    .stats-card.pendiente-pago::before {
        background-color: #FFC107;
    }
    
    .stats-card.en-proceso::before {
        background-color: #2196F3;
    }
    
    .stats-card.finalizado::before {
        background-color: #4CAF50;
    }
    
    .stats-card-content {
        position: relative;
        z-index: 1;
    }
    
    .stats-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 32px;
        opacity: 0.1;
        z-index: 0;
    }
    
    .stats-card.pendiente-pago .stats-icon {
        color: #FFC107;
    }
    
    .stats-card.en-proceso .stats-icon {
        color: #2196F3;
    }
    
    .stats-card.finalizado .stats-icon {
        color: #4CAF50;
    }
    
    .stats-number {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .stats-card.pendiente-pago .stats-number {
        color: #FFC107;
    }
    
    .stats-card.en-proceso .stats-number {
        color: #2196F3;
    }
    
    .stats-card.finalizado .stats-number {
        color: #4CAF50;
    }
    
    .stats-label {
        font-size: 14px;
        color: #666;
        font-weight: 500;
    }
</style>
@endsection
