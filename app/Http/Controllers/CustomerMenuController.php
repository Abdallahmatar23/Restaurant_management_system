<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomerMenuController extends Controller
{
    public function index(string $token)
    {

        $restaurantTable = RestaurantTable::where('unique_token', $token)->where('status', '!=', 'maintenance')->firstOrFail();
        $sections = Section::whereHas('categories.subcategories.items')->with(['categories' => function ($query) {
            $query->whereHas('subcategories.items')->with(['subcategories' => function ($query) {
                $query->whereHas('items');
            }]);
        }])->get();
        // $sections = Section::with('categories.subcategories.items')->whereHas('categories.subcategories.items')->get();
        return view('customer.table-menu', compact('restaurantTable', 'sections'));
    }
}
