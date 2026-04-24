<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\ArticleMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ArticleMediaController extends Controller
{
    /**
     * Agregar media a un artículo
     */
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'type' => 'required|in:image,youtube',
            'url' => 'required|string',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:5120', // 5MB
        ]);

        // Si es una imagen cargada, guardarla
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $validated['url'] = Storage::url($path);
        }

        $validated['article_id'] = $article->id;
        $validated['order'] = $article->media()->max('order') + 1;

        // Traducir descripción si es multiidioma
        if (!empty($validated['description'])) {
            $validated['description'] = [
                'es' => $validated['description'],
                'en' => $validated['description'],
            ];
        }

        $media = ArticleMedia::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Media agregado exitosamente',
            'media' => $media,
        ], 201);
    }

    /**
     * Actualizar orden de media
     */
    public function updateOrder(Request $request, Article $article)
    {
        $validated = $request->validate([
            'media_ids' => 'required|array',
        ]);

        foreach ($validated['media_ids'] as $index => $mediaId) {
            ArticleMedia::where('id', $mediaId)
                ->where('article_id', $article->id)
                ->update(['order' => $index]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden actualizado',
        ]);
    }

    /**
     * Eliminar media
     */
    public function destroy(Article $article, ArticleMedia $media)
    {
        if ($media->article_id !== $article->id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado',
            ], 403);
        }

        // Eliminar imagen del almacenamiento si es local
        if ($media->type === 'image' && str_starts_with($media->url, '/storage/')) {
            $path = str_replace('/storage/', '', $media->url);
            Storage::disk('public')->delete($path);
        }

        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Media eliminado exitosamente',
        ]);
    }

    /**
     * Obtener media de un artículo
     */
    public function index(Article $article)
    {
        $media = $article->media()->orderBy('order')->get();

        return response()->json([
            'success' => true,
            'media' => $media,
        ]);
    }
}
