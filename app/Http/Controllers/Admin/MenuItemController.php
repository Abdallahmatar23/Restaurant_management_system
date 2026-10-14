<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Section;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $items = MenuItem::with('subcategory.category.section')
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($request->availability, fn ($q, $a) => $q->where('availability', $a))
            ->when($request->subcategory_id, fn ($q, $id) => $q->where('subcategory_id', $id))
            ->when($request->category_id, fn ($q, $id) => $q->whereHas('subcategory', fn ($s) => $s->where('category_id', $id)))
            ->when($request->section_id, fn ($q, $id) => $q->whereHas('subcategory.category', fn ($c) => $c->where('section_id', $id)))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.admin.menu-items.index', [
            'items'         => $items,
            'sections'      => Section::orderBy('display_order')->get(),
            'categories'    => Category::orderBy('display_order')->get(),
            'subcategories' => Subcategory::orderBy('display_order')->get(),
        ]);
    }

    public function create()
    {
        return view('dashboard.admin.menu-items.form', [
            'item'     => new MenuItem(),
            'sections' => Section::orderBy('display_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['image'] = 'storage/' . $request->file('image')->store('menu', 'public');

        MenuItem::create($data);

        return redirect()->route('menu-items.index')->with('status', 'Item created.');
    }

    public function edit(MenuItem $menuItem)
    {
        $menuItem->load('subcategory.category');

        return view('dashboard.admin.menu-items.form', [
            'item'     => $menuItem,
            'sections' => Section::orderBy('display_order')->get(),
        ]);
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $this->validated($request, false);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete(Str::after($menuItem->image, 'storage/'));
            $data['image'] = 'storage/' . $request->file('image')->store('menu', 'public');
        }

        $menuItem->update($data);

        return redirect()->route('menu-items.index')->with('status', 'Item updated.');
    }

    public function destroy(MenuItem $menuItem)
    {
        Storage::disk('public')->delete(Str::after($menuItem->image, 'storage/'));
        $menuItem->delete();

        return back()->with('status', 'Item deleted.');
    }

    private function validated(Request $request, bool $imageRequired): array
    {
        $data = $request->validate([
            'section_id'       => ['required', 'exists:sections,id'],
            'category_id'      => ['required', Rule::exists('categories', 'id')->where('section_id', $request->section_id)],
            'subcategory_id'   => ['required', Rule::exists('subcategories', 'id')->where('category_id', $request->category_id)],
            'name'             => ['required', 'string', 'max:200'],
            'description'      => ['nullable', 'string', 'max:500'],
            'price'            => ['required', 'numeric', 'min:0'],
            'image'            => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'preparation_time' => ['nullable', 'integer', 'min:0'],
            'availability'     => ['required', Rule::in(['available', 'out_of_stock'])]
        ]);

        // section_id و category_id للـ validation والـ dropdowns بس، مش بيتخزنوا
        unset($data['section_id'], $data['category_id'], $data['image']);

        return $data;
    }
}
