@extends('layouts.admin')

@section('title', 'Moderación de Comentarios')

@section('page_title', 'Comentarios de Artículos')

@section('content')
<div class="comments-moderation">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h2 style="margin: 0;">Comentarios Pendientes y Aprobados</h2>
            @if(request('article'))
                @php $article = \App\Models\Article::find(request('article')); @endphp
                @if($article)
                    <p style="color: #666; font-size: 14px; margin-top: 5px;">
                        Artículo: <strong>{{ $article->title }}</strong>
                        <a href="{{ route('admin.articles.comments') }}" style="margin-left: 15px; color: #667eea; text-decoration: none; font-weight: 600;">Ver todos</a>
                    </p>
                @endif
            @endif
        </div>
    </div>
    
    @if (session('success'))
        <div style="background: #e8f5e9; border-left: 4px solid #4CAF50; padding: 15px; border-radius: 4px; margin-bottom: 20px; color: #2e7d32;">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Pending Comments -->
    <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <div style="background: #fff3cd; padding: 15px 20px; border-bottom: 1px solid #ffeaa7;">
            <h3 style="margin: 0; color: #856404; font-size: 16px;">Comentarios Pendientes de Respuesta</h3>
        </div>
        
        @php
            $pendingComments = \App\Models\ArticleComment::where('status', 'pending')
                ->with('article', 'replies');
            
            if(request('article')) {
                $pendingComments = $pendingComments->where('article_id', request('article'));
            }
            
            $pendingComments = $pendingComments->orderByDesc('created_at')->get();
        @endphp
        
        @if ($pendingComments->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f5f5f5; border-bottom: 2px solid #e0e0e0;">
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Comentario</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Artículo</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Autor</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingComments as $comment)
                            <tr style="border-bottom: 1px solid #e0e0e0; hover: background: #f9f9f9;">
                                <td style="padding: 12px;">
                                    <p style="margin: 0; color: #333; font-size: 14px;">{{ Str::limit($comment->content, 80) }}</p>
                                    <small style="color: #999;">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td style="padding: 12px;">
                                    <a href="{{ route('articles.show', $comment->article) }}" target="_blank" style="color: #667eea; text-decoration: none;">
                                        {{ Str::limit($comment->article->title, 50) }}
                                    </a>
                                </td>
                                <td style="padding: 12px;">
                                    <div style="font-size: 14px;">
                                        <p style="margin: 0; font-weight: 600;">{{ $comment->author_name }}</p>
                                        <small style="color: #999;">{{ $comment->author_email }}</small>
                                    </div>
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    <button type="button" onclick="openReplyModal({{ $comment->id }}, '{{ addslashes($comment->author_name) }}')" 
                                        style="background: #667eea; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; margin-right: 5px;">
                                        Responder
                                    </button>
                                    <form action="{{ route('admin.articles.comments.reject', $comment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" onclick="return confirm('¿Rechazar este comentario?')"
                                            style="background: #f44336; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                            Rechazar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="padding: 20px; text-align: center; color: #666;">
                No hay comentarios pendientes
            </div>
        @endif
    </div>
    
    <!-- Approved Comments -->
    <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="background: #e8f5e9; padding: 15px 20px; border-bottom: 1px solid #c8e6c9;">
            <h3 style="margin: 0; color: #2e7d32; font-size: 16px;">Comentarios Aprobados (Con Respuesta)</h3>
        </div>
        
        @php
            $approvedComments = \App\Models\ArticleComment::where('status', 'approved')
                ->with('article', 'replies');
            
            if(request('article')) {
                $approvedComments = $approvedComments->where('article_id', request('article'));
            }
            
            $approvedComments = $approvedComments->orderByDesc('created_at')->get();
        @endphp
        
        @if ($approvedComments->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f5f5f5; border-bottom: 2px solid #e0e0e0;">
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Comentario</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Artículo</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600;">Respuestas</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($approvedComments as $comment)
                            <tr style="border-bottom: 1px solid #e0e0e0;">
                                <td style="padding: 12px;">
                                    <p style="margin: 0; color: #333; font-size: 14px;">{{ Str::limit($comment->content, 80) }}</p>
                                    <small style="color: #999;">{{ $comment->author_name }} • {{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td style="padding: 12px;">
                                    <a href="{{ route('articles.show', $comment->article) }}" target="_blank" style="color: #667eea; text-decoration: none;">
                                        {{ Str::limit($comment->article->title, 50) }}
                                    </a>
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 3px; font-size: 12px; font-weight: 600;">
                                        {{ $comment->replies->count() }}
                                    </span>
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    <button type="button" onclick="openReplyModal({{ $comment->id }}, '{{ addslashes($comment->author_name) }}')" 
                                        style="background: #667eea; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; margin-right: 5px;">
                                        + Respuesta
                                    </button>
                                    <form action="{{ route('admin.articles.comments.destroy', $comment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Eliminar este comentario?')"
                                            style="background: #f44336; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="padding: 20px; text-align: center; color: #666;">
                No hay comentarios aprobados
            </div>
        @endif
    </div>
</div>

<!-- Reply Modal -->
<div id="replyModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
    <div style="background-color: white; margin: 10% auto; padding: 30px; border-radius: 8px; width: 90%; max-width: 500px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
        <span onclick="closeReplyModal()" style="color: #999; float: right; font-size: 28px; font-weight: bold; cursor: pointer; line-height: 20px;">×</span>
        
        <h2 style="margin: 0 0 20px 0; color: #1a2e44;">Responder a Comentario</h2>
        
        <div id="commentAuthor" style="background: #f5f5f5; padding: 12px; border-radius: 4px; margin-bottom: 15px; font-size: 13px; color: #666;"></div>
        
        <form id="replyForm" method="POST" style="display: none;">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #333;">Respuesta *</label>
                <textarea 
                    id="reply_content" 
                    name="content" 
                    placeholder="Escribe la respuesta..." 
                    rows="6"
                    required
                    maxlength="2000"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: inherit; resize: vertical;"></textarea>
                <small style="color: #999; display: block; margin-top: 4px;">Máximo 2000 caracteres</small>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeReplyModal()" 
                    style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 4px; cursor: pointer; font-weight: 600; color: #666;">
                    Cancelar
                </button>
                <button type="submit" 
                    style="padding: 10px 20px; background: #667eea; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                    Publicar Respuesta
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentCommentId = null;
    
    function openReplyModal(commentId, authorName) {
        currentCommentId = commentId;
        document.getElementById('commentAuthor').innerHTML = `<strong>De: ${authorName}</strong>`;
        
        const form = document.getElementById('replyForm');
        form.action = `/admin/articles/comments/${commentId}/reply`;
        form.style.display = 'block';
        
        document.getElementById('replyModal').style.display = 'block';
        document.getElementById('reply_content').focus();
    }
    
    function closeReplyModal() {
        document.getElementById('replyModal').style.display = 'none';
        document.getElementById('reply_content').value = '';
    }
    
    window.onclick = function(event) {
        const modal = document.getElementById('replyModal');
        if (event.target === modal) {
            closeReplyModal();
        }
    }
</script>
@endsection
