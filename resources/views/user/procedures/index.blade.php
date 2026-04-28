@extends('layouts.user')

@section('title', 'Consulta')

@section('page_title', 'Consulta de Trámites')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('css/procedures-index.css') }}">
@endsection

@section('content')
    <div class="procedures-container">
        <div class="search-section">
            <h1>Consulta de Trámites</h1>
            <p class="subtitle">Busca el estado de tu clasificación usando el radicado</p>

            <form method="GET" class="search-form">
                <div class="search-input-group">
                    <input 
                        type="text" 
                        name="radicado" 
                        placeholder="Ej: CLA20260001"
                        value="{{ $radicado ?? '' }}"
                        class="search-input"
                        maxlength="14"
                    >
                    <button type="submit" class="btn-search">
                        Buscar
                    </button>
                </div>
            </form>

            @if ($errors->any())
                <div class="alert alert-error">
                    <strong></strong> {{ $errors->first('radicado') }}
                </div>
            @endif
        </div>

        @if ($classification)
            <div class="result-section">
                <div class="classification-detail">
                    <div class="detail-header">
                        <h2>{{ $classification->radicado }}</h2>
                        <span class="status-badge status-{{ str_replace(' ', '-', strtolower($classification->status)) }}">
                            {{ $classification->status }}
                        </span>
                    </div>

                    <div class="detail-info">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Tipo de Clasificación:</label>
                                <value>
                                    @if ($classification->type === 'general')
                                        Mercancía General
                                    @else
                                        Unidad Funcional
                                    @endif
                                </value>
                            </div>

                            <div class="info-item">
                                <label>Total de Ítems:</label>
                                <value>{{ $classification->items->count() }}</value>
                            </div>

                            <div class="info-item">
                                <label>Costo Total:</label>
                                <value class="highlight">${{ number_format($classification->total_cost, 0, ',', '.') }}</value>
                            </div>

                            <div class="info-item">
                                <label>Fecha de Creación:</label>
                                <value>{{ $classification->created_at->format('d/m/Y H:i') }}</value>
                            </div>

                            @if ($classification->clasificador)
                                <div class="info-item">
                                    <label>Clasificador Asignado:</label>
                                    <value>{{ $classification->clasificador->name }}</value>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Ítems de la Clasificación -->
                    <div class="items-section">
                        <h3>Items a Clasificar</h3>
                        
                        @if ($classification->items->count() > 0)
                            <div class="items-list">
                                @foreach ($classification->items as $index => $item)
                                    <div class="item-card">
                                        <div class="item-header-mini">
                                            <strong>Ítem #{{ $index + 1 }}: {{ $item->commercial_name }}</strong>
                                            <span class="item-status status-{{ str_replace(' ', '-', strtolower($item->status)) }}">
                                                {{ $item->status }}
                                            </span>
                                        </div>

                                        <div class="item-details">
                                            @if ($item->technical_name)
                                                <p><strong>Nombre Técnico:</strong> {{ $item->technical_name }}</p>
                                            @endif

                                            @if ($item->matter)
                                                <p><strong>Materia Prima:</strong> {{ $item->matter }}</p>
                                            @endif

                                            @if ($item->function)
                                                <p><strong>Función/Uso:</strong> {{ $item->function }}</p>
                                            @endif

                                            @if ($item->destination)
                                                <p><strong>Destino/Aplicación:</strong> {{ $item->destination }}</p>
                                            @endif

                                            @if ($item->suggested_tariff)
                                                <p><strong>Código Arancelario Sugerido:</strong> {{ $item->suggested_tariff }}</p>
                                            @endif

                                            @if ($item->observations)
                                                <p><strong>Observaciones:</strong> {{ $item->observations }}</p>
                                            @endif

                                            @if ($item->revision_note)
                                                <div class="revision-note">
                                                    <strong>Nota de Revisión:</strong>
                                                    <p>{{ $item->revision_note }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Histórico de Cambios -->
                    <div class="history-section">
                        <h3>Histórico de Cambios</h3>
                        
                        @if ($classification->histories->count() > 0)
                            <div class="timeline">
                                @foreach ($classification->histories as $history)
                                    <div class="timeline-item">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <div class="timeline-header">
                                                <strong>{{ $history->status }}</strong>
                                                <span class="timeline-date">{{ $history->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            @if ($history->note)
                                                <p>{{ $history->note }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @elseif ($radicado)
            <div class="empty-search">
                <p>No se encontraron resultados para "{{ $radicado }}"</p>
            </div>
        @else
            <div class="help-section">
                <div class="help-box">
                    <h3>¿Cómo usar?</h3>
                    <ol>
                        <li>Ingresa el radicado de tu clasificación (Ej: CLA20260001)</li>
                        <li>Haz clic en "Buscar"</li>
                        <li>Verás el estado de tu trámite y todos los detalles</li>
                    </ol>
                </div>
            </div>
        @endif
    </div>
@endsection
