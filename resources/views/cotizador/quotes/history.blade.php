@extends('layouts.cotizador')

@section('title', 'Historial de Cotizaciones')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">Historial de Cotizaciones</h1>
    <a href="{{ route('cotizador.quotes.send') }}" class="btn-primary">
        <i class="fa fa-plus"></i> Nueva Cotización
    </a>
</div>

@if($quotes->isEmpty())
    <div class="form-card">
        <div class="empty-state">
            <i class="fa fa-paper-plane-o"></i>
            <p>Aún no has enviado ninguna cotización.</p>
        </div>
    </div>
@else
    <div class="form-card" style="padding: 0; overflow: hidden;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Destinatario</th>
                    <th>Asunto</th>
                    <th>Cuenta usada</th>
                    <th>PDF</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotes as $quote)
                <tr>
                    <td>{{ $quote->id }}</td>
                    <td>
                        <div>{{ $quote->to_name ?: $quote->to_email }}</div>
                        <small class="text-muted">{{ $quote->to_email }}</small>
                    </td>
                    <td>{{ Str::limit($quote->subject, 55) }}</td>
                    <td>{{ $quote->emailAccount->name ?? '-' }}</td>
                    <td>
                        @if($quote->pdf_path)
                            <span class="badge badge-info"><i class="fa fa-file-pdf-o"></i> Adjunto</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($quote->success)
                            <span class="badge badge-success">Enviado</span>
                        @else
                            <span class="badge badge-danger" title="{{ $quote->error_message }}">Error</span>
                        @endif
                    </td>
                    <td>{{ $quote->sent_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $quotes->links() }}
    </div>
@endif
@endsection
