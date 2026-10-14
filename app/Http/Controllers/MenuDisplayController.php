<?php

namespace App\Http\Controllers;

use App\Models\Section;

class MenuDisplayController extends Controller
{
    public function index()
    {
        $sections = Section::where('is_active', true)
            ->with(['categories' => fn ($q) => $q->where('is_active', true)
                ->with(['subcategories' => fn ($s) => $s->where('is_active', true)
                    ->with('items')])])
            ->orderBy('display_order')
            ->get();

        return view('dashboard.menu.display', compact('sections'));
    }
}
