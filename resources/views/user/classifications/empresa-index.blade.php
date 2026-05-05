@extends('layouts.user')

@section('title', 'Clasificaciones de la empresa')

@section('page_title', 'Clasificaciones de la empresa')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('css/classifications-index.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .empresa-filters {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            display: flex;
            align-items: flex-end;
            gap: 16px;
            flex-wrap: wrap;
        }
        .empresa-filters .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .empresa-filters label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .empresa-filters select {
            padding: 8px 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            min-width: 200px;
            color: #333;
        }
        .empresa-filters .btn-filter {
            padding: 8px 20px;
            background: #22c5bc;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }
        .empresa-filters .btn-clear {
            padding: 8px 16px;
            background: #f0f0f0;
            color: #555;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }
        .totales-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .total-card {
            background: white;
            border-radius: 8px;
            padding: 18px 20px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            border-left: 4px solid #22c5bc;
        }
        .total-card .total-label {
            font-size: 11px;
            font-weight: 600;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .total-card .total-value {
            font-size: 20px;
            font-weight: 700;
            color: #0d2340;
        }
        .total-card .total-sub {
            font-size: 12px;
            color: #aaa;
            margin-top: 2px;
        }
        .empresa-table-wrap {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .empresa-table {
            width: 100%;
            border-collapse: collapse;
        }
        .empresa-table th {
            background: #f8f9fa;
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #eee;
        }
        .empresa-table td {
            padding: 14px 16px;
            font-size: 14px;
            color: #333;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        .empresa-table tr:last-child td {
            border-bottom: none;
        }
        .empresa-table tr:hover td {
            background: #fafafa;
        }
        .user-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }
        .user-avatar-sm {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #22c5bc;
            color: white;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .cost-highlight {
            font-weight: 700;
            color: #0d2340;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #aaa;
        }
        .empty-state i {
            font-size: 40px;
            margin-bottom: 16px;
            display: block;
        }
        /* DataTables layout */
        .dt-wrapper { width: 100%; padding: 20px; display: flex; flex-direction: column; }
        .dt-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            padding-bottom: 16px;
        }
        .dt-controls { display: flex; gap: 15px; align-items: center; flex-wrap: wrap; }
        .dt-length { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #555; }
        .dt-length select {
            padding: 8px 12px;
            border: 1px solid #dce4ef;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            background: white;
            transition: all 0.2s;
        }
        .dt-length select:focus { outline: none; border-color: #22c5bc; box-shadow: 0 0 0 3px rgba(34,197,188,0.15); }
        .dt-search { flex: 1; min-width: 200px; display: flex; align-items: center; gap: 8px; font-size: 14px; color: #555; }
        .dt-search input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #dce4ef;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s;
        }
        .dt-search input:focus { outline: none; border-color: #22c5bc; box-shadow: 0 0 0 3px rgba(34,197,188,0.15); }
        .dt-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            padding-top: 16px;
            border-top: 1px solid #f0f0f0;
            margin-top: 4px;
        }
        .dt-info { font-size: 13px; color: #888; }
        .dt-pagination { display: flex; justify-content: flex-end; }
        ul.pagination-custom {
            list-style: none;
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            padding: 0;
            margin: 0;
        }
        ul.pagination-custom li.page-item { display: inline-block; }
        ul.pagination-custom li.page-item a.page-link,
        ul.pagination-custom li.page-item span.page-link {
            display: inline-block;
            padding: 8px 13px;
            border: 1.5px solid #dce4ef;
            border-radius: 6px;
            background: white;
            color: #22c5bc;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 36px;
            text-align: center;
            line-height: 1;
        }
        ul.pagination-custom li.page-item a.page-link:hover {
            background: #e0fafa;
            border-color: #22c5bc;
        }
        ul.pagination-custom li.page-item.active span.page-link {
            background: #22c5bc;
            color: white;
            border-color: #22c5bc;
            font-weight: 600;
        }
        ul.pagination-custom li.page-item.disabled span.page-link {
            opacity: 0.4;
            cursor: not-allowed;
            background: #f5f5f5;
            color: #999;
            border-color: #ddd;
        }
        /* tabla dentro del dt-wrapper */
        #empresaTable { width: 100% !important; min-width: 700px; }
        #empresaTable thead th {
            background: #f8f9fa;
            color: #555;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border-bottom: 2px solid #e0e0e0;
        }
        #empresaTable tbody td { padding: 14px 16px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
        #empresaTable tbody tr:last-child td { border-bottom: none; }
        #empresaTable tbody tr:hover td { background: #fafafa; }
    </style>
@endsection

@section('content')
<div class="classifications-container">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tarjetas resumen -->
    <div class="totales-bar">
        <div class="total-card">
            <div class="total-label">Total Clasificaciones</div>
            <div class="total-value">{{ $classifications->count() }}</div>
            <div class="total-sub">{{ $selectedUserId ? 'del usuario filtrado' : 'de todos los usuarios' }}</div>
        </div>
        @foreach ($totalesPorUsuario as $totUsuario)
            <div class="total-card" style="border-color: #667eea;">
                <div class="total-label">{{ $totUsuario->user->name }}</div>
                <div class="total-value">${{ number_format($totUsuario->total, 0, ',', '.') }}</div>
                <div class="total-sub">{{ $totUsuario->cantidad }} clasificación(es)</div>
            </div>
        @endforeach
    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('user.empresa.classifications') }}" class="empresa-filters">
        <div class="filter-group">
            <label>Filtrar por Usuario</label>
            <select name="user_id">
                <option value="">Todos los usuarios</option>
                @foreach ($companyUsers as $cu)
                    <option value="{{ $cu->id }}" @selected($selectedUserId == $cu->id)>
                        {{ $cu->name }} ({{ $cu->email }})
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-filter">Filtrar</button>
        @if ($selectedUserId)
            <a href="{{ route('user.empresa.classifications') }}" class="btn-clear">Limpiar</a>
        @endif
    </form>

    <!-- Tabla de clasificaciones -->
    <div class="empresa-table-wrap">
        @if ($classifications->count() > 0)
            <table class="empresa-table" id="empresaTable">
                <thead>
                    <tr>
                        <th>Radicado</th>
                        <th>Usuario</th>
                        <th>Tipo</th>
                        <th>Items</th>
                        <th>Total a Pagar</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classifications as $classification)
                        <tr>
                            <td><strong>{{ $classification->radicado }}</strong></td>
                            <td>
                                <div class="user-badge">
                                    <div class="user-avatar-sm">
                                        {{ strtoupper(substr($classification->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 13px;">{{ $classification->user->name }}</div>
                                        <div style="font-size: 11px; color: #aaa;">{{ $classification->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $classification->type === 'general' ? 'Mercancía General' : 'Unidad Funcional' }}
                            </td>
                            <td style="text-align: center;">{{ $classification->items->count() }}</td>
                            <td>
                                <span class="cost-highlight">${{ number_format($classification->total_cost, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ str_replace(' ', '-', strtolower($classification->status)) }}">
                                    {{ $classification->status }}
                                </span>
                            </td>
                            <td style="font-size: 12px; color: #aaa;">
                                {{ $classification->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                <a href="{{ route('user.classifications.show', $classification) }}" 
                                   style="color: #22c5bc; font-size: 13px; font-weight: 600; text-decoration: none;">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <div class="empty-state">
                <i class="fa fa-inbox"></i>
                <p>No hay clasificaciones registradas{{ $selectedUserId ? ' para este usuario' : '' }}.</p>
            </div>
        @endif
    </div>

</div>

@section('extra_js')
<script>
$(document).ready(function() {
    $('#empresaTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        order: [],
        ordering: false,
        dom: '<"dt-wrapper"<"dt-head"<"dt-controls"<"dt-length"l><"dt-search"f>>>tr<"dt-footer"<"dt-info"i><"dt-pagination"p>>>',
        drawCallback: function() {
            $('ul.pagination').addClass('pagination-custom');
            $('ul.pagination li').each(function() {
                $(this).addClass('page-item');
                $(this).find('a, span').addClass('page-link');
            });
        }
    });
});
</script>
@endsection
@endsection
