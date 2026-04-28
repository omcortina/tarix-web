<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Comentario en Artículo - TARIX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            background-color: #667eea;
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.95;
            margin-top: 8px;
        }
        
        .content {
            padding: 30px;
        }
        
        .comment-box {
            background-color: #f9f9f9;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .author-info {
            font-weight: 600;
            color: #1a2e44;
            font-size: 16px;
        }
        
        .comment-date {
            color: #999;
            font-size: 13px;
        }
        
        .comment-content {
            color: #333;
            font-size: 14px;
            line-height: 1.6;
            margin: 15px 0;
        }
        
        .article-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a2e44;
            margin-bottom: 10px;
        }
        
        .article-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .action-section {
            background-color: #e8f5e9;
            border: 1px solid #4CAF50;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        
        .cta-button {
            display: inline-block;
            background-color: #667eea;
            color: white !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
            font-size: 14px;
        }
        
        .cta-button:hover {
            background-color: #5568d3;
        }
        
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #e0e0e0;
        }
        
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nuevo Comentario</h1>
            <p>Se ha recibido un comentario pendiente de respuesta</p>
        </div>
        
        <div class="content">
            <div class="article-title">
                Artículo: {{ $article->title }}
            </div>
            
            <div class="comment-box">
                <div class="comment-header">
                    <span class="author-info">{{ $comment->author_name }}</span>
                    <span class="comment-date">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="comment-content">
                    {!! nl2br(e($comment->content)) !!}
                </div>
                
                <div style="font-size: 13px; color: #999; margin-top: 10px;">
                    Email: {{ $comment->author_email }}
                </div>
            </div>
            
            <div class="action-section">
                <p style="margin: 0; color: #2e7d32; font-weight: 600;">Acciones Requeridas:</p>
                <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #2e7d32;">
                    <li>Revisa el comentario</li>
                    <li>Agrega una respuesta en el admin</li>
                    <li>El comentario será visible en la publicación</li>
                </ul>
            </div>
            
            <center>
                <a href="{{ $adminUrl }}" class="cta-button">Ver en Admin</a>
            </center>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} TARIX. Todos los derechos reservados.</p>
            <p>Se recibió un nuevo comentario pendiente de moderación en tu artículo.</p>
        </div>
    </div>
</body>
</html>
