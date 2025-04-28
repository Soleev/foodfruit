<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserCabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function index()
    {
        // Получаем текущего аутентифицированного пользователя
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        $products = Product::all();
        $orders = $user->orders()->with('products')->get()->keyBy('product_id');
        $discounts = Discount::where('user_id', $user->id)->get()->keyBy('product_id');

        return view('cabinet', compact('products', 'discounts'));
    }

}
