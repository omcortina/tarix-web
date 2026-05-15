@extends('layouts.user')

@section('page_title', 'Detalle de clasificación')

@section('title', 'Clasificaciones')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('css/show-verificacion.css') }}">
@endsection

@section('content')
    <div class="verificacion-container">
        <div class="back-button">
            <a href="{{ route('clasificador.index') }}">Volver a clasificaciones</a>
        </div>

        <div class="classification-header">
            <div class="header-info">
                <h1>{{ $classification->radicado }}</h1>
                <p class="user-detail">Solicitante: <strong>{{ $classification->user->name }}</strong></p>
            </div>
            <span class="status-badge status-{{ str_replace(' ', '-', strtolower($classification->status)) }}">
                {{ $classification->status }}
            </span>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Verificación de Pago -->
        @if (!$classification->payment_verified)
            <div class="payment-verification-section">
                <div class="payment-warning">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div>
                            <strong style="display: block; margin-bottom: 4px;">Pago Pendiente de Verificación</strong>
                            <p style="margin: 0; font-size: 13px; color: #666;">Debe verificar que el cliente haya completado el pago antes de iniciar la revisión de ítems.</p>
                        </div>
                    </div>
                </div>
                <form action="{{ route('clasificador.verify-payment', $classification) }}" method="POST" style="margin-top: 15px;">
                    @csrf
                    <button type="submit" class="btn btn-verify-payment">
                        Verificar Pago
                    </button>
                </form>
            </div>
        @else
            <div class="payment-verified-section">
                <p style="color: #28a745; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 8px;">
                    Pago Verificado el {{ \Carbon\Carbon::parse($classification->payment_verified_at)->format('d/m/Y H:i') }}
                </p>
            </div>
        @endif

        <!-- Información General -->
        <div class="info-section">
            <h2>Información General</h2>
            <div class="info-grid">
                <div class="info-card">
                    <label>Tipo de Clasificación:</label>
                    <value>
                        @if ($classification->type === 'general')
                            Mercancía General
                        @else
                            Unidad Funcional
                        @endif
                    </value>
                </div>
                <div class="info-card">
                    <label>Total de Ítems:</label>
                    <value>{{ $classification->items->count() }}</value>
                </div>
                <div class="info-card">
                    <label>Costo Total:</label>
                    <value class="highlight">${{ number_format($classification->total_cost, 0, ',', '.') }}</value>
                </div>
                <div class="info-card">
                    <label>Fecha de Solicitud:</label>
                    <value>{{ $classification->created_at->format('d/m/Y H:i') }}</value>
                </div>
            </div>
        </div>

        <!-- Ítems para Verificación -->
        <div class="items-section">
            <h2>Items para Verificación</h2>

            @if ($classification->items->count() > 0)
                <div class="items-list">
                    @foreach ($classification->items as $index => $item)
                        <div class="item-verification-card">
                            <div class="item-header-verify">
                                <div class="item-title">
                                    <h3>Item #{{ $index + 1 }}</h3>
                                    <p class="item-name">{{ $item->commercial_name }}</p>
                                </div>
                                <span class="item-status-badge status-{{ str_replace(' ', '-', strtolower($item->status)) }}">
                                    {{ $item->status }}
                                </span>
                            </div>

                            <div class="item-content">
                                <div class="item-details-grid">
                                    @if ($item->technical_name)
                                        <div class="detail-field">
                                            <label>Nombre Técnico:</label>
                                            <p>{{ $item->technical_name }}</p>
                                        </div>
                                    @endif

                                    @if ($item->matter)
                                        <div class="detail-field">
                                            <label>Materia Prima:</label>
                                            <p>{{ $item->matter }}</p>
                                        </div>
                                    @endif

                                    @if ($item->function)
                                        <div class="detail-field">
                                            <label>Función/Uso:</label>
                                            <p>{{ $item->function }}</p>
                                        </div>
                                    @endif

                                    @if ($item->destination)
                                        <div class="detail-field">
                                            <label>Destino/Aplicación:</label>
                                            <p>{{ $item->destination }}</p>
                                        </div>
                                    @endif

                                    @if ($item->observations)
                                        <div class="detail-field full-width">
                                            <label>Observaciones del Solicitante:</label>
                                            <p class="obs-text">{{ $item->observations }}</p>
                                        </div>
                                    @endif

                                    @if ($item->suggested_tariff)
                                        <div class="detail-field">
                                            <label>Código Arancelario Sugerido:</label>
                                            <p class="tariff-code">{{ $item->suggested_tariff }}</p>
                                        </div>
                                    @endif
                                </div>

                                @if ($item->attachments->count() > 0)
                                    <div class="attachments-section">
                                        <strong>Documentos de Apoyo:</strong>
                                        <div class="attachments-list">
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

                                @if ($item->revision_note)
                                    <div class="revision-note">
                                        <strong>Nota de Revisión Anterior:</strong>
                                        <p>{{ $item->revision_note }}</p>
                                    </div>
                                @endif

                                <!-- Correcciones y respuestas del cliente -->
                                @if ($item->corrections->count() > 0)
                                    <div class="corrections-history">
                                        <strong style="display: block; margin-bottom: 12px; margin-top: 12px;">Histórico de Correcciones:</strong>
                                        @foreach ($item->corrections as $correction)
                                            <div style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin-bottom: 12px; border-left: 3px solid #ffc107;">
                                                <div style="font-weight: 600; color: #666; font-size: 12px; text-transform: uppercase; margin-bottom: 6px;">
                                                    Tu Observación ({{ $correction->created_at->format('d/m/Y H:i') }})
                                                </div>
                                                <p style="margin: 0 0 10px; color: #333; font-size: 13px;">{{ $correction->observations }}</p>
                                                
                                                @if ($correction->client_response)
                                                    <div style="background: white; padding: 10px; border-radius: 4px; margin-top: 10px;">
                                                        <div style="font-weight: 600; color: #28a745; font-size: 12px; text-transform: uppercase; margin-bottom: 6px;">
                                                            ✓ Respuesta del Cliente ({{ $correction->updated_at->format('d/m/Y H:i') }})
                                                        </div>
                                                        <p style="margin: 0; color: #333; font-size: 13px;">{{ $correction->client_response }}</p>
                                                        
                                                        @if ($correction->attachments->where('type', 'cliente')->count() > 0)
                                                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #e0e0e0;">
                                                                <strong style="font-size: 12px; color: #666;">Archivos Adjuntos del Cliente:</strong>
                                                                <div style="margin-top: 8px;">
                                                                    @foreach ($correction->attachments->where('type', 'cliente') as $attachment)
                                                                        <div style="display: flex; align-items: center; gap: 8px; padding: 6px; background: #f0f4ff; border-radius: 4px; margin-bottom: 6px; font-size: 12px;">
                                                                            <a href="{{ route('corrections.attachments.download', $attachment->id) }}" target="_blank" download="{{ $attachment->file_name }}" style="color: #667eea; text-decoration: none; flex: 1;">
                                                                                {{ $attachment->file_name }}
                                                                            </a>
                                                                            <small style="color: #999;">{{ number_format($attachment->file_size / 1024, 2) }} KB</small>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Acciones solo si no está Verificado -->
                            @if ($item->status !== 'Verificado')
                                @if (!$classification->payment_verified)
                                    <div class="item-actions" style="opacity: 0.5; pointer-events: none;">
                                        <div style="background: #fff3cd; padding: 12px; border-radius: 4px; text-align: center; font-size: 13px; color: #856404;">
                                            Verifica el pago antes de proceder
                                        </div>
                                    </div>
                                @else
                                    <div class="item-actions">
                                        <!-- Verificar con subpartida -->
                                        <button type="button" class="btn btn-verify" onclick="openVerifyModal({{ $item->id }})">
                                            Verificar Item
                                        </button>

                                        <!-- Rechazar con nota -->
                                        <button type="button" class="btn btn-reject" onclick="openRejectModal({{ $item->id }})">
                                            Requerir Corrección
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="item-verified-badge">
                                    <p>Este ítem ya ha sido verificado</p>
                                    @if($item->final_tariff)
                                        <p style="margin-top: 8px; color: #22c5bc; font-weight: 600;">Subpartida: {{ $item->final_tariff }}</p>
                                    @endif
                                    @if($item->clasificador_observations)
                                        <p style="margin-top: 8px; color: #666; font-style: italic;">{{ $item->clasificador_observations }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Resumen de Verificación -->
        <div class="verification-summary">
            <div class="summary-card">
                <h3>Resumen de Verificación</h3>
                <div class="summary-stats">
                    <div class="stat">
                        <span class="stat-label">Verificados:</span>
                        <span class="stat-value verified">{{ $classification->items->where('status', 'Verificado')->count() }}</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">En Revisión:</span>
                        <span class="stat-value pending">{{ $classification->items->where('status', 'Devolución')->count() }}</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">Pendientes:</span>
                        <span class="stat-value">{{ $classification->items->where('status', 'Pendiente')->count() }}</span>
                    </div>
                </div>

                @if ($classification->items->where('status', 'Verificado')->count() === $classification->items->count() && $classification->status !== 'Aprobado')
                    <form action="{{ route('clasificador.approve', $classification) }}" method="POST" style="margin-top: 20px;">
                        @csrf
                        <button type="submit" class="btn btn-approve-full">
                            Aprobar Clasificación Completa
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Histórico -->
        <div class="history-section">
            <h2>Histórico de Cambios</h2>
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
                                @if ($history->changedBy)
                                    <small>Por: {{ $history->changedBy->name }}</small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modal para Verificar Item -->
    <div id="verifyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeVerifyModal()">&times;</span>
            <h2>Verificar Item</h2>
            
            <form id="verifyForm" method="POST">
                @csrf
                <div class="form-group">
                    <label for="final_tariff">Subpartida Final *</label>
                    <input 
                        type="text" 
                        id="final_tariff" 
                        name="final_tariff" 
                        class="form-control" 
                        placeholder="Ej: 6403.99.90.00" 
                        required
                        maxlength="50">
                    <small style="color: #666; display: block; margin-top: 4px;">Código arancelario que asignas a este ítem</small>
                </div>
                <div class="form-group">
                    <label for="clasificador_observations">Observaciones del Clasificador</label>
                    <textarea 
                        id="clasificador_observations" 
                        name="clasificador_observations" 
                        class="form-control" 
                        rows="4" 
                        placeholder="Agregar observaciones técnicas o justificación (opcional)"
                        maxlength="2000"></textarea>
                    <small style="color: #666; display: block; margin-top: 4px;">Estas observaciones se enviarán al cliente junto con la subpartida asignada</small>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeVerifyModal()">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-verify">
                        Verificar Item
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Rechazar Ítem -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRejectModal()">&times;</span>
            <h2>Requerir Corrección de Item</h2>
            
            <form id="rejectForm" method="POST">
                @csrf
                <div class="form-group">
                    <label for="revision_note">Nota de Revisión</label>
                    <textarea 
                        id="revision_note" 
                        name="revision_note" 
                        class="form-control" 
                        rows="5" 
                        placeholder="Describe qué correcciones se requieren..." 
                        required></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeRejectModal()">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-reject">
                        Enviar Requerimiento
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentItemId = null;

        // Verify Modal
        function openVerifyModal(itemId) {
            currentItemId = itemId;
            const form = document.getElementById('verifyForm');
            form.action = `{{ route('clasificador.verify-item', [$classification, ':itemId']) }}`.replace(':itemId', itemId);
            document.getElementById('verifyModal').style.display = 'block';
        }

        function closeVerifyModal() {
            document.getElementById('verifyModal').style.display = 'none';
            document.getElementById('final_tariff').value = '';
            document.getElementById('clasificador_observations').value = '';
        }

        // Reject Modal
        function openRejectModal(itemId) {
            currentItemId = itemId;
            const form = document.getElementById('rejectForm');
            form.action = `{{ route('clasificador.reject-item', [$classification, ':itemId']) }}`.replace(':itemId', itemId);
            document.getElementById('rejectModal').style.display = 'block';
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
            document.getElementById('revision_note').value = '';
        }

        // Close modal on outside click
        window.onclick = function(event) {
            const verifyModal = document.getElementById('verifyModal');
            const rejectModal = document.getElementById('rejectModal');
            
            if (event.target === verifyModal) {
                verifyModal.style.display = 'none';
            }
            if (event.target === rejectModal) {
                rejectModal.style.display = 'none';
            }
        }
    </script>
@endsection
