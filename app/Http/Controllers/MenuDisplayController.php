<?php

namespace App\Http\Controllers;

use App\Models\Section;



class MenuDisplayController extends Controller
{
    public function index()
    {

        $sections =  Section::where('status', 'active')->with([
            'categories' => function ($query) {
                return $query->where('status', 'active')
                    ->with(['subcategories' => function ($query2) {
                        return $query2->where('status', 'active')->with('items');
                    }]);
            }
        ])->orderBy('display_order')->get();

        // dd(get_class($sections));

        return view('dashboard.menu.display', compact('sections'));
    }
}
