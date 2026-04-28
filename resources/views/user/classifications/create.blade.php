@extends('layouts.user')

@section('title', 'Clasificaciones')

@section('page_title', 'Nueva Clasificación Arancelaria')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('css/classifications-create.css') }}">
@endsection

@section('content')
    <div class="classification-create-container">
        <div class="create-header">
            <h1>Nueva Clasificación Arancelaria</h1>
            <p class="subtitle">Completa el formulario para solicitar una nueva clasificación. Costo: <strong>${{ number_format($setting->price_general, 0, ',', '.') }}</strong> por ítem (MERCANCIA GENERAL)</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Error al procesar:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.classifications.store') }}" method="POST" id="classificationForm" enctype="multipart/form-data">
            @csrf
            
            <!-- Tipo de Clasificación -->
            <div class="form-section">
                <h2>Tipo de Clasificación</h2>
                
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="type" value="general" checked onchange="toggleBulkOption()">
                        <span class="radio-label">
                            <strong>Mercancía General</strong>
                            <small>Clasificación estándar de productos</small>
                        </span>
                    </label>
                    
                    <label class="radio-option" style="display: none;">
                        <input type="radio" name="type" value="unidad_funcional" onchange="toggleBulkOption()">
                        <span class="radio-label">
                            <strong>Unidad Funcional</strong>
                            <small>Clasificación por funcionalidad</small>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Carga Masiva (Solo para Mercancía General) -->
            <div class="form-section" id="bulkSection">
                <h2>Carga Masiva de Items</h2>
                <p class="info-text">Descarga la plantilla, complétala con tus ítems y súbela aquí para crear múltiples ítems de una vez.</p>
                
                <div class="bulk-upload-area">
                    <div class="template-link">
                        <a href="{{ route('user.classifications.download-template') }}" class="btn btn-template">
                            Descargar Plantilla Excel
                        </a>
                    </div>

                    <div class="separator">o</div>

                    <div class="form-group full-width">
                        <label for="bulk_file">Subir Archivo Excel</label>
                        <input 
                            type="file" 
                            id="bulk_file"
                            name="bulk_file"
                            accept=".xls,.xlsx"
                        >
                        <small class="file-info">Máximo 5MB. Formatos: .xls, .xlsx</small>
                    </div>
                </div>
            </div>

            <!-- Ítems de Clasificación -->
            <div class="form-section">
                <div class="section-header">
                    <h2>Items a Clasificar</h2>
                    <button type="button" class="btn btn-add-item" onclick="addItem()">
                        Agregar ítem
                    </button>
                </div>

                <p class="info-text">Máximo: {{ $setting->max_items }} ítems por clasificación</p>

                <div id="itemsContainer">
                    <!-- Items se agregan aquí dinámicamente -->
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="form-actions">
                <a href="{{ route('user.classifications') }}" class="btn btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Enviar Clasificación
                </button>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
    <script>
        let itemCount = 0;

        function addItem(data = null) {
            itemCount++;
            
            // Si hay datos del Excel, usarlos; si no, usar valores vacíos
            const values = data || {
                commercial_name: '',
                technical_name: '',
                matter: '',
                function: '',
                destination: '',
                suggested_tariff: '',
                observations: ''
            };
            
            const itemHTML = `
                <div class="item-card" data-item-index="${itemCount}">
                    <div class="item-header">
                        <span class="item-number">Item #${itemCount}</span>
                        <button type="button" class="btn-remove-item" onclick="removeItem(${itemCount})">
                            Eliminar
                        </button>
                    </div>

                    <div class="item-fields">
                        <div class="form-group full-width">
                            <label for="items_${itemCount}_commercial_name">
                                Nombre Comercial <span style="color: red;">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="items_${itemCount}_commercial_name"
                                name="items[${itemCount}][commercial_name]"
                                placeholder="Ej: Zapatos deportivos Nike"
                                value="${values.commercial_name || ''}"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="items_${itemCount}_technical_name">Nombre Técnico</label>
                            <input 
                                type="text" 
                                id="items_${itemCount}_technical_name"
                                name="items[${itemCount}][technical_name]"
                                placeholder="Ej: Calzado deportivo sintético"
                                value="${values.technical_name || ''}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="items_${itemCount}_matter">Materia Prima</label>
                            <input 
                                type="text" 
                                id="items_${itemCount}_matter"
                                name="items[${itemCount}][matter]"
                                placeholder="Ej: Caucho, poliéster"
                                value="${values.matter || ''}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="items_${itemCount}_function">Función/Uso</label>
                            <input 
                                type="text" 
                                id="items_${itemCount}_function"
                                name="items[${itemCount}][function]"
                                placeholder="Ej: Deporte, ocio"
                                value="${values.function || ''}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="items_${itemCount}_destination">Destino/Aplicación</label>
                            <input 
                                type="text" 
                                id="items_${itemCount}_destination"
                                name="items[${itemCount}][destination]"
                                placeholder="Ej: Venta minorista, uso personal"
                                value="${values.destination || ''}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="items_${itemCount}_suggested_tariff">Código Arancelario Sugerido</label>
                            <input 
                                type="text" 
                                id="items_${itemCount}_suggested_tariff"
                                name="items[${itemCount}][suggested_tariff]"
                                placeholder="Ej: 6403.99.90.00"
                                value="${values.suggested_tariff || ''}"
                            >
                        </div>

                        <div class="form-group full-width">
                            <label for="items_${itemCount}_observations">Observaciones Adicionales</label>
                            <textarea 
                                id="items_${itemCount}_observations"
                                name="items[${itemCount}][observations]"
                                placeholder="Detalles adicionales que ayuden a la clasificación..."
                            >${values.observations || ''}</textarea>
                        </div>

                        <div class="form-group full-width">
                            <label for="items_${itemCount}_attachments">Documentos de Apoyo</label>
                            <input 
                                type="file" 
                                id="items_${itemCount}_attachments"
                                name="items[${itemCount}][attachments][]"
                                multiple
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                            >
                            <small class="file-info">Puedes subir múltiples archivos (PDF, Word, Excel, imágenes). Máximo 10MB por archivo.</small>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('itemsContainer').insertAdjacentHTML('beforeend', itemHTML);
        }

        function removeItem(index) {
            const itemCard = document.querySelector(`[data-item-index="${index}"]`);
            if (itemCard) {
                itemCard.remove();
            }
        }

        function toggleBulkOption() {
            const typeSelect = document.querySelector('input[name="type"]:checked');
            const bulkSection = document.getElementById('bulkSection');
            
            if (typeSelect.value === 'general') {
                bulkSection.style.display = 'block';
            } else {
                bulkSection.style.display = 'none';
            }
        }

        // Procesar archivo Excel cuando se carga
        document.getElementById('bulk_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Verificar que XLSX esté disponible
            if (typeof XLSX === 'undefined') {
                Swal.fire('Error', 'La librería de procesamiento de Excel aún no está lista. Por favor intenta de nuevo en unos segundos.', 'error');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                try {
                    const data = new Uint8Array(event.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    const worksheet = workbook.Sheets[workbook.SheetNames[0]];
                    const rows = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

                    if (!rows || rows.length < 2) {
                        Swal.fire('Advertencia', 'El archivo está vacío o no tiene datos válidos.', 'warning');
                        return;
                    }

                    // Mapeo de columnas: A=0, B=1, C=2, D=3, E=4, F=5, G=6
                    const items = [];
                    
                    // Saltar encabezado (fila 0) y procesar datos
                    for (let i = 1; i < rows.length; i++) {
                        const row = rows[i];
                        
                        // Saltar filas vacías o incompletas
                        if (!row || !row[0]) {
                            continue;
                        }

                        items.push({
                            commercial_name: row[0] ? String(row[0]).trim() : '',
                            technical_name: row[1] ? String(row[1]).trim() : '',
                            matter: row[2] ? String(row[2]).trim() : '',
                            function: row[3] ? String(row[3]).trim() : '',
                            destination: row[4] ? String(row[4]).trim() : '',
                            suggested_tariff: row[5] ? String(row[5]).trim() : '',
                            observations: row[6] ? String(row[6]).trim() : ''
                        });
                    }

                    if (items.length === 0) {
                        Swal.fire('Advertencia', 'El archivo no contiene datos válidos. Asegúrate de que tenga al menos una fila con información después del encabezado.', 'warning');
                        return;
                    }

                    // Limpiar items existentes
                    document.getElementById('itemsContainer').innerHTML = '';
                    itemCount = 0;

                    // Agregar items del Excel
                    items.forEach(item => {
                        addItem(item);
                    });

                    Swal.fire('Éxito', `Se agregaron ${items.length} ítems del archivo Excel`, 'success');
                    
                    // Limpiar el campo de archivo
                    document.getElementById('bulk_file').value = '';
                } catch (error) {
                    console.error('Error detallado:', error);
                    Swal.fire('Error', 'Error al procesar el archivo Excel: ' + error.message, 'error');
                }
            };

            reader.onerror = function() {
                Swal.fire('Error', 'Error al leer el archivo. Por favor intenta de nuevo.', 'error');
            };

            reader.readAsArrayBuffer(file);
        });

        // Inicializar opciones de carga masiva al cargar
        document.addEventListener('DOMContentLoaded', function() {
            toggleBulkOption();
        });

        // Validar al enviar
        document.getElementById('classificationForm').addEventListener('submit', function(e) {
            const bulkFile = document.getElementById('bulk_file').files.length > 0;
            const items = document.querySelectorAll('.item-card');
            
            if (items.length === 0 && !bulkFile) {
                e.preventDefault();
                Swal.fire('Advertencia', 'Debes agregar al menos un ítem o subir un archivo masivo', 'warning');
                return false;
            }
        });
    </script>
@endsection
