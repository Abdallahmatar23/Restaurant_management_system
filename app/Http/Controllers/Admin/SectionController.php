<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::withCount('categories')->orderBy('display_order')->get();
        return view('dashboard.admin.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('dashboard.admin.sections.form', ['section' => new Section()]);
    }

    public function store(Request $request)
    {
        Section::create($this->validated($request));
        return redirect()->route('sections.index')->with('status', 'Section created.');
    }

    public function edit(Section $section)
    {
        return view('dashboard.admin.sections.form', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $section->update($this->validated($request, $section));
        return redirect()->route('sections.index')->with('status', 'Section updated.');
    }

    public function destroy(Section $section)
    {
        if ($section->categories()->exists()) {
            return back()->withErrors(['delete' => 'Cannot delete a section that contains categories.']);
        }

        $section->delete();
        return back()->with('status', 'Section deleted.');
    }


    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        foreach ($request->order as $position => $id) {
            Section::where('id', $id)->update(['display_order' => $position]);
        }

        return response()->json(['ok' => true]);
    }

    private function validated(Request $request, ?Section $section = null): array
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255', Rule::unique('sections', 'name')->ignore($section?->id)],
            'description'   => ['nullable', 'string'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'status'     => ['required'],
        ]);

        $data['display_order'] = $data['display_order'] ?? 0;
        return $data;
    }
}
