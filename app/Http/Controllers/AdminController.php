<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Discount;
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
        $users = User::all(); // Показываем всех пользователей
        return view('admin.users', [
            'title' => 'Покупатели',
            'users' => $users
        ]);
    }
    public function orders()
    {
        $orders = Order::with('user', 'products')
            ->whereNull('deleted_at') // Показываем только активные
            ->latest()
            ->get();

        return view('admin.orders', compact('orders'));
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


    // Форма покупки товара для пользователя
    public function buyProduct(User $user)
    {
        $products = Product::all();
        return view('admin.buy-product', [
            'title' => 'Купить товар для пользователя',
            'user' => $user,
            'products' => $products
        ]);
    }

    // Сохранение покупки
    public function storePurchase(Request $request, User $user)
    {
        $validated = $request->validate([
            'product_id' => 'required|array', // Массив выбранных товаров
            'product_id.*' => 'exists:products,id', // Проверка, что каждый товар существует
            'quantity' => 'required|array', // Массив количеств
            'quantity.*' => 'integer|min:1', // Проверка, что количество — целое число >= 1
        ]);

        // Создаём заказ
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => 0, // Временно 0, обновим ниже
        ]);

        // Подсчитываем общую стоимость и добавляем товары в заказ
        $totalPrice = 0;
        foreach ($validated['product_id'] as $index => $productId) {
            $product = Product::findOrFail($productId);
            $quantity = $validated['quantity'][$index];
            $order->products()->attach($productId, ['quantity' => $quantity]);
            $totalPrice += $product->price * $quantity;
        }

        // Обновляем общую стоимость заказа и устанавливаем начальные статусы
        $order->update([
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('admin.users')->with('success', 'Товары успешно куплены для пользователя.');
    }

    // История покупок пользователя
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->back()->with('success', 'Пользователь успешно добавлен.');
    }

    public function products()
    {
        // Показываем только те продукты, которые НЕ удалены
        $products = Product::whereNull('deleted_at')->get();
        return view('admin.products', compact('products'));

    }

    // Форма редактирования продукта
    public function editProduct(Product $product)
    {
        return view('admin.products-edit', [
            'title' => 'Редактировать продукт',
            'product' => $product
        ]);
    }

    // Обновление продукта
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


    // Мягкое удаление продукта
    public function deleteProduct(Product $product)
    {
        // Удаляем картинку, если она есть
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete(); // soft delete
        return redirect()->route('admin.products')->with('success', 'Продукт скрыт, но сохранён в истории заказов.');
    }

    public function deletedProducts()
    {
        $products = Product::onlyTrashed()->get(); // только удалённые
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
        $users = User::where('role', 'user')->get();
        $products = Product::all();
        $discounts = Discount::with(['user', 'product'])->get();
        return view('admin.discounts', compact('users', 'products', 'discounts'));
    }

    public function storeDiscount(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        Discount::updateOrCreate(
            ['user_id' => $request->user_id, 'product_id' => $request->product_id],
            ['discount_percentage' => $request->discount_percentage]
        );

        return redirect()->back()->with('success', 'Скидка успешно установлена.');
    }
}
