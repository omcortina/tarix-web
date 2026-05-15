@extends('layouts.admin')

@section('title', 'Editar Artículo')

@section('extra_css')
<style>
    .admin-container { max-width: 100%; }
    .admin-header h1 { font-size: 28px; color: #0d2340; margin-bottom: 30px; }
    .form-card { background: white; border-radius: 8px; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 24px; }
    .form-group label { display: block; font-weight: 600; color: #0d2340; margin-bottom: 8px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-input, .form-textarea, .form-select { width: 100%; padding: 12px 16px; border: 1.5px solid #dce4ef; border-radius: 6px; font-size: 14px; font-family: 'Inter', sans-serif; transition: border-color 0.2s; }
    .form-input:focus, .form-textarea:focus, .form-select:focus { outline: none; border-color: #22c5bc; }
    .form-textarea { min-height: 300px; resize: vertical; }
    .form-checkbox { margin-top: 20px; }
    .form-checkbox input { margin-right: 8px; width: 18px; height: 18px; cursor: pointer; }
    .form-checkbox label { display: inline-block; font-weight: 500; color: #333; text-transform: none; letter-spacing: normal; font-size: 14px; }
    .form-error { color: #ff6b6b; font-size: 12px; margin-top: 4px; }
    .form-actions { display: flex; gap: 12px; margin-top: 40px; padding-top: 30px; border-top: 2px solid #f0f0f0; }
    .btn { padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-block; }
    .btn-primary { background: #22c5bc; color: white; }
    .btn-primary:hover { background: #1ba8a0; }
    .btn-secondary { background: #e0e0e0; color: #333; }
    .btn-secondary:hover { background: #d0d0d0; }
    .media-section { background: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 6px; padding: 20px; margin-bottom: 24px; }
    .media-section h3 { color: #0d2340; font-size: 16px; margin-bottom: 16px; }
</style>
@endsection

@section('content')
@include('admin.articles._form')
@endsection

@section('extra_js')
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const imageUrl = document.getElementById('media_image_url').value.trim();
        const youtubeUrl = document.getElementById('media_youtube_url').value.trim();
        if (imageUrl && youtubeUrl) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                html: 'Por favor completa solo <strong>UNA URL</strong>:<br>- URL de Imagen<br>- O URL de YouTube<br><br>(No ambas)',
                confirmButtonColor: '#22c5bc',
                confirmButtonText: 'Entendido'
            });
            return false;
        }
    });
</script>
@endsection
