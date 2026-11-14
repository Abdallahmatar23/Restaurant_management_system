<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $role = request()->user()->role;
        abort_unless(view()->exists("dashboard.$role.home"),403);
        return view("dashboard.{$role}.home");
    }
}
