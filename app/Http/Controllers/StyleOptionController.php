<?php

namespace App\Http\Controllers;

use App\Models\StyleCategory;
use App\Models\StyleOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StyleOptionController extends Controller
{
    public function store(Request $request, StyleCategory $styleCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|alpha_dash|unique:style_options,code,NULL,id,style_category_id,' . $styleCategory->id,
            'swatch_color' => 'nullable|string|max:7',
            'icon' => 'nullable|file|mimes:svg,png,jpg,jpeg,webp|max:512', // 512 KB limit
            'description' => 'nullable|string',
            'extra_price' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['style_category_id'] = $styleCategory->id;
        $validated['extra_price'] = $validated['extra_price'] ?? 0;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('icon')) {
            // storage/app/public/icons/{category-code}/xxxxx.svg mein save hoga
            $validated['icon_path'] = $request->file('icon')->store('icons/' . $styleCategory->code, 'public');
        }

        unset($validated['icon']); // 'icon' key StyleOption table mein nahi hai, sirf icon_path hai

        StyleOption::create($validated);

        return back()->with('success', 'Style option add ho gaya!');
    }

    public function update(Request $request, StyleOption $styleOption)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|alpha_dash|unique:style_options,code,' . $styleOption->id . ',id,style_category_id,' . $styleOption->style_category_id,
            'swatch_color' => 'nullable|string|max:7',
            'icon' => 'nullable|file|mimes:svg,png,jpg,jpeg,webp|max:512',
            'remove_icon' => 'nullable|boolean',
            'description' => 'nullable|string',
            'extra_price' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['extra_price'] = $validated['extra_price'] ?? 0;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('icon')) {
            // Purani icon file delete karain (agar thi) taake storage mein orphan files na rahein
            if ($styleOption->icon_path) {
                Storage::disk('public')->delete($styleOption->icon_path);
            }
            $validated['icon_path'] = $request->file('icon')->store('icons/' . $styleOption->category->code, 'public');
        } elseif ($request->boolean('remove_icon')) {
            // User ne "remove icon" chuna, koi nayi file nahi di
            if ($styleOption->icon_path) {
                Storage::disk('public')->delete($styleOption->icon_path);
            }
            $validated['icon_path'] = null;
        }

        unset($validated['icon'], $validated['remove_icon']);

        $styleOption->update($validated);

        return back()->with('success', 'Style option update ho gaya!');
    }

    public function destroy(StyleOption $styleOption)
    {
        // Option delete hone par uski icon file bhi storage se hata dein
        if ($styleOption->icon_path) {
            Storage::disk('public')->delete($styleOption->icon_path);
        }

        $styleOption->delete();

        return back()->with('success', 'Style option delete kar diya gaya.');
    }
}
