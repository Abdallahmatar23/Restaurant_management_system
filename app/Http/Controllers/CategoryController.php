<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::has('categories', '>=', 1)->get();
        // dd($_GET['section_id']);
        $section_id = request('section_id');
        if (!empty($section_id)) {
            $categories = Category::with('subcategories.items')->where('section_id', $section_id)->orderBy('display_order', 'asc')->withCount('subcategories')->get();
        } else {
            $categories = Category::with('subcategories.items')->orderBy('display_order', 'asc')->withCount('items', 'subcategories')->get();
        }

        // dd($categories);
        return view('dashboard.admin.categories.index', compact(['sections', 'categories']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::get();
        return view('dashboard.admin.categories.form', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // dd($request);

        $data = $request->validated();
        Category::create($data);

        return back()->with('status', 'Category Created Successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('section', 'subcategories.items')->orderBy('display_order', 'asc');

        return view('dashboard.admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category->get();
        $sections = Section::get();
        return view('dashboard.admin.categories.form', compact('category', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // dd($request, $category);
        $data = $request->validated();
        $category->update($data);

        return redirect()->route('categories.index')->with('status', 'Category Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->subcategories()->exists()) {
            return back()->with('status', 'You Cannot Delete This Category !');
        }
        $category->delete();
        return back()->with('status', 'Category Deleted Successfully !');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        if ($order) {
            foreach ($order as $index => $id) {
                Category::where('id', $id)->update(['display_order' => $index + 1]);
            }

            return response()->json(['status' => 'success', 'message' => 'Categories reordered successfully!']);
        }

        return response()->json(['status' => 'error', 'message' => 'No data received.'], 400);
    }

    public function getBySection(Section $section)
    {
        return response()->json(
            $section->categories()
                ->select('id', 'name')
                ->orderBy('display_order')
                ->get()
        );
    }
}
