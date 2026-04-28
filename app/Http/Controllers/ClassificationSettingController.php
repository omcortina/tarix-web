<?php

namespace App\Http\Controllers;

use App\Models\ClassificationSetting;
use Illuminate\Http\Request;

class ClassificationSettingController extends Controller
{
    public function index()
    {
        $setting = ClassificationSetting::first() ?? new ClassificationSetting();
        return view('admin.classifications.settings', compact('setting'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'price_general' => 'required|numeric|min:0',
            'price_preferential' => 'required|numeric|min:0',
            'max_items' => 'required|integer|min:1',
            'max_attachment_size_mb' => 'required|integer|min:1',
        ]);
        
        $setting = ClassificationSetting::first();
        if (!$setting) {
            $setting = new ClassificationSetting();
        }
        
        $setting->update([
            ...$validated,
            'updated_by' => auth()->id(),
        ]);
        
        return redirect()->back()->with('success', 'Configuración actualizada correctamente');
    }
}
