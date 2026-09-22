<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = Category::all();
    $products = Product::with('category')->latest()->limit(5)->get();
    $suppliers = Supplier::all();

    return view('page', compact('categories', 'products', 'suppliers'));
});

Route::get('/posts', [PostController::class, 'index']);
Route::resource('products', ProductController::class);