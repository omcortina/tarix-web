<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\UsefulResource;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $icons = \App\Models\Icon::all();
        return view('admin.services.create', compact('icons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:services',
            'title' => 'required|string|max:500',
            'subtitle' => 'required|string|max:500',
            'description' => 'required|string',
            'icon_class' => 'nullable|string',
            'what_is_section' => 'nullable|string',
            'process_section' => 'nullable|string',
            'why_section' => 'nullable|string',
            'published' => 'boolean',
            'show_in_footer' => 'boolean',
        ]);

        // Translate all text fields to English and store as translatable arrays
        $translatable_fields = [
            'title',
            'subtitle',
            'description',
            'what_is_section',
            'process_section',
            'why_section'
        ];

        foreach ($translatable_fields as $field) {
            if (!empty($validated[$field])) {
                $validated[$field] = TranslationService::makeTranslatable($validated[$field]);
            }
        }

        Service::create($validated);
        return redirect()->route('admin.services.index')->with('success', 'Servicio creado exitosamente (traducido automáticamente a inglés).');
    }

    public function show(Service $service)
    {
        $service->load('usefulResources');
        return view('servicio', compact('service'));
    }

    public function edit(Service $service)
    {
        $icons = \App\Models\Icon::all();
        return view('admin.services.edit', compact('service', 'icons'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:services,slug,' . $service->id,
            'title' => 'required|string|max:500',
            'subtitle' => 'required|string|max:500',
            'description' => 'required|string',
            'icon_class' => 'nullable|string',
            'what_is_section' => 'nullable|string',
            'process_section' => 'nullable|string',
            'why_section' => 'nullable|string',
            'published' => 'boolean',
            'show_in_footer' => 'boolean',
        ]);

        // Translate all text fields to English and store as translatable arrays
        $translatable_fields = [
            'title',
            'subtitle',
            'description',
            'what_is_section',
            'process_section',
            'why_section'
        ];

        foreach ($translatable_fields as $field) {
            if (!empty($validated[$field])) {
                $validated[$field] = TranslationService::makeTranslatable($validated[$field]);
            }
        }

        $service->update($validated);
        return redirect()->route('admin.services.index')->with('success', 'Servicio actualizado exitosamente (traducido automáticamente a inglés).');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Servicio eliminado exitosamente.');
    }

    // Métodos para recursos útiles
    public function editResources(Service $service)
    {
        $service->load('usefulResources');
        return view('admin.services.edit-resources', compact('service'));
    }

    public function storeResource(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:500',
            'url' => 'required|url',
            'is_active' => 'boolean',
        ]);

        // Translate title to both ES and EN
        $validated['title'] = TranslationService::makeTranslatable($validated['title']);

        $order = $service->usefulResources()->max('order') ?? 0;
        UsefulResource::create([
            'service_id' => $service->id,
            'title' => $validated['title'],
            'url' => $validated['url'],
            'order' => $order + 1,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.services.edit-resources', $service)->with('success', 'Recurso agregado exitosamente (traducido automáticamente a inglés).');
    }

    public function updateResource(Request $request, Service $service, UsefulResource $resource)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:500',
            'url' => 'required|url',
            'is_active' => 'boolean',
        ]);

        // Translate title to both ES and EN
        $validated['title'] = TranslationService::makeTranslatable($validated['title']);

        $resource->update($validated);
        return redirect()->route('admin.services.edit-resources', $service)->with('success', 'Recurso actualizado exitosamente (traducido automáticamente a inglés).');
    }

    public function destroyResource(Service $service, UsefulResource $resource)
    {
        $resource->delete();
        return redirect()->route('admin.services.edit-resources', $service)->with('success', 'Recurso eliminado exitosamente.');
    }

    public function toggleResource(Service $service, UsefulResource $resource)
    {
        $resource->update(['is_active' => !$resource->is_active]);
        $status = $resource->is_active ? 'activado' : 'desactivado';
        return redirect()->route('admin.services.edit-resources', $service)->with('success', "Recurso $status exitosamente.");
    }
}