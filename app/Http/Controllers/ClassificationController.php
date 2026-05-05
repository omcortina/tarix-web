<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\ClassificationItem;
use App\Models\ClassificationHistory;
use App\Models\ClassificationAttachment;
use App\Models\ClassificationSetting;
use App\Models\ItemCorrection;
use App\Models\CorrectionAttachment;
use App\Models\User;
use App\Mail\ClassificationAssignedMail;
use App\Mail\ClassificationCreatedMail;
use App\Mail\EmpresaNewClassificationMail;
use App\Mail\CorrectionRespondedMail;
use App\Services\InvoicePdfService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;

class ClassificationController extends Controller
{
    /**
     * Mostrar listado de clasificaciones del usuario
     */
    public function index()
    {
        $user = Auth::user();
        $classifications = Classification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(6);
        
        return view('user.classifications.index', compact('classifications'));
    }

    /**
     * Listado de clasificaciones de la empresa (para usuario EMPRESA)
     */
    public function empresaIndex(Request $request)
    {
        $user = Auth::user();

        if ($user->user_type !== 'EMPRESA') {
            abort(403);
        }

        $companyUsers = User::where('company_id', $user->company_id)
            ->where('user_type', 'EXTERNO')
            ->get();

        $selectedUserId = $request->get('user_id');

        $query = Classification::with(['user', 'items'])
            ->whereIn('user_id', $companyUsers->pluck('id'))
            ->orderByDesc('created_at');

        if ($selectedUserId) {
            $query->where('user_id', $selectedUserId);
        }

        $classifications = $query->get();

        $totalGeneral = $classifications->sum('total_cost');

        // Totales por usuario
        $totalesPorUsuario = Classification::whereIn('user_id', $companyUsers->pluck('id'))
            ->selectRaw('user_id, SUM(total_cost) as total, COUNT(*) as cantidad')
            ->groupBy('user_id')
            ->with('user:id,name,email')
            ->get();

        return view('user.classifications.empresa-index', compact(
            'classifications',
            'companyUsers',
            'selectedUserId',
            'totalGeneral',
            'totalesPorUsuario'
        ));
    }

    /**
     * Resumen de facturación de la empresa (para usuario EMPRESA)
     */
    public function empresaBilling()
    {
        $user = Auth::user();

        if ($user->user_type !== 'EMPRESA') {
            abort(403);
        }

        $companyUsers = User::where('company_id', $user->company_id)
            ->where('user_type', 'EXTERNO')
            ->get();

        $userIds = $companyUsers->pluck('id');

        // Resumen por usuario
        $resumenPorUsuario = Classification::whereIn('user_id', $userIds)
            ->selectRaw('user_id, status, SUM(total_cost) as total, COUNT(*) as cantidad')
            ->groupBy('user_id', 'status')
            ->with('user:id,name,email')
            ->get()
            ->groupBy('user_id');

        // Total general
        $totalGeneral = Classification::whereIn('user_id', $userIds)->sum('total_cost');
        $totalPendientePago = Classification::whereIn('user_id', $userIds)->where('payment_verified', false)->sum('total_cost');
        $totalPagado = Classification::whereIn('user_id', $userIds)->where('payment_verified', true)->sum('total_cost');
        $cantidadTotal = Classification::whereIn('user_id', $userIds)->count();

        return view('user.classifications.empresa-billing', compact(
            'companyUsers',
            'resumenPorUsuario',
            'totalGeneral',
            'totalPendientePago',
            'totalPagado',
            'cantidadTotal'
        ));
    }

    /**
     * Mostrar formulario de creación de clasificación
     */
    public function create()
    {
        $setting = ClassificationSetting::first();
        
        // Validar que exista al menos un clasificador registrado
        $clasificadoresCount = User::where('user_type', 'CLASIFICADOR')->count();
        if ($clasificadoresCount === 0) {
            return redirect()->route('user.classifications')
                ->withErrors([
                    'error' => 'No hay clasificadores disponibles en este momento. Por favor, intente más tarde o contacte al administrador.'
                ]);
        }
        
        return view('user.classifications.create', compact('setting'));
    }

