<?php

namespace App\Http\Controllers;

use App\Http\Requests\Section\StoreSectionRequest;
use App\Http\Requests\Section\UpdateSectionRequest;
use App\Models\Section;
use Illuminate\Foundation\Http\Attributes\RedirectTo;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::orderBy('display_order', 'asc')->withCount('categories')->get();
        // $sections = Section::with('categories');
        return view('dashboard.admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd('add');
        return view('dashboard.admin.sections.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSectionRequest $request)
    {
        $data = $request->validated();

        Section::create($data);

        return redirect()->route('sections.index')->with('status', 'Section Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        $section->load('categories.subcategories.items')->orderBy('display_order', 'asc');

        return view('dashboard.admin.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        // dd($section->name);
        return view('dashboard.admin.sections.form', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {
        // dd($request->name);
        $data = $request->validated();
        // dd($data);
        // dd($section->update($data));
        $section->update($data);
        return  redirect(route('sections.index'))->with('status', 'Section Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        if ($section->categories()->exists()) {
            return back()->with('status', 'You Cannot Delete This Section !');
        }
        $section->Delete();

        return back()->with('status', 'Section Deleted Successfully !');
    }


    public function reorder(Request $request)
    {
        $order = $request->input('order');

        if ($order) {
            foreach ($order as $index => $id) {
                Section::where('id', $id)->update(['display_order' => $index + 1]);
            }

            return response()->json(['status' => 'success', 'message' => 'Sections reordered successfully!']);
        }

        return response()->json(['status' => 'error', 'message' => 'No data received.'], 400);
    }
}
