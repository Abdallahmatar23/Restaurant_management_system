<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuItem\StoreMenuItemRequest;
use App\Http\Requests\MenuItem\UpdateMenuItemRequest;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Section;
use App\Models\Subcategory;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $section_id = request('section_id');
        $category_id = request('category_id');
        $subcategory_id = request('subcategory_id');
        $availability = request('availability');
        // dd($search);
        $sections = Section::get();
        $categories = Category::get();
        $subcategories = Subcategory::get();

        $items = MenuItem::query()->with('subcategory.category.section')->when(
            $search,
            function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            }
        )->when($subcategory_id, function ($query, $subcategory_id) {
            $query->where('subcategory_id', $subcategory_id);
        })->when($category_id, function ($query, $category_id) {
            $query->whereHas('subcategory', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        })->when($section_id, function ($query, $section_id) {
            $query->whereHas('subcategory.category', function ($query) use ($section_id) {
                $query->where('section_id', $section_id);
            });
        })->when($availability, function ($query, $availability) {
            $query->where('availability', $availability);
        })->paginate(15)->withQueryString();


        // if ($search == null) {
        //     $items = MenuItem::with('subcategory.category.section');
        //     $items->with(['subcategory', function ($query,$subcategory_id)  {
        //         $query->where('id', $subcategory_id)->with('category', function ($query,$category_id) {
        //             $query->where('id', $category_id)->with('section', function ($query,$section_id) {
        //                 $query->where('id', $section_id);
        //             });
        //         });
        //     }])->paginate(15)->withQueryString();
        // } else {
        //     $items = MenuItem::query()->where('name', 'like', "%{$search}%");
        // }
        // dd($items->toArray());

        return view('dashboard.admin.menu-items.index', compact('sections', 'categories', 'subcategories', 'items', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $sec = request('section_id');
        // dd($sec);
        // $sections = Section::get();
        // $categories = Category::get();
        $subcategories = Subcategory::orderBy('display_order')->get();
        $tags = [
            'Vegetarian',
            'Vegan',
            'Spicy',
            "Chef's Special",
            'Popular',
        ];

        return view('dashboard.admin.menu-items.form', compact('subcategories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuItemRequest $request)
    {
        // dd($request->toArray());
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu_items', 'public');
            $data['image'] = 'storage/' . $path;
        }
        // dd($data);
        MenuItem::create($data);

        return back()->with('status', "{$data['name']} Item Created Successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuItem $menuItem)
    {
        $item = $menuItem->load('subcategory.category.section');
        return view('dashboard.admin.menu-items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        $tags = [
            'Vegetarian',
            'Vegan',
            'Spicy',
            "Chef's Special",
            'Popular',
        ];
        // dd($menuItem);
        $subcategories = Subcategory::orderBy('display_order')->get();
        $item = $menuItem->load('subcategory.category.section');

        return view('dashboard.admin.menu-items.form', compact('tags', 'subcategories', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu_items', 'public');
            $data['image'] = 'storage/' . $path;
        }
        $menuItem->update($data);
        return redirect()->route('menu-items.index')->with('status', "{$data['name']} Updated Successfully !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        // if ($menuItem->orders()->exists()) {
        //     $menuItem->update(['availability' => 'unavailable']);
        //     return redirect()->route('menu-items.index')->with('status', 'The item Marked Unavailable Successfully');
        // } else {
        $menuItem->delete();
        return redirect()->route('menu-items.index')->with('status', 'The item Deleted Successfully');
        // }
    }
}
