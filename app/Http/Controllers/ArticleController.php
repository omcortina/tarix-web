<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:500',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string|min:50',
            'published' => 'boolean',
            'media_image_url' => 'nullable|string|url',
            'media_youtube_url' => 'nullable|string',
            'media_description' => 'nullable|string|max:500',
        ]);

        // Generate slug from Spanish title
        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();

        // Translate all text fields to English and store as translatable arrays
        $validated['title'] = TranslationService::makeTranslatable($validated['title']);
        
        if (!empty($validated['excerpt'])) {
            $validated['excerpt'] = TranslationService::makeTranslatable($validated['excerpt']);
        }
        
        $validated['content'] = TranslationService::makeTranslatable($validated['content']);

        // Extraer URLs de media antes de guardar artículo
        $mediaImageUrl = $validated['media_image_url'] ?? null;
        $mediaYoutubeUrl = $validated['media_youtube_url'] ?? null;
        $mediaDescription = $validated['media_description'] ?? null;

        // Eliminar campos de media de validated para no guardarlos en tabla articles
        unset($validated['media_image_url']);
        unset($validated['media_youtube_url']);
        unset($validated['media_description']);

        $article = Article::create($validated);

        // Guardar media si se proporcionó
        if (!empty($mediaImageUrl)) {
            $article->media()->create([
                'type' => 'image',
                'url' => $mediaImageUrl,
                'description' => !empty($mediaDescription) ? [
                    'es' => $mediaDescription,
                    'en' => $mediaDescription,
                ] : null,
                'order' => 1,
            ]);
        }

        if (!empty($mediaYoutubeUrl)) {
            $article->media()->create([
                'type' => 'youtube',
                'url' => $mediaYoutubeUrl,
                'description' => !empty($mediaDescription) ? [
                    'es' => $mediaDescription,
                    'en' => $mediaDescription,
                ] : null,
                'order' => !empty($mediaImageUrl) ? 2 : 1,
            ]);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artículo creado exitosamente (traducido automáticamente a inglés).');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:500',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string|min:50',
            'published' => 'boolean',
            'media_image_url' => 'nullable|string|url',
            'media_youtube_url' => 'nullable|string',
            'media_description' => 'nullable|string|max:500',
        ]);

        // Generate slug from Spanish title
        $validated['slug'] = Str::slug($validated['title']);

        // Translate all text fields to English and store as translatable arrays
        $validated['title'] = TranslationService::makeTranslatable($validated['title']);
        
        if (!empty($validated['excerpt'])) {
            $validated['excerpt'] = TranslationService::makeTranslatable($validated['excerpt']);
        }
        
        $validated['content'] = TranslationService::makeTranslatable($validated['content']);

        // Extraer URLs de media antes de actualizar artículo
        $mediaImageUrl = $validated['media_image_url'] ?? null;
        $mediaYoutubeUrl = $validated['media_youtube_url'] ?? null;
        $mediaDescription = $validated['media_description'] ?? null;

        // Eliminar campos de media de validated para no guardarlos en tabla articles
        unset($validated['media_image_url']);
        unset($validated['media_youtube_url']);
        unset($validated['media_description']);

        $article->update($validated);

        // Gestionar media: actualizar, crear o eliminar según lo que envíe el formulario
        
        // IMAGEN
        if (!empty($mediaImageUrl)) {
            // Si hay URL de imagen, crear o actualizar
            $existingImage = $article->media()->where('type', 'image')->first();
            if ($existingImage) {
                // Actualizar existente
                $existingImage->update([
                    'url' => $mediaImageUrl,
                    'description' => !empty($mediaDescription) ? [
                        'es' => $mediaDescription,
                        'en' => $mediaDescription,
                    ] : null,
                ]);
            } else {
                // Crear nuevo
                $maxOrder = $article->media()->max('order') ?? 0;
                $article->media()->create([
                    'type' => 'image',
                    'url' => $mediaImageUrl,
                    'description' => !empty($mediaDescription) ? [
                        'es' => $mediaDescription,
                        'en' => $mediaDescription,
                    ] : null,
                    'order' => $maxOrder + 1,
                ]);
            }
        } else {
            // Si NO hay URL de imagen, eliminar si existe
            $article->media()->where('type', 'image')->delete();
        }

        // YOUTUBE
        if (!empty($mediaYoutubeUrl)) {
            // Si hay URL de YouTube, crear o actualizar
            $existingYoutube = $article->media()->where('type', 'youtube')->first();
            if ($existingYoutube) {
                // Actualizar existente
                $existingYoutube->update([
                    'url' => $mediaYoutubeUrl,
                    'description' => !empty($mediaDescription) ? [
                        'es' => $mediaDescription,
                        'en' => $mediaDescription,
                    ] : null,
                ]);
            } else {
                // Crear nuevo
                $maxOrder = $article->media()->max('order') ?? 0;
                $article->media()->create([
                    'type' => 'youtube',
                    'url' => $mediaYoutubeUrl,
                    'description' => !empty($mediaDescription) ? [
                        'es' => $mediaDescription,
                        'en' => $mediaDescription,
                    ] : null,
                    'order' => $maxOrder + 1,
                ]);
            }
        } else {
            // Si NO hay URL de YouTube, eliminar si existe
            $article->media()->where('type', 'youtube')->delete();
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artículo actualizado exitosamente (traducido automáticamente a inglés).');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artículo eliminado exitosamente.');
    }
}
