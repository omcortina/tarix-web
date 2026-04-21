<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artículos | Admin - TARIX</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        body { background: #f5f7fa; font-family: 'Inter', sans-serif; }
        .admin-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .admin-header h1 { font-size: 28px; color: #0d2340; margin: 0; }
        .btn-new { padding: 10px 20px; background: #22c5bc; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; }
        .btn-new:hover { background: #1ba8a0; }
        .breadcrumb { font-size: 14px; color: #666; margin-bottom: 20px; }
        .breadcrumb a { color: #22c5bc; text-decoration: none; margin: 0 5px; }
        .articles-table { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .table { width: 100%; border-collapse: collapse; }
        .table th { background: #f8f9fa; padding: 16px; text-align: left; font-weight: 600; color: #0d2340; border-bottom: 1px solid #e0e0e0; }
        .table td { padding: 16px; border-bottom: 1px solid #e0e0e0; }
        .table tr:hover { background: #f8f9fa; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-published { background: #e8f5e9; color: #2e7d32; }
        .badge-draft { background: #fff3e0; color: #e65100; }
        .btn-edit { padding: 6px 12px; background: #0066cc; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; }
        .btn-edit:hover { background: #0052a3; }
        .btn-delete { padding: 6px 12px; background: #ff6b6b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; }
        .btn-delete:hover { background: #ff5252; }
        .empty-state { text-align: center; padding: 60px 20px; color: #999; }
        .pagination { margin-top: 30px; display: flex; justify-content: center; gap: 5px; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #0066cc; }
        .pagination .active { background: #0066cc; color: white; border-color: #0066cc; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="admin-container">
        <div style="margin-bottom: 20px; display: flex; gap: 8px; align-items: center; font-size: 14px; color: #666;">
            <a href="{{ route('admin.dashboard') }}" style="color: #22c5bc; text-decoration: none; font-weight: 600;">
                Dashboard
            </a>
            <span>/</span>
            <span>Artículos</span>
        </div>

        <div class="admin-header">
            <h1>Artículos</h1>
            <a href="{{ route('admin.articles.create') }}" class="btn-new">+ Nuevo Artículo</a>
        </div>

        @if($articles->count())
            <div class="articles-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Título</th>
                            <th style="width: 25%;">Autor</th>
                            <th style="width: 15%;">Estado</th>
                            <th style="width: 20%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td><strong>{{ $article->title }}</strong></td>
                                <td>{{ $article->user->name ?? 'Admin' }}</td>
                                <td>
                                    <span class="badge {{ $article->published ? 'badge-published' : 'badge-draft' }}">
                                        {{ $article->published ? 'Publicado' : 'Borrador' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn-edit">Editar</a>
                                    <form id="deleteForm-{{ $article->id }}" action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display:inline;">
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

            <div class="pagination">
                {{ $articles->links() }}
            </div>
        @else
            <div class="empty-state">
                <p>No hay artículos publicados aún.</p>
                <a href="{{ route('admin.articles.create') }}" class="btn-new" style="margin-top: 20px; display: inline-block;">Crear el primer artículo</a>
            </div>
        @endif
    </div>

    <script>
        function confirmDelete(event, itemId, itemType) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas eliminar este ' + itemType + '? Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + itemId).submit();
                }
            });
        }
    </script>
</body>
</html>
