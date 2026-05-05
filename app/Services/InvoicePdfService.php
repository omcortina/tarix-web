<?php

namespace App\Services;

use App\Models\Classification;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicePdfService
{
    /**
     * Generate PDF invoice for a classification and return it as a string.
     */
    public function generate(Classification $classification): string
    {
        $classification->loadMissing(['user.company', 'items', 'clasificador']);

        $pdf = Pdf::loadView('emails.invoice-pdf', [
            'classification' => $classification,
            'cliente'        => $classification->user,
        ])->setPaper('a4', 'portrait');

        return $pdf->output();
    }

    /**
     * Generate PDF and save to storage, returning the path.
     */
    public function generateAndStore(Classification $classification): string
    {
        $content  = $this->generate($classification);
        $filename = "factura-{$classification->radicado}.pdf";
        $path     = "invoices/{$filename}";

        \Storage::disk('local')->put($path, $content);

        return storage_path("app/{$path}");
    }
}
