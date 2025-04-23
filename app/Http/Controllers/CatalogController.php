<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class CatalogController extends Controller
{
    public function index($category)
    {
        if (!in_array($category, ['products', 'fruits'])) {
            abort(404);
        }
        $products = Product::where('category', $category)->get();
        return view('catalog', compact('products', 'category'));
    }
}
