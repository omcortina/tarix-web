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
        $articles = Article::latest()->paginate(10);
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

        Article::create($validated);
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
        ]);

        // Generate slug from Spanish title
        $validated['slug'] = Str::slug($validated['title']);

        // Translate all text fields to English and store as translatable arrays
        $validated['title'] = TranslationService::makeTranslatable($validated['title']);
        
        if (!empty($validated['excerpt'])) {
            $validated['excerpt'] = TranslationService::makeTranslatable($validated['excerpt']);
        }
        
        $validated['content'] = TranslationService::makeTranslatable($validated['content']);

        $article->update($validated);
        return redirect()->route('admin.articles.index')->with('success', 'Artículo actualizado exitosamente (traducido automáticamente a inglés).');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artículo eliminado exitosamente.');
    }
}
