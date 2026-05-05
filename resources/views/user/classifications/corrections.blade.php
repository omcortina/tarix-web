@extends('layouts.user')

@section('title', 'Correcciones de Ítem')

@section('page_title', 'Correcciones Requeridas')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('css/classifications-show.css') }}">
    <style>
        .corrections-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .item-info-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .item-field {
            margin-bottom: 12px;
        }

        .item-field-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #666;
        }

        .item-field-value {
            font-size: 14px;
            color: #333;
            margin-top: 4px;
        }

        .correction-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
        }

        .correction-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .correction-title {
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .correction-date {
            font-size: 12px;
            color: #999;
        }

        .correction-status {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .status-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .status-respondido {
            background: #d4edda;
            color: #155724;
        }

        .observations-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            border-left: 3px solid #ffc107;
        }

        .observations-label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .observations-text {
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }

        .response-form {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            font-size: 14px;
            resize: vertical;
            min-height: 100px;
        }

        .file-upload-area {
            border: 2px dashed #ddd;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-upload-area:hover {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .file-upload-area input {
            display: none;
        }

        .file-list {
            margin-top: 10px;
        }

        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .file-remove {
            color: #dc3545;
            cursor: pointer;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
        }

        .attachment-list {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
        }

        .attachment-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            font-size: 13px;
            color: #666;
        }

        .attachment-icon {
            color: #667eea;
            font-weight: 600;
        }

        .back-link {
            margin-bottom: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
    <div class="corrections-container">
        <div class="back-link">
            <a href="{{ route('user.classifications.show', $classification) }}">Volver a la clasificación</a>
        </div>

        <!-- Item Information -->
        <div class="item-info-box">
            <h3 style="margin-top: 0; margin-bottom: 15px;">Información del Ítem</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="item-field">
                    <div class="item-field-label">Nombre Comercial</div>
                    <div class="item-field-value">{{ $item->commercial_name }}</div>
                </div>
                <div class="item-field">
                    <div class="item-field-label">Nombre Técnico</div>
                    <div class="item-field-value">{{ $item->technical_name ?? 'N/A' }}</div>
                </div>
                <div class="item-field">
                    <div class="item-field-label">Materia Prima</div>
                    <div class="item-field-value">{{ $item->matter ?? 'N/A' }}</div>
                </div>
                <div class="item-field">
                    <div class="item-field-label">Función</div>
                    <div class="item-field-value">{{ $item->function ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Corrections List -->
        @if ($corrections->count() > 0)
            @foreach ($corrections as $correction)
                <div class="correction-card">
                    <div class="correction-header">
                        <div>
                            <h4 class="correction-title">Solicitud de Corrección</h4>
                            <div class="correction-date">{{ $correction->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <span class="correction-status status-{{ $correction->status }}">
                            {{ ucfirst($correction->status) }}
                        </span>
                    </div>

                    <div class="observations-box">
                        <div class="observations-label">Observaciones del Clasificador:</div>
                        <div class="observations-text">{{ $correction->observations }}</div>
                    </div>

                    @if ($correction->status === 'respondido' && $correction->client_response)
                        <div class="observations-box" style="border-left-color: #28a745; background: #f0fff4;">
                            <div class="observations-label" style="color: #155724;">Tu Respuesta:</div>
                            <div class="observations-text">{{ $correction->client_response }}</div>
                        </div>

                        @if ($correction->attachments->count() > 0)
                            <div class="attachment-list">
                                <strong style="display: block; margin-bottom: 10px;">Archivos Adjuntos:</strong>
                                @foreach ($correction->attachments->where('type', 'cliente') as $attachment)
                                    <div class="attachment-item">
                                        <span class="attachment-icon">📎</span>
                                        <a href="{{ route('corrections.attachments.download', $attachment->id) }}" target="_blank" download="{{ $attachment->file_name }}">
                                            {{ $attachment->file_name }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @elseif ($correction->status === 'pendiente')
                        <!-- Response Form -->
                        <form action="{{ route('user.classifications.corrections.respond', [$classification, $item, $correction]) }}" method="POST" enctype="multipart/form-data" class="response-form">
                            @csrf

                            <div class="form-group">
                                <label for="response">Tu Respuesta *</label>
                                <textarea name="client_response" id="response" required placeholder="Describe los cambios realizados o proporciona más información..."></textarea>
                                @error('client_response')
                                    <small style="color: #dc3545;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Archivos Adjuntos (Opcional)</label>
                                <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                                    <p style="margin: 0; color: #666;">Haz clic aquí o arrastra archivos para cargar</p>
                                    <small style="color: #999;">Máx. 10MB por archivo. Formatos: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG</small>
                                    <input type="file" id="fileInput" name="attachments[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                                </div>
                                <div class="file-list" id="fileList"></div>
                                @error('attachments')
                                    <small style="color: #dc3545;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="action-buttons">
                                <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
                                <a href="{{ route('user.classifications.show', $classification) }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    @endif
                </div>
            @endforeach
        @else
            <div class="correction-card" style="text-align: center; padding: 40px;">
                <p style="color: #999; margin: 0;">No hay correcciones pendientes para este ítem.</p>
            </div>
        @endif
    </div>

    <script>
        // Handle file selection
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');

        fileInput?.addEventListener('change', function() {
            fileList.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                fileItem.innerHTML = `
                    <span>${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
                    <span class="file-remove" onclick="this.parentElement.remove(); fileInput.value = '';">✕</span>
                `;
                fileList.appendChild(fileItem);
            });
        });
    </script>
@endsection
