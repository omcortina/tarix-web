@extends('layouts.user')

@section('title', 'Clasificaciones')

@section('page_title', 'Bandeja de Clasificaciones')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('css/clasificador-dashboard.css') }}">
@endsection

@section('content')
    <div class="clasificador-container">
        @if ($classifications->count() > 0)
            <div class="classifications-grid">
                @foreach ($classifications as $classification)
                    <div class="classification-card">
                        <div class="card-header">
                            <div class="radicado-info">
                                <h3 class="radicado">{{ $classification->radicado }}</h3>
                                <p style="margin-top: 5px;">{{ $classification->user->name }}</p>
                            </div>
                            <span class="status-badge status-{{ str_replace(' ', '-', strtolower($classification->status)) }}">
                                {{ $classification->status }}
                            </span>
                        </div>

                        <div class="card-body">
                            <div class="info-row">
                                <span class="label">Tipo:</span>
                                <span class="value">
                                    @if ($classification->type === 'general')
                                        Mercancía General
                                    @else
                                        Unidad Funcional
                                    @endif
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="label">Ítems:</span>
                                <span class="value">
                                    {{ $classification->items->where('status', 'Verificado')->count() }}/{{ $classification->items->count() }} verificados
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="label">Costo:</span>
                                <span class="value strong">${{ number_format($classification->total_cost, 0, ',', '.') }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Creado:</span>
                                <span class="value">{{ $classification->created_at->format('d/m/Y') }}</span>
                            </div>

                            @if (!$classification->payment_verified)
                                <div style="background: #fff3cd; padding: 8px; border-radius: 4px; margin-top: 10px; text-align: center; font-size: 12px; color: #856404; font-weight: 600;">
                                    Pago no verificado
                                </div>
                            @else
                                <div style="background: #d4edda; padding: 8px; border-radius: 4px; margin-top: 10px; text-align: center; font-size: 12px; color: #155724; font-weight: 600;">
                                    Pago verificado
                                </div>
                            @endif

                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ ($classification->items->where('status', 'Verificado')->count() / $classification->items->count()) * 100 }}%"></div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('clasificador.show', $classification) }}" class="btn btn-primary">
                                Ver detalle
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-container">
                {{ $classifications->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h2>Sin clasificaciones pendientes</h2>
                <p>Todas las clasificaciones asignadas han sido procesadas</p>
            </div>
        @endif
    </div>
@endsection
