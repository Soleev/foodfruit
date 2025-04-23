<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;
class UserCabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $products = Product::all();
        $discounts = Discount::where('user_id', auth()->id())->get()->keyBy('product_id');
        return view('cabinet', compact('products', 'discounts'));
    }
}
