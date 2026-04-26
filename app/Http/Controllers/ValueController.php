<?php

namespace App\Http\Controllers;

use App\Models\Value;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class ValueController extends Controller
{
    public function index()
    {
        $values = Value::orderBy('order')->get();
        return view('admin.values.index', compact('values'));
    }

    public function create()
    {
        return view('admin.values.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_svg' => 'nullable|string',
            'icon_color' => 'required|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        // Translate to English and store as translatable arrays
        $validated['name'] = TranslationService::makeTranslatable($validated['name']);
        $validated['description'] = TranslationService::makeTranslatable($validated['description']);

        Value::create($validated);

        return redirect()->route('admin.values.index')
            ->with('success', 'Valor creado exitosamente');
    }

    public function edit(Value $value)
    {
        return view('admin.values.edit', compact('value'));
    }

    public function update(Request $request, Value $value)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_svg' => 'nullable|string',
            'icon_color' => 'required|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        // Translate to English and store as translatable arrays
        $validated['name'] = TranslationService::makeTranslatable($validated['name']);
        $validated['description'] = TranslationService::makeTranslatable($validated['description']);

        $value->update($validated);

        return redirect()->route('admin.values.index')
            ->with('success', 'Valor actualizado exitosamente');
    }

    public function destroy(Value $value)
    {
        $value->delete();

        return redirect()->route('admin.values.index')
            ->with('success', 'Valor eliminado exitosamente');
    }

    public function toggle(Value $value)
    {
        $value->update(['is_active' => !$value->is_active]);

        return back()->with('success', 'Estado actualizado');
    }
}
