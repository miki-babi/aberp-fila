<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Spec;
use App\Models\SubCategory;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});


// Sales (POS) screen
Route::get('/sale', function () {
    $categories = Category::all();
    $subCategories = SubCategory::all();
    $specs = Spec::all();
    $products = Product::all();
    return view('sales', compact('categories', 'subCategories', 'specs', 'products'));
})->name('salespage');

// Sales submission
Route::post('/sale/store', [SalesController::class, 'store'])->name('sale.post');

Route::get('/get-products', function (Request $request) {
    $query = Product::query();

    if ($request->filled('attribute_id')) {
        $query->where('spec_id', $request->attribute_id);
    }

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->filled('sub_category_id')) {
        $query->where('sub_category_id', $request->sub_category_id);
    }

    return response()->json($query->get());
});

// Data endpoints (AJAX/JSON)
Route::get('/brands/{category}', function ($category) {
    $brands = Product::where('category', $category)->get();
    return response()->json($brands);
})->name('get.brands.by.category');

Route::get('/specs/{brand}', function ($brand) {
    $specs = Product::where('model', $brand)->get();
    return response()->json($specs);
})->name('get.specs.by.brand');

// Attributes
Route::get('/get-attributes', function (Request $request) {
    $query = Spec::query();

    if ($request->has('sub_category_id') && $request->sub_category_id) {
        $query->where('sub_category_id', $request->sub_category_id);
    } elseif ($request->has('category_id') && $request->category_id) {
        $query->where('category_id', $request->category_id)->whereNull('sub_category_id');
    }

    return response()->json($query->get());
});

// Subcategories
Route::get('/get-subcategories/{categoryId}', function ($categoryId) {
    $subcategories = SubCategory::where('category_id', $categoryId)->get();
    return response()->json($subcategories);
});