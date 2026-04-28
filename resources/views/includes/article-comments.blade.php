<!-- Comments Section for Public Article View -->
<div class="comments-section" style="margin-top: 40px; border-top: 2px solid #e0e0e0; padding-top: 30px;">
    <h3 style="font-size: 20px; margin-bottom: 30px; color: #1a2e44;">Comentarios</h3>
    
    <!-- Comments List -->
    @if ($article->comments()->where('status', 'approved')->with('replies')->count() > 0)
        <div class="comments-list" style="margin-bottom: 40px;">
            @foreach ($article->comments()->where('status', 'approved')->with('replies')->get() as $comment)
                <div class="comment-item" style="margin-bottom: 25px; background: #f9f9f9; padding: 20px; border-radius: 6px; border-left: 3px solid #667eea;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #1a2e44; font-size: 15px;">{{ $comment->author_name }}</strong>
                            <small style="color: #999; display: block; margin-top: 4px;">{{ $comment->created_at->format('d \d\e M \d\e Y \a \l\a\s H:i') }}</small>
                        </div>
                    </div>
                    
                    <p style="color: #333; margin: 12px 0; line-height: 1.6;">
                        {!! nl2br(e($comment->content)) !!}
                    </p>
                    
                    <!-- Replies -->
                    @if ($comment->replies->count() > 0)
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                            @foreach ($comment->replies as $reply)
                                <div style="background: white; padding: 12px; border-radius: 4px; margin-top: 10px; border-left: 3px solid #4CAF50;">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                        <strong style="color: #4CAF50; font-size: 14px;">TARIX - {{ $reply->user->name }}</strong>
                                        <small style="color: #999; font-size: 12px;">{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p style="color: #333; margin: 0; font-size: 14px; line-height: 1.6;">
                                        {!! nl2br(e($reply->content)) !!}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p style="color: #999; text-align: center; padding: 30px 0;">No hay comentarios aún. ¡Sé el primero en comentar!</p>
    @endif
    
    <!-- Comment Form -->
    <div style="background: #f0f4ff; padding: 25px; border-radius: 8px; border: 1px solid #e0e6ff;">
        <h4 style="color: #667eea; margin-bottom: 20px; font-size: 16px;">Dejar un Comentario</h4>
        
        @if (session('success'))
            <div style="background: #e8f5e9; border-left: 4px solid #4CAF50; padding: 15px; border-radius: 4px; margin-bottom: 15px; color: #2e7d32;">
                <p style="margin: 0; font-size: 14px; font-weight: 600;">
                    <span style="font-size: 16px; margin-right: 8px;">✓</span>{{ session('success') }}
                </p>
            </div>
        @endif
        
        @if ($errors->any())
            <div style="background: #ffebee; border-left: 4px solid #f44336; padding: 15px; border-radius: 4px; margin-bottom: 15px; color: #c62828;">
                @foreach ($errors->all() as $error)
                    <p style="margin: 5px 0; font-size: 13px;">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form action="{{ route('articles.comments.store', $article) }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 15px;">
                <label for="author_name" style="display: block; margin-bottom: 6px; font-weight: 600; color: #333; font-size: 14px;">Nombre *</label>
                <input 
                    type="text" 
                    id="author_name" 
                    name="author_name" 
                    value="{{ old('author_name', Auth::user()?->name ?? '') }}"
                    placeholder="Tu nombre" 
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="author_email" style="display: block; margin-bottom: 6px; font-weight: 600; color: #333; font-size: 14px;">Email *</label>
                <input 
                    type="email" 
                    id="author_email" 
                    name="author_email" 
                    value="{{ old('author_email', Auth::user()?->email ?? '') }}"
                    placeholder="tu@email.com" 
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="content" style="display: block; margin-bottom: 6px; font-weight: 600; color: #333; font-size: 14px;">Comentario *</label>
                <textarea 
                    id="content" 
                    name="content" 
                    placeholder="Escribe tu comentario..." 
                    rows="5"
                    required
                    maxlength="2000"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: inherit; resize: vertical;">{{ old('content') }}</textarea>
                <small style="color: #999; display: block; margin-top: 4px;">Máximo 2000 caracteres</small>
            </div>
            
            <button type="submit" style="background: #667eea; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; font-size: 14px;">
                Publicar Comentario
            </button>
        </form>
        
        <small style="display: block; margin-top: 15px; color: #999; line-height: 1.5;">
            Nota: Tu comentario será revisado por nuestro equipo antes de ser publicado.
        </small>
    </div>
</div>
