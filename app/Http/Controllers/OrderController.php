<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Discount;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $quantities = $request->input('quantities', []);

        // Проверяем, что выбрано хотя бы одно количество больше 0
        $hasItems = false;
        foreach ($quantities as $quantity) {
            if ($quantity > 0) {
                $hasItems = true;
                break;
            }
        }

        if (!$hasItems) {
            return redirect()->back()->with('error', 'Пожалуйста, выберите хотя бы один товар для заказа.');
        }

        // Валидация
        $request->validate([
            'quantities.*' => 'integer|min:0',
        ]);

        // Рассчитываем общую сумму с учётом скидок
        $totalPrice = 0;
        $products = Product::whereIn('id', array_keys($quantities))->get();
        $discounts = Discount::where('user_id', auth()->id())->whereIn('product_id', array_keys($quantities))->get()->keyBy('product_id');

        foreach ($products as $product) {
            $quantity = $quantities[$product->id];
            if ($quantity > 0) {
                $price = $product->price;
                if (isset($discounts[$product->id])) {
                    $discount = $discounts[$product->id]->discount_percentage;
                    $price = $price * (1 - $discount / 100);
                }
                $totalPrice += $price * $quantity;
            }
        }

        // Создаём заказ
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        foreach ($quantities as $productId => $quantity) {
            if ($quantity > 0) {
                $order->products()->attach($productId, ['quantity' => $quantity]);
            }
        }

        return redirect()->back()->with('success', 'Заказ успешно оформлен! Общая сумма: ' . number_format($totalPrice, 0, ',', ' ') . ' сум.');
    }
}
