<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\{SectionController, CategoryController, SubcategoryController, MenuItemController};
use App\Http\Controllers\MenuDisplayController;

Route::get('/', fn() => redirect()->route('login'));



// Route::get('/waiter', function () {
//     return view('dashboard.waiter.home');
// })->name('waiter');

Route::middleware('auth')->get('/dash', [DashboardController::class, 'index'])->name('dashboard');

// Route::middleware('auth')->get('/dashboard', function () {
//     // return view('dashboard.admin.home');
//     // return view('dashboard.' . auth()->user()->role . '.home');
// })->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('users/create', [RegisteredUserController::class, 'create'])->name('users.create');
    Route::post('users', [RegisteredUserController::class, 'store'])->name('users.store');
});


Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('sections', SectionController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('subcategories', SubcategoryController::class)->except('show');
    Route::resource('menu-items', MenuItemController::class)->except('show')->parameters(['menu-items' => 'menuItem']);

    // الترتيب (reorder)
    Route::post('sections/reorder', [SectionController::class, 'reorder'])->name('sections.reorder');
    Route::post('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
    Route::post('subcategories/reorder', [SubcategoryController::class, 'reorder'])->name('subcategories.reorder');
});

// endpoints للـ cascading dropdowns (الأدمن فقط لأنها بتخدم فورم الـ items)
Route::middleware(['auth', 'role:admin'])->prefix('ajax')->group(function () {
    Route::get('sections/{section}/categories', fn (\App\Models\Section $section) => $section->categories()->get(['id', 'name']))->name('ajax.categories');
    Route::get('categories/{category}/subcategories', fn (\App\Models\Category $category) => $category->subcategories()->get(['id', 'name']))->name('ajax.subcategories');
});

// عرض المنيو (للموظفين)
Route::middleware(['auth', 'role:admin,waiter,cashier'])->get('/menu', [MenuDisplayController::class, 'index'])->name('menu.index');


 Route::get('/logout', function () {
    return view('logout');
});

require __DIR__ . '/auth.php';
