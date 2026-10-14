<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('section')
            ->withCount(['subcategories', 'items'])
            ->when($request->section_id, fn ($q, $id) => $q->where('section_id', $id))
            ->orderBy('section_id')->orderBy('display_order')
            ->get();

        $sections = Section::orderBy('display_order')->get();

        return view('dashboard.admin.categories.index', compact('categories', 'sections'));
    }

    public function create()
    {
        return view('dashboard.admin.categories.form', [
            'category' => new Category(),
            'sections' => Section::orderBy('display_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Category::create($this->validated($request));
        return redirect()->route('categories.index')->with('status', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('dashboard.admin.categories.form', [
            'category' => $category,
            'sections' => Section::orderBy('display_order')->get(),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validated($request));
        return redirect()->route('categories.index')->with('status', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->subcategories()->exists() || $category->items()->exists()) {
            return back()->withErrors(['delete' => 'Cannot delete a category that contains subcategories or items.']);
        }

        $category->delete();
        return back()->with('status', 'Category deleted.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        foreach ($request->order as $position => $id) {
            Category::where('id', $id)->update(['display_order' => $position]);
        }

        return response()->json(['ok' => true]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'section_id'    => ['required', 'exists:sections,id'],
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'status'     => ['required'],
        ]);

        $data['display_order'] = $data['display_order'] ?? 0;
        return $data;
    }
}
