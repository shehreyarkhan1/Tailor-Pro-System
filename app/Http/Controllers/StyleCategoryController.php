<?php

namespace App\Http\Controllers;

use App\Models\StyleCategory;
use App\Models\StyleOption;
use Illuminate\Http\Request;

class StyleCategoryController extends Controller
{
    public function index()
    {
        $categories = StyleCategory::withCount('options')->orderBy('sort_order')->get();
        return view('style-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('style-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|alpha_dash|unique:style_categories,code',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        StyleCategory::create($validated);

        return redirect()->route('style-categories.index')->with('success', 'Category successfully add ho gayi!');
    }

    // Ye page category detail + uske options list + add/edit option forms dikhata hai
    public function edit(StyleCategory $styleCategory)
    {
        $styleCategory->load(['options' => fn ($q) => $q->orderBy('sort_order')]);
        return view('style-categories.edit', ['category' => $styleCategory]);
    }

    public function update(Request $request, StyleCategory $styleCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|alpha_dash|unique:style_categories,code,' . $styleCategory->id,
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');
        $styleCategory->update($validated);

        return redirect()->route('style-categories.edit', $styleCategory)->with('success', 'Category update ho gayi!');
    }

    public function destroy(StyleCategory $styleCategory)
    {
        $styleCategory->delete(); // options cascade delete ho jayenge (foreign key cascadeOnDelete)
        return redirect()->route('style-categories.index')->with('success', 'Category delete kar di gayi.');
    }
}