    /**
     * Guardar nueva clasificación
     */
    public function store(Request $request)
    {
        // Validar que exista al menos un clasificador registrado
        $clasificadoresCount = User::where('user_type', 'CLASIFICADOR')->count();
        if ($clasificadoresCount === 0) {
            return back()->withErrors([
                'error' => 'No hay clasificadores disponibles en este momento. Por favor, intente más tarde o contacte al administrador.'
            ])->withInput();
        }
        
        $validated = $request->validate([
            'type' => 'required|in:general,unidad_funcional',
            'items' => 'nullable|array|min:0',
            'items.*.commercial_name' => 'required_with:items|string',
            'items.*.technical_name' => 'nullable|string',
            'items.*.matter' => 'nullable|string',
            'items.*.function' => 'nullable|string',
            'items.*.destination' => 'nullable|string',
            'items.*.suggested_tariff' => 'nullable|string',
            'items.*.observations' => 'nullable|string',
            'items.*.attachments' => 'nullable|array',
            'items.*.attachments.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'bulk_file' => 'nullable|file|mimes:xls,xlsx|max:5120',
        ]);
        
        $user = Auth::user();
        $setting = ClassificationSetting::first();
        
        // Si hay archivo bulk (carga masiva), procesar primero
        if ($request->hasFile('bulk_file')) {
            if ($validated['type'] !== 'general') {
                return back()->withErrors(['bulk_file' => 'La carga masiva solo está disponible para Mercancía General']);
            }
            $validated['items'] = $this->processBulkFile($request->file('bulk_file'));
        }
        
        // Validar que hay al menos un ítem
        if (!$validated['items'] || count($validated['items']) === 0) {
            return back()->withErrors(['items' => 'Debes agregar al menos un ítem o subir un archivo masivo']);
        }
        
        // Validar cantidad de ítems
        if (count($validated['items']) > $setting->max_items) {
            return back()->withErrors(['items' => "No puedes enviar más de {$setting->max_items} ítems"]);
        }
        
        try {
            DB::beginTransaction();
            
            // Generar radicado
            $radicado = $this->generateRadicado();
            
            // Calcular costo total
            $pricePerItem = $user->client_type === 'PREFERENTIAL'
                ? $setting->price_preferential
                : $setting->price_general;
            $subtotal   = count($validated['items']) * $pricePerItem;
            $ivaPercent = $setting->iva_percentage ?? 0;
            $ivaAmount  = round($subtotal * ($ivaPercent / 100), 2);
            $totalCost  = $subtotal + $ivaAmount;

            // Crear clasificación
            $classification = Classification::create([
                'user_id'        => $user->id,
                'radicado'       => $radicado,
                'type'           => $validated['type'],
                'subtotal'       => $subtotal,
                'iva_percentage' => $ivaPercent,
                'iva_amount'     => $ivaAmount,
                'total_cost'     => $totalCost,
                'status'         => 'Pendiente de Pago',
                'payment_verified' => false,
            ]);
            
            // Crear ítems
            foreach ($validated['items'] as $itemIndex => $itemData) {
                $item = ClassificationItem::create([
                    'classification_id' => $classification->id,
                    'commercial_name' => $itemData['commercial_name'],
                    'technical_name' => $itemData['technical_name'] ?? null,
                    'matter' => $itemData['matter'] ?? null,
                    'function' => $itemData['function'] ?? null,
                    'destination' => $itemData['destination'] ?? null,
                    'suggested_tariff' => $itemData['suggested_tariff'] ?? null,
                    'observations' => $itemData['observations'] ?? null,
                    'status' => 'Pendiente',
                ]);
                
                // Guardar archivos adjuntos si existen
                if ($request->hasFile("items.{$itemIndex}.attachments")) {
                    $files = $request->file("items.{$itemIndex}.attachments");
                    foreach ($files as $file) {
                        // Generar nombre único preservando extensión original
                        $extension = $file->getClientOriginalExtension();
                        $hashName = uniqid() . '_' . time() . '.' . $extension;
                        $path = $file->storeAs("classifications/{$classification->id}/items/{$item->id}", $hashName, 'public');
                        ClassificationAttachment::create([
                            'classification_item_id' => $item->id,
                            'file_path' => $path,
                            'file_name' => $file->getClientOriginalName(),
                            'file_size' => $file->getSize(),
                        ]);
                    }
                }
            }
            
            // Crear entrada en historial
            ClassificationHistory::create([
                'classification_id' => $classification->id,
                'status' => 'Pendiente de Pago',
                'note' => 'Clasificación creada. Pendiente de verificación de pago',
                'changed_by' => $user->id,
            ]);
            
            // Asignar a clasificador con menos carga
            $this->assignClasificador($classification);

            // Generar PDF de factura (solo para usuarios que ven precios: Tarix o sin empresa)
            $pdfPath = null;
            $shouldAttachPdf = !$user->company_id || ($user->company && $user->company->isTarix());
            if ($shouldAttachPdf) {
                try {
                    $pdfPath = app(InvoicePdfService::class)->generateAndStore($classification);
                } catch (\Exception $e) {
                    \Log::error('Error generating invoice PDF on creation: ' . $e->getMessage());
                }
            }

            // Enviar email al usuario con radicado (con PDF si aplica)
            try {
                Mail::queue(new ClassificationCreatedMail($classification, $pdfPath));
            } catch (\Exception $e) {
                \Log::error('Error sending classification created email to user: ' . $e->getMessage());
            }

            // Enviar email al usuario EMPRESA si el cliente pertenece a una empresa (con PDF)
            if ($user->company_id) {
                $empresaUser = User::where('company_id', $user->company_id)
                    ->where('user_type', 'EMPRESA')
                    ->first();
                if ($empresaUser) {
                    // Generar PDF para EMPRESA si no se generó antes
                    if (!$pdfPath) {
                        try {
                            $pdfPath = app(InvoicePdfService::class)->generateAndStore($classification);
                        } catch (\Exception $e) {
                            \Log::error('Error generating invoice PDF for empresa: ' . $e->getMessage());
                        }
                    }
                    try {
                        Mail::queue(new EmpresaNewClassificationMail($classification, $empresaUser, $pdfPath));
                    } catch (\Exception $e) {
                        \Log::error('Error sending new classification email to empresa: ' . $e->getMessage());
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->route('user.classifications')
                ->with('success', "Clasificación creada exitosamente. Radicado: {$radicado}");
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear la clasificación: ' . $e->getMessage()]);
        }
    }

    /**
     * Ver detalle de clasificación (usuario)
     */
    public function show(Classification $classification)
    {
        $this->authorize('view', $classification);
        
        return view('user.classifications.show', compact('classification'));
    }

    /**
     * Mostrar búsqueda de trámites (Consulta de Trámites)
     */
    public function procedures(Request $request)
    {
        $radicado = $request->get('radicado');
        $classification = null;
        
        if ($radicado) {
            $user = Auth::user();

            if ($user->user_type === 'EMPRESA') {
                $companyUserIds = User::where('company_id', $user->company_id)
                    ->where('user_type', 'EXTERNO')
                    ->pluck('id');

                $classification = Classification::where('radicado', strtoupper($radicado))
                    ->whereIn('user_id', $companyUserIds)
                    ->first();
            } else {
                $classification = Classification::where('radicado', strtoupper($radicado))
                    ->where('user_id', $user->id)
                    ->first();
            }

            if (!$classification) {
                return back()->withErrors(['radicado' => 'Radicado no encontrado']);
            }
        }
        
        return view('user.procedures.index', compact('classification', 'radicado'));
    }

    /**
     * Generar radicado único (CLA + AÑO + CONSECUTIVO)
     * Ejemplo: CLA20260001
     */
    private function generateRadicado()
    {
        $year = date('Y');
        $lastClassification = Classification::whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();
        
        $consecutive = ($lastClassification ? (int)substr($lastClassification->radicado, -6) + 1 : 1);
        $radicado = 'CLA' . $year . str_pad($consecutive, 6, '0', STR_PAD_LEFT);
        
        // Verificar que sea único
        while (Classification::where('radicado', $radicado)->exists()) {
            $consecutive++;
            $radicado = 'CLA' . $year . str_pad($consecutive, 6, '0', STR_PAD_LEFT);
        }
        
        return $radicado;
    }

    /**
     * Asignar clasificación al clasificador con menos carga
     */
    private function assignClasificador(Classification $classification)
    {
        $clasificador = User::where('user_type', 'CLASIFICADOR')
            ->withCount('classifications')
            ->orderBy('classifications_count')
            ->first();
        
        if ($clasificador) {
            $classification->update(['clasificador_id' => $clasificador->id]);
            
            ClassificationHistory::create([
                'classification_id' => $classification->id,
                'status' => 'Asignado',
                'note' => "Asignado a clasificador: {$clasificador->name}",
            ]);
            
            // Enviar correo de notificación al clasificador
            try {
                Mail::queue(new ClassificationAssignedMail($classification));
            } catch (\Exception $e) {
                // Log the error but don't fail the classification creation
                \Log::error('Error sending classification assigned email: ' . $e->getMessage());
            }
        }
    }

    /**
     * Procesar archivo Excel masivo de ítems
     * Espera columnas: Nombre Comercial, Nombre Técnico, Materia Prima, Función/Uso, Destino, Código Arancelario, Observaciones
     */
    public function downloadTemplate()
    {
        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Configurar encabezados
            $headers = [
                'Nombre Comercial',
                'Nombre Técnico',
                'Materia Prima',
                'Función/Uso',
                'Destino/Aplicación',
                'Código Arancelario',
                'Observaciones'
            ];
            
            $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
            foreach ($headers as $index => $header) {
                $sheet->setCellValue($columns[$index] . '1', $header);
            }
            
            // Estilos para encabezado
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '667eea'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];
            
            $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
            
            // Ajustar ancho de columnas
            $sheet->getColumnDimension('A')->setWidth(25);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(18);
            $sheet->getColumnDimension('G')->setWidth(30);
            
            // Agregar ejemplo
            $sheet->setCellValue('A2', 'Zapatos deportivos Nike');
            $sheet->setCellValue('B2', 'Calzado deportivo sintético');
            $sheet->setCellValue('C2', 'Caucho, poliéster');
            $sheet->setCellValue('D2', 'Deporte, ocio');
            $sheet->setCellValue('E2', 'Venta minorista');
            $sheet->setCellValue('F2', '6403.99.90.00');
            $sheet->setCellValue('G2', 'Incluye suela de goma');
            
            // Generar archivo
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $filename = 'Plantilla_Clasificacion_' . date('Y-m-d_H-i-s') . '.xlsx';
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"{$filename}\"");
            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al generar la plantilla: ' . $e->getMessage()]);
        }
    }

