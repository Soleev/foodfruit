<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\DiscountTier;
use App\Models\DiscountTierHistory;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // Список пользователей
    public function users()
    {
        $users = User::all();
        // Вычисляем общий долг всех пользователей
        $totalDebt = $users->sum('debt');
        $totalUsers = $users->count();

        return view('admin.users', [
            'title' => 'Покупатели',
            'users' => $users,
            'totalDebt' => $totalDebt,
            'totalUsers' => $totalUsers
        ]);
    }

    public function orders()
    {
        $orders = Order::with('user', 'products')
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        // Подсчет заказов со статусом 'to_deliver'
        $toDeliverCount = Order::where('delivery_status', 'to_deliver')
            ->whereNull('deleted_at')
            ->count();

        return view('admin.orders', compact('orders', 'toDeliverCount'));

    }

    public function editOrder(Order $order)
    {
        return view('admin.orders_edit', compact('order'));
    }

    public function updateOrder(Request $request, Order $order)
    {
        $request->validate([
            'delivery_status' => 'required|in:new,to_deliver,delivered',
            'payment_status' => 'required|in:pending,prepaid,paid,credit',
        ]);

        $order->update([
            'delivery_status' => $request->input('delivery_status'),
            'payment_status' => $request->input('payment_status'),
        ]);

        return redirect()->route('admin.orders')->with('success', 'Статус заказа обновлен!');
    }

    public function deleteOrder(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'Заказ удалён (мягко).');
    }

    public function buyProduct(User $user)
    {
        $products = Product::all();
        return view('admin.buy-product', [
            'title' => 'Купить товар для пользователя',
            'user' => $user,
            'products' => $products
        ]);
    }

    public function storePurchase(Request $request, User $user)
    {
        $validated = $request->validate([
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => 0,
        ]);

        $totalPrice = 0;
        foreach ($validated['product_id'] as $index => $productId) {
            $product = Product::findOrFail($productId);
            $quantity = $validated['quantity'][$index];
            $order->products()->attach($productId, ['quantity' => $quantity]);
            $totalPrice += $product->price * $quantity;
        }

        // Применение скидки
        $discount = DiscountTier::where('threshold_amount', '<=', $totalPrice)
            ->orderBy('threshold_amount', 'desc')
            ->first();
        $discountPercentage = $discount ? $discount->discount_percentage : 0;
        $finalPrice = $totalPrice * (1 - $discountPercentage / 100);

        $order->update([
            'total_price' => $finalPrice,
            'applied_discount_percentage' => $discountPercentage,
        ]);

        return redirect()->route('admin.users')->with('success', 'Товары успешно куплены для пользователя.');
    }

    public function userOrders(User $user)
    {
        $orders = $user->orders()->with('products')->latest()->get();
        return view('admin.user-orders', [
            'title' => 'История покупок: ' . $user->name,
            'user' => $user,
            'orders' => $orders
        ]);
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'store_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'required|confirmed|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'store_name' => $validated['store_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Пользователь успешно добавлен.');
    }

    public function products()
    {
        $products = Product::whereNull('deleted_at')->get();
        return view('admin.products', compact('products'));
    }

    public function editProduct(Product $product)
    {
        return view('admin.products-edit', [
            'title' => 'Редактировать продукт',
            'product' => $product
        ]);
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:products,fruits',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);
        return redirect()->route('admin.products')->with('success', 'Продукт успешно обновлён.');
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Продукт скрыт, но сохранён в истории заказов.');
    }

    public function deletedProducts()
    {
        $products = Product::onlyTrashed()->get();
        return view('admin.deleted-products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:products,fruits',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->back()->with('success', 'Товар успешно добавлен.');
    }

    public function discounts()
    {
        $discountTiers = DiscountTier::all();
        $discountHistory = DiscountTierHistory::latest('action_at')->get();
        return view('admin.discounts', compact('discountTiers', 'discountHistory'));
    }

    public function storeDiscount(Request $request)
    {
        $validated = $request->validate([
            'threshold_amount' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $discountTier = DiscountTier::create($validated);

        DiscountTierHistory::create([
            'discount_tier_id' => $discountTier->id,
            'threshold_amount' => $discountTier->threshold_amount,
            'discount_percentage' => $discountTier->discount_percentage,
            'action' => 'created',
            'action_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Скидка успешно добавлена.');
    }

    public function editDiscount(DiscountTier $discountTier)
    {
        return view('admin.discounts-edit', compact('discountTier'));
    }

    public function updateDiscount(Request $request, DiscountTier $discountTier)
    {
        $validated = $request->validate([
            'threshold_amount' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        DiscountTierHistory::create([
            'discount_tier_id' => $discountTier->id,
            'threshold_amount' => $discountTier->threshold_amount,
            'discount_percentage' => $discountTier->discount_percentage,
            'action' => 'updated',
            'action_at' => now(),
        ]);

        $discountTier->update($validated);
        return redirect()->route('admin.discounts')->with('success', 'Скидка обновлена.');
    }

    public function deleteDiscount(DiscountTier $discountTier)
    {
        DiscountTierHistory::create([
            'discount_tier_id' => $discountTier->id,
            'threshold_amount' => $discountTier->threshold_amount,
            'discount_percentage' => $discountTier->discount_percentage,
            'action' => 'deleted',
            'action_at' => now(),
        ]);

        $discountTier->delete();
        return redirect()->route('admin.discounts')->with('success', 'Скидка удалена.');
    }
    public function payOrder(User $user, Order $order)
    {
        return view('admin.pay-order', [
            'title' => 'Оплата заказа #' . $order->id,
            'user' => $user,
            'order' => $order,
        ]);
    }
    public function storePayment(Request $request, User $user, Order $order)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0|max:' . $order->remaining_debt,
            'payment_method' => 'nullable|string|max:255',
        ]);

        $order->payments()->create([
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'payment_date' => now(),
        ]);

        // Обновляем статус оплаты заказа
        $remainingDebt = $order->remaining_debt;
        if ($remainingDebt == 0) {
            $order->update(['payment_status' => 'paid']);
        } elseif ($remainingDebt < $order->total_price) {
            $order->update(['payment_status' => 'credit']); // Частично оплачен
        }

        return redirect()->route('admin.users.orders', $user->id)
            ->with('success', 'Платеж на сумму ' . number_format($validated['amount'], 0, ',', ' ') . ' сум успешно внесен.');
    }
    public function payDebt(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0|max:' . $user->debt,
        ]);

        $remainingAmount = $validated['amount'];
        $orders = $user->orders()
            ->whereIn('payment_status', ['pending', 'credit'])
            ->orderBy('created_at')
            ->get();

        foreach ($orders as $order) {
            if ($remainingAmount <= 0) break;

            $debt = $order->remaining_debt;
            if ($debt > 0) {
                $paymentAmount = min($remainingAmount, $debt);
                $order->payments()->create([
                    'amount' => $paymentAmount,
                    'payment_date' => now(),
                ]);

                $remainingAmount -= $paymentAmount;

                // Обновляем статус заказа
                $newDebt = $order->remaining_debt;
                if ($newDebt == 0) {
                    $order->update(['payment_status' => 'paid']);
                }
            }
        }

        return redirect()->route('admin.users')
            ->with('success', 'Платеж на сумму ' . number_format($validated['amount'], 0, ',', ' ') . ' сум успешно внесен.');
    }
    public function printOrders()
    {
        $orders = Order::with('user', 'products')
            ->where('delivery_status', 'to_deliver')
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        return view('admin.orders_print', compact('orders'));
    }

    public function printOrder(Order $order)
    {
        if ($order->delivery_status !== 'to_deliver') {
            return redirect()->route('admin.orders')->with('error', 'Этот заказ не готов к доставке.');
        }

        return view('admin.orders_print', ['orders' => collect([$order])]);
    }
}
