@extends('layouts.user')

@section('title', 'Clasificaciones')

@section('page_title', 'Mis Clasificaciones Arancelarias')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('css/classifications-index.css') }}">
@endsection

@section('content')
    <div class="classifications-container">
        <div class="header-section">
            <a href="{{ route('user.classifications.create') }}" class="btn btn-primary">
                Nueva Clasificación
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @if ($errors->has('error'))
                    <strong>Error:</strong> {{ $errors->first('error') }}
                @else
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        @if ($classifications->count() > 0)
            <div class="classifications-grid">
                @foreach ($classifications as $classification)
                    @php
                        $displayStatus = $classification->status;
                        if (!auth()->user()->canSeePrices() && $displayStatus === 'Pendiente de pago') {
                            $displayStatus = 'En Revisión';
                        }
                    @endphp
                    <div class="classification-card">
                        <div class="card-header">
                            <div class="radicado">
                                <strong>{{ $classification->radicado }}</strong>
                            </div>
                            <span class="status-badge status-{{ str_replace(' ', '-', strtolower($displayStatus)) }}">
                                {{ $displayStatus }}
                            </span>
                        </div>

                        <div class="card-body">
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

                            <div class="info-row">
                                <span class="label">Ítems:</span>
                                <span class="value">{{ $classification->items->count() }}</span>
                            </div>

                            @if(auth()->user()->canSeePrices())
                            <div class="info-row">
                                <span class="label">Costo Total:</span>
                                <span class="value strong">${{ number_format($classification->total_cost, 0, ',', '.') }}</span>
                            </div>
                            @endif

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

                        <div class="card-footer">
                            <a href="{{ route('user.classifications.show', $classification) }}" class="btn btn-primary">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($classifications->hasPages())
                <div class="pagination-container">
                    {{ $classifications->links('vendor.pagination.custom') }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <h2>Sin clasificaciones aún</h2>
                <p>No tienes clasificaciones arancelarias registradas.</p>
                <a href="{{ route('user.classifications.create') }}" class="btn btn-primary">
                    Crear tu primera clasificación
                </a>
            </div>
        @endif
    </div>
@endsection