    /**
     * Procesar archivo Excel masivo de ítems
     * Espera columnas: Nombre Comercial, Nombre Técnico, Materia Prima, Función/Uso, Destino, Código Arancelario, Observaciones
     */
    private function processBulkFile($file)
    {
        try {
            $extension = $file->getClientOriginalExtension();
            
            if ($extension === 'xlsx') {
                $reader = new XlsxReader();
            } else {
                $reader = new XlsReader();
            }
            
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
            
            $items = [];
            
            // Saltar encabezado (fila 1) y procesar desde fila 2
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                
                // Saltar filas vacías
                if (empty($row[0])) {
                    continue;
                }
                
                $items[] = [
                    'commercial_name' => $row[0] ?? '',
                    'technical_name' => $row[1] ?? '',
                    'matter' => $row[2] ?? '',
                    'function' => $row[3] ?? '',
                    'destination' => $row[4] ?? '',
                    'suggested_tariff' => $row[5] ?? '',
                    'observations' => $row[6] ?? '',
                ];
            }
            
            return $items;
        } catch (\Exception $e) {
            throw new \Exception('Error al procesar el archivo Excel: ' . $e->getMessage());
        }
    }
    
    /**
     * Show corrections for an item
     */
    public function showCorrections(Classification $classification, ClassificationItem $item)
    {
        // Verify user owns this classification
        if ($classification->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($item->classification_id !== $classification->id) {
            abort(404);
        }
        
        $corrections = $item->corrections()->orderByDesc('created_at')->get();
        
        return view('user.classifications.corrections', compact('classification', 'item', 'corrections'));
    }
    
    /**
     * Respond to a correction request
     */
    public function respondCorrection(Request $request, Classification $classification, ClassificationItem $item, ItemCorrection $correction)
    {
        // Verify user owns this classification
        if ($classification->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($item->classification_id !== $classification->id || $correction->classification_item_id !== $item->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'client_response' => 'required|string|max:2000',
            'attachments.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png'
        ]);
        
        // Update correction with client response
        $correction->update([
            'client_response' => $validated['client_response'],
            'status' => 'respondido'
        ]);
        
        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Generar nombre único preservando extensión original
                $extension = $file->getClientOriginalExtension();
                $hashName = uniqid() . '_' . time() . '.' . $extension;
                $path = $file->storeAs("classifications/{$classification->id}/corrections/{$item->id}", $hashName, 'public');
                
                \App\Models\CorrectionAttachment::create([
                    'item_correction_id' => $correction->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'type' => 'cliente'
                ]);
            }
        }
        
        // Update item status back to Pendiente for re-verification
        $item->update(['status' => 'Pendiente']);
        
        // Record history
        ClassificationHistory::create([
            'classification_id' => $classification->id,
            'status' => 'Item Respondido',
            'note' => 'Cliente respondió a solicitud de corrección del ítem: ' . $item->commercial_name,
            'changed_by' => Auth::id()
        ]);

        // Notificar al clasificador que el cliente respondió
        try {
            Mail::queue(new CorrectionRespondedMail($item, $correction));
        } catch (\Exception $e) {
            \Log::error('Error sending correction responded email to clasificador: ' . $e->getMessage());
        }

        return redirect()->route('user.classifications.show', $classification)
            ->with('success', 'Respuesta enviada. El clasificador revisará los cambios.');
    }

    /**
     * Descargar archivo adjunto de clasificación con headers MIME correctos
     */
    public function downloadAttachment($attachmentId)
    {
        $attachment = ClassificationAttachment::find($attachmentId);
        
        if (!$attachment) {
            abort(404, 'Archivo no encontrado');
        }
        
        // Verificar acceso: solo el usuario propietario o clasificador pueden descargar
        $user = Auth::user();
        $classification = $attachment->classificationItem->classification;
        
        if ($user->id !== $classification->user_id && $user->id !== $classification->clasificador_id && $user->user_type !== 'ADMIN') {
            abort(403, 'No tienes permiso para descargar este archivo');
        }
        
        $filePath = Storage::disk('public')->path($attachment->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'El archivo no existe en el servidor');
        }
        
        // Determinar el tipo MIME basado en la extensión
        $extension = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'txt' => 'text/plain',
        ];
        
        $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';
        
        return response()->download(
            $filePath,
            $attachment->file_name,
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $attachment->file_name . '"'
            ]
        );
    }

    /**
     * Descargar archivo adjunto de corrección con headers MIME correctos
     */
    public function downloadCorrectionAttachment($attachmentId)
    {
        $attachment = CorrectionAttachment::find($attachmentId);
        
        if (!$attachment) {
            abort(404, 'Archivo no encontrado');
        }
        
        // Verificar acceso: solo el usuario propietario o clasificador pueden descargar
        $user = Auth::user();
        $classification = $attachment->itemCorrection->item->classification;
        
        if ($user->id !== $classification->user_id && $user->id !== $classification->clasificador_id && $user->user_type !== 'ADMIN') {
            abort(403, 'No tienes permiso para descargar este archivo');
        }
        
        $filePath = Storage::disk('public')->path($attachment->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'El archivo no existe en el servidor');
        }
        
        // Determinar el tipo MIME basado en la extensión
        $extension = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'txt' => 'text/plain',
        ];
        
        $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';
        
        return response()->download(
            $filePath,
            $attachment->file_name,
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $attachment->file_name . '"'
            ]
        );
    }
}
