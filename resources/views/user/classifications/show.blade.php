@extends('layouts.user')

@section('title', 'Clasificaciones')

@section('page_title', 'Detalles de Clasificación - ' . $classification->radicado)

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('css/classifications-show.css') }}">
@endsection

@section('content')
    <div class="classification-show-container">
        <div class="back-button">
            <a href="{{ route('user.classifications') }}">Volver a mis clasificaciones</a>
        </div>

        <div class="classification-detail">
            @php
                $displayStatus = $classification->status;
                if (!auth()->user()->canSeePrices() && $displayStatus === 'Pendiente de pago') {
                    $displayStatus = 'En Revisión';
                }
            @endphp
            <div class="detail-header">
                <h1>{{ $classification->radicado }}</h1>
                <span class="status-badge status-{{ str_replace(' ', '-', strtolower($displayStatus)) }}">
                    {{ $displayStatus }}
                </span>
            </div>

            <div class="detail-grid">
                <div class="detail-card">
                    <h3>Información General</h3>
                    <div class="info-row">
                        <span class="label">Radicado:</span>
                        <span class="value">{{ $classification->radicado }}</span>
                    </div>
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
                    @if(auth()->user()->canSeePrices())
                    <div class="info-row">
                        <span class="label">Costo Total:</span>
                        <span class="value highlight">${{ number_format($classification->total_cost, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="label">Estado:</span>
                        <span class="value">{{ $displayStatus }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Creada:</span>
                        <span class="value">{{ $classification->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if ($classification->clasificador)
                        <div class="info-row">
                            <span class="label">Clasificador:</span>
                            <span class="value">{{ $classification->clasificador->name }}</span>
                        </div>
                    @endif
                </div>

                <div class="detail-card">
                    <h3>Resumen de Ítems</h3>
                    <div class="info-row">
                        <span class="label">Total de Ítems:</span>
                        <span class="value">{{ $classification->items->count() }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Verificados:</span>
                        <span class="value">{{ $classification->items->where('status', 'Verificado')->count() }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Pendientes:</span>
                        <span class="value">{{ $classification->items->where('status', 'Pendiente')->count() }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Devoluciones:</span>
                        <span class="value">{{ $classification->items->where('status', 'Devolución')->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="items-section">
                <h2>Items a Clasificar</h2>
                
                @if ($classification->items->count() > 0)
                    <div class="items-list">
                        @foreach ($classification->items as $index => $item)
                            <div class="item-card">
                                <div class="item-header">
                                    <div>
                                        <strong>Item #{{ $index + 1 }}: {{ $item->commercial_name }}</strong>
                                        <div class="item-meta">Creado: {{ $item->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        @if ($item->corrections()->where('status', 'pendiente')->count() > 0)
                                            <span class="badge-correction" style="background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">
                                                Correcciones Pendientes
                                            </span>
                                        @endif
                                        <span class="item-status status-{{ str_replace(' ', '-', strtolower($item->status)) }}">
                                            {{ $item->status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="item-details">
                                    @if ($item->technical_name)
                                        <div class="detail-row">
                                            <strong>Nombre Técnico:</strong>
                                            <p>{{ $item->technical_name }}</p>
                                        </div>
                                    @endif

                                    @if ($item->matter)
                                        <div class="detail-row">
                                            <strong>Materia Prima:</strong>
                                            <p>{{ $item->matter }}</p>
                                        </div>
                                    @endif

                                    @if ($item->function)
                                        <div class="detail-row">
                                            <strong>Función/Uso:</strong>
                                            <p>{{ $item->function }}</p>
                                        </div>
                                    @endif

                                    @if ($item->destination)
                                        <div class="detail-row">
                                            <strong>Destino/Aplicación:</strong>
                                            <p>{{ $item->destination }}</p>
                                        </div>
                                    @endif

                                    @if ($item->suggested_tariff)
                                        <div class="detail-row">
                                            <strong>Código Arancelario Sugerido:</strong>
                                            <p>{{ $item->suggested_tariff }}</p>
                                        </div>
                                    @endif

                                    @if ($item->observations)
                                        <div class="detail-row full-width">
                                            <strong>Observaciones:</strong>
                                            <p>{{ $item->observations }}</p>
                                        </div>
                                    @endif

                                    @if ($item->revision_note)
                                        <div class="revision-note">
                                            <strong>Nota de Revisión:</strong>
                                            <p>{{ $item->revision_note }}</p>
                                        </div>
                                    @endif

                                    @if ($item->status === 'Verificado' && $item->final_tariff)
                                        <div class="detail-row full-width" style="background:#e8f5e9;border-left:3px solid #22c5bc;padding:10px 14px;border-radius:4px;">
                                            <strong style="color:#1a7a5e;">Subpartida Final Asignada:</strong>
                                            <p style="font-weight:700;color:#1a7a5e;font-size:15px;margin-top:4px;">{{ $item->final_tariff }}</p>
                                        </div>
                                    @endif

                                    @if ($item->status === 'Verificado' && $item->clasificador_observations)
                                        <div class="detail-row full-width">
                                            <strong>Observaciones del Clasificador:</strong>
                                            <p style="font-style:italic;color:#555;">{{ $item->clasificador_observations }}</p>
                                        </div>
                                    @endif

                                    @if ($item->corrections()->count() > 0)
                                        <div style="grid-column:1/-1;margin-top:4px;">
                                            <a href="{{ route('user.classifications.items.corrections', [$classification, $item]) }}" class="btn-corrections" style="display: inline-block; background: #fff3cd; color: #856404; padding: 8px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: 600; border: 1px solid #ffc107;">
                                                Ver Correcciones ({{ $item->corrections()->count() }})
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                @if ($item->attachments->count() > 0)
                                    <div class="attachments-section">
                                        <strong>Documentos Adjuntos:</strong>
                                        <div class="attachment-list">
                                            @foreach ($item->attachments as $attachment)
                                                <div class="attachment-item">
                                                    <i class="fa fa-file"></i>
                                                    <a href="{{ route('attachments.download', $attachment->id) }}" target="_blank" download="{{ $attachment->file_name }}">
                                                        {{ $attachment->file_name }}
                                                    </a>
                                                    <small>({{ number_format($attachment->file_size / 1024, 2) }} KB)</small>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="history-section">
                <h2>Historial de la solicitud</h2>
                
                @if ($classification->histories->count() > 0)
                    <div class="timeline">
                        @foreach ($classification->histories as $history)
                            @if (!auth()->user()->canSeePrices() && $history->status === 'Pendiente de Pago')
                                @continue
                            @endif
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
@endsection
