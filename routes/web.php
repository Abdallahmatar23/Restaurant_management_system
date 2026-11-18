<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerMenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuDisplayController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantTableController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/admin',function(){
//     return view('dashboard.admin.home');
// })->name('admin');


Route::middleware(['auth', 'role:admin'])->group(function () {
    //Manage Users
    Route::get('users/create', [RegisteredUserController::class, 'create'])->name('users.create');
    Route::post('/users', [RegisteredUserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{id}', [RegisteredUserController::class, 'edit'])->name('users.edit');
    Route::put('/users', [RegisteredUserController::class, 'update'])->name('users.update');
    Route::delete('/users', [RegisteredUserController::class, 'destroy'])->name('users.destroy');

    //Manage Menu
    //Sections
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::get('/sections/{section}', [SectionController::class, 'show'])->name('sections.show');
    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('sections/edit/{section}', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('/sections{section}', [SectionController::class, 'destroy'])->name('sections.destroy');
    Route::post('Sections/reorder', [SectionController::class, 'reorder'])->name('sections.reorder');


    //Categories
    Route::post('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
    Route::resource('categories', CategoryController::class);
    // Route::get('/categories',[CategoryController::class,'index'])->name('categories.index');
    // Route::get('categories/create',[CategoryController::class,'create'])->name('categories.create');
    // Route::get('/categories/{category}',[CategoryController::class,'show'])->name('categories.show');
    // Route::post('/categories',[CategoryController::class,'store'])->name('categories.store');
    // Route::get('categories/edit/{category}',[CategoryController::class,'edit'])->name('categories.edit');
    // Route::put('/categories',[CategoryController::class,'update'])->name('categories.update');
    // Route::delete('/categories',[CategoryController::class,'destroy'])->name('categories.destroy');


    //Subcategories
    Route::post('subcategories/reorder', [SubcategoryController::class, 'reorder'])->name('subcategories.reorder');
    Route::resource('subcategories', SubcategoryController::class);
    // Route::get('/subcategories',[SubcategoryController::class,'index'])->name('subcategories.index');
    // Route::get('subcategories/create',[SubcategoryController::class,'create'])->name('subcategories.create');
    // Route::get('/subcategories/{subcategory}',[SubcategoryController::class,'show'])->name('subcategories.show');
    // Route::post('/subcategories',[SubcategoryController::class,'store'])->name('subcategories.store');
    // Route::get('subcategories/edit/{subcategory}',[SubcategoryController::class,'edit'])->name('subcategories.edit');
    // Route::put('/subcategories',[SubcategoryController::class,'update'])->name('subcategories.update');
    // Route::delete('/subcategories',[SubcategoryController::class,'destroy'])->name('subcategories.destroy');


    //Menu-items
    // Cascading Filters
    Route::get('/sections/{section}/categories', [CategoryController::class, 'getBySection'])
        ->name('categories.by-section');
    Route::get('/categories/{category}/subcategories', [SubcategoryController::class, 'getByCategory'])
        ->name('subcategories.by-category');
    Route::resource('menu-items', MenuItemController::class);
});

Route::middleware('auth')->get('/dash', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:admin,waiter,cashier'])->group(function () {
    Route::get('/menu', [MenuDisplayController::class, 'index'])->name('menu.index');
});

Route::middleware(['auth', 'role:waiter,admin'])->group(function () {
    Route::resource('restaurant-tables', RestaurantTableController::class);
    Route::patch('/restaurant-tables/qr/regenerate/{restaurantTable}', [RestaurantTableController::class, 'qrRegenerate'])->name('restaurant-tables.qr.regenerate');
    Route::get('/restaurant-tables/to/qr-bulk/', function () {
        return view('dashboard.admin.restaurant-tables.qr-bulk');
    })->name('restaurant-tables.to.qr.bulk-generate');
    Route::post('/restaurant-tables/qr/regenerateAll/', [RestaurantTableController::class, 'qrBulkGenerate'])->name('restaurant-tables.qr.bulk-generate');
    Route::get('/menu/table/{token}', [RestaurantTableController::class, 'qrShow'])->name('restaurant-tables.qr.show');
    Route::get('/qr/download/{restaurantTable},{flag}', [RestaurantTableController::class, 'qrDownload'])->name('restaurant-tables.qr.download');
    // Route::get('orders/create',[OrderController::class,'create'])->name('orders.create);
    // Route::post('orders/store',[OrderController::class,'store'])->name('order.store);
});

Route::middleware(['auth', 'role:cashier,admin'])->group(function () {});
Route::middleware(['auth', 'role:kitchen_staff,admin'])->group(function () {});

Route::middleware(['auth', 'role:client,admin'])->group(function () {});

Route::get('/customer/menu/table/{token}', [CustomerMenuController::class, 'index'])->name('customer.menu');
require __DIR__ . '/auth.php';
