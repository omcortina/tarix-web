<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\ClassificationItem;
use App\Models\ClassificationHistory;
use App\Models\ItemCorrection;
use App\Mail\CorrectionRequestedMail;
use App\Mail\ClassificationApprovedMail;
use App\Mail\EmpresaPaymentVerifiedMail;
use App\Mail\EmpresaClassificationApprovedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ClassificadorController extends Controller
{
    /**
     * List all classifications assigned to this clasificador
     */
    public function index()
    {
        $clasificador = Auth::user();
        
        $classifications = Classification::where('clasificador_id', $clasificador->id)
            ->orderByDesc('created_at')
            ->paginate(6);
        
        return view('admin.classifications.clasificador-dashboard', [
            'classifications' => $classifications,
            'clasificador' => $clasificador
        ]);
    }

    /**
     * Show a classification for verification
     */
    public function show(Classification $classification)
    {
        $this->authorize('verify', $classification);
        
        return view('admin.classifications.show-for-verificacion', [
            'classification' => $classification
        ]);
    }

    /**
     * Verify an item (mark as Verificado)
     */
    public function verifyItem(Request $request, Classification $classification, ClassificationItem $item)
    {
        $this->authorize('verify', $classification);
        
        if ($item->classification_id !== $classification->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'final_tariff' => 'required|string|max:50',
            'clasificador_observations' => 'nullable|string|max:2000',
        ]);
        
        $item->update([
            'status' => 'Verificado',
            'final_tariff' => $validated['final_tariff'],
            'clasificador_observations' => $validated['clasificador_observations'],
        ]);
        
        // Record history
        ClassificationHistory::create([
            'classification_id' => $classification->id,
            'status' => 'Item Verificado',
            'note' => 'Ítem #' . ($classification->items->search(fn($i) => $i->id === $item->id) + 1) . ' verificado con subpartida: ' . $validated['final_tariff'],
            'changed_by' => Auth::id()
        ]);
        
        return redirect()->route('clasificador.show', $classification)
            ->with('success', 'Ítem verificado exitosamente con subpartida: ' . $validated['final_tariff']);
    }

    /**
     * Reject an item (mark as Devolución)
     */
    public function rejectItem(Request $request, Classification $classification, ClassificationItem $item)
    {
        $this->authorize('verify', $classification);
        
        if ($item->classification_id !== $classification->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'revision_note' => 'required|string|max:1000'
        ]);
        
        $item->update([
            'status' => 'Devolución',
            'revision_note' => $validated['revision_note']
        ]);
        
        // Create correction record
        $correction = ItemCorrection::create([
            'classification_item_id' => $item->id,
            'requested_by' => Auth::id(),
            'observations' => $validated['revision_note'],
            'status' => 'pendiente'
        ]);
        
        // Update classification status to pending revision
        $classification->update([
            'status' => 'En proceso'
        ]);
        
        // Send correction email to client
        try {
            Mail::queue(new CorrectionRequestedMail($item, $correction));
        } catch (\Exception $e) {
            \Log::error('Error sending correction requested email: ' . $e->getMessage());
        }
        
        // Record history
        ClassificationHistory::create([
            'classification_id' => $classification->id,
            'status' => 'Item en Devolución',
            'note' => 'Ítem devuelto para corrección: ' . $validated['revision_note'],
            'changed_by' => Auth::id()
        ]);
        
        return redirect()->route('clasificador.show', $classification)
            ->with('success', 'Ítem rechazado. El usuario recibirá notificación de la corrección requerida');
    }

    /**
     * Approve the entire classification (only if all items are Verificado)
     */
    public function approve(Request $request, Classification $classification)
    {
        $this->authorize('verify', $classification);
        
        // Check if all items are verified
        $unverifiedItems = $classification->items()
            ->where('status', '!=', 'Verificado')
            ->count();
        
        if ($unverifiedItems > 0) {
            return redirect()->route('clasificador.show', $classification)
                ->with('error', 'No se puede aprobar. Todos los ítems deben estar verificados primero');
        }
        
        $classification->update([
            'status' => 'Aprobado'
        ]);

        $cliente = $classification->user;

        // Send approval email to client (sin PDF — ya se envió al crear)
        try {
            Mail::queue(new ClassificationApprovedMail($classification));
        } catch (\Exception $e) {
            \Log::error('Error sending classification approved email: ' . $e->getMessage());
        }

        // Send approval email to empresa user if applicable (sin PDF — ya se envió al crear)
        if ($cliente->company_id) {
            $empresaUser = User::where('company_id', $cliente->company_id)
                ->where('user_type', 'EMPRESA')
                ->first();
            if ($empresaUser) {
                try {
                    Mail::queue(new EmpresaClassificationApprovedMail($classification, $empresaUser));
                } catch (\Exception $e) {
                    \Log::error('Error sending approved email to empresa: ' . $e->getMessage());
                }
            }
        }
        
        // Record history
        ClassificationHistory::create([
            'classification_id' => $classification->id,
            'status' => 'Aprobado',
            'note' => 'Clasificación completamente verificada y aprobada',
            'changed_by' => Auth::id()
        ]);
        
        return redirect()->route('clasificador.show', $classification)
            ->with('success', 'Clasificación aprobada exitosamente. Se ha notificado al cliente por correo');
    }

    /**
     * Verify payment for a classification
     */
    public function verifyPayment(Classification $classification)
    {
        $this->authorize('verify', $classification);
        
        $classification->update([
            'payment_verified' => true,
            'payment_verified_at' => now(),
            'status' => 'En Proceso'
        ]);
        
        // Record history
        ClassificationHistory::create([
            'classification_id' => $classification->id,
            'status' => 'Pago Verificado',
            'note' => 'Pago del cliente verificado. Iniciando revisión de ítems',
            'changed_by' => Auth::id()
        ]);
        
        // Notificar al usuario EMPRESA sobre la verificación del pago
        $cliente = $classification->user;
        if ($cliente->company_id) {
            $empresaUser = User::where('company_id', $cliente->company_id)
                ->where('user_type', 'EMPRESA')
                ->first();
            if ($empresaUser) {
                try {
                    Mail::queue(new EmpresaPaymentVerifiedMail($classification, $empresaUser));
                } catch (\Exception $e) {
                    \Log::error('Error sending payment verified email to empresa: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('clasificador.show', $classification)
            ->with('success', 'Pago verificado. Ahora puedes proceder con la verificación de ítems');
    }
}
