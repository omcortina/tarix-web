@extends('layouts.admin')

@section('title', 'Artículos')

@section('extra_css')
<style>
    .admin-header { display: flex; justify-content: space-between; align-items: center; }
    .admin-header h1 { font-size: 32px; }
    .articles-table { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .badge-published { background: #e8f5e9; color: #2e7d32; }
    .badge-draft { background: #fff3e0; color: #e65100; }
    .comment-badge { display: inline-block; background: #e3f2fd; color: #1565c0; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .comment-badge:hover { background: #bbdefb; }
    .comment-badge.has-pending { background: #fff3cd; color: #856404; }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">Dashboard</a>
        <span>/</span>
        <span>Artículos</span>
    </div>

    <div class="admin-header">
        <h1>Gestionar Artículos</h1>
        <a href="{{ route('admin.articles.create') }}" class="btn-new">+ Nuevo Artículo</a>
    </div>

    @if($articles->count())
        <div class="articles-table">
            <table class="table" id="adminTable">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Estado</th>
                        <th style="text-align:center;">Visualizaciones</th>
                        <th>Comentarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td title="{{ $article->title }}">{{ Str::limit($article->title, 50) }}</td>
                            <td>{{ $article->user->name ?? 'Admin' }}</td>
                            <td>
                                <span class="badge {{ $article->published ? 'badge-published' : 'badge-draft' }}">
                                    {{ $article->published ? 'Publicado' : 'Borrador' }}
                                </span>
                            </td>
                            <td style="text-align:center;">
                                <span style="display: inline-flex; align-items: center; gap: 5px; font-weight: 600; color: #555;">
                                    <i class="fa fa-eye" style="color: #22c5bc;"></i>
                                    {{ number_format($article->views) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $total_comments = $article->comments()->count();
                                    $pending_comments = $article->comments()->where('status', 'pending')->count();
                                    $has_pending = $pending_comments > 0;
                                @endphp
                                <a href="{{ route('admin.articles.comments') . '?article=' . $article->id }}" 
                                   class="comment-badge {{ $has_pending ? 'has-pending' : '' }}"
                                   title="{{ $pending_comments > 0 ? $pending_comments . ' comentario(s) pendiente(s)' : 'Ver comentarios' }}">
                                    @if($total_comments > 0)
                                        Total comentarios: {{ $total_comments }} 
                                        @if($has_pending)<span style="font-weight: 800;">({{ $pending_comments }} sin revisar)</span>@endif
                                    @else
                                        <span style="opacity: 0.6;">Sin comentarios</span>
                                    @endif
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.articles.edit', $article) }}" class="btn-edit">Editar</a>
                                <form id="deleteForm-{{ $article->id }}" action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display:inline; margin-top: 4px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete" onclick="confirmDelete(event, '{{ $article->id }}', 'artículo')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p>No hay artículos publicados aún.</p>
            <a href="{{ route('admin.articles.create') }}" class="btn-new" style="margin-top: 20px; display: inline-block;">Crear el primer artículo</a>
        </div>
    @endif
</div>
@endsection
