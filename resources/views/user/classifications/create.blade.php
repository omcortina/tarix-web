@extends('layouts.user')

@section('title', 'Clasificaciones')

@section('page_title', 'Nueva Clasificación Arancelaria')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('css/classifications-create.css') }}">
    <style>
        .items-table { width: 100%; border-collapse: collapse; font-size: 13px; margin-top: 12px; }
        .items-table thead th { background: #f5f7fa; color: #0d2340; font-weight: 600; padding: 10px 8px; text-align: left; border-bottom: 2px solid #e0e8ed; white-space: nowrap; font-size: 12px; }
        .items-table tbody tr:nth-child(even) { background: #fafbfc; }
        .items-table tbody tr:hover { background: #f0f8ff; }
        .items-table td { padding: 5px 6px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .items-table td input[type="text"], .items-table td textarea { width: 100%; min-width: 90px; padding: 5px 7px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; box-sizing: border-box; font-family: inherit; }
        .items-table td input[type="text"]:focus, .items-table td textarea:focus { border-color: #22c5bc; outline: none; }
        .items-table td textarea { resize: vertical; min-height: 36px; overflow-y: hidden; }
        .items-table td input[type="file"] { font-size: 11px; max-width: 130px; }
        .items-table th:first-child, .items-table td:first-child { width: 32px; text-align: center; }
        .items-table th:last-child, .items-table td:last-child { width: 36px; text-align: center; }
        .btn-remove-row { background: none; border: 1px solid #d32f2f; color: #d32f2f; font-size: 12px; cursor: pointer; padding: 3px 7px; border-radius: 4px; line-height: 1; }
        .btn-remove-row:hover { background: #FFEBEE; }
        .items-table-overflow { overflow-x: auto; }
        /* Panel de nuevo item */
        .add-item-panel { background: #fff; border: 1px solid #e0e8ed; border-radius: 8px; padding: 20px 24px; margin-bottom: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .item-panel-title { font-size: 15px; font-weight: 700; color: #0d2340; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #f0f0f0; }
        .item-panel-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .item-panel-fields .form-group { display: flex; flex-direction: column; gap: 5px; }
        .item-panel-fields .form-group.full-width { grid-column: 1 / -1; }
        .item-panel-fields label { font-size: 13px; font-weight: 600; color: #444; }
        .item-panel-fields input[type="text"], .item-panel-fields textarea { padding: 8px 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; width: 100%; box-sizing: border-box; }
        .item-panel-fields input[type="text"]:focus, .item-panel-fields textarea:focus { border-color: #22c5bc; outline: none; }
        .item-panel-fields textarea { resize: vertical; min-height: 70px; }
        .item-panel-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 16px; padding-top: 14px; border-top: 1px solid #f0f0f0; }
        @media (max-width: 768px) { .item-panel-fields { grid-template-columns: 1fr; } }
    </style>
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
                    <button type="button" id="btnAddItem" class="btn btn-add-item" onclick="openAddItemPanel()">
                        Agregar ítem
                    </button>
                </div>

                <p class="info-text">Máximo: {{ $setting->max_items }} ítems por clasificación</p>

                <!-- Panel para agregar item individual -->
                <div id="addItemPanel" style="display:none;" class="add-item-panel">
                    <div class="item-panel-title">Nuevo ítem</div>
                    <div class="item-panel-fields">
                        <div class="form-group full-width">
                            <label>Nombre Comercial <span style="color:red">*</span></label>
                            <input type="text" id="panel_commercial_name" placeholder="Ej: Zapatos deportivos Nike">
                        </div>
                        <div class="form-group">
                            <label>Nombre Técnico</label>
                            <input type="text" id="panel_technical_name" placeholder="Ej: Calzado deportivo sintético">
                        </div>
                        <div class="form-group">
                            <label>Materia Prima</label>
                            <input type="text" id="panel_matter" placeholder="Ej: Caucho, poliéster">
                        </div>
                        <div class="form-group">
                            <label>Función / Uso</label>
                            <input type="text" id="panel_function" placeholder="Ej: Deporte, ocio">
                        </div>
                        <div class="form-group">
                            <label>Destino / Aplicación</label>
                            <input type="text" id="panel_destination" placeholder="Ej: Venta minorista">
                        </div>
                        <div class="form-group">
                            <label>Código Arancelario Sugerido</label>
                            <input type="text" id="panel_suggested_tariff" placeholder="Ej: 6403.99.90.00">
                        </div>
                        <div class="form-group full-width">
                            <label>Observaciones Adicionales</label>
                            <textarea id="panel_observations" placeholder="Detalles adicionales que ayuden a la clasificación..."></textarea>
                        </div>
                        <div class="form-group full-width">
                            <label>Documentos de Apoyo</label>
                            <div id="panel_file_wrapper">
                                <input type="file" id="panel_attachments" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            </div>
                            <small class="file-info">PDF, Word, Excel, imágenes. Máximo 10MB por archivo.</small>
                        </div>
                    </div>
                    <div class="item-panel-actions">
                        <button type="button" class="btn btn-secondary" onclick="cancelAddItemPanel()">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="confirmAddItem()">Confirmar</button>
                    </div>
                </div>

                <div class="items-table-overflow">
                    <table class="items-table" id="itemsTable" style="display:none;">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre Comercial <span style="color:red">*</span></th>
                                <th>Nombre Técnico</th>
                                <th>Materia Prima</th>
                                <th>Función / Uso</th>
                                <th>Destino</th>
                                <th>Cód. Arancelario</th>
                                <th>Observaciones</th>
                                <th>Docs</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody"></tbody>
                    </table>
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
        const maxItems = {{ $setting->max_items }};

        function openAddItemPanel() {
            if (document.querySelectorAll('#itemsTableBody tr').length >= maxItems) return;
            document.getElementById('addItemPanel').style.display = 'block';
            document.getElementById('panel_commercial_name').focus();
        }

        function cancelAddItemPanel() {
            resetPanel();
            document.getElementById('addItemPanel').style.display = 'none';
        }

        function resetPanel() {
            ['panel_commercial_name','panel_technical_name','panel_matter',
             'panel_function','panel_destination','panel_suggested_tariff','panel_observations']
                .forEach(id => document.getElementById(id).value = '');
            document.getElementById('panel_file_wrapper').innerHTML =
                '<input type="file" id="panel_attachments" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">';
        }

        function confirmAddItem() {
            const commercial = document.getElementById('panel_commercial_name').value.trim();
            if (!commercial) {
                Swal.fire('Campo requerido', 'El nombre comercial es obligatorio.', 'warning');
                return;
            }

            itemCount++;
            const rowNum = document.querySelectorAll('#itemsTableBody tr').length + 1;
            const esc = v => (v || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

            const rowHTML = `
                <tr data-item-index="${itemCount}">
                    <td style="text-align:center;font-weight:600;color:#555;">${rowNum}</td>
                    <td><textarea name="items[${itemCount}][commercial_name]" required>${esc(commercial)}</textarea></td>
                    <td><textarea name="items[${itemCount}][technical_name]">${esc(document.getElementById('panel_technical_name').value.trim())}</textarea></td>
                    <td><textarea name="items[${itemCount}][matter]">${esc(document.getElementById('panel_matter').value.trim())}</textarea></td>
                    <td><textarea name="items[${itemCount}][function]">${esc(document.getElementById('panel_function').value.trim())}</textarea></td>
                    <td><textarea name="items[${itemCount}][destination]">${esc(document.getElementById('panel_destination').value.trim())}</textarea></td>
                    <td><textarea name="items[${itemCount}][suggested_tariff]">${esc(document.getElementById('panel_suggested_tariff').value.trim())}</textarea></td>
                    <td><textarea name="items[${itemCount}][observations]">${esc(document.getElementById('panel_observations').value.trim())}</textarea></td>
                    <td class="file-cell-${itemCount}"></td>
                    <td><button type="button" class="btn-remove-row" onclick="removeItem(${itemCount})" title="Eliminar"><i class="fa fa-times"></i></button></td>
                </tr>
            `;

            document.getElementById('itemsTableBody').insertAdjacentHTML('beforeend', rowHTML);
            document.getElementById('itemsTable').style.display = 'table';

            // Mover el input de archivos al row (preserva los archivos seleccionados)
            const fileInput = document.getElementById('panel_attachments');
            fileInput.name = `items[${itemCount}][attachments][]`;
            fileInput.id = `items_${itemCount}_attachments`;
            document.querySelector(`.file-cell-${itemCount}`).appendChild(fileInput);

            resetPanel();
            document.getElementById('addItemPanel').style.display = 'none';
            checkItemLimit();
        }

        // Para carga desde Excel: va directo a la tabla
        function addItemFromData(data) {
            itemCount++;
            const rowNum = document.querySelectorAll('#itemsTableBody tr').length + 1;
            const esc = v => (v || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

            const rowHTML = `
                <tr data-item-index="${itemCount}">
                    <td style="text-align:center;font-weight:600;color:#555;">${rowNum}</td>
                    <td><textarea name="items[${itemCount}][commercial_name]" required>${esc(data.commercial_name)}</textarea></td>
                    <td><textarea name="items[${itemCount}][technical_name]">${esc(data.technical_name)}</textarea></td>
                    <td><textarea name="items[${itemCount}][matter]">${esc(data.matter)}</textarea></td>
                    <td><textarea name="items[${itemCount}][function]">${esc(data.function)}</textarea></td>
                    <td><textarea name="items[${itemCount}][destination]">${esc(data.destination)}</textarea></td>
                    <td><textarea name="items[${itemCount}][suggested_tariff]">${esc(data.suggested_tariff)}</textarea></td>
                    <td><textarea name="items[${itemCount}][observations]">${esc(data.observations)}</textarea></td>
                    <td><input type="file" name="items[${itemCount}][attachments][]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"></td>
                    <td><button type="button" class="btn-remove-row" onclick="removeItem(${itemCount})" title="Eliminar"><i class="fa fa-times"></i></button></td>
                </tr>
            `;

            document.getElementById('itemsTableBody').insertAdjacentHTML('beforeend', rowHTML);
            document.getElementById('itemsTable').style.display = 'table';
            checkItemLimit();
        }

        function removeItem(index) {
            const row = document.querySelector(`#itemsTableBody tr[data-item-index="${index}"]`);
            if (row) {
                row.remove();
                document.querySelectorAll('#itemsTableBody tr').forEach((tr, i) => {
                    tr.querySelector('td:first-child').textContent = i + 1;
                });
                if (document.querySelectorAll('#itemsTableBody tr').length === 0) {
                    document.getElementById('itemsTable').style.display = 'none';
                }
                checkItemLimit();
            }
        }

        function checkItemLimit() {
            const count = document.querySelectorAll('#itemsTableBody tr').length;
            const limitReached = count >= maxItems;
            const isGeneral = document.querySelector('input[name="type"]:checked')?.value === 'general';
            document.getElementById('btnAddItem').style.display = limitReached ? 'none' : '';
            document.getElementById('bulkSection').style.display = (!limitReached && isGeneral) ? 'block' : 'none';
        }

        function toggleBulkOption() {
            checkItemLimit();
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
                    document.getElementById('itemsTableBody').innerHTML = '';
                    itemCount = 0;

                    // Agregar items del Excel
                    items.forEach(item => {
                        addItemFromData(item);
                    });

                    Swal.fire('Éxito', `Se agregaron ${items.length} items del archivo Excel`, 'success');
                    
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
            const items = document.querySelectorAll('#itemsTableBody tr');
            
            if (items.length === 0 && !bulkFile) {
                e.preventDefault();
                Swal.fire('Advertencia', 'Debes agregar al menos un ítem o subir un archivo masivo', 'warning');
                return false;
            }
        });
    </script>
@endsection
