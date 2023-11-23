<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;

class HomesController extends Controller
{
    public function index()
    {

        $products = Product::with('categories')->where("is_visible", true)->get();
        $categories = Category::all()->where("is_visible", true);
        return view('frontend.index', compact('products', 'categories'));
    }
}
