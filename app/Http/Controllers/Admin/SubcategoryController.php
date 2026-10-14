<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Section;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $subcategories = Subcategory::with('category.section')
            ->withCount('items')
            ->when($request->category_id, fn($q, $id) => $q->where('category_id', $id))
            ->when($request->section_id, fn($q, $id) => $q->whereHas('category', fn($c) => $c->where('section_id', $id)))
            ->orderBy('category_id')->orderBy('display_order')
            ->get();

        $sections   = Section::orderBy('display_order')->get();
        $categories = Category::when($request->section_id, fn($q, $id) => $q->where('section_id', $id))
            ->orderBy('display_order')->get();

        return view('dashboard.admin.subcategories.index', compact('subcategories', 'sections', 'categories'));
    }

    public function create()
    {
        return view('dashboard.admin.subcategories.form', [
            'subcategory' => new Subcategory(),
            'categories'  => Category::with('section')->orderBy('section_id')->orderBy('display_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Subcategory::create($this->validated($request));
        return redirect()->route('subcategories.index')->with('status', 'Subcategory created.');
    }

    public function edit(Subcategory $subcategory)
    {
        return view('dashboard.admin.subcategories.form', [
            'subcategory' => $subcategory,
            'categories'  => Category::with('section')->orderBy('section_id')->orderBy('display_order')->get(),
        ]);
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $subcategory->update($this->validated($request));
        return redirect()->route('subcategories.index')->with('status', 'Subcategory updated.');
    }

    public function destroy(Subcategory $subcategory)
    {
        if ($subcategory->items()->exists()) {
            return back()->withErrors(['delete' => 'Cannot delete a subcategory that contains items.']);
        }

        $subcategory->delete();
        return back()->with('status', 'Subcategory deleted.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        foreach ($request->order as $position => $id) {
            Subcategory::where('id', $id)->update(['display_order' => $position]);
        }

        return response()->json(['ok' => true]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category_id'   => ['required', 'exists:categories,id'],
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'status'     => ['required'],
        ]);

        $data['display_order'] = $data['display_order'] ?? 0;
        return $data;
    }
}
