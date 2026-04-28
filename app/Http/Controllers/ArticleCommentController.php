<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\ArticleCommentReply;
use App\Mail\NewArticleCommentMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ArticleCommentController extends Controller
{
    /**
     * Show admin moderation interface
     */
    public function index()
    {
        // This will be used in the view, but we'll query there
        return view('admin.comments.index');
    }
    
    /**
     * Store a new comment on an article
     */
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|max:2000',
        ]);
        
        $comment = ArticleComment::create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'author_name' => $validated['author_name'],
            'author_email' => $validated['author_email'],
            'content' => $validated['content'],
            'status' => 'pending',
        ]);
        
        // Send email notification to admin
        try {
            Mail::queue(new NewArticleCommentMail($comment));
        } catch (\Exception $e) {
            \Log::error('Error sending new article comment email: ' . $e->getMessage());
        }
        
        return back()->with('success', 'Gracias por tu comentario. Será visible una vez que el administrador responda.');
    }
    
    /**
     * Admin approve and reply to a comment
     */
    public function reply(Request $request, ArticleComment $comment)
    {
        $this->authorize('update', $comment);
        
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);
        
        // Create reply
        $reply = ArticleCommentReply::create([
            'article_comment_id' => $comment->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);
        
        // Mark comment as approved when first reply is added
        if ($comment->status === 'pending') {
            $comment->update(['status' => 'approved']);
        }
        
        return back()->with('success', 'Respuesta agregada exitosamente. Ahora el comentario es visible en la publicación.');
    }
    
    /**
     * Admin reject a comment
     */
    public function reject(ArticleComment $comment)
    {
        $this->authorize('update', $comment);
        
        $comment->update(['status' => 'rejected']);
        
        return back()->with('success', 'Comentario rechazado.');
    }
    
    /**
     * Admin delete a comment
     */
    public function destroy(ArticleComment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->delete();
        
        return back()->with('success', 'Comentario eliminado.');
    }
    
    /**
     * Admin delete a reply
     */
    public function destroyReply(ArticleCommentReply $reply)
    {
        $this->authorize('delete', $reply);
        
        $comment = $reply->comment;
        $reply->delete();
        
        return back()->with('success', 'Respuesta eliminada.');
    }
}
