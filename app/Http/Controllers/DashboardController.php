<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    public function index()
    {
        $role = request()->user()->role;

        // Kitchen Staff يتحول مباشرة لصفحة المطبخ (لما تتعمل)
        if ($role === 'kitchen_staff' && Route::has('kitchen.index')) {
            return redirect()->route('kitchen.index');
        }

        abort_unless(view()->exists("dashboard.$role.home"), 403);

        // return view("dashboard.admin.home");
        return view("dashboard.$role.home");
    }
}
