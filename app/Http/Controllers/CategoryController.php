<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Category $category): View
    {
        $allCategories = Category::with('products')->where("is_visible", true)->get();
        $products = $category ? $category->products : Product::where("is_visible", true)->get();

        return view("frontend.index", ["categories" => $allCategories, "products" => $products]);
    }
}
