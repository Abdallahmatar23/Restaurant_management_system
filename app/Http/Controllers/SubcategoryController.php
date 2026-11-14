<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Subcategory\StoreSubcategoryRequest;
use App\Http\Requests\Subcategory\UpdateSubcategoryRequest;
use App\Models\Category;
use App\Models\Section;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::get();
        $categories = Category::get();
        $section_id = request('section_id');
        // dd($section_id);
        $category_id = request('category_id');
        // dd($category_id);


        $subcategories = Subcategory::with(['category', 'items'])->withCount('items')
            ->when($category_id, function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            })->when($section_id, function ($query) use ($section_id) {
                $query->whereHas(
                    'category',
                    function ($query2) use ($section_id) {
                        $query2->where('section_id', $section_id);
                    }
                );
            })->get();


        // if (!empty($category_id) && !empty($section_id)) {
        // } elseif (!empty($category_id)) {
        //     $subcategories = Subcategory::with('category', 'items')->where('category_id', $category_id)->withCount('items')->get();
        // } elseif (!empty($section_id)) {
        //     $subcategories = Subcategory::with('category', 'items')->where('section_id', $section_id)->withCount('items')->get();
        // } else {
        //     $subcategories = Subcategory::with('category', 'items')->withCount('items')->get();
        // }
        return view('dashboard.admin.subcategories.index', compact('sections', 'categories', 'subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('dashboard.admin.subcategories.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubcategoryRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        Subcategory::create($data);
        return redirect()->route('subcategories.create')->with('status', 'Subcategory Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        $subcategory->load('category', 'items');
        return view('dashboard.admin.subcategories.show', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::get();
        $subcategory->load('section', 'category', 'items');
        return view('dashboard.admin.subcategories.form', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory)
    {
        $data = $request->validated();
        $subcategory->update($data);
        return redirect()->route('subcategories.index')->with('status', 'Subcategory Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {

        // dd($subcategory->items()->exists());
        if ($subcategory->items()->exists()) {
            return back()->with('status', 'You Cannot Delete This Subcategory !');
        }
        $subcategory->delete();
        return back()->with('status', 'Subcategory Deleted Successfully !');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        if ($order) {
            foreach ($order as $index => $id) {
                Subcategory::where('id', $id)->update(['display_order' => $index + 1]);
            }

            return response()->json(['status' => 'success', 'message' => 'Subcategories reordered successfully!']);
        }

        return response()->json(['status' => 'error', 'message' => 'No data received.'], 400);
    }

    public function getByCategory(Category $category)
    {
        return response()->json(
            $category->subcategories()
                ->select('id', 'name')
                ->orderBy('display_order')
                ->get()
        );
    }
}
