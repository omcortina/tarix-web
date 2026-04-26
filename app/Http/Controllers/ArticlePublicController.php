<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlePublicController extends Controller
{
    /**
     * Mostrar lista de artículos publicados
     */
    public function index()
    {
        $articles = Article::where('published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('articles.index', compact('articles'));
    }

    /**
     * Mostrar detalle de un artículo
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        // Obtener artículos relacionados (últimos 3)
        $related = Article::where('published', true)
            ->where('id', '!=', $article->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Obtener servicios para el footer
        $services = \App\Models\Service::where('show_in_footer', true)->where('published', true)->orderBy('id', 'asc')->get();

        return view('articles.show', compact('article', 'related', 'services'));
    }
}
